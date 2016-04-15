<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transaction_m
 *
 * @author frantisekferancik
 */
class Transaction_m extends CI_Model{
    
    
    public function insert($data){
        if(!$this->isTransactionInDb($data)){
            if($this->db->insert(DB_PREFIX.'transaction', $data)){
                return $this->db->insert_id();
            }else{
                return FALSE;
            }
        }
        
    }
    
    public function isTransactionInDb($data){
        $query = $this->db->select()
                          ->from(DB_PREFIX.'transaction')
                          ->where('cislo_uctu', $data['cislo_uctu'])
                          ->where('suma', $data['suma'])
                          ->where('variabylny_symbol', $data['variabylny_symbol'])
                          ->where('sprava', $data['sprava'])
                          ->where('zostatok', $data['zostatok'])
                          ->where('protiucet', $data['protiucet'])
                          ->where('specificky_symbol', $data['specificky_symbol'])
                          ->where('konstantny_symbol', $data['konstantny_symbol'])
                          ->get();
        if($query->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }     
    }
    
    
}
