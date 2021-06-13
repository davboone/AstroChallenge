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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //TODO check which event was clicked when submit was clicked
            $eventOne=$_POST['eventOne'];
            $eventTwo=$_POST['eventTwo'];
            $eventThree=$_POST['eventThree'];
            $eventFour=$_POST['eventFour'];

        }

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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //data validation for name [at least two char should be given]
            if(Validation::validName($_POST['name'])){
                $_SESSION['name']=$_POST['name'];
            }
            else{
                $this->_f3-> set('errors["name"]', '! Please enter a valid name. !');
            }

            if (Validation::validEmail($_POST["email"]))
            {
                $this->_f3->set('errors["gender"]', '! Please provide us valid email. !');
            }
            else {
                $_SESSION['email'] = $_POST['email'];

            }

            $_SESSION['nickname']=$_POST['nickname'];
            $_SESSION['password']=$_POST['password'];

            if(empty($this->_f3->get('errors'))){
                //TODO:find the page that we need to route after registering
                //If there is no error route this to this page
                header('location: signupsummary');
            }
        }

        $this->_f3->set('names',$_POST['name']);
        $this->_f3->set('emails',$_POST['email']);
        $this->_f3->set('nicknames',$_POST['nickname']);
        $this->_f3->set('passwords',$_POST['password']);

        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/register.html');
    }

}