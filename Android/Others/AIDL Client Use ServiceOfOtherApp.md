## 一个APP调用另一个APP的服务,通过AIDL

### 步骤
#### 服务器端
1.AIDL
2.Service 实现AIDL
3.配置清单
```
<service
    android:label="视频流采集"
    android:name=".MyService"
    android:enabled="true"
    android:exported="true">
    <intent-filter android:priority="1000">
        <action android:name="com.aidl.service.MyService" />
    </intent-filter>
</service>
```

#### 客户端
3.将服务端的AIDL复制到自己的项目中(包名要原封不动)
4.客户端对应activity实现连接流程
5.bindServer方式网上大多数是用
Intent intent = new Intent();
intent.setAction("com.aidl.service.MyService");
intent.setPackage("com.example.myapplication2");
实测并不是很好用，要用
intent.setComponent(new ComponentName("com.example.myapplication2", "com.example.myapplication2.MyService"));

#### 结束
