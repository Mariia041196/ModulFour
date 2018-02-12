<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS . '..' . DS . 'src' . DS);
define('VIEW_DIR', ROOT . 'View' . DS);
define('VENDOR_DIR', ROOT . '..' . DS . 'vendor' . DS);
define('CONF_DIR', ROOT . '..' . DS . 'config' . DS);
require VENDOR_DIR . 'autoload.php';
try {
    // parse config
    $config = Symfony\Component\Yaml\Yaml::parse(file_get_contents(CONF_DIR . 'config.yml'));
    $parameters = $config['parameters'];
    $routing = $config['routing'];

    $dsn = "mysql: host={$parameters['database_host']}; dbname={$parameters['database_name']}";

    \Framework\Session::start();

    $loader = new \Twig_Loader_Filesystem(VIEW_DIR);
    $twig = new \Twig_Environment($loader);

    $request = new \Framework\Request($_GET, $_POST, $_SERVER, $_FILES);
    $container = new \Framework\Container();

    // create objects for container
    $dbConnection = new \PDO(
        $dsn,
        $parameters['database_user'],
        $parameters['database_password']
    );
    $dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $router = new \Framework\Router($routing);

    $repositoryFactory = new \Framework\RepositoryFactory();
    $repositoryFactory->setPdo($dbConnection);

    $twig->addExtension(new \Framework\Twig\AppExtension($router));

    $cartService = new \Model\Service\CartService();
    $pdfExport = new \Model\Service\PDFExport();

    $container
        ->set('pdo', $dbConnection)
        ->set('router', $router)
        ->set('repository_factory', $repositoryFactory)
        ->set('twig', $twig)
        ->set('cart_service', $cartService)
        ->set('pdf_export', $pdfExport)
    ;

    $router->match($request);

    $controller = $request->get('controller', 'Default');
    $action = $request->get('action', 'index');

    // go!
    $controller = '\\Controller\\' . $router->getCurrentController();
    $action = $router->getCurrentAction();

    if (!class_exists($controller)) {
        throw new \Exception("Controller {$controller} not found");
    }

    $controller = new $controller();
    $controller->setContainer($container);
    $controller->doLayoutDecision();

    // var_dump($controller);die;

    if (!method_exists($controller, $action)) {
        throw new \Exception("Action {$action} not found");
    }

    $content = $controller->$action($request);

} catch (\Framework\Exception\NotFoundException $e) {
    $controller = new \Controller\ErrorController($e);
    $controller->setContainer($container);
    $content = $controller->error404Action();
} catch (\Exception $e) {
    $controller = new \Controller\ErrorController($e);
    $controller->setContainer($container);
    $content = $controller->errorAction();
}
echo $content;