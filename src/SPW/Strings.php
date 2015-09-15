<?php

namespace SPW;

class Strings
{
    public static function toLabel($str)
    {
        $str = htmlspecialchars_decode($str, ENT_QUOTES | ENT_HTML5);
        $str = html_entity_decode($str);
        $str = self::removeAccent($str);
        $str = strtolower($str);
        $str = strip_tags($str);
        $str = stripslashes($str);
        $str = preg_replace('/[^a-z0-9]+/', '-', $str);
        $str = trim($str, '-');

        return $str;
    }
    
    public static function removeAccent($str){
        $str = strtr(utf8_decode($str), utf8_decode("ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ"), "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
        return $str;
    }
    
    public static function toFloat($value) {
        return floatval(preg_replace(array('/[^0-9\.\,]/', '/,/'), array('', '.'), $value));
    }
    public static function toInt($value) {
        return intval(preg_replace('/[^0-9\-]/', '', $value));
    }
    
    public static function truncate($string, $length = 255, $ellipsis = '...', $at_space = true)
    {
        $length -= strlen($ellipsis);
        $string_length = strlen($string);

        if($string_length <= $length) {
            return $string;
        }
        
        if( $at_space && ($space_position = strrpos($string, ' ', $length - $string_length)) ) {
            $length = $space_position;
        }

        return substr_replace($string, $ellipsis, $length);
    }
    
    public static function random($length = 10, $regex = '/[0-9]|[a-z]|[A-Z]/')
    {
        $characters = '!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
        
        $charactersAllowedArray = array();
        preg_match_all($regex, $characters, $charactersAllowedArray);
        if(!sizeof($charactersAllowedArray[0])) {
            return '';
        }
        
        $charactersAllowed = implode('', $charactersAllowedArray[0]);
        $charactersLength = strlen($charactersAllowed);
        
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $charactersAllowed[rand(0, $charactersLength - 1)];
        }
        
        return $string;
    }
}