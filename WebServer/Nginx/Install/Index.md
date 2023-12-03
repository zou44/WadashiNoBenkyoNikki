
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

### 源码选择
-   Mainline (主线版本)
    -   修复了已知BUG和一些新的功能。但也有会些实验性模块和一些新的bug
-   Stable (稳定版本)

