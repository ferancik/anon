<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test
 *
 * @author frantisekferancik
 */
class Test extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library("anonco/order_lib");
    }
    
    public function index(){
        $this->order_lib->sparujPlatby();
    }
}
