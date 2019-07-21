<?php

    function __autoload($class_name){
        $class_name = strtolower($class_name);
        $path = LIB_PATH.DS."{$class_name}.php";
        if(file_exists($path)){
            require_once($path);
        }  else {
            die("The File {$class_name}.php could not be found ");
        }
    }

     function redirect($url){
        if($url != NULL){
                header("Location: $url");

        }
    }
    function output_message($message=""){
        if(!empty($message)){
                return "<h4> {$message} </h4>";
        }else{
                return "";
        }
    }
    function strip_zero_from_date($marked_string=""){
        $no_zeros = str_replace('*0','',$marked_string);
        $cleaned_string = str_replace('*','',$no_zeros);
        return $cleaned_string;
    }

    function datetime_to_text($datetime="") {
        $unixdatetime = strtotime($datetime);
        return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
    }

    function datetime_to_text_post($datetime="") {
        $unixdatetime = strtotime($datetime);
        return strftime("%B %d, %Y", $unixdatetime);
    }


    function sanitize_int($string) {
        if(preg_match('/[0-9]/', $string)){
            return intval($string);
        }else{
            return false;
        }

    }

    function sanitize_str($string) {

        if(preg_match('/\w/', $string)){
            return $string;
        }else{
            return false;
        }
    }


function sanitize_search($string) {

    if(preg_match('/[a-zA-Z0-9]/', $string)){
        return $string;
    }else{
        return false;
    }
}




