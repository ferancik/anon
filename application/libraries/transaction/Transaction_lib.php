<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include(APPPATH . '/libraries/peeker/peeker.php');

/**
 * Description of Transaction_lib
 *
 * @author frantisekferancik
 */
class Transaction_lib {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('transaction/banka/fio_email_lib');
        
        $this->CI->load->model('transaction/transaction_m');
        $this->CI->load->model('anonco/order_m');
    }

    public function downloadEmail() {
        /* connect to gmail */
        $hostname = '{imap.websupport.sk:993/imap/ssl}INBOX';
        $username = 'banka@anonco.sk';
        $password = 'st2wkj77a';

        // this can also be a Google Apps email account
        $config['login'] = 'banka@anonco.sk';
        $config['pass'] = $password;

// do not change these lines
// this should not change unless you are having problems
        $config['host'] = 'imap.websupport.sk';
        $config['port'] = '993';
        $config['service_flags'] = '/imap/ssl/novalidate-cert';

// you can definitely change these lines!
// because your application code goes here
        $peeker = new peeker($config);
        $peeker->set_search('FROM "frantisek.ferancik@emudk.sk"');
        $id_array = $peeker->search_and_count_messages();
        $spravy_ids = $peeker->get_ids_from_search();
        $return_arrays = array();
        foreach ($spravy_ids as $key => $value) {
            
            $email = $peeker->message($value);
            echo $email->message_id . '<br />';
            $email->get_parts();
            $body_email = $email->body_string;
            $transaction_array  = $this->CI->fio_email_lib->parseArray(explode("\n", $body_email));
            
            if($transaction_array){
                $transaction_id = $this->CI->transaction_m->insert($transaction_array);
                
                if($transaction_id){//sparovanie platby s objednavkou
                    $transaction_array['transaction_id'] = $transaction_id;
                    $return_arrays[] = $transaction_array;
                }
            }
        }
        
        return $return_arrays;
    }
    
    

}
