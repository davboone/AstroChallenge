<?php

/*
 Authors: Cruiser Baxter, David Boone, Raju Shrestha
File: admin.php
Description: admin class extends user class, for astro challenge app
 * */

class Admin extends User
{
    private $_isAdmin;

    /** returns true the value of this->_isAdmin
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->_isAdmin;
    }

    /** sets the value of this->_isAdmin to the passed var isAdmin
     * @param bool $isAdmin true or false
     */
    public function setIsAdmin($isAdmin): void
    {
        $this->_isAdmin = $isAdmin;
    }


}