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
require 'index.html';

$dsn = 'mysql: host=localhost; dbname=news';
$user = 'root';
$pass = '';

$pdo = new \PDO($dsn , $user, $pass);

$pdo->setAttribute(\PDO::ATTR_ERRMODE,
    \PDO::ERRMODE_EXCEPTION);

$request = new Request($_GET, $_POST);
$form = new Feedback ($request->post('email'),
     $request->post('message'));
 if ($request->isPost()) {
     if($form->isValid()) {
        echo 'Valid';
         $query = 'insert into feedback (email, message)
values (:email, :message)';

         $sth = $pdo->prepare('$query');
         $sth->execute([
             'email' => $form->email,
             'message' => $form->message
         ]);
     }
 }
