<?php
spl_autoload_register(function  ($className) {
    $file = "{$className}.php";

    $file = str_replace(
        '\\',
        DIRECTORY_SEPARATOR,
        $file
    );
    if (!file_exists($file)){
        throw new \Exception("{$file} not found");
    }
    require_once $file;
});
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS);
define('VIEW_DIR', ROOT . 'View' . DS);

$dbConfig = [
    'user' => 'root',
    'pass' => '',
    'host' => 'localhost',
    'dbname' => 'news'
];
$dsn = "mysql: host={$dbConfig['host']}; dbname={$dbConfig['dbname']};";

$request = new \Framework\Request($_GET, $_POST, $_FILES);

$dbConection = new\PDO($dsn, $dbConfig['user'], $dbConfig['pass']);
$dbConection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);

$controller = $request->get('controller', 'Default');
$action = $request->get('action', 'index');

$controller = '\\Controller\\'. $controller . 'Controller';
$controller = new $controller();

$action .= 'Action'; //feedback action

if (!method_exists($controller, '$action')) {
    throw new \Exception("Action {$action} Not found");
};

$content = $controller->$action;


require VIEW_DIR . 'layout.phtml';

