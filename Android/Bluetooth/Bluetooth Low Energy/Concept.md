![mind Map](./mind%20map.png)

# 低功耗蓝牙相关概念
>低功耗蓝牙（Bluetooth Low Energy），又称为蓝牙4.0。它是蓝牙技术的一种变体，旨在降低能耗，使设备能够在电池
供电的情况下长时间运行。

## 目录
- [低功耗蓝牙相关概念](#低功耗蓝牙相关概念)
  - [目录](#目录)
  - [Generic Attribute Profile (GATT, 通用属性配置文件)](#generic-attribute-profile-gatt-通用属性配置文件)
    - [GATT (服务端) or Peripheral (外围设备)](#gatt-服务端-or-peripheral-外围设备)
    - [GATT (客户端) or Central (中心设备)](#gatt-客户端-or-central-中心设备)
    - [Service (服务)](#service-服务)
    - [Characteristic (特征)](#characteristic-特征)
    - [Descriptor (描述)](#descriptor-描述)
  - [Maximum Transmission Unit (MTU)](#maximum-transmission-unit-mtu)
  - [Received Signal Strength Indication (RSSI)](#received-signal-strength-indication-rssi)
  - [TX Power (发送功率)](#tx-power-发送功率)


## Generic Attribute Profile (GATT, 通用属性配置文件)
`GATT 是一种规范，定义了BLE设备如何使用服务和特征，以实现设备间的数据交换。`
### GATT (服务端) or Peripheral (外围设备)
提供数据的设备
-   Advertising (广播)
    -   Advertising Interval (广播间隔)
        -   广播包发送的时间间隔
    -   Advertising Data (广播数据)
        -   广播数据，包含设备名称、服务UUID等信息的数据
    -   Scan Response Data (扫描想用数据)
        -   广播设备在接收到扫描请求后发送的额外数据。   
### GATT (客户端) or Central (中心设备)
接收数据的设备
-   Scanning (扫描)
    -   Scan Interval (扫描间隔)
        -   中心设备执行扫描的时间间隔。
    -   Scan Window (扫描窗口)
        -   中心设备在每个扫描间隔内进行扫描的时间段。
### Service (服务)
服务是特征的集合，每个服务都有一个UUID.
-   Primary and Secondary Services 主要和次要服务
    -   主要服务一般是外围设备的核心功能，备用服务一般是外围设备的非核心功能
### Characteristic (特征)
特征是服务中的数据单元，包含一个数值和与该值相关的属性，同时每个特征值都有一个UUID。
-   数值
    -   通常传输的是字节
-   属性
    -   每个特征值有多个属性，如可读、可写...
-   UUID
    -   唯一标识
### Descriptor (描述)
描述符用于提供有关特征的附加信息。规范固定了4个UUID (见下)。
-   规范固定的UUID
    -   Client Characteristic Configuration Descriptor (CCCD)：
        -   UUID: 00002902-0000-1000-8000-00805f9b34fb
        -   作用: 用于启用或禁用通知和指示。 
        -   注意
            -   根据规范外围设备若想向中心设备发送通知or指示,需向该描述写入相关值表开启关闭. 但实际外围设备可忽略规范直接进行通知or指示
            -   允许写入的值
                -   0x0000：禁用通知和指示。
                -   0x0001：启用通知。
                -   0x0002：启用指示。
    -   Characteristic User Description
        -   UUID: 00002901-0000-1000-8000-00805f9b34fb
        -   作用: 提供特征的用户可读描述
    -   Characteristic Presentation Format
        -   UUID: 00002904-0000-1000-8000-00805f9b34fb
        -   作用: 描述特征值的格式和单位
    -   Characteristic Aggregate Format
        -   UUID: 00002905-0000-1000-8000-00805f9b34fb
        -   作用: 描述多个特征值的组合格式。
  
## Maximum Transmission Unit (MTU)
定义了单个BLE数据包的最大字节数。
## Received Signal Strength Indication (RSSI)
接收信号强度指示，用于衡量连接质量 (越接近0信号越强)。
## TX Power (发送功率)
设备发射信号的功率(功率越大信号越强)。“android中 AdvertiseSettings.setTxPowerLevel可设置”