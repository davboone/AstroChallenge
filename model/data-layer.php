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
            $this->_dbh = new PDO('DB_USERNAME', 'DB_DSN', 'DB_PASSWORD');
            echo "Connected to database!";
        } catch (PDOException $e) {
//            echo $e->getMessage();  //for debugging only
            die ("Oh darn! We're having a bad day. Please call support department.");
        }
    }

}