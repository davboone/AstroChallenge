<?php
/*
 Authors: Cruiser Baxter, David Boone, Raju Shrestha
File: user.php
Description: User class for astro challenge app. stores values for user information
 * */

class User
{
    private $_userName;
    private $_password;
    private $_email;
    private $_nickname;
    private $_location;

    /** constructs a new user object with either default empty information
     * or passed data to be assigned to the private data fields
     * User constructor.
     * @param $_userName string for user name
     * @param $_password string for password
     * @param $_email string for email
     * @param $_nickname string for nickname
     */
    public function __construct($_userName="", $_password="", $_email="", $_nickname="", $_location="")
    {
        $this->_userName = $_userName;
        $this->_password = $_password;
        $this->_email = $_email;
        $this->_nickname = $_nickname;
        $this->_location = $_location;
    }

    /** returns the value of this->_userName
     * @return string _userName
     */
    public function getUserName(): string
    {
        return $this->_userName;
    }

    /** sets the value of this->_userName
     * @param string $userName string for user name
     */
    public function setUserName($userName): void
    {
        $this->_userName = $userName;
    }

    /** gets the value of this->_password
     * @return string value of _password
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /** sets the value of this->_password
     * @param string $password string for password
     */
    public function setPassword($password): void
    {
        $this->_password = $password;
    }

    /** gets the value of this->_email
     * @return string value of this->_email
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /** sets the value of this->_email
     * @param string $email string for users email
     */
    public function setEmail($email): void
    {
        $this->_email = $email;
    }

    /** gets the value of this->_nickname
     * @return string value of _nickname
     */
    public function getNickname(): string
    {
        return $this->_nickname;
    }

    /** sets the value of this->_nickname
     * @param string $nickname string for user nickname
     */
    public function setNickname($nickname): void
    {
        $this->_nickname = $nickname;
    }

    /** gets the value of this->_location
     * @return string value of _location
     */
    public function getLocation(): string
    {
        return $this->_location;
    }

    /** sets the value of this->_location
     * @param string $location string for user location
     */
    public function setLocation($location): void
    {
        $this->_location = $location;
    }


}