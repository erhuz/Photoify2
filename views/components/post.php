<section class="col-md-10 col-lg-6">
    <div class="row post" data-id="<?= $post_id ?>">
        <div class="col">
            <div class="card shadow-sm">

                <!-- User header -->
                <div class="card-header">
                    <div class="profile-picture-container">
                        <img class="profile-picture rounded-circle" src="<?= get_image($user_avatar, 'avatar') ?>" alt="">
                    </div>
                    <h5 class="card-title">
                        <a href="<?= '/profile.php?id=' . $user_id ?>">
                            <?= $user_name ?>
                        </a>
                    </h5>
                </div> <!-- /User header -->
                <?php if (USER_IS_LOGGEDIN && intval($user_id) === intval(User['id'])): ?>

                <!-- Delete-modal -->
                <div class="custom_modal">
                    <div class="container mt-4 p-4 modal-content">
                        <div class="row">

                            <!-- Modal content -->
                            <div class="col-12">
                                <span class="close-btn close">&times;</span>
                                <h3>Warning!</h3>
                                <p>Are you sure you want to delete this post?<br>
                                    This action <b>CANNOT</b> be undone!</p>
                            </div>

                            <div class="col-6">
                                <a href="/app/posts/delete.php?id=<?= $post_id ?>" class="btn btn-block btn-danger text-white">DELETE</a>
                            </div>
                            <div class="col-6">
                                <button class="close-btn btn btn-block btn-outline-secondary">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- /Delete-modal -->

                <!-- Post modification buttons -->
                <div class="container">
                    <div class="row">
                        <button type="button" class="delete btn btn-danger btn-sm rounded-0 col-6"><i class="fa fa-trash-o"
                                aria-hidden="true"></i> Delete</button>
                        <a href="/post/edit.php?id=<?= $post_id ?>" class="edit btn btn-warning btn-sm rounded-0 col-6"><i class="fa fa-pencil-square-o"
                                aria-hidden="true"></i> Edit</a>
                    </div>
                </div>
                <?php endif; ?> <!-- /Post modification buttons -->

                <!-- Post image -->
                <div class="card-image">
                    <img src="<?= get_image($post_image, 'post') ?>" alt="<?= $post_description ?>">
                </div>
                <div class="text-muted p-2 bg-light border-bottom small-text">
                    Upload date:
                    <?= date('d-m-Y', strtotime($post_created_at)); ?>
                </div> <!-- /Post image -->

                <!-- Reaction buttons -->
                <div class="container">
                    <div class="row">
                        <button type="button" class="like btn btn-primary m-2 col">
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                            <span><?= $likeCount ?></span>
                        </button>
                        <button type="button" class="dislike btn btn-primary m-2 col">
                            <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                            <span><?= $dislikeCount ?></span>
                        </button>
                        <button type="button" class="comment-btn btn btn-primary m-2 col">
                            <i class="fa fa-comment-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div> <!-- /Reaction buttons -->

                <!-- Reaction alerts -->
                <div class="container text-white bg-danger">
                    <div class="row like-alert">
                        <div class="col">
                            <p class="my-2">Please <a class="text-white" href="/login.php"><U>log in</U></a> to like a
                                post.</p>
                        </div>
                    </div>
                    <div class="row dislike-alert">
                        <div class="col">
                            <p class="my-2">Please <a class="text-white" href="/login.php"><U>log in</U></a> to dislike
                                a post.</p>
                        </div>
                    </div>
                    <div class="row comment-alert">
                        <div class="col">
                            <p class="my-2">Please <a class="text-white" href="/login.php"><U>log in</U></a> to
                                comment.</p>
                        </div>
                    </div>
                </div> <!-- Reaction alerts -->

                <!-- Post description -->
                <div class="card-body">
                    <div class="card-text pl-0 pt-0">
                        <div class="p-2 pl-0 description">
                            <h6 class="text-muted pl-3">Description</h6>
                            <div class="description-content">
                                <p class="mb-0 lead bg-white p-1 pl-2">
                                    <?php /* This row below is to preserve input line-breaks and spaces */ ?>
                                    <?= str_replace(PHP_EOL, '<br>', str_replace(' ', '&nbsp', $post_description)) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> <!-- Post description -->

                <!-- Comments / footer -->
                <div class="card-footer container">
                <?php if (USER_IS_LOGGEDIN): ?>
                    <div class="row comment-form-container display-none">
                        <div class="col">
                            <form class="comment-form">
                                <label for="comment-input-<?= $post_id ?>">Write a comment:</label><br>
                                <input
                                    class="comment-input form-control"
                                    type="text"
                                    name="content"
                                    id="comment-input-<?= $post_id ?>"
                                    placeholder="Give us your thoughts..."
                                >
                                <button class="btn btn-primary btn-block mt-1 mb-4" type="submit">Comment <i class="fa fa-comment-o" aria-hidden="true"></i></button>
                            </form>
                            <hr>
                        </div>
                    </div>
                <?php endif; ?>

                    <div class="row show-comments-btn-container">
                        <div class="col text-muted show-comments-btn">
                            <button class="btn btn-secondary btn-block">
                                Show Comments <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="comment-loader display-none">
                        <hr>
                        <div class="icon-center hidden">
                            <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="comment-container display-none"> <!-- Comment container -->

                    </div> <!-- /Comment-container -->
                </div> <!-- /Comments / footer -->

            </div>
        </div>
    </div>
</section>
