<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we login users.
if(isset($_POST['email'], $_POST['password'])){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $query = 'SELECT * FROM users WHERE email=:email;';
    $stmt = $pdo->prepare($query);
    $stmt->execute([
       ':email' => $email
    ]);
    $result = $stmt->fetch();

    if(!$result){
        set_alert('Login failed: Email or password was invalid.', 'danger');
        redirect('/login.php');
    }


    if(password_verify($password, $result['password'])){
        $_SESSION['user'] = $result;

        set_alert('Login successfull!', 'success');
        redirect('/');
    }
        set_alert('Login failed: Email or password was invalid.', 'danger');
        redirect('/login.php');
}

set_alert('Something went wrong, please try again!', 'warning');
redirect('/login.php');
