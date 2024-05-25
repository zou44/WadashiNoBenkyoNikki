# android使用Paho.clicent.mqttv3包遇到的问题
> LastUpdateTime: The 25th of May, 2024
> Number of Changes: one


###   `MqttMessageListener.messageArrived`调用`publish(qos=0)`导致客户端断开连接
-   解决
    1. 若使用的是`MqttClient`则将其改为`MqttAsyncClient`.
    2. publish使用单独的线程发送. `(注:publish非线程安全)`
    3. 将publish的qos>0
-   相关链接
    -   [文章1](https://stackoverflow.com/questions/31161740/how-to-publish-a-message-while-receiving-on-a-java-mqtt-client-using-eclipse-pah)
    -   [文章2](https://stackoverflow.com/questions/49608077/program-hangs-while-publishing-message-using-qos-0-in-mqtt-java)
    -   [文章3](https://eclipse.dev/paho/files/javadoc/org/eclipse/paho/client/mqttv3/IMqttMessageListener.html)