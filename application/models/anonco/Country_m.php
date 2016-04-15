<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Country_m
 *
 * @author frantisekferancik
 */
class Country_m extends CI_Model{
    
    /*
     * vrati krajinu na zaklade iso codu krajiny
     */
    public function getCountryAsCode($code){
        $query = $this->db->select()
                          ->from(DB_PREFIX.'country')
                          ->where('iso_code_2', $code)
                          ->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return FALSE;
    }
}
