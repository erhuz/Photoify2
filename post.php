<?php require __DIR__.'/views/header.php'; ?>

<article class="row">
    <h1>New post</h1>
</article>

<article>
    <section class="row justify-content-center">
    <div class="card-image">
        <img class="" src="<?= $post['description'] ?>" alt="Card image cap">
    </div>
    </section>
    <section class="row justify-content-center">
        <div class="col-md-6">
            <form action="/app/posts/store.php" method="post" enctype="multipart/form-data">
                <label class="mt-4" for="image">Picture</label>
                <input type="file" name="image" id="image" required>

                <label class="mt-4" for="content">Description / Content</label>
                <textarea
                    class="form-control"
                    name="content"
                    id="content"
                    cols="20"
                    rows="5"
                    maxlength="128"
                    placeholder="Type something in your post!"
                    required
                ></textarea>

                <input type="submit" class="btn btn-primary btn-block mt-2" value="Upload">
            </form>
        </div>
    </section>

</article>

<?php require __DIR__.'/views/footer.php'; ?>
