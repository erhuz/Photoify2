<?php $page = 'post'; ?>

<?php require __DIR__.'/views/header.php'; ?>

<?php
if(!isset($_GET['id'])){
    set_alert('No user ID specified. Redirected', 'warning');
    redirect('/');
}

$user_id = intval(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));

$query = 'SELECT
        users.id,
        users.name,
        users.avatar,
        users.bio,
        users.avatar,
        users.created_at,
        COALESCE(SUM(reactions.status = 1), 0 ) as likeCount,
        COALESCE(SUM(reactions.status = -1), 0 ) as dislikeCount


    FROM users
    LEFT OUTER JOIN reactions ON reactions.user_id = users.id
    WHERE users.id = :id
    GROUP BY users.id;';

$params = [':id' => $user_id];

$stmt = $pdo->prepare($query);
if(!$stmt){
    die(var_dump($pdo->errorInfo()));

}
$stmt->execute($params);
$user = $stmt->fetch(PDO::FETCH_ASSOC);



// if(!$user){
//     set_alert('User doesn\'t exists. Redirected', 'warning');
//     redirect('/');
// }

// echo "<pre>";
// die(print_r($user));

$joined_date = date('d/m/Y', strtotime($user['created_at']));




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
    JOIN users ON posts.user_id = users.id AND users.id = :id
    LEFT OUTER JOIN reactions ON posts.id = reactions.post_id
    GROUP BY posts.id
    ORDER BY posts.created_at DESC;';

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="profile">
    <header class="row shadow mx-1 p-4 rounded iconic-gradient-bg">
        <div class="col-md-3 col-lg-2">
            <img class="profile-img rounded-circle" src="<?= get_image($user['avatar'], 'avatar') ?>" alt="<?= $user['name'] ?>">
        </div>
        <div class="col d-flex flex-center">
            <h1 class="text-light"><?= $user['name'] ?></h1>
        </div>
    </header>

    <article class="row mt-4 mx-0 d-flex justify-content-center">
        <?php if(strlen($user['bio']) > 0): ?>
        <div class="col">
            <div class="row">
                <div class="col-sm-12 m-2 section shadow-sm p-3 rounded border border-light profile-info"><b>Biography<br><br></b> <?= $user['bio']; ?></div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-md-12">
            <div class="row d-flex justify-content-center">
                <div class="col white-space-nowrap m-2 section shadow-sm p-3 rounded border border-light profile-info"><b>Joined:</b> <?= $joined_date ?></div>
                <div class="col white-space-nowrap m-2 section shadow-sm p-3 rounded border border-light profile-info"><b>Likes:</b> <?= $user['likeCount'] ?></div>
                <div class="col white-space-nowrap m-2 section shadow-sm p-3 rounded border border-light profile-info"><b>Dislikes:</b> <?= $user['dislikeCount'] ?></div>
                <div class="col white-space-nowrap m-2 section shadow-sm p-3 rounded border border-light profile-info"><b>Comments:</b> <?= $user['id'] ?></div>
            </div>
        </div>

    </article>

    <article id="post-container" class="row">
        <h2 class="mx-2 mt-4 col-12"><?= $user['name'] ?>'s posts</h2>
        <?php if(count($posts) > 0): ?>
            <?php foreach($posts as $post): ?>

                <?php
                    create_post(
                        $post['id'],
                        $post['image'],
                        $post['description'],
                        $post['created_at'],
                        $post['user_id'],
                        $post['name'],
                        $post['avatar'],
                        $post['likeCount'],
                        $post['dislikeCount']
                    );
                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <h4 class="mx-4 mt-2">This user have not posted anything yet.</h4>
        <?php endif; ?>
    </article>
</div>

<?php require __DIR__.'/views/footer.php'; ?>
