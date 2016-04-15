<?php

function createUrlEventDetail($event_url){
    return site_url("event/detail/".$event_url);
}


function createEventForm($event_url){
    return site_url("event/registration/".$event_url);
}


function createRuleValidation($field){
    $output = "";
    
    if($field->validation->required == 1){
        $output .= "required|";
    }
    
    if($field->validation->min_length > 0){
        $output .= "min_length[".$field->validation->min_length."]|";
    }
    
    if($field->field_size > 0){
        $output .= "max_length[".$field->field_size."]|";
    }
    
    if($field->is_email == 1){
        $output .= "valid_email|";
    }
    
    return substr($output,0,-1);
    
}


function createteHash($string){
    return md5($string.microtime());
}