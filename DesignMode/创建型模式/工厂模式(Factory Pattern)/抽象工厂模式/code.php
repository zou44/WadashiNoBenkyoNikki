<?php
/* =============================================================================#
# Date: 2022/6/5 2:49 
# Description: 
#============================================================================= */

/**
 * 实例：
　　现在需要做一款跨平台的游戏，需要兼容Android，Ios，Wp三个移动操作系统，该游戏针对每个系统都设计了一套操作控制器（OperationController）和界面控制器（UIController），下面通过抽闲工厂方式完成这款游戏的架构设计。
    由题可知，游戏里边的各个平台的UIController和OperationController应该是我们最终生产的具体产品。所以新建两个抽象产品接口。

    作者：Knight_Davion
    链接：https://www.jianshu.com/p/83ef48ce635b
    来源：简书
    著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。
 */

//====================== 产品接口

interface OperationController {
    public function control();
}

interface UIController {
    public function  display();
}

//Android
class AndroidOperationController implements OperationController {
    public function control() {
        echo("AndroidOperationController");
    }
}

class AndroidUIController implements UIController {
    public function display() {
        echo("AndroidInterfaceController");
    }
}

//Ios
class IosOperationController implements OperationController {
    public function control() {
        echo("IosOperationController");
    }
}

class IosUIController implements UIController {
    public function display() {
        echo("IosInterfaceController");
    }
}

//Wp
class WpOperationController implements OperationController {
    public function control() {
        echo("WpOperationController");
    }
}
class WpUIController implements UIController {
    public function display() {
        echo("WpInterfaceController");
    }
}


//=================== 抽象工厂
interface SystemFactory {
    public function createOperationController();
    public function createInterfaceController();
}

//Android
class AndroidFactory implements SystemFactory {
    public function createOperationController() {
        return new AndroidOperationController();
    }

    public function createInterfaceController() {
        return new AndroidUIController();
    }
}

//Ios
class IosFactory implements SystemFactory {
    public function createOperationController() {
        return new IosOperationController();
    }

    public function createInterfaceController() {
        return new IosUIController();
    }
}

//Wp
class WpFactory implements SystemFactory {
    public function createOperationController() {
        return new WpOperationController();
    }

    public function createInterfaceController() {
        return new WpUIController();
    }
}


//Android
$mFactory = new AndroidFactory();
//Ios
$mFactory = new IosFactory();
//Wp
$mFactory = new WpFactory();

$interfaceController = $mFactory->createInterfaceController();
$operationController = $mFactory->createOperationController();
$interfaceController->display();
$operationController->control();