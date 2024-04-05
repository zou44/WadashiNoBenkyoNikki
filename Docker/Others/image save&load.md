# 镜像保存&载入

- [镜像保存\&载入](#镜像保存载入)
  - [场景](#场景)
    - [导出](#导出)
    - [导入](#导入)


## 场景
国内的一些服务器就算设置了国内源,download某些image依旧很慢. 此时 save & load 就很有用,通常会先在一台国外服务器download然后save成文件,再通过load载入到国内服务器.


### 导出
- options
  - -o, --output 以标准流输出

```shell
# 方法1 输出到指定文件
docker image save image > local_file.tar

# 方法2 从标准输出流
docker image save -o local_file.tar image
```

### 导入
-   Options
    -  -i, --input 从指定文件加载归档,而不是从标准输入
    -  -q, --quite 安静模式，只输出加载的镜像 ID。

``` shell
#方法1 从指定文件载入
docker image load -i local_file.tar

#方法 从标准输入流载入
cat local_file.tar | docker image load
```