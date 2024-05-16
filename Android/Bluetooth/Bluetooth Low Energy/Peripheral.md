# 外围设备 
> Last Update Time: 2024/05/17

## 注意
-   API Level Min >= 18
-   Android Version > 4.3

## 示例
### 权限
```xml
<!-- 遗留的蓝牙权限 -->
<!-- 允许应用程序连接到已配对的蓝牙设备 -->
<uses-permission android:name="android.permission.BLUETOOTH" android:maxSdkVersion="30" />
<!-- 管理蓝牙 -->
<uses-permission android:name="android.permission.BLUETOOTH_ADMIN" maxSdkVersion="30"/>

<!-- 允许应用程序连接到蓝牙设备。 -->
<uses-permission android:name="android.permission.BLUETOOTH_CONNECT"/>
<!-- 允许应用程序作为低功耗蓝牙外围设备进行广播，从而让中心设备发现并连接它。 -->
<uses-permission android:name="android.permission.BLUETOOTH_ADVERTISE"/>
```

### 实现代码
- `动态请求权限部分代码没写`
```java
class Test {
    String TAG = "TEST";
    UUID SERVICE_UUID = UUID.fromString("97D8189F-DA45-4F41-9035-81D868B1F0E7");
    UUID CHARACTERISTIC_UUID = UUID.fromString("3497CB5B-FEE1-4118-8A3D-CAF299688089");
    UUID DESCRIPTOR_UUID = UUID.fromString("00002904-0000-1000-8000-00805F9B34FB");
    BluetoothGattServerCallback gattServerCallback = new BluetoothGattServerCallback() {
        @Override
        public void onConnectionStateChange(BluetoothDevice device, int status, int newState) {
            super.onConnectionStateChange(device, status, newState);
        }

        @Override
        public void onCharacteristicReadRequest(BluetoothDevice device, int requestId, int offset, BluetoothGattCharacteristic characteristic) {
            super.onCharacteristicReadRequest(device, requestId, offset, characteristic);
            log.d(TAG, "读取特征值请求");
            bluetoothGattServer.sendResponse(device, requestId, BluetoothGatt.GATT_SUCCESS, offset, characteristic.getValue());
        }

        @Override
        public void onCharacteristicWriteRequest(BluetoothDevice device, int requestId, BluetoothGattCharacteristic characteristic, boolean preparedWrite, boolean responseNeeded, int offset, byte[] value) {
            super.onCharacteristicWriteRequest(device, requestId, characteristic, preparedWrite, responseNeeded, offset, value);
            log.d(TAG, "写入特征值请求");
        }
    };

    public void main() {
        // 蓝牙管理类
        BluetoothManager bluetoothManager = (BluetoothManager) context.getSystemService(Context.BLUETOOTH_SERVICE);
        // 适配器
        BluetoothAdapter bluetoothAdapter = bluetoothManager.getAdapter();
        // 开启蓝牙
        if(!bluetoothAdapter.isEnabled()) {
            bluetoothAdapter.enable();
        }
        // 设置蓝牙名称
        bluetoothAdapter.setName("test");

        // 创建服务 & 设置为主服务
        BluetoothGattService service = new BluetoothGattService(SERVICE_UUID, BluetoothGattService.SERVICE_TYPE_PRIMARY);
    
        // 创建特征值 & 设置属性
        // 可读 & 可写 & 可订阅
        // 设置读写权限的方式, 跟上面一样
        BluetoothGattCharacteristic characteristic = new BluetoothGattCharacteristic(CHARACTERISTIC_UUID,BluetoothGattCharacteristic.PROPERTY_READ | BluetoothGattCharacteristic.PROPERTY_WRITE | BluetoothGattCharacteristic.PROPERTY_NOTIFY,BluetoothGattCharacteristic.PERMISSION_READ | BluetoothGattCharacteristic.PERMISSION_WRITE); 
        // 设置默认值
        characteristic.setValue("test");

        // 创建一个描述对象
        // 描述特征单位 & 只读
        BluetoothGattDescriptor descriptor = new BluetoothGattDescriptor(DESCRIPTOR_UUID,BluetoothGattDescriptor.PERMISSION_READ);
        descriptor.setValue("特征值描述".getBytes());
        characteristic.addDescriptor(descriptor);

        // 向服务添加特征值
        service.addCharacteristic(characteristic);
        // 添加到 GattServer
        BluetoothGattServer bluetoothGattServer = bluetoothManager.openGattServer(context, gattServerCallback);
        bluetoothGattServer.addService(service);

        // 广播
        AdvertiseSettings settings = new AdvertiseSettings.Builder()
            // 低延迟模式
            .setAdvertiseMode(AdvertiseSettings.ADVERTISE_MODE_LOW_LATENCY)
            // 允许连接
            .setConnectable(true)
            // 持续发送广播
            .setTimeout(0)
            // 高功耗模式 
            .setTxPowerLevel(AdvertiseSettings.ADVERTISE_TX_POWER_HIGH)
            .build();
        AdvertiseData.Builder advertiseBuild = new AdvertiseData.Builder()
            // 显示设备名
            .setIncludeDeviceName(true)
            // 显示功率级别
            .setIncludeTxPowerLevel(true);
        AdvertiseData advertiseData = advertiseBuild.build();
        BluetoothLeAdvertiser bluetoothLeAdvertiser = bluetoothAdapter.getBluetoothLeAdvertiser();
        bluetoothLeAdvertiser.startAdvertising(settings, advertiseData, new AdvertiseCallback() {
            @Override
            public void onStartSuccess(AdvertiseSettings settingsInEffect) {
                log.d(TAG, "广播成功");
            }

            @Override
            public void onStartFailure(int errorCode) {
                log.d(TAG, "广播失败 err=" + errorCode);
            }
        });
    }
}
```
### 步骤
1. 保证蓝牙是开启的能获得相关示例
2. 创建服务和特征 `(描述是个可选项)`
3. 设置广播 (广播了别人才能扫描到)

## 注意
1.  外围设备和中心设备的数据交互,如果超过MTU数据会被切割依次发送, 需自己实现拼接逻辑. 但在一些中心设备中超过了最大MTU,中心设备会产生BUG(`比如微信小程序`),所以很多时候会尽可能在超过MTU前自行对数据进行切割.