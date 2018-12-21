<?php require __DIR__.'/views/header.php'; ?>

<article>
    <h1>Register</h1>
    <form action="/app/users/register.php" method="post">
        <label for="name">Name:</label>
        <input name="name" class="form-control" type="text">

        <label for="email">Email:</label>
        <input name="email" class="form-control" type="email">

        <label for="password">Password:</label>
        <input name="password" class="form-control" type="password">

        <label for="c_password">Confirm password:</label>
        <input name="c_password" class="form-control" type="password">

        <input type="submit" class="btn btn-primary mt-4" value="Register">
    </form>
</article>

<?php require __DIR__.'/views/footer.php'; ?>
