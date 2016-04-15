<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->model('anonco/event_m');
    }

    public function index() {
        $events = $this->event_m->getListActiveEvents();
        
        $this->template->load(TEMPLATE . 'template', TEMPLATE . 'page/home', array(
            'events' => $events,
            'title' => "Športové podujatia | Anonco.sk",
            'keywords' => "Registrácia na športove podujatia, registrácia na eventy, anonco.sk",
            'page_title' => "Podujatia"
                )
        );
    }

}
