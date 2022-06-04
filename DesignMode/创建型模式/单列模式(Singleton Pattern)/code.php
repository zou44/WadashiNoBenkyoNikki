<?php
/* =============================================================================#
# Date: 2022/6/5 0:46 
# Description: 
#============================================================================= */

// 懒汉式
class Singleton1
{
    // 实例
    private static $instance;

    // 构造函数私有化,禁止被实例化
    private function __construct()
    {
    }

    // 获得实例
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function message()
    {
        echo '输出消息';
    }
}

// 因为构造函数权限不对,所以没办法被是劣化
//$o = new Singleton1();
//$o->message();

//$o = Singleton1::getInstance();
//$o->message();

//======================================================

//饿汉式 - PHP不支持在表达式中new当前类,所以没办法展示
//class Singleton2
//{
//    private static $instance = new Singleton2();
//
//    private function __construct()
//    {
//
//    }
//
//    // 获得实例
//    public static function getInstance()
//    {
//        if (!self::$instance) {
//            self::$instance = new self;
//        }
//
//        return self::$instance;
//    }
//
//    public function message()
//    {
//        echo '输出消息';
//    }
//
//}