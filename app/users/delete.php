<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we delete users.

if(!USER_IS_LOGGEDIN){
    set_alert('You need to be logged in to take this action.', 'danger');
    redirect('/');
}
