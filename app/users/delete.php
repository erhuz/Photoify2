<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we delete users.

if (!USER_IS_LOGGEDIN) {
    set_alert('You need to be logged in to take this action.', 'warning');
    redirect('/');
}

if (!isset($_POST['confirm_password'], $_POST['confirm_checkbox'])) {
    set_alert('You need to enter your password and check the agreement checkbox', 'danger');
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

if (!password_verify($password, $result['password'])) {
    set_alert('Authentication failed. Account deletion aborted!', 'danger');
    redirect('/account.php');
}

// Retrieve avatar image name from database
$query = 'SELECT
        avatar
        FROM users
        WHERE users.id = :user_id;';

$stmt = $pdo->prepare($query);
$stmt->execute($params); // Parameters didn't change since last query
$avatar = $stmt->fetch(PDO::FETCH_ASSOC);

unlink('../..' . get_image($avatar['avatar'], 'avatar'));

// Retrieve post image names from database
$query = 'SELECT
        image
        FROM posts
        WHERE user_id = :user_id';

$stmt = $pdo->prepare($query);
$stmt->execute($params); // Parameters didn't change since last query
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Delete post images locally
foreach ($images as $image) {
    unlink('../..' . get_image($image['image'], 'post'));
}

// Delete reactions, comments, posts and user
$query = 'DELETE FROM reactions WHERE reactions.user_id = :user_id;';
$stmt = $pdo->prepare($query);
$stmt->execute($params); // Parameters didn't change since last query

$query = 'DELETE FROM comments WHERE comments.user_id = :user_id;';
$stmt = $pdo->prepare($query);
$stmt->execute($params); // Parameters didn't change since last query

$query = 'DELETE FROM posts WHERE posts.user_id = :user_id;';
$stmt = $pdo->prepare($query);
$stmt->execute($params); // Parameters didn't change since last query

$query = 'DELETE FROM users WHERE users.id = :user_id;';
$stmt = $pdo->prepare($query);

$stmt->execute($params); // Parameters didn't change since last query

// All data should have been deleted by now

set_alert('Your account has been deleted.', 'success');
set_alert('We\'re sad to see you go. You\'re welcome back at any time!', 'info');
unset($_SESSION['user']);
redirect('/');
