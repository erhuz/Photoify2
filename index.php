<?php $page = 'home'; ?>

<?php require __DIR__.'/views/header.php'; ?>

<?php
    $query = 'SELECT posts.id, user_id, posts.image, posts.description, posts.created_at, users.name, users.avatar
    FROM posts
    JOIN users ON posts.user_id = users.id
    ORDER BY posts.created_at DESC;
    ';

    $stmt = $pdo->prepare($query);

    if(!$stmt){
 // REMOVE ME BEFORE PRODUCTION
        die(var_dump($pdo->errorInfo()));
    }

    $stmt->execute();
    $posts = $stmt->fetchAll();
?>
<article class="row">
    <h1 class="col-12">
        <?= $config['title']; ?>
    </h1>
    <p class="col-12">Welcome to <?= $config['title'] ?>. Sign up to get started or check out the posts below!</p>

    <?php if(USER_IS_LOGGEDIN): ?>
    <div class="col-12">
        <a href="/post.php" class="mr-2 btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create Post</button>
        <a href="#" class="mr-2 btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Manage Posts</a>
    </div>
    <?php endif; ?>

</article>

<article class="row">
    <?php foreach($posts as $post): ?>
        <?php require __DIR__.'/views/components/post.php'; ?>
    <?php endforeach; ?>
</article>

<?php require __DIR__.'/views/footer.php'; ?>
