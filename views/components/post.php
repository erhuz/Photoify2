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

                <?php if($post['user_id'] === User['id']): ?>
                <div class="container">
                    <div class="row">
                        <button type="button" class="delete btn btn-danger btn-sm rounded-0 col-6"><i class="fa fa-trash-o"
                                aria-hidden="true"></i> Delete</button>
                        <button type="button" class="edit btn btn-warning btn-sm rounded-0 col-6"><i class="fa fa-pencil-square-o"
                                aria-hidden="true"></i> Edit</button>
                    </div>
                </div>
                <?php endif; ?>

                <div class="card-image">
                    <img src="<?= '/uploads/posts/' . $post['image'] ?>" alt="<?= $post['description'] ?>">
                </div>

                <div class="container">
                    <div class="row">
                        <button type="button" class="like btn btn-light rounded-0 col-6"><i class="fa fa-thumbs-o-up"
                                aria-hidden="true"></i> Like</button>
                        <button type="button" class="dislike btn btn-light rounded-0 col-6"><i class="fa fa-thumbs-o-down"
                                aria-hidden="true"></i> Dislike</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-text">
                        <p class="mb-0">
                            <?= $post['description'] ?>
                        </p>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-8">
                            Uploaded:
                            <?= $post['created_at'] ?>
                        </div>
                        <div class="col text-right">
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 31
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
