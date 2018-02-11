<?php
class  Car {

    public $brand = 123;
    public $model;
    private $price;
    private $state = 'static';

    public function __construct($brand, $model)
    {
        $this->brand = $brand;
        $this->model = $model;

    }

    public function __destruct()
    {

    }

   // function test() {
   //     $this->brand;
    //}
    function drive()
    {
       $this->state = 'moving';
    }
    function stop()
    {
        if ($this->isMoving()) {
            echo 'You are not moving';
        } else {
            $this->state = 'static';
        }
    }
    function isMoving()
    {
        return $this->state != 'moving';
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        if(!is_numeric($price)){
            die('Invalid price');
        }
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }
}
$car1 = new Car('Mazda', 6);
$car1->setPrice(1000);


$car2 = new Car('BMW', 6);
var_dump($car1, $car2);

?>


