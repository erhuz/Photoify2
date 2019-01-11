<?php
declare (strict_types = 1);

require __DIR__. '/../app/autoload.php';

// In this file we comment on posts and send the data back as encoded JSON.
$data = ''; // Define the output variable

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);


if($_GET['action'] === 'read'){

    $query = 'SELECT
                comments.description,
                users.id,
                users.name,
                users.avatar
            FROM comments
            JOIN users ON users.id = comments.user_id
            WHERE post_id = :post_id;';
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
}elseif(_GET['action'] === 'store'){
    $data = 'action status => store';
}


header('Content-Type: application/json');
echo json_encode($data);
die;
