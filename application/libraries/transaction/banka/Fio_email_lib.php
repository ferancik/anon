<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fio_email_lib
 *
 * @author frantisekferancik
 */
class Fio_email_lib {

    private $CI;
    private $array_test = array(
        'cislo_uctu' => array(
            'data_type' => 'string',
            'value' => 'Příjem na kontě:'
        ),
        'suma' => array(
            'data_type' => 'double',
            'value' => 'Částka:'
        ),
        'variabylny_symbol' => array(
            'data_type' => 'string',
            'value' => 'VS:'
        ),
        'sprava' => array(
            'data_type' => 'string',
            'value' => 'Zpráva příjemci:'
        ),
        'zostatok' => array(
            'data_type' => 'double',
            'value' => 'Aktuální zůstatek:'
        ),
        'protiucet' => array(
            'data_type' => 'string',
            'value' => 'Protiúčet:'
        ),
        'specificky_symbol' => array(
            'data_type' => 'string',
            'value' => 'SS:'
        ),
        'konstantny_symbol' => array(
            'data_type' => 'string',
            'value' => 'KS:'
        ),
    );

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function parseArray($array) {
        $return_array = array();
        $is_transaction = false;
        foreach ($this->array_test as $key => $value) {
            foreach ($array as $row) {
                $pos = strpos($row, $value['value']);
                if ($pos !== FALSE) {
                    if ($value['data_type'] == 'double') {
                        $temp = substr($row, strlen($value['value']) + 1, -1);
                        $temp = str_replace(" ", "", $temp);
                        $temp = str_replace(",", ".", $temp);
                        $return_array[$key] = floatval($temp);
                        $is_transaction = TRUE;
                    } else if ($value['data_type'] == 'string') {
                        $return_array[$key] = substr($row, strlen($value['value']) + 1, -1);
                        $is_transaction = TRUE;
                    }
                }
            }
        }

        if ($is_transaction) {
            return $return_array;
        }
        return FALSE;
    }

}
