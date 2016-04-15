<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order_lib
 *
 * @author frantisekferancik
 */
class Order_lib {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('anonco/order_m');
        $this->CI->load->library('transaction/transaction_lib');
        $this->CI->load->library('anonco/submission_lib');
        $this->CI->load->model('anonco/submission_m');
        $this->CI->load->model('anonco/form_m');
    }

    public function generateVarSym($event_id) {
        $last_order_number = $this->CI->order_m->getLastOrderNumber($event_id);
        if (strlen($last_order_number) == 1) {
            $order_number = "000" . $last_order_number;
        } else if (strlen($last_order_number) == 2) {
            $order_number = "00" . $last_order_number;
        } else if (strlen($last_order_number) == 3) {
            $order_number = "0" . $last_order_number;
        } elseif (strlen($last_order_number4)) {
            $order_number == $last_order_number;
        }

        if (strlen($event_id) == 1) {
            $event_number = "0" . $event_id;
        } elseif (strlen($event_id) == 2) {
            $event_number = $event_id;
        }

        return date("Y") . $event_number . $order_number;
    }

    public function sparujPlatby() {
        $transactions = $this->CI->transaction_lib->downloadEmail();
        foreach ($transactions as $key => $transaction) {
            preVarDump($transaction);
            $order = $this->CI->order_m->getOrderSparuj($transaction['variabylny_symbol'], $transaction['suma']);
            if ($order) {//odoslanie info o platbe a priradenie startovnych cisel
                $form = $this->CI->form_m->getFormAsEvent_id($order->event_id);
                $submissions = $this->CI->submission_m->getOrderSubmission($order->order_id, $form->form_id);
                foreach ($submissions as $key => $submission) {
                    $this->CI->submission_lib->spracujSubmissionPoPlatbe($order, $form, $submission);
                }
                preVarDump($submissions);
            } else {
                preVarDump(FALSE);
            }
        }
    }

}
