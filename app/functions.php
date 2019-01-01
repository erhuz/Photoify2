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

if (!function_exists('set_alert')) {
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
        $mess['content'] = $message;
        $mess['type'] = $type;

        $_SESSION['alerts'][] = $mess;
    }
}

if (!function_exists('get_alerts')) {
    /**
     * Echoes the current alerts and empties the alerts array
     *
     * @return void
     */
    function get_alerts()
    {
        if(isset($_SESSION['alerts'])){
            foreach($_SESSION['alerts'] as $alert){
                require(realpath(dirname(__FILE__) . '/../views/components/alert.php'));
            }
        }

    unset($_SESSION['alerts']);
    }
}

if(!function_exists('create_post')){
    function create_post(
        Int $post_id,
        String $post_image,
        String $post_description,
        String $post_created_at,
        Int $user_id,
        String $user_name,
        String $user_avatar,
        Int $likeCount,
        Int $dislikeCount
    )
    {
        require __DIR__.'/../views/components/post.php';
    }
}

if(!function_exists('get_image')){
    function get_image(
        String $image,
        String $type
    )
    {
        if(strtolower($type) == 'avatar'){
            return '/../uploads/avatars/' . $image;
        }elseif(strtolower($type) == 'post'){
            return '/../uploads/posts/' . $image;
        }
        return 'THAWIFNOWFNOIF';
    }
}
