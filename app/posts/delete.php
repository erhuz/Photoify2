<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we delete posts in the database.
if (!USER_IS_LOGGEDIN) {
    set_alert('You need to be logged in to take this action.', 'danger');
    redirect('/');
}

$post_id = intval(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));

$query = 'DELETE FROM posts WHERE id = :post_id AND user_id = :user_id;';
$params = [
    ':post_id' => $post_id,
    ':user_id' => User['id']
];

$stmt = $pdo->prepare($query);
if (!$stmt->execute($params)) {
    set_alert('This post doesn\'t appear to exist', 'danger');
    redirect('/');
}

set_alert('Post successfully deleted.', 'warning');
redirect('/profile.php?id=' . User['id']);
