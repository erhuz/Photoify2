<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we update users.

// Update account information
if(USER_IS_LOGGEDIN && isset($_POST['name'], $_POST['email'])){
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    if(isset($_POST['bio'])){
        $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
    }

    $query = 'UPDATE users SET name=:name, email=:email WHERE id=:id;';
    $params = [
        ':id' => User['id'],
        ':name' => $name,
        ':email' => $email
    ];

    if(isset($_POST['bio'])){
        $query = 'UPDATE users SET name=:name, email=:email, bio=:bio WHERE id=:id;';
        $params[':bio'] = $bio;
    }

    $stmt = $pdo->prepare($query);
    if($stmt->execute($params)){
        // $_SESSION['user'] only updates on login, this is a fix
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        if(isset($_POST['bio'])){
            $_SESSION['user']['bio'] = $bio;
        }

        set_alert('Update successfull!', 'success');
        redirect('/account.php');
    }


    set_alert('Update failed, please try again!', 'danger');
    redirect('/account.php');
}

// Password reset
if(USER_IS_LOGGEDIN && isset($_POST['password'], $_POST['c_password'])){
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $c_password = filter_var($_POST['c_password'], FILTER_SANITIZE_STRING);

    if($password !== $c_password){
        set_alert('Passwords did not match.', 'warning');
        redirect('/account.php');
    }

    $query = 'UPDATE users SET password=:password WHERE id=:id;';
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':id' => User['id'],
        ':password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    set_alert('Password updated successfully!', 'success');
    redirect('/account.php');
}

// Change avatar
if(USER_IS_LOGGEDIN && isset($_FILES['avatar'])){
    // Allowed file extensions
    $allow = array("jpg", "jpeg", "gif", "png");

    $upload_dir = __DIR__ . '/../../uploads/avatars/';

    $file_extension = pathinfo($_FILES['avatar']['name'])['extension'];

    $file_name = hash("sha256", microtime(true) . $_FILES['avatar']['name']) . '.' . $file_extension;

    $upload_path = $upload_dir . $file_name;

    if ( in_array( $file_extension, $allow) ) { // is this file allowed
        if ( move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_path)) {

            // the file has been moved correctly
            $query = 'UPDATE users SET avatar = :avatar WHERE id=:id;';
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':id' => User['id'],
                ':avatar' => $file_name
            ]);

            // Delete last used avatar if set
            if(User['avatar'] !== 'avatar.png'){
                unlink ( $upload_dir . User['avatar']);
            }

            // $_SESSION['user'] only updates on login, this is a fix for the avatar
            $_SESSION['user']['avatar'] = $file_name;

            set_alert('Successfully changed avatar!', 'success');
            redirect('/account.php');
        } else {

            // the file wasn't moved correctly
            set_alert('Something went wrong, please try again!', 'danger');
            redirect('/account.php');
        }
    } else {

        // error this file ext is not allowed
        set_alert("File extension <b>.$file_extension</b> not allowed. Allowed extensions: jpg, jpeg, gif, png", 'danger');
        redirect('/account.php');
    }
}



set_alert('Something went wrong, please try again!', 'danger');
redirect('/account.php');
