<?php $page = 'about'; ?>

<?php require __DIR__.'/views/header.php'; ?>

<article class="row">
    <div class="col">
        <h1>About <?= $config['title'] ?></h1>
        <p>This is the about page.</p>
    </div>
</article>

<article class="row">
    <section class="col-12">
        <h2>What is <?= $config['title'] ?></h2>
        <p><?= $config['title'] ?> is an instagram-like application
        built as a school project for me to show what I've been taught
        durning school.</p>
    </section>

    <section class="col-12">
        <h2></h2>
        <p></p>
    </section>

    <section class="col-12">
        <h2></h2>
        <p></p>
    </section>
</article>

<?php require __DIR__.'/views/footer.php'; ?>
