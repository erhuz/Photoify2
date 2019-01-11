<?php
declare (strict_types = 1);

require __DIR__.'/../app/autoload.php';

// In this file we like posts and send the data back as encoded JSON.
if(!USER_IS_LOGGEDIN){
    // End execution and send error
    $data = ['result' => false];

    header('Content-Type: application/json');
    echo json_encode($data);
    die;
}

// Sanitize user input
$post_id = intval(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
$status = intval(filter_var($_GET['status'], FILTER_SANITIZE_NUMBER_INT));

// Declare valid states on status [1 = like, -1 = dislike]
$status_accept = [1, -1];

// Check if status doesn't have a valid value
if(!in_array($status, $status_accept)){
    // End execution and send error
    $data = ['result' => false];

    header('Content-Type: application/json');
    echo json_encode($data);
    die;
}


// Check if row exists in table.
$query = 'SELECT status FROM reactions WHERE post_id = :post_id AND user_id = :user_id;';

$params = [
    ':post_id' => $post_id,
    ':user_id' => User['id']
];
$stmt = $pdo->prepare($query);

// Check if execution was valid
if(!$stmt->execute($params)){
    $data = ['result' => ['error' => 'Query did not execute propperly.']];

    header('Content-Type: application/json');
    echo json_encode($data);
    die;
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// If status index is set, get the integer value
if(isset($result['status'])){
    $result['status'] = intval($result['status']);
}


if(!$result){ // Check if result returned false
    // Row not found
    $data = [
        'result' => 'Row not found'
    ];

    $query = 'INSERT INTO reactions(user_id, post_id, status) VALUES(:user_id, :post_id, :status)';
    $params = [
        ':post_id' => $post_id,
        ':user_id' => User['id'],
        ':status' => $status
    ];

}elseif($result['status'] === $status){ // Check if recieved status equals user sent status
    // Result same as recieved
    $data = [
        'result' => 'Result same as recieved'
    ];

    $query = 'DELETE FROM reactions WHERE post_id = :post_id AND user_id = :user_id;';

    $params = [
        ':post_id' => $post_id,
        ':user_id' => User['id']
    ];
}else{ // If recieved status does not equal user sent status
    // Result not same as recieved, updated status.
    $data = [
        'result' => 'Result not same as recieved, updated status'
    ];

    $query = 'UPDATE reactions SET status=:status WHERE post_id = :post_id AND user_id = :user_id;';

    $params = [
        ':post_id' => $post_id,
        ':user_id' => User['id'],
        ':status' => $status
    ];
}

// Prepare query
try {
    $stmt = $pdo->prepare($query);
    if(!$stmt->execute($params)){
        echo $query;
        echo 'shit';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br />\n";
}

// Get updated likes / dislikes
$query = 'SELECT
        posts.id,
        posts.user_id,
        posts.image,
        posts.description,
        posts.created_at,
        users.name,
        users.avatar,
        COALESCE(SUM(reactions.status = 1), 0 ) as likeCount,
        COALESCE(SUM(reactions.status = -1), 0 ) as dislikeCount

    FROM posts
    JOIN users ON posts.user_id = users.id
    LEFT OUTER JOIN reactions ON posts.id = reactions.post_id
    WHERE posts.id = :id
    GROUP BY posts.id
    ORDER BY posts.created_at DESC;';

$params = [':id' => $post_id];
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Send updated stats to client
$data['likes'] = $result['likeCount'];
$data['dislikes'] = $result['dislikeCount'];

header('Content-Type: application/json');
echo json_encode($data);
die;
