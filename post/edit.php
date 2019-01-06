<?php $page = 'post'; ?>

<?php require __DIR__.'/../views/header.php'; ?>

<?php
$post_id = intval(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));

$query = 'SELECT id, image, description FROM posts WHERE id=:id';
$params = [':id' => $post_id];

$stmt = $pdo->prepare($query);
if(!$stmt){
// REMOVE ME BEFORE PRODUCTION
    die(var_dump($pdo->errorInfo()));
}

$stmt->execute($params);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<article class="row">
    <div class="col">
        <h1>Edit post</h1>
    </div>
</article>

<article>
    <section class="row justify-content-center">
    <div class="col-md-6 post mt-2">
        <img id="img-preview-input" class="rounded" src="<?= get_image($post['image'], 'post') ?>" alt="Current image">
        <div class="btn btn-primary mt-2">Change image</div>
    </div>
    </section>
    <section class="row justify-content-center">
        <div class="col-md-6">
            <form class="create-post-form" action="/app/posts/update.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                <label class="mt-4 display-none" for="image">Picture</label>
                <input class="display-none" type="file" name="image" id="image">
                <label class="mt-4" for="content">Description</label>
                <textarea
                    class="form-control"
                    name="description"
                    id="description"
                    cols="20"
                    rows="5"
                    maxlength="128"
                    placeholder="Type something in your post!"
                    required
                ><?= $post['description'] ?></textarea>

                <input type="submit" class="btn btn-primary btn-block mt-2" value="Upload">
            </form>
        </div>
    </section>

</article>

<?php require __DIR__.'/../views/footer.php'; ?>
