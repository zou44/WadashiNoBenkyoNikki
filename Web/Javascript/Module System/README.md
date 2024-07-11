#  Module System in javascript
> LastUpdateTime: The 12th of July, 2024  
> Number of Changes: 1 times

![map](./module%20system%20mind%20map%20.png)

## 目录
- [Module System in javascript](#module-system-in-javascript)
  - [目录](#目录)
  - [前言](#前言)
  - [ESM (ECMAScript Modules)](#esm-ecmascript-modules)
    - [使用](#使用)
    - [同步和异步问题](#同步和异步问题)
    - [动态导入](#动态导入)
    - [default](#default)
      - [注意](#注意)
    - [细节](#细节)
  - [CommonJS](#commonjs)
    - [使用](#使用-1)
    - [细节](#细节-1)
  - [AMD (Asynchronous Modeuls Defintion)](#amd-asynchronous-modeuls-defintion)
    - [require.js的使用](#requirejs的使用)
  - [UMD (Uuniversal Module Definition)](#umd-uuniversal-module-definition)
    - [使用](#使用-2)
  - [参考](#参考)


## 前言
这几天在写electron遇到不同加载方式依赖包共存问题. 趁着查文档之际顺手把加载规范都梳理了以下.

## ESM (ECMAScript Modules)
Node和浏览器主流的加载方式. 支持同步和异步(按需加载)两种方式.

### 使用
```javascript
// 导出, 有三种方式
// 方式1
export const name = "123"
export function foo() {}
export class Person {}
// 方式2
export {
	name,
    foo
}
// 方式3, 从另一个模块中导出
export * from './bar'

// 导入, 有两种方式
// 方式1
import { name, age } from './foo'
// 方式2, 别名
import * as foo from './foo'
```

### 同步和异步问题
执行import时是同步的, 即只有导入完成后才可执行后面的代码. 若要异步则需使用`动态导入`.

### 动态导入
使用import函数,返回一个Promise
```javascript
import("./foo").then(module => {})
```

### default
```javascript
// 导出
// 如果想要让 foo 作为默认导出
const foo = "foo value"
// 也可以这样
export default foo;

// 导出
import foo from './foo'
```
#### 注意
1.  default只能有一个
2.  方便与CommonJS等规范相互操作



### 细节
1.  拥有动态引入方式(异步)
2.  Node和浏览器的ESM稍微有区别
3.  有CORS(跨域限制)
4.  默认采用严格模式


## CommonJS
在运行时同步加载. 因为是同步机制,一般该规范只会出现在服务端node环境中.

### 使用
```javascript
// 导出
// 方法1
module.exports = {
    foo: 'bar'    
};

// 方法2
exports.foo = 'bar';

// 导入
const module = require('./module');
```

### 细节
1.  重复加载同一模块时始终运行一次.
2.  采用`深度优先`算法. [来自](https://juejin.cn/post/7069644953663569927)

## AMD (Asynchronous Modeuls Defintion)
采用异步方式加载模块, 并在浏览器中广泛使用.  
`AMD并不是JS原生支持的特性,而是通过动态创建script标签实异步加载的. 通常使用实现了该规范的第三方库, 如require.js 和 curl.js`
### require.js的使用
1.  下载require.js
2.  在html在引入并设置相关属性
    ```javascript
    // data-main是入口脚本
    <script src='./lib/require.js' data-main="./index.js"></script>
    ```
3.  导出模块
    ```javascript
        // src/foo.js

        // 在 define 中写逻辑
        define(function () {
            const name = 'foo'
            const age = 18
            function sum(num1, num2) {
                return num1 + num2
            }
            // 这里的 return 就导出了
            return {
                name,
                age,
                sum,
            }
        })
    ```
4.  使用模块
    ```javascript
    // ./index.js
    
    // 配置每个模块的路径. 也可不配置直接通过文件名来加载(不带后缀)
    require.config({
        paths: {
            foo: './src/foo',
        },
    })

    // 这里再引入模块
    require(['foo'], function (foo) {
        // 加载完成 foo 后触发回调 并传入加载的数据
        console.log(foo.name)
        console.log(foo.age)
        console.log(foo.sum(1, 2))
    })
    ```


## UMD (Uuniversal Module Definition)
是一种编写Module的方式, 使模块能在服务器和浏览器上正常运行. 实际上它是CommonJS(服务器)和AMD(浏览器)的组合.

### 使用
1. 定义一个UMD模块
    ```javascript
    // my-umd.js

    ;(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD.
        define([], factory)
    } else if (typeof module === 'object' && module.exports) {
        // CommonJS
        module.exports = factory()
    } else {
        // 浏览器
        root.myModule = factory()
    }
    })(this, function () {
    return {
        hello: function () {
        return 'Hello, World!'
        },
    }
    })
    ```
2. 使用  
    a.  浏览器环境
    ```javascript
    <script src="my-umd.js"></script>
    <script>
    console.log(myModule.hello()) // Outputs: "Hello, World!"
    </script>
    ```
    b.  AMD
    ```javascript
    <script src='./lib/require.js'></script>
    <script>
        require(['my-umd'], function (myModule) {
            console.log(myModule.hello()) // Outputs: "Hello, World!"
        })
    </script>
    ```
    c.  CommonJS(Node)
    ```javascript
    const myModule = require('./my-umd.js')
    console.log(myModule.hello()) // Outputs: "Hello, World!"
    ```

## 参考
[参考1](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Guide/Modules)  
[参考2](https://techhub.iodigital.com/articles/javascript-module-systems)  
[参考3](https://juejin.cn/post/7069644953663569927#heading-21)