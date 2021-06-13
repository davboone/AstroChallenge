<?php

/* validation.php
 * Validate data for the diner app
 *
 */

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

}