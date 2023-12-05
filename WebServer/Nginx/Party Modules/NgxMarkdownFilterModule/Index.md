# 使你的Nginx能解析markdown
note: [第三方模块地址](https://github.com/ukarim/ngx_markdown_filter_module)  
它是解析md内容并转成html

## 
环境:Ubuntu22
### 示例
```nginx
location ~ \.md {
    markdown_filter on;
    markdown_template html/template.html;
}
```

### 指令
```
# 开启markdown解析
Syntax:  markdown_filter on;
Context: location
```
```
# 解析的模板
Syntax:  markdown_template html/template.html;
Context: location
```

### 编译
-   第一步 克隆仓库
    ```
    git clone https://github.com/ukarim/ngx_markdown_filter_module
    ```
-   第二步 安装开发版本的cmark
    ```
    # ubuntu
    sudo apt-get install libcmark-dev
    ```
    ```
    #验证是否安装完成,编译并运行以下代码
    vim test_cmark.c
    gcc -o test_cmark test_cmark.c -lcmark
    ./test_cmark
    ----------
    #include <stdio.h>
    #include <stdlib.h>
    #include <cmark.h>

    int main() {
        const char *input = "# Hello, cmark!\n";
        char *output = cmark_markdown_to_html(input, strlen(input), CMARK_OPT_DEFAULT);
        
        if (output != NULL) {
            printf("Markdown to HTML conversion successful:\n%s", output);
            free(output);
        } else {
            printf("Markdown to HTML conversion failed.\n");
        }

        return 0;
    }

    ```
-   第三步 重新编译Nginx
    note:注意这些指令必须要放在一行中执行,否则被当作单独命令会报错说目录不存在
    ```
    ./configure --sbin-path=/usr/local/nginx/nginx --conf-path=/usr/local/nginx/nginx.conf --pid-path=/usr/local/nginx/nginx.pid --with-pcre=../pcre2-10.42 --with-zlib=../zlib-1.2.13 --add-module=../ngx_markdown_filter_module # 注意这里带上了 静态链接模块

    make
sudo make install
    ```