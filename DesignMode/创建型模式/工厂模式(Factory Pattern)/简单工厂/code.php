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
class ShapeFactory {
      public static function getShape($type) {
          $shape = null;
          if ($type == 'circle') {
              $shape = new CircleShape();
          } else if ($type == 'rect') {
              $shape = new RectShape();
          } else if ($type == 'triangle') {
              $shape = new TriangleShape();
          }
          return $shape;
      }
}

$shape = ShapeFactory::getShape('circle');
$shape->draw();
$shape = ShapeFactory::getShape('rect');
$shape->draw();