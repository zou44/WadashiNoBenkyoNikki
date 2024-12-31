# 容器映射设备
> CreateAt: The 31st of December, 2024

`以下解决方案仅考虑功能实现`  
近期做项目遇到需要在docker-compose中挂在宿主机/dev/*文件到容器的情况, 趁着有空整理一下.

## 方案
1.  使用devices参数 (不满足)
    ```yaml
        services:
            ros:
                ...
                devices:
                    - /dev/ttyUSB0:/dev/ttyUSB0
    ```
    问题:
    1.  若设备符不存在则容器启动会报错
    2.  无法满足设备符随机改变的情况

2. privileged + devices映射 (不满足)
    ```yaml
        services:
            ros:
                ...
                privileged: true
                devices:
                    - /dev:/dev
    ```
    问题
    1.  整个设备目录是映射进去了, 但是由udev动态创建的设备符却没有!
3.  privileged + volumes挂载 (满足)
     ```yaml
        services:
            ros:
                ...
                privileged: true
                volumes:
                    - /dev:/dev
    ```
    完美解决了所有问题