# AutoInstall Usage Record

> CreateAt: The 18th of September, 2025  
> LastUpdateAt: The 18th of September, 2025  
> Number of Changes: 0 times

## 前置知识
- BIOS基础

## 前言
最近有个任务是为40台(暂定)设备装系统的工作, 故记下这篇

## Concepts
-   Data Source Files - 源文件
    -   user-data
        若分离出autoinstall.yml则它只描述系统安装后还需做什么
    -   autoinstall.yaml
        user-data核心片段独立出来的部分, 用于描述如何安装系统. 通常不会把它独立出来
    -   meta-data
        允许为空, 但必须存在. 描述环境or设备的元信息等自定义信息, 系统安装好后会释放到系统中 (/var/lib/cloud/instance/meta-data.json).
-   Data Source Methods - 源文件获取方式
    -   NoCloud - 本地
    -   NoCloud-Net - 网络
    -   Cloud Provider - 专属服务器
-   clout-init - 控制器
    寻找数据源, 解析, 配置(ssh等), 发布执行任务
-   Subiquity - 安装器  
    负责交互安装. Ubuntu20 开始的新安装器，取代了旧的 debian-installer。
-   curtin - 执行器
    负责执行cloud-init发布的任务. 分区/安装动作.
-   Kernel Command Line - 内核参数
    需修改内核的启动参数. 加入autoinstall标志以及相关参数用于使其能正常执行.

