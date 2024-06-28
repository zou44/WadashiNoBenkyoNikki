# Electron-Updater 概念和基础
> LastUpdate: the 28th of June, 2024  
> Number of Changes: 1 times

## 目录
- [Electron-Updater 概念和基础](#electron-updater-概念和基础)
  - [目录](#目录)
  - [note](#note)
  - [前置知识](#前置知识)
    - [自动更新流程](#自动更新流程)
    - [包格式](#包格式)
    - [版本类型](#版本类型)
    - [AutoUpdater.on 事件](#autoupdateron-事件)
  - [参考](#参考)

## note
`macOS必须得有签名, windowns无所谓`  
`Electron-Updater` 通常跟`Electron-Biulder`一起使用.

## 前置知识
### 自动更新流程
1.  配置`Electron-Updater`并编译产生 release metadata(latest.yml)
2.  `Electron-Builder`编译应用,上传编译应用和metadata文件到配置的`publish server`
3.  正确配置了的`Electron-Updater`会从`publish server`查询最新版本

### 包格式
*   macOs: DMG
*   Linux: AppImage, DEB and RPM.
*   Windows: NSIS.  
`Windows只支持NSIS. 如果你用的是Squirrel.Windows,官方给的建议是改为NSIS`

<!-- ### Staged Rollouts（分阶段推出） -->

### 版本类型
*   `release`: 发布版
*   `draft`: 草稿版
*   `prerelease`: 预发布版

### AutoUpdater.on 事件
*   error  
更新时发生错误时触发
*   checking-for-update  
开始检查更新时触发
*   update-available  
当有可用更新时触发. 如果`autoDownload=true`时,则自动下载.
    * info [UpdateInfo (对于通用和Github)](https://www.electron.build/auto-update#UpdateInfo) |  VersionInfo (for Bintray provider)
*   update-not-available  
没有可用更新时触发
    * info [UpdateInfo (对于通用和Github)](https://www.electron.build/auto-update#UpdateInfo) |  VersionInfo (for Bintray provider)
*   download-progress  
更新时产生进度时触发
    *   progress
    <!-- *   bytesPerSecond
    *   percent
    *   total
    *   transferred -->
*   update-downloaded  
下载完成后触发
    * info [UpdateInfo (对于通用和Github)](https://www.electron.build/auto-update#UpdateInfo) |  VersionInfo (for Bintray provider)

## 参考
*   [官方](https://www.electron.build/auto-update)