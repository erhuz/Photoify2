<?php $page = 'login'; ?>

<?php require __DIR__.'/views/header.php'; ?>

<article>
    <h1>Login</h1>
    <form action="/app/users/login.php" method="post">
        <label for="email">Email:</label>
        <input name="email" class="form-control" type="email">

        <label for="password">Password:</label>
        <input name="password" class="form-control" type="password">

        <input type="submit" class="btn btn-primary mt-4" value="Login">
    </form>
</article>

<?php require __DIR__.'/views/footer.php'; ?>
