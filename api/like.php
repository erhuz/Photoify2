<?php
declare (strict_types = 1);

require __DIR__.'/../app/autoload.php';

/** PSUEDO
 *  Check if row exists w/status
 *      if status === inputStatus
 *          remove row
 *      if status !== inputStatus
 *          update row w/ new status
*/

// In this file we like posts and send the data back as encoded JSON.
if(!USER_IS_LOGGEDIN){
    $data = ['result' => false];

    header('Content-Type: application/json');
    echo json_encode($data);
    die;
}

$post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$status = filter_var($_GET['status'], FILTER_SANITIZE_NUMBER_INT);

// Check if row exists in table.
$query = 'SELECT 1 FROM likes WHERE post_id = :post_id AND user_id = :user_id;';
$params = [
    ':post_id' => $post_id,
    ':user_id' => User['id']
];

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$results = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($results[1])){
    if($status !== $results[1]){
        $data = ['result' => 'conflict'];

        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }
    $liked = true;
}else{
    $liked = false;
}


if($liked){
    $query = 'DELETE FROM likes WHERE user_id=:user_id AND post_id=:post_id AND status=:status;';
    $params = [
        ':user_id' => User['id'],
        ':post_id' => $post_id,
        ':status' => $status
    ];
    $stmt = $pdo->prepare($query);

    // REMOVE ME BEFORE PRODUCTION
    if(!$stmt){
        die(var_dump($pdo->errorInfo()));
    }

    $result = $stmt->execute($params);

    $data = ['result' => 'removed'];

    header('Content-Type: application/json');
    echo json_encode($data);
    die;

}else{
    $query = 'INSERT INTO likes (user_id, post_id, status) VALUES (:user_id, :post_id, :status);';
    $params = [
        ':user_id' => User['id'],
        ':post_id' => $post_id,
        ':status' => $status
    ];

    $stmt = $pdo->prepare($query);
    $result = $stmt->execute($params);

    // REMOVE ME BEFORE PRODUCTION
    if(!$stmt){
        die(var_dump($pdo->errorInfo()));
    }
}

$data = ['result' => 'inserted'];

header('Content-Type: application/json');
echo json_encode($data);
