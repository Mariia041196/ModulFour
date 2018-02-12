<?php
class Count
{
    private static $createdAmount = 0;
    public $a;
    public $b;

    public function __construct()
    {
        $this->a = rand(1,100);
        $this->b = rand(1,100);

        self::$createdAmount++;
    }
    public function __clone()
    {
        self::$createdAmount++;
    }
    public function __destruct()
    {
        self::$createdAmount--;
    }


    /**
     * @return int
     */
    public static function getCreatedAmount()
    {
        return self::$createdAmount;
    }
}


?>