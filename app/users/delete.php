<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we delete users.

if(!USER_IS_LOGGEDIN){
    set_alert('You need to be logged in to take this action.', 'warning');
    redirect('/');
}

if(!isset($_POST['confirm_password'], $_POST['confirm_checkbox'])){
    set_alert('Authentication failed. Account deletion aborted!', 'danger');
    redirect('/account.php');
}

$password = $_POST['confirm_password'];

$query = 'SELECT password FROM users WHERE id = :user_id';
$params = [
    ':user_id' => User['id']
];

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

die(var_dump($result));


// Validate password and checkbox value
    // Delete user together with posts, reactions, comments and local images
