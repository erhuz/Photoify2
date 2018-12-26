<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we store/insert new posts in the database.

if(USER_IS_LOGGEDIN && isset($_FILES['image'], $_POST['description'])){
    $allow = array("jpg", "jpeg", "gif", "png");

    $upload_dir = __DIR__ . '/../../uploads/posts/';

    $file_extension = pathinfo($_FILES['image']['name'])['extension'];

    $file_name = hash("sha256", microtime(true) . $_FILES['image']['name']) . '.' . $file_extension;

    $upload_path = $upload_dir . $file_name;

    if ( in_array( $file_extension, $allow) ) { // is this file allowed
        if ( move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {

            // the file has been moved correctly
            $query = 'INSERT INTO posts (user_id, image, description) VALUES (:user_id, :image, :description);';
            $params = [
                ':user_id' => User['id'],
                ':image' => $file_name,
                ':description' => $_POST['description']
            ];
            $stmt = $pdo->prepare($query);

            if(!$stmt){
                die(var_dump($pdo->errorInfo()));
            }

            $result = $stmt->execute($params);

            set_alert('Successfully uploaded post!', 'success');
            redirect('/');
        } else {

            // the file wasn't moved correctly
            set_alert('Something went wrong, please try again!', 'danger');
            redirect('/');
        }
    } else {

        // error this file ext is not allowed
        set_alert("File extension <b>.$file_extension</b> not allowed. Allowed extensions: jpg, jpeg, gif, png", 'danger');
        redirect('/');
    }

}

set_alert('Something went wrong, please try again!', 'danger');
redirect('/');
