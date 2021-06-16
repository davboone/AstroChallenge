<?php

/*
 Authors: Cruiser Baxter, David Boone, Raju Shrestha
File: data-layer.php
Description: data-layer for astro challenge app
 * */

//Require the config file
require_once($_SERVER['DOCUMENT_ROOT'].'/../pdoconnect.php');

class DataLayer
{
    // Add a field for the database object
    /**
     * @var PDO The database connection object
     */
    private $_dbh;

    // Define a constructor

    /**
     * DataLayer constructor.
     */
    function __construct()
    {
        //Connect to the database
        try {
            //Instantiate a PDO database object
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo "Connected to database!";
        }
        catch(PDOException $e) {
            //echo $e->getMessage();  //for debugging only
            die ("Oh darn! We're having a bad day. Please contact our support department.");
        }
    }

    /** takes in a User object and saves the user information from the object to the database
     * @param $user user object
     * @return bool true if successful else false
     */
    function saveUser($user)
    {
        //1. Define the query
        $sql = "INSERT INTO users (username, nickname, userlocation, archive, usertype, password, email) 
                VALUES (:username, :nickname, :userlocation, :archive, :usertype, :password, :email)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':username', $user->getUserName(), PDO::PARAM_STR);
        $statement->bindParam(':nickname', $user->getNickname(), PDO::PARAM_STR);
        $statement->bindParam(':userlocation', $user->getLocation(), PDO::PARAM_STR);
        $statement->bindParam(':password', $user->getPassword(), PDO::PARAM_STR);
        $statement->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);

        // set account type and archive if admin
        if ($user instanceof Admin) {
            $userType = "admin";
            $archive = 1;
        } else {
            $userType = "standard";
            $archive = 0;
        }

        $statement->bindParam(':archive', $archive, PDO::PARAM_STR);
        $statement->bindParam(':usertype', $userType, PDO::PARAM_STR);

        $lastId = $this->_dbh->lastInsertId();

        //4. Execute the query
        $result = $statement->execute();

        //5. Process the results
        return $result;
    }

    /** queries the database for a user that matches the passed email and returns an
     * array with the user information
     * @param $email string with email address
     * @return array assoc array
     */
    function getUser($email)
    {
        //1. Define the query
        $sql = "SELECT * FROM users WHERE email = '$email'";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //4. Execute the query
        $statement->execute();

        //5. Process the results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /** takes in variables with event information and saves it to the database as
     * a new event in the event table
     * @param $eventId string
     * @param $start Date
     * @param $end Date
     * @param $objectid string that matches an existing objectid in the object table
     * @param $event_details string
     * @param $event_desc string
     * @param $event_image string with file name
     * @return bool true of successfully saves to DB else false
     */
    function saveEvents($eventId, $start, $end, $objectid, $event_details, $event_desc, $event_image)
    {
        //1. Define the query
        $sql = "INSERT INTO events (eventid, starttime, endtime, objectid, event_details, event_desc, event_image, archive, event_complete) 
                VALUES (:eventid, :starttime, :endtime, :objectid, :event_details, :event_desc, :event_image, 0, 0)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':eventid', $eventId, PDO::PARAM_STR);
        $statement->bindParam(':starttime', $start, PDO::PARAM_STR);
        $statement->bindParam(':endtime', $end, PDO::PARAM_STR);
        $statement->bindParam(':objectid', $objectid, PDO::PARAM_STR);
        $statement->bindParam(':event_details', $event_details, PDO::PARAM_STR);
        $statement->bindParam(':event_desc', $event_desc, PDO::PARAM_STR);
        $statement->bindParam(':event_image', $event_image, PDO::PARAM_STR);

        $lastId = $this->_dbh->lastInsertId();

        //4. Execute the query
        $result = $statement->execute();

        //5. Process the results
        return $result;
    }

    /** gets all events from the DB events table
     * @return array assoc array of all evvents
     */
    function getEvents()
    {
        //1. Define the query
        $sql = "SELECT * FROM events";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get OrderID)
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /** gets one event from the DB that matches the eventid passed
     * @param $eventid string with eventid
     * @return array assoc array with one single evvent
     */
    function getOneEvent($eventid)
    {
        //1. Define the query
        $sql = "SELECT * FROM events WHERE eventid = '$eventid'";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get OrderID)
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //current events for within upcoming 30 days

    /** gets events that are currently active from DB
     * @return array assoc array with currently active events
     */
    function getCurrentEvents()
    {
        //1. Define the query
        $sql = "SELECT * FROM events WHERE starttime < CURRENT_DATE && event_complete != 1 ORDER BY starttime";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get OrderID)
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //gets events that are more than a month away

    /** gets events with a future start date from the DB
     * @return array assoc array with events that have a future start date
     */
    function getUpcomingEvents()
    {
        //1. Define the query
        $sql = "SELECT * FROM events WHERE starttime > CURRENT_DATE && archive != 1 ORDER BY starttime";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get OrderID)
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /** saves a new object to the DB with information passed as variables
     * @param $objectname string object name
     * @param $objectcoordinates string object coordinates in RA DEC celestial format
     * @return bool true if successfully saves to DB else false
     */
    function saveObject($objectname, $objectcoordinates)
    {
        //1. Define the query
        $sql = "INSERT INTO objects (objectname, objectcoordinates) 
                VALUES (:objectname, :objectcoordinates)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':objectname', $objectname, PDO::PARAM_STR);
        $statement->bindParam(':objectcoordinates', $objectcoordinates, PDO::PARAM_STR);

        $lastId = $this->_dbh->lastInsertId();
        //4. Execute the query
        $result = $statement->execute();

        //5. Process the results
        return $result;
    }

    /** gets a single object from the DB based on the object name passed as variable
     * @param $objectName string object name (ID)
     * @return array assoc array with one event
     */
    function getObject($objectName)
    {
        //1. Define the query
        $sql = "SELECT * FROM objects WHERE objectname = '$objectName'";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get OrderID)
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /** updates an existing event in the DB based on the eventId passed in and
     * updates with information passed as variables
     * @param $eventId string event id in DB
     * @param $start Date start date of event yyyy-mm-dd
     * @param $end Date end date of event yyyy-mm-dd
     * @param $objectid string object id of existing object in object table
     * @param $event_details string details/rules of event
     * @param $event_desc string description of event
     * @param $event_image string file name for image
     * @param $firstPlace string email of existing user in user table
     * @param $secondPlace string email of existing user in user table
     * @param $thirdPlace string email of existing user in user table
     * @param $firstImage string file name of image
     * @param $secondImage string file name of image
     * @param $thirdImage string file name of image
     * @param $eventComplete bool 0 for false 1 for true, marks if events is complete or not
     * @param $archive  bool 0 for false 1 for true, marks if event is archived or not
     * @return bool true if event successfully updated else false
     */
    function updateEvent($eventId, $start, $end, $objectid, $event_details, $event_desc, $event_image,
                         $firstPlace, $secondPlace, $thirdPlace, $firstImage, $secondImage, $thirdImage,
                         $eventComplete, $archive)
    {
        //1. Define the query
        $sql = "UPDATE events SET eventid=:eventid, objectid=:objectid, starttime=:starttime, endtime=:endtime, 
                      event_details=:event_details, event_desc=:event_desc, first_place=:firstPlace, 
                      second_place=:secondPlace, third_place=:thirdPlace, event_image=:event_image, 
                      first_image=:firstImage, second_image=:secondImage, third_image=:thirdImage, 
                      event_complete=:eventComplete, archive=:archive WHERE eventid=:eventid";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':eventid', $eventId, PDO::PARAM_STR);
        $statement->bindParam(':starttime', $start, PDO::PARAM_STR);
        $statement->bindParam(':endtime', $end, PDO::PARAM_STR);
        $statement->bindParam(':objectid', $objectid, PDO::PARAM_STR);
        $statement->bindParam(':event_details', $event_details, PDO::PARAM_STR);
        $statement->bindParam(':event_desc', $event_desc, PDO::PARAM_STR);
        $statement->bindParam(':event_image', $event_image, PDO::PARAM_STR);
        $statement->bindParam(':firstPlace', $firstPlace, PDO::PARAM_STR);
        $statement->bindParam(':secondPlace', $secondPlace, PDO::PARAM_STR);
        $statement->bindParam(':thirdPlace', $thirdPlace, PDO::PARAM_STR);
        $statement->bindParam(':firstImage', $firstImage, PDO::PARAM_STR);
        $statement->bindParam(':secondImage', $secondImage, PDO::PARAM_STR);
        $statement->bindParam(':thirdImage', $thirdImage, PDO::PARAM_STR);
        $statement->bindParam(':eventComplete', $eventComplete, PDO::PARAM_STR);
        $statement->bindParam(':archive', $archive, PDO::PARAM_STR);

        $lastId = $this->_dbh->lastInsertId();

        //4. Execute the query
        $result = $statement->execute();

        //5. Process the results
        return $result;
    }


    //gets events that are older than a month from today's date

    /** gets past events from the DB
     * @return array assoc array of events with an end date the is in the past
     */
    function getPastEvents()
    {
        //1. Define the query
        $sql = "SELECT * FROM events WHERE endtime < CURRENT_DATE AND archive != 1 ORDER BY starttime DESC";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get OrderID)
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}