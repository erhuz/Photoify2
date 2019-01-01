<section class="col-md-10 col-lg-6">
    <div class="row post" data-id="<?= $post_id ?>">
        <div class="col">
            <div class="card">

                <div class="card-header">
                    <div class="profile-picture-container">
                        <img class="profile-picture rounded-circle" src="<?= get_image($user_avatar, 'avatar') ?>"
                            alt="">
                    </div>
                    <h5 class="card-title">
                        <a href="<?= '/posts.php?user=' . $user_id ?>">
                            <?= $user_name ?>
                        </a>
                    </h5>
                </div>
                <?php if(USER_IS_LOGGEDIN && $user_id === User['id']): ?>
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
                    <img src="<?= get_image($post_image, 'post') ?>" alt="<?= $post_description ?>">
                </div>

                <div class="container">
                    <div class="row">
                        <button type="button" class="like btn btn-primary m-2 col"><i class="fa fa-thumbs-o-up"
                                aria-hidden="true"></i> <?= $likeCount ?></button>
                        <button type="button" class="dislike btn btn-primary m-2 col"><i class="fa fa-thumbs-o-down"
                                aria-hidden="true"></i> <?= $dislikeCount ?></button>
                        <button type="button" class="comment btn btn-primary m-2 col"><i class="fa fa-comment-o"
                                aria-hidden="true"></i> commentCount</button>
                    </div>
                </div>

                <div class="container text-white bg-danger">
                    <div class="row like-alert">
                        <div class="col">
                            <p class="my-2">Please <a class="text-white" href="/login.php"><U>log in</U></a> to like a post.</p>
                        </div>
                    </div>
                    <div class="row dislike-alert">
                        <div class="col">
                            <p class="my-2">Please <a class="text-white" href="/login.php"><U>log in</U></a> to dislike a post.</p>
                        </div>
                    </div>
                    <div class="row comment-alert">
                        <div class="col">
                            <p class="my-2">Please <a class="text-white" href="/login.php"><U>log in</U></a> to comment.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-text">
                        <p class="mb-0">
                            <?= $post_description ?>
                        </p>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    Upload date:
                    <?= $post_created_at ?>
                </div>

            </div>
        </div>
    </div>
</section>
