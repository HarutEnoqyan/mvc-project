<?php
namespace Core;

class Validation {

    public static function validateName($str)
    {
        $str = trim($str);
//        dd(strlen($str));
//        echo $str;

        if ($str && $str !='' && strlen($str)>=3 && strlen($str)<=15 && preg_match('/^[a-z]+$/i' , $str )) {
            return true;
        }else {
            switch ($str) {
                case '' : return 'Name required';
                break;
                case (strlen($str)<3) :  return 'Name can\'t contain less than 3 simbols';
                break;
                case (strlen($str)>15) : return 'Name can\'t contain more than 15 simbols';
                break;
                case (preg_match('/^[a-z]+$/i' , $str )== NULL):  return 'Invalid Name';
                break;

            }
        }
        return "validation failed";
    }

    public static function validateLastName($str)
    {
        $str = trim($str);

        if ($str && $str !='' && strlen($str)>=3 && strlen($str)<=15 && preg_match('/^[a-z]+$/i' , $str )) {
            return true;
        }else {
            switch ($str) {
                case ' ' :
                case '' : return "LastName required";
                break;
                case (strlen($str) < 3) : return 'LastName can\'t contain less than 3 simbols';
                break;
                case (strlen($str) > 15) :return 'LastName can\'t contain more than 15 simbols';
                break;
                case (preg_match('/^[a-z]+$/i' , $str )== NULL): return 'Invalid LastName';
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
                case '' : return "Password required";
                    break;
                case (strlen("$str") < 5) : return 'Password can\'t be less than 5 sibols';
                    break;
                case (strlen("$str") > 25) :return 'Password can\'t be more than 25 sibols';
                    break;
            }
        }
        return "validation failed";
    }


    public static function validateEmail($str)
    {
        if (trim($str) == "" ) {
            return 'email required';
        }
        if (filter_var($str, FILTER_VALIDATE_EMAIL)){
           return true;
        }else{
            return 'wrong email';
        }

    }

    //dateTime regexp "/(\d{4}(.|\/|-|:)\d{2}(.|\/|-|:)\d{2} \d{2}(.|\/|-|:)\d{2}(.|\/|-|:)\d{2})/i"

    public static function validateDate($str)
    {
        if (preg_match("/(\d{4}(.|\/|-|:)\d{2}(.|\/|-|:)\d{2})/i", $str)==1){
            return true;
        } else {
            return 'Invalid date';
        }
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
                case (strlen($str) < 10) : return "Content can't be less than 10 simbols";
                    break;
                case (strlen($str) > 255) : return "Content can't be more than 255 simbols";
                    break;

            }
        }
        return "validation failed";
    }

}