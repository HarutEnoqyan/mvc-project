<?php
namespace Core;

class Validation {

    public static function validateName($str)
    {
        $str = trim($str);

        if ($str && $str !='' && strlen($str)>=3 && strlen($str)<=15 && preg_match('/^[a-z]+$/i' , $str )) {
            return true;
        }else {
            switch (strlen($str)) {
                case ' ' :
                case '' : dd("Name required");
                break;
                case (preg_match('/^[a-z]+$/i' , $str )== NULL): dd('Invalid Name');
                break;
                case (strlen($str) < 3) : dd('can\'t contain less than 3 simbols');
                break;
                case (strlen($str) > 15) :dd('can\'t contain more than 15 simbols');
                break;

            }
        }
        return "validation failed";
    }


    public static function validatePass($str)
    {
        $str = trim($str);

        if ($str && $str !='' && strlen($str)>=5 && strlen($str)<=25) {
            return true;
        }else {
            switch ($str) {
                case ' ' :
                case '' : dd("cant be empty");
                    break;
                case (strlen("$str") < 5) : dd('<5');
                    break;
                case (strlen("$str") > 25) :dd('>25');
                    break;
            }
        }
        return "validation failed";
    }


    public static function validateEmail($str)
    {
        if (filter_var($str, FILTER_VALIDATE_EMAIL)){
           return true;
        }else{
            return false;
        }

    }

    public static function validateDate($str)
    {
        dd(preg_match("/(\d{4}(.|\/|-|:)\d{2}(.|\/|-|:)\d{2} \d{2}(.|\/|-|:)\d{2}(.|\/|-|:)\d{2})/i", $str));
    }

    public static function validateTitle($str)
    {
        $str = trim($str);

        $str = trim($str);
        if ($str && $str !='' && strlen($str)>=3 && strlen($str)<=30) {
            return true;
        }else {
            switch (strlen($str)) {
                case ' ' :
                case '' : return "Title required";
                    break;
                case (strlen($str) < 3) : return "Title can't be less than 3 simbols";
                    break;
                case (strlen($str) > 30) :return "Title can't be more than 30 simbols";
                    break;
            }
        }
        return "validation failed";
    }

    public static function validateContent($str)
    {
        $str = trim($str);

        if ($str && $str !='' && strlen($str)>=10 && strlen($str)<=255) {
            return true;
        }else {
            switch ($str) {
                case ' ' :
                case '' : return "Content required";
                    break;
                case (strlen($str) < 10) :return "Content can't be less than 10 simbols";
                    break;
                case (strlen($str) > 255) :return "Content can't be more than 255 simbols";
                    break;

            }
        }
        return "validation failed";
    }

}