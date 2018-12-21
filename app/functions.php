<?php

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}

if (!function_exists('read_alert')) {
    /**
     * Sets an alert for the user to read. Such as errors, warnings, notifications and success messages.
     *
     * @param string $message Message to deliver to the user.
     * @param string $type What bootstrap color to display.
     *
     * @return void
     */
    function set_alert($message, $type = 'primary')
    {
        $mess['message'] = $message;
        $mess['type'] = $type;

        $_SESSION['alerts'][] = $mess;
    }
}

if (!function_exists('read_alert')) {
    /**
     * Echoes the current alerts and empties the alerts array
     *
     * @return void
     */
    function read_alert()
    {
        if(isset($_SESSION['alerts'])):
            foreach($_SESSION['alerts'] as $alert):

?>
<div class="alert alert-<?= $alert['type'] ?>" role="alert">
    <?= $alert['content'] ?>
</div>
<?php

            endforeach;
        endif;

    unset($_SESSION['alerts']);
    }
}
