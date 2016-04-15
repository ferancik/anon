<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Send_mail_lib {

    private $settings;
    private $config_email;

    function __construct() {
        $this->ci = & get_instance();
    }

    // pri uspesnej platbe
    function sendEmail($template, $email, $data, $subject, $from = null, $files = false, $bcc = TRUE) {

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.websupport.sk',
            'smtp_port' => 465,
            'smtp_crypto' => 'ssl',
            'smtp_user' => 'info@anonco.sk',
            'smtp_pass' => 'st2wkj77a',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );



        $this->ci->load->library('email');
        $this->ci->email->initialize($config);
        $this->ci->lang->load('tank_auth');
        if ($from != null) {
            $this->ci->email->from($from['email'], $from['meno']);
        }
        if ($bcc) {
            $this->ci->email->bcc("ferancik@poynta.sk,peter.gebura@gmail.com");
        }
        $this->ci->email->to($email);
        $this->ci->email->subject($subject);

        $this->ci->email->message($this->ci->load->view($template, $data, TRUE));
        if ($files) {
            foreach ($files as $value) {
                $this->ci->email->attach($value);
            }
        }

        $this->ci->email->send();
        echo $this->ci->email->print_debugger();
    }

    public function sendEmailSys($template, $subject, $email, $data, $files = FALSE) {
        $this->sendEmail($template, $email, $data, $subject, null, $files = false);
    }

}
