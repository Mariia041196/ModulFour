<?php
$dsn = 'mysql: host=localhost; dbname=news';
$user = 'root';
$pass = '';
try {
    $pdo = new \PDO($dsn , $user, $pass);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE,
    \PDO::ERRMODE_EXCEPTION);
    //var_dump($pdo);

    $query = 'select *from feedback where id = :NUMBER';

    $sth = $pdo->prepare('$query');
    $sth->execute([
    'NUMBER' => 1
    ]);
    $data = $sth->fetch(PDO::FETCH_ASSOC);
    //var_dump($data);
} catch (\PDOException $e) {
    echo $e->getMessage();
}

?>