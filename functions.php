<?php
function get_env($env_var) {
    if($_ENV[$env_var]) {
        return $_ENV[$env_var];
    }
    //get path where this file is
    define('ROOT_PATH', dirname(__FILE__));
    $user_env_config = include_once ROOT_PATH . '/env.php';

    foreach ($user_env_config as $key => $value) {
        if(!$_ENV[$key]) {
            $_ENV[$key] = $value;
        }
    }
    return $_ENV[$env_var];
}