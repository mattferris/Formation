<?php

/*
 * Setup class auto-loading
 */
spl_autoload_register(function($c){
    $base = array_pop(explode("\\", $c));
    $path = '../Classes/'.$base.'.php';
    if (file_exists($path)) {
        require_once($path);
    }
});
