<?php $page = 'post'; ?>

<?php require __DIR__.'/views/header.php'; ?>

<?php
if(!isset($_GET['id'])){
    set_alert('No user ID specified. Redirected', 'warning');
    redirect('/');
}

$user_id = intval(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));

$query = 'SELECT * FROM users WHERE id=:id';
$params = [':id' => $user_id];

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="profile">
    <header class="row p-4 rounded iconic-gradient-bg">
        <div class="col-md-3 col-lg-2">
            <img class="profile-img rounded-circle" src="<?= get_image($user['avatar'], 'avatar') ?>" alt="<?= $user['name'] ?>">
        </div>
        <div class="col d-flex flex-center">
            <h1 class="text-light"><?= $user['name'] ?></h1>
        </div>
    </header>

    <article>
        <section>

        </section>
    </article>
</div>

<?php require __DIR__.'/views/footer.php'; ?>
