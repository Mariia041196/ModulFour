<?php
//sql_autoload_register(function () {
//$file = "{$className}.php";
//if (!file_exists($file)){
//    die("{$file} not found");
//}
//require $className . '.php';
//});
//function __autoload($className)
//{
//    $file = "{$className}.php";
//    if (!file_exists($file)){
//        die("{$file} not found");
//    }
//    require $className . '.php';
//}


//$className = 'Car';
require 'Car1.php';
require 'Figure.php';
$car1 = new One\Car('Mazda', 6);
$car1->setPrice(1000);
//$car1->drive();


$car2 = new One\Car('BMW', 6);
var_dump($car1, $car2);
$figureNames = ['Circl','Trander'];
$lenght = count($figureNames);
$figures = [];
for ($i = 1; $i <= 10; $i++) {
     $index = rand(0, $lenght - 1);
     $figure = $figures[$index];
     $figure = new $figure();
     $figures[] = $figure;
}
var_dump($figures);


?>


