![head](./image.jpg)
# 目录
*   [注意](#note)
*   [介绍](#介绍)
*   [示例](#示例)
*   [IntentFilter](#IntentFilter)
    -   Methods
*   [DownloadManager](#Methods)
    -   Methos
    -   Constants
*   [DownloadManager.Request ](#DownloadManager.Request )
    -   Methos
    -   Constants
    -   其他
## Note
* API Level Min >= 9
* 需要 Manifest.permission.INTERNET 权限

## 介绍
<u>Android从9.0开始提供的用于管理下载的系统服务.</u>下载过程托管给系统服务,系统服务与客户端通过广播进行交互.

## 示例
1. 构造 DownloadManager.Request 对象
```Java
Uri url = Uri.parse("https://.../app-debug.apk");
DownloadManager.Request request = new DownloadManager.Request(url);
// 行为设置
request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE);
// 设置通知栏上的标题
request.setTitle("MetaData File Download");
// 下载目标
request.setDestinationInExternalPublicDir(Environment.DIRECTORY_DOWNLOADS, "my_file.apk");
```
2. 投递 & 构造广播
``` java
DownloadManager downloadManager = (DownloadManager) getSystemService(Context.DOWNLOAD_SERVICE);
// 投递
final long downloadId =  downloadManager.enqueue(request);
// 构造广播
IntentFilter filter = new IntentFilter();
// 下载完成时广播
filter.addAction(DownloadManager.ACTION_DOWNLOAD_COMPLETE);
// 注册广播
registerReceiver(downloadReceiver, filter);
```
## IntentFilter
配置接收匹配规则的类
*   Methods
    -   addAction - 增加匹配规则; 下载服务支持的匹配规则常量看 ACTION_DOWNLOAD_*

## DownloadManager
*   Methods
    -   enqueue
        ```java
        public long enqueue (DownloadManager.Request request)
        ```
        投递一个下载对象到队列,排队等待服务进行消费; 该方法返回一个DownloadId
*   Constants(常量)
    -   ACTION_DOWNLOAD_* - 广播Action常量
        -   ACTION_DOWNLOAD_COMPLETE - 下载完成
        -   ACTION_NOTIFICATION_CLICKED - 用户点击正在下载的任务


## DownloadManager.Request 
用于构造下载请求的类. [链接到官方文档](https://developer.android.com/reference/android/app/DownloadManager.Request)  
* Methods
    -   Request
        ```java
        public Request (Uri uri)
        ```
        new时必须传入下载地址,仅支持HTTPS或HTTP
    -   setNotificationVisibility
        ```java
        public DownloadManager.Request setNotificationVisibility (int visibility)
        ```
        设置请求在通知栏的显示行为,默认仅在请求被下载时可见. 具体值看下面VISIBILITY 
    -   setTitle
        ```java
        public DownloadManager.Request setTitle (CharSequence title)
        ```
        设置请求在通知栏中的标题,若未设置则取下载的文件名
    -   setDestinationInExternalPublicDir
        ```java
        public DownloadManager.Request setDestinationInExternalPublicDir (String dirType, 
                String subPath)
        ```
        将文件下载到 <u>外部公共存储</u> 的特定子目录.  
        注意:  
        1.  外部公共存储指的是 Environment.getExternalStoragePublicDirectory 方法返回的路径
        2.  API Level >= 29 的版本无需申明 WRITE_EXTERNAL_STORAGE 权限.


*   Constants (常量)
    - VISIBILITY 通知栏显示行为
        - VISIBILITY_HIDDEN - 下载时不显示
        - VISIBILITY_VISIBLE - 下载时可见
        - VISIBILITY_VISIBLE_NOTIFY_COMPLETED - 下载时和下载完成时可见
        - ~~VISIBILITY_VISIBLE_NOTIFY_ONLY_COMPLETION - 下载完成时可见;~~ 该常量只适用于addCompletedDownload方法,该方法在API Level29中被废除

*   其他
    - DownloadManager.addCompletedDownload (API Level < 29) - 向系统的下载数据库中添加一条自定义数据,它会在通知栏中显示.
    
