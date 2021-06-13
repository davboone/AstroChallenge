<?php

/* validation.php
 * Validate data for the diner app
 *
 */

class Validation
{

    //checks if user name char is greater than 2 without space at least
    static function validName($name){
        return ((preg_match('/^[a-zA-Z]/', $name) && strlen(trim($name))>=2));
    }

    //validate email
    static function validEmail($email){
        return (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email));
    }

    //Return true if a food is valid
    static function validFood($food)
    {
        return strlen(trim($food)) >= 2;
    }

    //Return true if meal is valid
    static function validMeal($meal)
    {
        return in_array($meal, DataLayer::getMeals());
    }

    //Return true if *all* condiments are valid
    static function validCondiments($condiments)
    {
        $validCondiments = DataLayer::getCondiments();

        //Make sure each selected condiment is valid
        foreach ($condiments as $userChoice) {
            if (!in_array($userChoice, $validCondiments)) {
                return false;
            }
        }

        //All choices are valid
        return true;
    }
}