<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we store/insert new posts in the database.

if(USER_LOGGEDIN && isset($_POST['image'], $_POST['content'])){

    dd($_POST['image']);

    $file_parts = pathinfo($_POST['image']);
    $file_parts['extension'];

    // $image = filter_var();
    $content = filter_var();

    $query = 'INSERT INTO posts (users_id, image, content) VALUES (:user_id, :image, :content);';
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute($stmt, [
        ':user_id' => User[id],
        ':image' => '',
        ':content' => ''
    ]);

    if(!$result){
        set_alert('Something went wrong, Please try again!', 'danger');
    }

}else{
    set_alert('EITHER: you are not logged in OR: some form inputs went missing.', 'danger');
}

redirect('/');
