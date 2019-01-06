<?php $page = 'home'; ?>

<?php require __DIR__.'/views/header.php'; ?>

<?php
$query = 'SELECT
        posts.id,
        posts.user_id,
        posts.image,
        posts.description,
        posts.created_at,
        users.name,
        users.avatar,
        ifnull((SELECT COUNT(reactions.status) WHERE reactions.status = 1), 0 ) as likeCount,
        ifnull((SELECT COUNT(reactions.status) WHERE reactions.status = 2), 0 ) as dislikeCount

    FROM posts
    JOIN users ON posts.user_id = users.id
    LEFT OUTER JOIN reactions ON posts.id = reactions.post_id
    GROUP BY posts.id, users.id, reactions.status
    ORDER BY posts.created_at DESC;';

    $stmt = $pdo->prepare($query);

    if(!$stmt){
 // REMOVE ME BEFORE PRODUCTION
        die(var_dump($pdo->errorInfo()));
    }

    $stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<pre>
    <?php print_r($posts); ?>
</pre>
<article class="row">
    <h1 class="col-12">
        <?= $config['title']; ?>
    </h1>
    <p class="col-12">Welcome to <?= $config['title'] ?>. Sign up to get started or check out the posts below!</p>

    <?php if(USER_IS_LOGGEDIN): ?>
    <div class="col-12">
        <a href="/post/new.php" class="mr-2 btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create Post</a>
        <a href="/users.php?id=<?= User['id'] ?>" class="mr-2 btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Manage Posts</a>
    </div>
    <?php endif; ?>

</article>

<article id="post-container" class="row">
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
</article>

<?php require __DIR__.'/views/footer.php'; ?>
