<?php $page = 'post'; ?>

<?php require __DIR__.'/views/header.php'; ?>

<article class="row">
    <div class="col">
        <h1>New post</h1>
    </div>
</article>

<article>
    <section class="row justify-content-center">
    <div class="col-md-6 post mt-2">
        <img id="img-preview-input" class="rounded" src="/uploads/posts/Placeholder.png" alt="Placeholder image">
        <div class="btn btn-primary mt-2">Change image</div>
    </div>
    </section>
    <section class="row justify-content-center">
        <div class="col-md-6">
            <form class="create-post-form" action="/app/posts/store.php" method="post" enctype="multipart/form-data">
                <label class="mt-4 display-none" for="image">Picture</label>
                <input class="display-none" type="file" name="image" id="image" required>
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
                ></textarea>

                <input type="submit" class="btn btn-primary btn-block mt-2" value="Upload">
            </form>
        </div>
    </section>

</article>

<?php require __DIR__.'/views/footer.php'; ?>
