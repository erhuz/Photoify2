<?php
declare (strict_types = 1);

require __DIR__.'/../autoload.php';

// In this file we like posts.

if(!$stmt){
 // REMOVE ME BEFORE PRODUCTION
    die(var_dump($pdo->errorInfo()));
}
