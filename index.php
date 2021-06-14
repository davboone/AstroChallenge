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
require_once ('controller/controller.php');
require_once ('model/validation.php');

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

$f3->route('GET /home', function (){
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

$f3->route('GET /currentevent',function (){
    $GLOBALS['con']->currentevent();
});

$f3->route('GET|POST /register',function (){
    $GLOBALS['con']->register();
});

$f3->route('GET /registersummary',function (){
    $GLOBALS['con']->registersummary();
});

$f3->route('GET|POST /login',function (){
    $GLOBALS['con']->login();
});

$f3->route('GET|POST /adminportal',function (){
   $GLOBALS['con']->adminportal();
});

$f3->route('GET|POST /addobject',function (){
    $GLOBALS['con']->addobject();
});

$f3->route('GET|POST /addevent',function (){
    $GLOBALS['con']->addevent();
});

$f3->route('GET|POST /editobject',function (){
    $GLOBALS['con']->editobject();
});

$f3->route('GET|POST /editevent',function (){
    $GLOBALS['con']->editevent();
});

// run Fat-Free
$f3->run();