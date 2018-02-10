<?php
class  Car {

    public $brand = 123;
    public $model;
    public $price;

    function drive()
    {
        echo $this->drive;
    }
    function stop()
    {
        echo 'Stop';
    }
}
$car1 = new Car();
$car1 -> brand = 'Mazda';
$car1 ->model ='6';
$car1 -> drive();

$car2 = new Car();

$car2 -> brand = 'BMW';
$car2 ->model = 'x6';
$car2 ->price = 2000;
var_dump($car1, $car2);

?>


