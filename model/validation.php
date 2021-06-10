<?php

/* validation.php
 * Validate data for the diner app
 *
 */

class Validation
{
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