<?php
/**
 * Project:  VFP Business Series
 * Copyright: 2014. VFP Business Solutions, LLC
 */

/**
 * Class View Helpers for static view helpers methods
 */
class ViewHelpers
{

    static function ViewHelperMethod1(){
        return "I'm a View Helper method";
    }
    
    /**
     * Return the class string builded from a given display name
     * Example: Display Name = display-name
     * @param string $value
     * @return string
     */
    static function BuildClassBy($value){
        return str_replace(' ', '-', strtolower($value));
    }
}