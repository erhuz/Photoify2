<?php
declare (strict_types = 1);

require __DIR__.'/../autoload.php';
header('Content-Type: application/json');

// In this file we comment on posts and send the data back as encoded JSON.

$stmt = true;
if(!$stmt){
    // REMOVE ME BEFORE PRODUCTION
    die(var_dump($pdo->errorInfo()));
}

if($_GET['action'] === 'read'){
    $comments = [
        ['avatar' => '', 'name' => 'Benjamin Fransson', 'content' => 'This is a comment'],
        ['avatar' => '', 'name' => 'André Broman', 'content' => 'This commen thing isn\'t really me. ']
    ];

    $data = $comments;
}

echo json_encode($data);
