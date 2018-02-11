<?php
namespace One;
class  Car {

    public $brand = 123;
    public $model;
    private $price;
    private $state = 'static';

    public function __construct($brand, $model)
    {
        echo 'This is class cr 1';
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

        //$waste = new Waste();
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