<?php require __DIR__.'/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <p>This is the home page.</p>
</article>

<article>
    <form action="/app/posts/store.php" method="post" enctype="multipart/form-data">
        <label for="image">Picture</label>
        <input type="file" name="image" id="image">

        <label for="content">Description / Content</label>
        <textarea name="content" id="content" cols="20" rows="10"></textarea>

        <input type="submit" value="Upload">
    </form>
</article>

<?php require __DIR__.'/views/footer.php'; ?>
