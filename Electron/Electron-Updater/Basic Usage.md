# Electron-Updater 使用和调试
> LastUpdate: the 28th of June, 2024  
> Number of Changes: 1 times

## 目录
- [Electron-Updater 使用和调试](#electron-updater-使用和调试)
  - [目录](#目录)
  - [使用](#使用)
    - [关于`autoUpdater.quitAndInstall()`,](#关于autoupdaterquitandinstall)
    - [publish github配置方法](#publish-github配置方法)
  - [调试](#调试)
  - [参考](#参考)


## 使用
1.  安装 `npm install electron-updater`. 
2.  引入库
```javascript
// CommonJS
const { autoUpdater } = require("electron-updater")
// ESM
import { autoUpdater } from "electron-updater"
```
3.  在合适的位置调用(通常ready事件)`autoUpdater.checkForUpdatesAndNotify()` 或 `autoUpdater.checkForUpdates()`.
4.  根据`publish`类型配置发布选项. [配置方法](#publish-github配置方法)
    *  注意需将`releaseType`设置为`release`. [版本类型](#版本类型) 
    *  注意发布版本和当前版本号,它必须比发布服务器上的小
    *  只有编译出来的应用才会执行更新检查
5.  加上`-p always`参数编译应用即可.   
    * 大多数类型的`publish`都会自动上传.除了`generic publish server`,这必须要手动上传.

### 关于`autoUpdater.quitAndInstall()`,
主动调用的话会退出应用并更新. 其实不调用也可以,应用关闭后重启会自动安全.

### publish github配置方法
1. electron-builder.yml中增加
```yml
// https://github.com/zou44/SmartClientOpsApp
win:
  publish:
    // 托管平台
    provider: github
    // 仓库名
    repo: SmartClientOpsApp
    // 拥有者
    owner: zou44
    // 发版类型
    releaseType: release
```
2. 创建Github Token
[https://github.com/settings/tokens/new](https://github.com/settings/tokens/new). 最少授权仓库权限 (repo)
3. 系统中增加环境变量名为:GH_TOKEN, 值为:上一步拿到的token


## 调试
1. 创建`dev-app-update.yml`文件并根据`publish server`配置.  
```yml
// dev-app-update.yml
provider: github
repo: SmartClientOpsApp
owner: zou44
releaseType: release
```
2. 加入开启调试代码
```javascript
// main.js
autoUpdater.updateConfigPath = path.join(__dirname, 'dev-app-update.yml');
autoUpdater.forceDevUpdateConfig = true;
```
3. 编译运行即可

## 参考
[github publish config](https://www.electron.build/auto-update.html#githuboptions-publishconfiguration)