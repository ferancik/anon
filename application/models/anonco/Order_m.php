<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order_m
 *
 * @author frantisekferancik
 */
class Order_m extends CI_Model{
    
    
    public function insert($data, $submisions){
        if($this->db->insert(DB_PREFIX.'order', $data)){
            $order_id = $this->db->insert_id();
            foreach ($submisions as $key => $sub) {
                $this->db->insert(DB_PREFIX.'order_submision', array('order_id'=>$order_id, 'submision_id'=>$sub));
            }
        }
    }
    
    
    public function getLastOrderNumber($event_id){
        $query = $this->db->select("MAX(order_number) as order_number")
                          ->from(DB_PREFIX.'order')
                          ->where('event_id', $event_id)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            $last_order_number = $query->row()->order_number;
            return ++$last_order_number;
        }
        return 1;
    }
    
    
    public function getOrderSparuj($var_symbol, $suma){
        $query = $this->db->select()
                          ->from(DB_PREFIX.'order')
                          ->where('var_symbol', $var_symbol)
                          ->where('price', $suma)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        
        return FALSE;
    }
}
