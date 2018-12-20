<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we store/insert new posts in the database.

if(USER_LOGGEDIN && isset($_POST[''], $_POST[''])){
    $query = 'INSERT INTO posts (users_id, image, content) VALUES (:user_id, :image, :content);';

    $stmt = $pdo->prepare($query);

    $result = $stmt->execute($stmt, [
        ':user_id' => $_SESSION['user'][id],
        ':image' => '',
        ':content' => ''
    ]);

    if(!$result){
        $mess = 'EITHER: you are not logged in OR: some form inputs went missing';

        $_SESSION['messages'][] = $mess;
    }

}else{
    $mess = 'EITHER: you are not logged in OR: some form inputs went missing';

    $_SESSION['messages'][] = $mess;
}

redirect('/');
