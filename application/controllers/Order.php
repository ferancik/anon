<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order
 *
 * @author frantisekferancik
 */
class Order extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->model('anonco/event_m');
        $this->load->model('anonco/form_m');


        $this->load->library('anonco/Submission_lib');
    }
    
    
    public function createOrder(){
        $this->submission_lib->addSubmissionToDb();
        redirect(site_url('event/registracia_uspesna'));
    }
        
}
