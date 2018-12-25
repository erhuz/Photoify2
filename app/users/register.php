<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we register users.

if(isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['c_password'])){
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $c_password = filter_var($_POST['c_password'], FILTER_SANITIZE_STRING);

    if($password !== $c_password){
        set_alert('Passwords did not match.', 'warning');
        redirect('/');
    }

    $query = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password);';
    $params = [
        ':name' => $name,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    $stmt = $pdo->prepare($query);
    if($stmt->execute($params)){
        set_alert('Registration successfull!', 'success');
        redirect('/login.php');
    }

    set_alert('Email is already associated with another account.', 'danger');
    redirect('/register.php');
}


set_alert('Something went wrong, please try again!', 'danger');
redirect('/');
