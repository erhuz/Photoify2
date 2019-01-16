<?php
declare (strict_types = 1);

require __DIR__. '/../app/autoload.php';

// In this file we comment on posts and send the data back as encoded JSON.
$data; // Define the output variable

if(!isset($_POST['id'], $_POST['action']) || !USER_IS_LOGGEDIN){
    $data = false;

    header('Content-Type: application/json');
    echo json_encode($data);
    die();
}

$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
$action = filter_var($_POST['action'], FILTER_SANITIZE_STRING);

if(isset($_POST['content'])){
    $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
}

if($action === 'read'){

    $query = 'SELECT
                comments.description,
                users.id,
                users.name,
                users.avatar
            FROM comments
            JOIN users ON users.id = comments.user_id
            WHERE post_id = :post_id
            ORDER BY comments.created_at;';
    $params = [
        ':post_id' => $id
    ];

    $stmt = $pdo->prepare($query);

    if(!$stmt){
        // REMOVE ME BEFORE PRODUCTION
        die(var_dump($pdo->errorInfo()));
    }

    $stmt->execute($params);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $tmp_comments = array(); // Define variable
    foreach ($comments as $comment) {
        $tmp_comments[] = [
            'user_id' => $comment['id'],
            'avatar' => get_image($comment['avatar'], 'avatar'),
            'name' => $comment['name'],
            'content' => $comment['description']
        ];
    }
    $data = $tmp_comments;
}elseif($action === "store"){
    $data['result'] = 'Store action recieved';
    $query = 'INSERT INTO comments (user_id, post_id, description) VALUES (:user_id, :post_id, :description)';
    $params = [
        ':user_id' => User['id'],
        ':post_id' => $id,
        ':description' => $content
    ];

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);


}else{
    $data = false;
}

// Remove this and tell people you optimized your application
// sleep(1);

header('Content-Type: application/json');
echo json_encode($data);
die;
