<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we delete posts in the database.

if(!USER_IS_LOGGEDIN){
    set_alert('You must be logged in to take this action.');
    redirect('/');
}

if(!isset($_POST['post_id'], $_POST['description'])){
    set_alert('Input missing, update aborted.', 'danger');
    redirect('/post/edit.php?id=' . $post_id);
}

$post_id = intval(filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT));
$description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

echo '<pre>';
// description upload fail will not kill script,
// due to image upload can still succeed
if(strlen($description) > 0){
    $query = 'UPDATE posts SET description = :description WHERE id=:id';
    $params = [
        ':description' => $description,
        ':id' => $post_id
    ];

    $stmt = $pdo->prepare($query);
    if(!$stmt->execute($params)){
        set_alert('Description upload failed.', 'danger');
    }else{
        set_alert('Successfully updated post description!', 'success');
    }

}else{
    set_alert('Failed to update post description.', 'danger');
}

if(strlen($_FILES['image']['tmp_name']) > 1){
    // Setup variables for file upload
    $allow = array("jpg", "jpeg", "gif", "png"); // Allowed file extensions
    $upload_dir = __DIR__ . '/../../uploads/posts/';
    $file_extension = pathinfo($_FILES['image']['name'])['extension'];
    $file_name = hash("sha256", microtime(true) . $_FILES['image']['name']) . '.' . $file_extension;
    $upload_path = $upload_dir . $file_name;

    $query = 'SELECT image FROM posts WHERE id=:id';
    $params = [':id' => $post_id];

    $stmt = $pdo->prepare($query);
    if ($stmt->execute($params)) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_img = $result['image'];

        if (in_array($file_extension, $allow)) { // if this file extension allowed
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) { // try to move file

            // the file has been moved correctly
                $query = 'UPDATE posts SET image = :image WHERE id=:id;';
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                ':id' => $post_id,
                ':image' => $file_name
            ]);

                // Delete "current image"
                unlink($upload_dir . $current_img);

                set_alert('Successfully edited post image!', 'success');
                redirect('/post/edit.php?id=' . $post_id);
            } else {

            // the file wasn't moved correctly
                set_alert('Failed to update post image.', 'danger');
                redirect('/post/edit.php?id=' . $post_id);
            }
        } else {

        // error this file ext is not allowed
            set_alert("File extension <b>.$file_extension</b> not allowed. Allowed extensions: jpg, jpeg, gif, png", 'danger');
            redirect('/post/edit.php?id=' . $post_id);
        }
    }
}

redirect('/');
