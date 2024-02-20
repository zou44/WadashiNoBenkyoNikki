# 使应用在模拟器中成为系统应用
> Last Update 2024/02/19
1.  从[Android源码](https://cs.android.com/android/platform/superproject/+/master:build/make/target/product/security/)中获得通用的公私钥`platform.x509.pem`,`platform.pk8`
2.  对应用进行系统签名, 这里不展开. [跳转](https://juejin.cn/post/7052229760503513095)  
3.  (重) 选择标明编译来源的镜像, 如`Android Open Source Project` 
4.  现在应用已成为系统应用. 可将应用改为 android:sharedUserId="android.uid.system" 尝试