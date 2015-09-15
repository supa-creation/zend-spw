<?php

namespace SPW\Validator;

class Url extends \Zend\Validator\Regex
{
    
    protected static $defaultPattern = "#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#iS";
    
    public function __construct() {
        parent::__construct(self::$defaultPattern);
    }
}

?>