## Tasks
### 目标:ubuntu22 desktop 无人值守安装
### 思路描述: 使用1个15G的U盘做两个分区, 一个用于存放ISO和bootloader程序, 另一个用于存放数据源(Data Source).
### 障碍
1. 目前了解到autoinstall安装desktop版最低是23, server最低是20. 不过github有[解决方案](https://github.com/canonical/autoinstall-desktop). 可通过先安装server在安装desktop包来实现. 

### Steps
1.  一个Ubuntu环境
2.  准备一个15G的U盘
3.  准备一份user-data(下方贴出了一份最小配置)文件和Ubuntu22 Server ISO
4.  安装必要的工具 sudo apt install -y grub-efi-amd64-bin dosfstools parted whois
5.  确定你的U盘所属的设备路径. 我这里假设是/dev/sdb
6.  初始化/分区U盘 
```sh
    # 设置分区方式
    sudo parted -s /dev/sdb mklabel gpt

    # 创建分区P1, 设置为10G和fat32文件系统.
    # 用于存放bootloader和iso
    sudo parted -s /dev/sdb mkpart BOOT fat32 1MiB 10GiB
    # 设置引导标识符esp
    sudo parted -s /dev/sdb set 1 esp on

    # 创建分区P2, 把剩余的都分配给P2. 
    # 用于存放数据源
    sudo parted -s /dev/sdb mkpart CIDATA fat32 10GiB 100%

    # 格式化
    sudo mkfs.vfat -F32 -n BOOTISO /dev/sdb1     # P1 卷标可叫 BOOTISO
    sudo mkfs.vfat -F32 -n CIDATA  /dev/sdb2     # P2 卷标必须叫 CIDATA
```
7.  P1填入数据
```sh
    # 挂载两个分区
    sudo mkdir -p /mnt/iso /mnt/cidata
    sudo mount /dev/sdb1 /mnt/iso
    sudo mount /dev/sdb2 /mnt/cidata

    # 制作bootloader. 
    sudo grub-install \
        # 平台架构
        --target=x86_64-efi \ 
        # 可移动设备
        --removable \
        # bootloader 程序
        --efi-directory=/mnt/iso \
        # bootloader 配置和其他模块
        --boot-directory=/mnt/iso/boot \
        # 禁止往固件的 NVRAM 里写启动项
        --no-nvram

    # 复制ISO到P1
    sudo mkdir -p /mnt/iso/iso
    sudo cp ~/Downloads/ubuntu-22.04.5-live-server-amd64.iso /mnt/iso/iso/
    ls -lh /mnt/iso/iso/

    # 获得分区UUID, 把UUID的值复制过来. 我的是 D9EE-4892
    sudo blkid /dev/sdb1
    
    # 编写bootloader
    sudo tee /mnt/iso/boot/grub/grub.cfg >/dev/null << 'EOF'
        set default=0
        set timeout=1

        insmod part_gpt
        insmod fat
        insmod iso9660
        insmod loopback
        insmod linux
        insmod search
        insmod search_fs_file

        # 这里改成刚查询到的uuid
        search --no-floppy --fs-uuid --set=D9EE-4892
        set prefix=($root)/boot/grub
        # iso路径
        set iso_path="/iso/ubuntu-22.04.5-live-server-amd64.iso"

        menuentry "Ubuntu Server (autoinstall)" {
            # 清理可能遗留的 loop
            loopback -d loop

            # 没找到ISO就给出清晰提示
            if [ ! -e ($root)$iso_path ]; then
                echo "ISO not found: ($root)$iso_path"
                echo "Check file name & location on the BOOTISO partition."
                sleep 5
                return
            fi

            loopback loop ($root)$iso_path
            linux   (loop)/casper/vmlinuz boot=casper iso-scan/filename=$iso_path cdrom-detect/try-usb=true  autoinstall ---
            initrd  (loop)/casper/initrd
            boot
        }
    EOF

    # 保险：有些固件会优先找 EFI/BOOT/grub.cfg，再拷一份    
    sudo cp /mnt/iso/boot/grub/grub.cfg /mnt/iso/EFI/BOOT/grub.cfg
```
8. P2填入数据
```sh
    sudo tee /mnt/cidata/user-data >/dev/null <<'EOF'
        # ...将下面的user-data copy进去
    EOF
    # 元数据文件, 可空但必须要有
    sudo touch /mnt/cidata/meta-data 
```
9. 完成并弹出U盘
```sh
    # 将内存中的数据都同步进去
    sync
    # 卸载挂载
    sudo umount /mnt/iso /mnt/cidata
```
使用时的注意事项
    -   实体机器设置一下启动盘即
    -   若是mv需将启动固件从bios改为UEFI. 然后进入到bios中从U盘启动

### user-data
```yaml
#cloud-config
autoinstall:
  # version is an Autoinstall required field.
  version: 1

  # This adds the default ubuntu-desktop packages to the system.
  # Any desired additional packages may also be listed here.
  packages:
    - ubuntu-desktop

  # This adds the default snaps found on a 22.04 Ubuntu Desktop system.
  # Any desired additional snaps may also be listed here.
  snaps:
    - name: firefox
    - name: gnome-3-38-2004
    - name: gtk-common-themes
    - name: snap-store
    - name: snapd-desktop-integration

  # User creation can occur in one of 3 ways:
  # 1. Create a user using this `identity` section.
  # 2. Create users as documented in cloud-init inside the user-data section,
  #    which means this single-user identity section may be removed.
  # 3. Prompt for user configuration on first boot.  Remove this identity
  #    section and see the "Installation without a default user" section.
  identity:
    realname: ''
    username: ubuntu
    # A password hash is needed. `mkpasswd --method=SHA-512` can help.
    # mkpasswd can be found in the package 'whois'
    # 密码 root
    password: '$6$hDJMSMUImHStl2R5$VpMZkLvepGIx7zQz.0brIF6B8tc.Gh9n4o.rqkwmzTRj7PFfWxeyblj1kpo/KyZM7g3RYkO.e6o4SitySxOZs/'
    hostname: ubuntu-desktop

  # Subiquity will, by default, configure a partition layout using LVM.
  # The 'direct' layout method shown here will produce a non-LVM result.
  storage:
    layout:
      name: direct

  # Ubuntu Desktop uses the hwe flavor kernel by default.
  early-commands:
    - echo 'linux-generic-hwe-22.04' > /run/kernel-meta-package

  # The live-server ISO does not contain some of the required packages,
  # such as ubuntu-desktop or the hwe kernel (or most of their depdendencies).
  # The system being installed will need some sort of apt access.
  # proxy: http://192.168.0.1:3142

  late-commands:
    # Enable the boot splash
    - >-
      curtin in-target --
      sed -i /etc/default/grub -e
      's/GRUB_CMDLINE_LINUX_DEFAULT=".*/GRUB_CMDLINE_LINUX_DEFAULT="quiet splash"/'
    - curtin in-target -- update-grub

    # Let NetworkManager handle network
    - rm /target/etc/netplan/00-installer-config*yaml
    - >-
      printf "network:\n  version: 2\n  renderer: NetworkManager"
      > /target/etc/netplan/01-network-manager-all.yaml

    # Remove default filesystem and related tools not used with the suggested
    # 'direct' storage layout.  These may yet be required if different
    # partitioning schemes are used.
    - >-
      curtin in-target -- apt-get remove -y
      btrfs-progs cryptsetup* lvm2 xfsprogs

    # Remove other packages present by default in Ubuntu Server but not
    # normally present in Ubuntu Desktop.
    - >-
      curtin in-target -- apt-get remove -y
      ubuntu-server ubuntu-server-minimal
      binutils byobu curl dmeventd finalrd gawk
      kpartx mdadm ncurses-term needrestart open-iscsi openssh-server
      sg3-utils ssh-import-id sssd thin-provisioning-tools vim tmux
      sosreport screen open-vm-tools motd-news-config lxd-agent-loader
      landscape-common htop git fonts-ubuntu-console ethtool

    # Keep cloud-init, as it performs some of the installation on first boot.
    - curtin in-target -- apt-get install -y cloud-init

    # Finally, remove things only installed as dependencies of other things
    # we have already removed.
    - curtin in-target -- apt-get autoremove -y

    # A postinstall script may optionally be used for further install
    # customization. Deploy this postinstall.sh script on the webserver.
    # - wget -O /target/postinstall.sh http://192.168.0.2/postinstall.sh
    # - curtin in-target -- bash /postinstall.sh
    # - rm /target/postinstall.sh

  # Additional cloud-init configuration affecting the target
  # system can be supplied underneath a user-data section inside of
  # autoinstall.
  # user-data:
  #   …
```
