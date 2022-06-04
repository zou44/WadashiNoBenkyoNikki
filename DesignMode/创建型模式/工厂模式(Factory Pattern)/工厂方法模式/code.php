<?php
/* =============================================================================#
# Date: 2022/6/5 1:30
# Description:
#============================================================================= */

//================== 业务类
interface Shape  {
    public function draw();
}

//圆形
class CircleShape implements Shape {

    public function __construct()
    {
        echo "CircleShape: created";
    }

    public function draw() {
        echo  "draw: CircleShape";
    }
}

// 正方形
class RectShape implements Shape {

    public function __construct()
    {
        echo "RectShape: created";
    }

    public function draw() {
        echo  "draw: RectShape";
    }
}

//三角形
class TriangleShape implements Shape {

    public function __construct()
    {
        echo "TriangleShape: created";
    }

    public function draw() {
        echo  "draw: TriangleShape";
    }
}

//====================== 业务类结束


// 工厂类
interface ShapeFactory {
      public function getShape();
}

// 圆形工厂
class CircleShapeFactory implements ShapeFactory {

    public function getShape()
    {
        return new CircleShape();
    }

}

// 正方形工厂
class RectShapeFactory implements ShapeFactory {

    public function getShape()
    {
        return new RectShape();
    }

}


// 三角形工厂
class TriangleShapeFactory implements ShapeFactory {

    public function getShape()
    {
        return new TriangleShape();
    }

}

$o = new CircleShapeFactory();
$e = $o->getShape();
$e->draw();

$o = new RectShapeFactory();
$e = $o->getShape();
$e->draw();

$o = new TriangleShapeFactory();
$e = $o->getShape();
$e->draw();