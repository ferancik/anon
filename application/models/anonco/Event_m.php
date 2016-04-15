<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event_m
 *
 * @author frantisekferancik
 */
class Event_m extends CI_Model{
    
    
    
    public function getListActiveEvents(){
        $query = $this->db->select("*")
                          ->from(DB_PREFIX.'event')
                          ->where('active', 1)
                          ->order_by("date_from", 'asc')
                          ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    
    /*
     * url = url eventu
     * 
     * Vrati data eventu na zaklade url 
     */
    public function getEventDetailUrl($url){
        $query = $this->db->select()
                          ->from(DB_PREFIX.'event')
                          ->where('url', $url)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return FALSE;
    }
    /*
     * $event_id
     * 
     * Vrati data eventu na zaklade url 
     */
    public function getEventDetailId($event_id){
        $query = $this->db->select()
                          ->from(DB_PREFIX.'event')
                          ->where('event_id', $event_id)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return FALSE;
    }
    
    /*
     * event_id = id eventu 
     * 
     * Vytihane informacie o formulari ktory je priradeni k eventu
     */
    public function getActiveFormEvent($event_id){
        $query = $this->db->select(DB_PREFIX.'forms.*')
                          ->from(DB_PREFIX.'forms')
                          ->join(DB_PREFIX.'event_form', DB_PREFIX.'event_form.form_id = '.DB_PREFIX.'forms.form_id AND '.DB_PREFIX.'event_form.event_id = '.$event_id, 'inner' )
                          ->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    /*
     * $event_id 
     * 
     * vrati poradove cislo pretekara od ktoreho ma zacat
     */
    public function getLastSerialNumber($event_id){
        $query = $this->db->select("start_number")
                          ->from(DB_PREFIX.'event')
                          ->where('event_id', $event_id)
                          ->get();
        if($query->num_rows()>0){
            return $query->row()->start_number+1;
        }
        return 1;
    }
}
