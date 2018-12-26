<section class="col-md-10 col-lg-6">
    <div class="row post">
        <div class="col">
            <div class="card">

                <div class="card-header">
                    <div class="profile-picture-container">
                        <img class="profile-picture rounded-circle" src="<?= '/uploads/avatars/' . $post['avatar'] ?>"
                            alt="">
                    </div>
                    <h5 class="card-title"><a href="<?= '/posts.php?user=' . $post['user_id'] ?>">
                            <?= $post['name'] ?></a></h5>
                </div>

                <div class="card-image">
                    <img src="<?= '/uploads/posts/' . $post['image'] ?>" alt="<?= $post['description'] ?>">
                </div>

                <div class="card-body">
                    <div class="card-text">
                        <p>
                            <?= $post['description'] ?>
                        </p>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    Uploaded: <?= $post['created_at'] ?>
                </div>

            </div>
        </div>
    </div>
</section>
