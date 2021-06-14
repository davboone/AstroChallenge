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
        if (!isset($_SESSION['loggedIn'])) {
            if (!$_SESSION['loggedIn'] instanceof User) {
                header('location: login');
            }

        }


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

    function pastevent() {
        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/pastevent.html');
    }


    function register() {
        //Reinitialize session array
        $_SESSION = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // check if a regular or admin registration
            // then instantiate new object
            if (isset($_POST['admin'])) {
                $user = new Admin();
            } else {
                $user = new User();
            }

            //data validation for name [at least two char should be given]
            if(Validation::validName(str_replace(' ', '', $_POST['name']))){
                $user->setUserName($_POST['name']);
            }
            else{
                $this->_f3-> set('errors["name"]', '! Please enter a valid name. !');
            }

            if (Validation::validEmail($_POST["email"]))
            {
                $user->setEmail($_POST['email']);
            }
            else {
                $this->_f3->set('errors["email"]', '! Please provide a valid email address. !');
            }

            if (Validation::validPassword($_POST['password'])) {
                $user->setPassword($_POST['password']);
            } else {
                $this->_f3->set('errors["pass"]', '! Password must be at least 8 characters !');
            }

            $user->setNickname($_POST['nickname']);
            $user->setLocation($_POST['state']);

            if(empty($this->_f3->get('errors'))){
                // save user object in session
                $_SESSION['user'] = $user;
                //If there is no error route this to this page
                header('location: registersummary');
            }
        }


        //Display the account registration page
        $view = new Template();
        echo $view-> render('views/register.html');
    }

    function registersummary()
    {
        $userId = $GLOBALS['dataLayer']->saveUser($_SESSION['user']);
        $this->_f3->set('userId', $userId);

        //Display the page
        $view = new Template();
        echo $view-> render('views/registersummary.html');
    }

    function login()
    {
        // reset session array
        //Reinitialize session array
        $_SESSION = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $result = $GLOBALS['dataLayer']->getUser($email);

            if ($email === $result[0]['email'] && $password === $result[0]['password']) {

                if ($result[0]['usertype'] === 'admin') {
                    $user = new Admin();
                } else {
                    $user = new User();
                }
                $user->setEmail($email);
                $_SESSION['loggedIn'] = $user;
                header('location: home');

            } else {
                echo "<h2>Invalid username or password!</h2>";
            }


        }
        //Display the upcoming events page
        $view = new Template();
        echo $view-> render('views/login.html');
    }

    function addevent()
    {
        $eventName = "";
        $startTime = "";
        $endTime = "";
        //check if the user account is an Admin type
        if (!$_SESSION['loggedIn'] instanceof Admin) {
            //if its not redirect to the login page
            header('location: login');
        } else{
            //if it is an admin this is ran once you submit an event
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $startTime = preg_split("/[-\s:]/",$_POST['eventStart']);
                $endTime = preg_split("/[-\s:]/",$_POST['eventEnd']);
                $eventName = $_POST['eventName'];

                //validate the dates
                if (Validation::validDate($startTime[2],$startTime[1],$startTime[0])) {
                    $startTime = $_POST['eventStart'];
                } else {
                    $this->_f3->set('errors["eventStart"]', '! Please submit correct date format !');
                }

                if (Validation::validDate($endTime[2],$endTime[1],$endTime[0])) {
                    $endTime = $_POST['eventEnd'];
                } else {
                    $this->_f3->set('errors["eventEnd"]', '! Please submit correct date format !');
                }

                if(empty($this->_f3->get('errors'))){
                    $GLOBALS['dataLayer']->saveEvents($eventName,$startTime,$endTime);
                }
            }
        }

        //Display the page
        $view = new Template();
        echo $view-> render('views/addevent.html');
    }

    function adminportal()
    {
        //check if the user account is an Admin type
        if (!$_SESSION['loggedIn'] instanceof Admin) {
            //if its not redirect to the login page
            header('location: login');
        }

        //Display the page
        $view = new Template();
        echo $view-> render('views/adminportal.html');
    }

    function addobject()
    {
        // clear old success or failure msg.
        unset($_SESSION['success']);
        
        //check if the user account is an Admin type
        if (!$_SESSION['loggedIn'] instanceof Admin) {
            //if its not redirect to the login page
            header('location: login');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (Validation::validInput($_POST['objectname'])) {
                $objectname = $_POST['objectname'];
            } else {
                    $this->_f3->set('errors["objectname"]', '! Event name must be 6 or more characters !');
                }

                if (Validation::validInput($_POST['objectcoordinates'])) {
                    $objectcoordinates = $_POST['objectcoordinates'];
                } else {
                    $this->_f3->set('errors["objectcoordinates"]', '! Object name must be in RA DEC celestial coordinates format !');
                }

                if(empty($this->_f3->get('errors'))){
                    $result = $GLOBALS['dataLayer']->saveObject($objectname,$objectcoordinates);

                    if ($result == 'true') {
                        $_SESSION['success'] = true;
                    } else {
                        $_SESSION['success'] = false;
                    }
                }
            }


        }

        //Display the page
        $view = new Template();
        echo $view-> render('views/addobject.html');
    }

    function editobject()
    {
        //check if the user account is an Admin type
        if (!$_SESSION['loggedIn'] instanceof Admin) {
            //if its not redirect to the login page
            header('location: login');
        }

        //Display the page
        $view = new Template();
        echo $view-> render('views/editobject.html');
    }

    function editevent()
    {
        //check if the user account is an Admin type
        if (!$_SESSION['loggedIn'] instanceof Admin) {
            //if its not redirect to the login page
            header('location: login');
        }

        //Display the page
        $view = new Template();
        echo $view-> render('views/editevent.html');
    }
}