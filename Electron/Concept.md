# Electron的基础概念
> LastUpdate: the 31st of May, 2024  
> Changes of Number: one

## 目录
- [Electron的基础概念](#electron的基础概念)
  - [目录](#目录)
  - [Main Process (主进程)](#main-process-主进程)
  - [Rreload Script (预加载脚本)](#rreload-script-预加载脚本)
  - [Penderer Process (渲染进程)](#penderer-process-渲染进程)


## Main Process (主进程)
主进程是Electron应用的入口。它在node环境中运行，负责管理应用窗口以及处理与系统的交互。
## Rreload Script (预加载脚本)
`由于安全问题, 从v12开始移除remote模块, Rreload Script取而代之`  
预加载脚本包含了那些执行于渲染器进程中，且先于网页内容开始加载的代码。它运行在node和浏览器环境中,负责将系统接口暴露到渲染进程.
- 注意
    1.  预加载脚本和渲染进程共用window对象，若上下文隔离(contextIsolation)未开启，可直接对window进行赋值并在渲染进程中调用。
## Penderer Process (渲染进程)
每个窗口都有自己的渲染进程。它运行在浏览器环境中，负责渲染页面和处理用户交互
