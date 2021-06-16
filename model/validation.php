<?php

/*
 Authors: Cruiser Baxter, David Boone, Raju Shrestha
File: validation.php
Description: validation class for astro challenge
 * */

class Validation
{

    /** function takes in a string and validates that the string only
     * contains letters and no numbers or special characters
     * @param $name string to be be validated
     * @return bool true if $name is only letters otherwise false
     */
    static function validName($name): bool
    {
        return ctype_alpha($name);
    }

    /** function takes in a string and validates that it represents
     * a valid email address format
     * @param $email string to be validated as email address
     * @return bool true if $email is a valid email address format
     * otherwise false
     */
    static function validEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /** validates that the string passed as password
     * is at least 8 char long
     * @param $pass string to validate
     * @return bool returns true if string is at least 8 cahr long
     * otherwise returns false
     */
    static function validPassword($pass): bool
    {
        return strlen($pass) >= 8;
    }

    /** takes in variables for day month and year then validates that the numbers
     * passed are a valid date in the correct format
     * @param $day number for day of month
     * @param $month number for month of year
     * @param $year number for four digit year
     * @return bool returns true if valid else false
     */
    static function validDate($day, $month, $year): bool
    {
        return checkdate($month,$day,$year);
    }

    /** takes in an alphanumeric string and returns true if it is
     * longer than 6 char else false
     * @param $input string alphanumeric user input
     * @return bool returns true if valid else false
     */
    static function validInput($input): bool
    {
        return strlen($input) >= 6;
    }

    /** takes in an alphanumeric string and returns true if it is at least 2
     * char long else false
     * @param $nickname string for nickname
     * @return bool returns true if valid else false
     */
    static function validString($nickname): bool
    {
        return strlen($nickname) >=2;
    }

}