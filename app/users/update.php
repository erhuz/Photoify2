<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we update users.


if(USER_IS_LOGGEDIN && isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['c_password'])){
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $c_password = filter_var($_POST['c_password'], FILTER_SANITIZE_STRING);

    if($password !== $c_password){
        set_alert('Passwords did not match.', 'warning');
        redirect('/');
    }

    $query = 'UPDATE users SET name=:name, email=:email, password=:password WHERE id=:id;';
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':id' => User['id'],
        ':name' => $name,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    set_alert('Update successfull!', 'success');
    redirect('/');
}


set_alert('Something went wrong, please try again!', 'danger');
redirect('/');
