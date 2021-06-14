<?php

/* data-layer.php
 * Return data for the diner app
 */

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

    function saveEvents($eventId,$start,$end, $objectid, $event_details, $event_desc, $event_image)
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

    function getEvents($eventid)
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

}