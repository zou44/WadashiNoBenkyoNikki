# docker导入导出
> CreateAt: The 5th of April, 2024  
> LastUpdateAt: The 20th of January, 2025
> Number of Changes: 2 times

## 目录
- [docker导入导出](#docker导入导出)
  - [目录](#目录)
  - [场景](#场景)
  - [方案](#方案)
  - [解决](#解决)
  - [镜像迁移](#镜像迁移)


## 场景
国内禁用docker后迁移较大的镜像或容器十分不方便. 故整理这次迁移的过程.

## 方案
市面上常见的方式有以下:
1.  save & load 保存完整的镜像信息, 就像从源拉的镜像一样. `镜像迁移`
2.  export & import 没有镜像信息, 仅对容器此刻快照. 导入到新服务器后会被当作镜像. `容器迁移`

## 解决
调研后选择`镜像迁移`方案. 


## 镜像迁移
导出
- options
  - -o, --output 以标准流输出

```shell
# 方法1 输出到指定文件
docker image save image_id > local_file.tar

# 方法2 从标准输出流
docker image save -o local_file.tar image_id
```

导入
-   Options
    -  -i, --input 从指定文件加载归档,而不是从标准输入
    -  -q, --quite 安静模式，只输出加载的镜像 ID。

``` shell
#方法1 从指定文件载入
docker image load -i local_file.tar

#方法2 从标准输入流载入
cat local_file.tar | docker image load

#方法3
docker load < local_file.tar
```
