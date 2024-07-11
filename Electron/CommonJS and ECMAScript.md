# Electron中的CommonJS和ECMAScript
> LastUpdateTime: The 12th of July, 2024  
> Number of Changes: 1 times

## 目录
- [Electron中的CommonJS和ECMAScript](#electron中的commonjs和ecmascript)
  - [目录](#目录)
  - [如何在CommonJS下导入ES模块](#如何在commonjs下导入es模块)
  - [为什么使用import...from...能导入CommonJS模块？](#为什么使用importfrom能导入commonjs模块)
  - [默认规范](#默认规范)


## 如何在CommonJS下导入ES模块
有两个方案
*  方案1,使用动态import
    ```javascript
    (async () => {
         const Store = (await import('electron-store')).default;
         const store = new Store();

         // 使用 store 进行数据操作
         store.set('user.name', 'Alice');
         console.log(store.get('user.name')); // Alice
    })();
    ```
*  方案2, 将CommonJS规范改为ES规范. 下面两个条件满足一个
    * 文件以.mjs后缀.
    * package.json将type字段设置为module.



## 为什么使用import...from...能导入CommonJS模块？
NodeJS中提供了一个兼容机制.当使用import...from会将CommonJS模块的module.exports作为默认导出.`简而言之就是NodeJS本身支持的`.  
[依据](https://nodejs.cn/api/esm.html#%E4%B8%8E-commonjs-%E7%9A%84%E4%BA%92%E6%93%8D%E4%BD%9C%E6%80%A7)

## 默认规范
默认情况下未设置package.json中的type字段，那么默认为commonjs，即CommonJS模块化规范。