<?php
/*
 Authors: Cruiser Baxter, David Boone, Raju Shrestha
File: index.php
Description: controller for Fat-Free views
 * */
// controller for the diner project

// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once ('vendor/autoload.php');

// instantiate Fat-Free
$f3 = Base::instance();

// define routes
$f3->route('GET /', function (){
    // instantiate a view object
    $view = new Template();
    echo $view->render('views/home.html');
});

// run Fat-Free
$f3->run();