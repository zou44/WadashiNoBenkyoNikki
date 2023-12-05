
## 安装方式
-   预构包
-   编译源码

## 区别
预构包可以容易快速的安装nginx. 但它并不包含非官方模块.  
一些流行的linux衍生版本中都有预构包 [支持的linux看文档](https://nginx.org/en/linux_packages.html#distributions)  
不同发行版中预构包安装的模块可能有差异，可以直接看源码 [文档 - Source Packages
](https://nginx.org/en/linux_packages.html#sourcepackages)

## 预构包
### 默认包含的模块
[地址](https://nginx.org/en/linux_packages.html#sourcepackages)
### 安装步骤
-   Note  
    -  不同操作衍射版本安装方式思路是一样的. 先设置源,在安装. 区别就是使用的源不同,源基本分为 系统自带的存储和Nginx官方提供存储库.[官方文档](https://docs.nginx.com/nginx/admin-guide/installing-nginx/installing-nginx-open-source/#installing-a-prebuilt-package)

-   适用于 CentOS/RHEL/ Oracle Linux/AlmaLinux/Rocky  
    1.  安装epel-release,可以让安装命令使用EPEL存储库的包
        ```
        sudo yum install epel-release
        ``` 
    2.  更新存储库
        ```
        sudo yum update
        ```
    3.  安装
        ```
        sudo yum install nginx
        ```
    4.  查看
        ```
        sudo nginx -v
        ```
-   适用于 Ubuntu
    1.  安装epel-release,可以让安装命令使用EPEL存储库的包
        ```
        sudo apt-get update
    2.  安装
        ```
        sudo apt-get install nginx
        ```
    3.  查看
        ```
        sudo nginx -v
        ```

## 编译源码


### 安装
-  第一步 安装必须的依赖
    1.  支持正则表达式. Nginx核心和重写功能需要
        ```shell
        wget github.com/PCRE2Project/pcre2/releases/download/pcre2-10.42/pcre2-10.42.tar.gz  
        tar -zxf pcre2-10.42.tar.gz
        cd pcre2-10.42
        ./configure
        make
        sudo make install
        ```
    2.  支持header压缩. Nginx Gzip模块需要  
        note:版本和Nginx官方提供的不一样(官方文档的版本 1.2.13 目前无法下载).
        ```shell
        wget http://zlib.net/zlib-1.3.tar.gz
        tar -zxf zlib-1.3.tar.gz
        cd zlib-1.2.13
        ./configure
        make
        sudo make install
        ```
    3.  支持HTTPS协议. Nginx SSL模块和其他模块需要
        ```
        wget http://www.openssl.org/source/openssl-1.1.1v.tar.gz
        tar -zxf openssl-1.1.1v.tar.gz
        cd openssl-1.1.1v
        ./config --prefix=/usr --openssldir=/usr
        make
        sudo make install
        ```
-   第二步 下载源码  
    note:
    -   前往 [官网](https://nginx.org/en/download.html) 选择版本号
    -   根据实际情况选择源码
        -   Mainline (主线版本)
            -   修复了已知BUG和一些新的功能。但也有会些实验性模块和一些新的bug
        -   Stable (稳定版本)
    ```
    # 我选择的是稳定版的
    wget https://nginx.org/download/nginx-1.24.0.tar.gz
    tar zxf nginx-1.24.0.tar.gz
    cd nginx-1.24.0
    ```
-   第三方 编译Nginx  
    以下给出最小的./configure配置. 它支持非常多参数 [文档](https://docs.nginx.com/nginx/admin-guide/installing-nginx/installing-nginx-open-source/#compiling-and-installing-from-source)
    ```
    # note:注意这些指令必须要放在一行中执行,否则被当作单独命令会报错说目录不存在
    ./configure \
    --sbin-path=/usr/local/nginx/nginx \  # 指定 Nginx 可执行文件的路径
    --conf-path=/usr/local/nginx/nginx.conf \  # 指定 Nginx 配置文件的路径
    --pid-path=/usr/local/nginx/nginx.pid \  # 指定 Nginx PID 文件的路径
    --with-http_ssl_module \  # 启用 HTTP SSL 模块，支持 HTTPS
    --with-zlib=../zlib-1.3 \  # 指定 zlib 库的路径

    make
    sudo make install
    sudo /usr/local/nginx/nginx
    ```
## 问题
-   /usr/local/nginx/nginx: error while loading shared libraries: libssl.so.1.1: cannot open shared object file: No such file or directory
    ```
    查看缺少的so
    (which /usr/local/nginx/nginx)
    大概率是缺少与ssl相关的
    libssl.so.1.1 => not found
	libcrypto.so.1.1 => not found

    解决:
    #手动增加动态库路径
    # "/root/openssl-1.1.1v" 是你刚才编译Openssl的文件夹路径
    sudo sh -c 'echo "/root/openssl-1.1.1v" > /etc/ld.so.conf.d/openssl.conf'
    ```
    
## 创建系统用户运行nginx
```
# 创建一个系统用户 & 没有home目录 & 并创建同名分组
sudo adduser --system --no-create-home --group www
# 切换到www用户
sudo su -s /bin/bash www
```
