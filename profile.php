<?php $page = 'post'; ?>

<?php require __DIR__.'/../views/header.php'; ?>

<?php
if(!isset($_GET['user'])){
    redirect('/');
}

$user_id = intval(filter_var($_GET['user'], FILTER_SANITIZE_NUMBER_INT));
?>

<article class="row">
    <div class="col">
        <h1>Edit post</h1>
    </div>
</article>

<article>
    <section>

    </section>
</article>

<?php require __DIR__.'/../views/footer.php'; ?>
