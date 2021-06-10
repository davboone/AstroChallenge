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

// start session
session_start();

// instantiate Fat-Free
$f3 = Base::instance();
$con = new Controller($f3);
$dataLayer = new DataLayer();


// define routes
$f3->route('GET /', function (){
    $GLOBALS['con']->home();
});

$f3->route('GET /upcoming',function (){
    $GLOBALS['con']->upcoming();
});

$f3->route('GET /community',function (){
    $GLOBALS['con']->community();
});

$f3->route('GET /signup',function (){
    $GLOBALS['con']->signup();
});

$f3->route('GET /eventdetails',function (){
    $GLOBALS['con']->eventdetails();
});

$f3->route('GET /signupsummary',function (){
    $GLOBALS['con']->signupsummary();
});

$f3->route('GET /signupsummary',function (){
    $GLOBALS['con']->currentevent();
});

// run Fat-Free
$f3->run();