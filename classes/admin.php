<?php

class Admin extends User
{
    private $_isAdmin;

    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->_isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin($isAdmin): void
    {
        $this->_isAdmin = $isAdmin;
    }


}