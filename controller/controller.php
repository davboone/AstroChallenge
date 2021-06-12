<?php

class Controller
{
    private $_f3; //router

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home() {
        // instantiate a views object
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function upcoming() {
        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/upcoming.html');
    }

    function community() {
        //Display the community page page
        header('location: http://dboone.greenriverdev.com/phpbb/');
    }

    function signup() {
        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/signup.html');
    }

    function eventdetails() {
        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/eventdetails.html');
    }

    function signupsummary() {
        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/signupsummary.html');
    }

    function currentevent() {
        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/currentevent.html');
    }

    function register() {
        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/register.html');
    }




}