<?php
declare (strict_types = 1);

require __DIR__.'/../autoload.php';
header('Content-Type: application/json');

// In this file we comment on posts and send the data back as encoded JSON.


if(!$stmt){
    // REMOVE ME BEFORE PRODUCTION
    die(var_dump($pdo->errorInfo()));
}

echo json_encode($data);
