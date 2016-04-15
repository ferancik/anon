<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Submission_lib
 *
 * @author frantisekferancik
 */
class Submission_lib {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model("anonco/submission_m");
        $this->CI->load->model("anonco/event_m");
        $this->CI->load->model('anonco/order_m');
        $this->CI->load->model('anonco/form_m');

        $this->CI->load->library('anonco/order_lib');

        $this->CI->load->library('admin/send_mail_lib');
    }

    public function createSubmission($event, $form, $data) {
        $data['hash'] = createteHash(" ");
        $data['password'] = $this->randomPassword();
        $data['submision_date'] = date("Y-m-d H:i:s");
        $data['last_modified_date'] = date("Y-m-d H:i:s");
        $data['ip_address'] = $this->CI->input->ip_address();
//        $data['serial_number'] = $this->getSerialNumber($event, $form);
        $data['serial_number'] = 0;

        return $this->CI->submission_m->insert(DB_PREFIX . 'form_' . $form->form_id, $data);
    }

    public function addSubmissionToDb() {
        $submission_user_data = $this->CI->session->userdata('submission');
        $order_submision = array();

        foreach ($submission_user_data as $key => $submission) {
            $form = $this->CI->form_m->getFormAsEvent_id($submission['event_id']);
            $event = $this->CI->event_m->getEventDetailId($submission['event_id']);
            unset($submission['event_id']);
            unset($submission['count_submision']);
            unset($submission['submission_hash']);
            $order_submission_id = $this->createSubmission($event, $form, $submission);
            $order_submision[] = $order_submission_id;
            $order_submision_data[] = $this->getSubmissionArray($submission, $form);
        }
       
        $submission_user_data = $this->CI->session->userdata('submission');

        $order_data = array();
        foreach ($submission_user_data as $key => $submission) {
            $order_data['event_id'] = $submission['event_id'];
            $order_data['first_name'] = $submission['meno'];
            $order_data['last_name'] = $submission['priezvisko'];
            $order_data['street'] = $submission['ulica'];
            $order_data['post_code'] = $submission['psc'];
            $order_data['phone_number'] = $submission['tel_cislo'];
            $order_data['email_address'] = $submission['email'];
            $temp = $this->calculateSubmisions($submission['event_id'], $submission_user_data);
            $order_data['price'] = $temp['price'];

            $order_data['order_number'] = $this->CI->order_m->getLastOrderNumber($submission['event_id']);
            $order_data['var_symbol'] = $this->CI->order_lib->generateVarSym($submission['event_id']);
            continue;
        }

        $this->CI->order_m->insert($order_data, $order_submision);

        //odoslanie informacii o platbe
        $from['email'] = "info@anonco.sk";
        $from['meno'] = "Anonco.sk";
        $this->CI->send_mail_lib->sendEmail(
                TEMPLATE . '/email/after_registration', $order_data['email_address'], array('submissions' => $order_submision_data, 'order_data' => $order_data), 'Registrácia pretekára ' . $event->name, $from, $files = false);
        $this->CI->session->unset_userdata('submission');
    }

    /*
     * funkcia ktora vrata v array vsetky data o registrovanom pretekeraovi
     * 'textbox','textarea','radios','checkboxes','select','multi-select','option_list_or_form_field','datepicker'
     */

    public function getSubmissionArray($submission, $form) {
        $form_fields = $this->CI->form_m->getFormFields($form->form_id);
//        preVarDump($form_fields);
        foreach ($form_fields as $key => $field) {
            if ($field->field_type == 'textbox' || $field->field_type == 'textarea' || $field->field_type == 'datepicker') {
                $return_array[] = array(
                    'label' => $field->field_label,
                    'value' => $submission[$field->field_name],
                );
            } else if ($field->field_type == 'radios' || $field->field_type == 'checkboxes' || $field->field_type == 'select') {
                foreach ($field->options as $option) {
                    if ($option->option_value == $submission[$field->field_name]) {
                        $return_array[] = array(
                            'label' => $field->field_label,
                            'value' => $option->option_name,
                        );
                    }
                }
            }
        }
       
        

        return $return_array;
    }

    public function spracujSubmissionPoPlatbe($order, $form, $submission) {
        $update_data = array(
            'serial_number' => $this->getSerialNumber($order->event_id, $form->form_id)
        );

        $this->CI->submission_m->update(DB_PREFIX . 'form_' . $form->form_id, $submission->submission_id, $update_data);

        $history = array(
            'submission_state_id' => 2,
            'submission_id' => $submission->submission_id,
            'form_id' => $form->form_id,
        );

        $this->CI->submission_m->insertHistory($history);

        //odoslanie emailu o zaplatene a 
        preVarDump("odoslat email o zaplateni");
        //odoslanie informacii o platbe
        $from['email'] = "info@anonco.sk";
        $from['meno'] = "Anonco.sk";
        $this->CI->send_mail_lib->sendEmail(TEMPLATE . '/email/after_payment', $submission->email, null, 'Po platbe', $from, $files = false);
    }

    public function calculateSubmisions($event_id, $submissions) {
        $return = array(
            'price' => 0,
            'currency' => null,
        );
        foreach ($submissions as $row) {
            foreach ($row as $key => $value) {
                $temp = $this->CI->submission_m->getPriceSubmision($event_id, $key, $value);
                if ($temp != NULL) {

                    $return['price'] += $temp->price;
                    if (strlen($temp->currency) > 0 & $return['currency'] == NULL) {
                        $return['currency'] = $temp->currency;
                    }
                }
            }
        }
        return $return;
    }

    //c94ceafd7b4289375ff01de31247aafb
    //c94ceafd7b4289375ff01de31247aafb

    public function addSubmissionUserData($data) {
        if ($data['submission_hash'] == 0) {
            $data['submission_hash'] = createteHash(" ");
        }

        $submission_user_data = $this->CI->session->userdata('submission');

        foreach ($data as $key => $value) {
            $submission_user_data[$data['submission_hash']][$key] = $value;
        }

        $this->CI->session->set_userdata(array('submission' => $submission_user_data));

        $this->calculateSumPriceUserData();
    }

    /*
     * vypocita sumu kolko ma uhradit user za registracie ktore vyklikal 
     * informativny vypocet
     */

    public function calculateSumPriceUserData() {
        $submission_user_data = $this->CI->session->userdata('submission');
        $sum = 0;
        foreach ($submission_user_data as $submission) {
            foreach ($submission as $key => $field) {
//                preVarDump($field);
                $field = $this->CI->form_m->getFieldAsName($submission['event_id'], $key);
                if ($field & count($field->options) > 0) {
                    foreach ($field->options as $key_option => $value) {
                        if ($value->option_value == $field) {
                            
                        }
                    }
                }
                //preVarDump($field);
            }
        }
    }

    /*
     * $event_id = id eventu
     * 
     * vyhlada a vrati dalsie cislo pretekara ktore ma nasledovat
     */

    public function getSerialNumber($event_id, $form_id) {
        $serial_number = $this->CI->submission_m->getLastSerialNumber(DB_PREFIX . 'form_' . $form_id);
        if ($serial_number) {
            return $serial_number;
        } else {
            return $this->CI->event_m->getLastSerialNumber($event_id);
        }
    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
