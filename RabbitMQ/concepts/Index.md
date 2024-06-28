# 概念

## Role(角色)
### Message Brokers(代理)
通常指的就是MQ.消息的生产者将消息投递到这, 消费者从这里获取消息.
### Publisher (生产者,发布者)
#### 关于Publisher的生命周期
通常以Pulisher身份创建的连接在`应用程序`的整个声明周期都会存在或以池的形式存在.(不推荐为每次投递消息时创建一次连接).
#### 将消息投递到不存在的目标
不同的协议处理的方式不同.
-   AMQP 0-9-1  
当发送的消息无法路由到任何队列时,并且发布者强制消息属性(mandatory)设置为false(默认值),改`消息将被丢弃`或`重新发布到备用exchange`; 当mandatory设置为true时, 发送的消息无法路由到任何队列时, 会触发发送者的一个很回调.
-   MQTT
投递的主题不存在时,会根据主题和QOS自动创建队列.
-   STOMP
/topic: publishing to a topic that has not had a consumer will result in dropped messages. First subscriber on the topic will declare a queue for it.  
/exchange: target exchange must exist, otherwise the server would report an error  
/amq/queue: target queue must exist, otherwise the server would report an error  
/queue: publishing to a non-existent queue would set it up  
/temp-queue: publishing to a non-existent temporary queue would set it up
#### Publisher Acknowledgement (发布者确认机制)
-   Transcational Messaging (事务机制)
-   Publisher Confirms (确认机制)
    -   注意  
### Consumer (消费者)
消费者从队列里消费消息.