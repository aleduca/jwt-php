<?php

require '../vendor/autoload.php';

use app\database\Connection;
use Firebase\JWT\JWT;

header('Access-Control-Allow-Origin: *');


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$email = strip_tags($_POST['email']);
$password = strip_tags($_POST['password']);

$pdo = Connection::connect();

$prepare = $pdo->prepare('select * from users where email = :email');
$prepare->execute([
    'email' => $email,
]);

$userFound = $prepare->fetch();

if (!$userFound) {
    http_response_code(401);
}

if (!password_verify($password, $userFound->password)) {
    http_response_code(401);
}

$payload = [
    'exp' => time() + 10,
    'iat' => time(),
    'email' => $email,
];

$encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');

echo json_encode($encode);
