<?php

class User
{
    private $_userName;
    private $_password;
    private $_email;
    private $_nickname;
    private $_location;

    /**
     * User constructor.
     * @param $_userName
     * @param $_password
     * @param $_email
     * @param $_nickname
     */
    public function __construct($_userName="", $_password="", $_email="", $_nickname="", $_location="")
    {
        $this->_userName = $_userName;
        $this->_password = $_password;
        $this->_email = $_email;
        $this->_nickname = $_nickname;
        $this->_location = $_location;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->_userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName): void
    {
        $this->_userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->_email = $email;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->_nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname($nickname): void
    {
        $this->_nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->_location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location): void
    {
        $this->_location = $location;
    }




}