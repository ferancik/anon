<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Submission_m
 *
 * @author frantisekferancik
 */
class Submission_m extends CI_Model {

    public function insert($table, $data) {
        if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function update($table, $submission_id, $data) {
        $this->db->where('submission_id', $submission_id);
        $this->db->update($table, $data);
    }

    public function getLastSerialNumber($table) {
        $query = $this->db->select()
                ->from($table)
                ->order_by("serial_number", "desc")
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            $serial_number = $query->row()->serial_number;
            if ($serial_number == 0) {
                return FALSE;
            } else {
                return $serial_number + 1;
            }
        }
        return FALSE;
    }

    public function insertHistory($data) {
        $this->db->insert(DB_PREFIX . 'submission_history', $data);
    }

    /*
     * vytiahne aktivne submissions ktore sa zobrazia v tabulke pretekarov
     */

    public function getActiveSubmissionsEvent($form_id) {
        $query = $this->db->select()
                ->from(DB_PREFIX."form_".$form_id)
                ->where("stav != ", "zruseny")
                ->get();
        
        if ($query->num_rows() > 0) {
            
            return $query->result();
        }
        return FALSE;   
    }

    public function getPriceSubmision($even_id, $field_name, $option_value) {
        $query = $this->db->select(DB_PREFIX . 'field_options.price,' . DB_PREFIX . 'field_options.currency')
                ->from(DB_PREFIX . 'event')
                ->join(DB_PREFIX . 'event_form', DB_PREFIX . 'event_form.event_id = ' . DB_PREFIX . 'event.event_id', 'inner')
                ->join(DB_PREFIX . 'form_fields', DB_PREFIX . 'form_fields.form_id = ' . DB_PREFIX . 'event_form.form_id', 'inner')
                ->join(DB_PREFIX . 'field_options', DB_PREFIX . 'field_options.field_id = ' . DB_PREFIX . 'form_fields.field_id', 'inner')
                ->where(DB_PREFIX . 'event.event_id', $even_id)
                ->where(DB_PREFIX . 'form_fields.field_name', $field_name)
                ->where(DB_PREFIX . 'field_options.option_value', $option_value)
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    public function getKatData($even_id, $field_name, $option_value) {
        $query = $this->db->select(DB_PREFIX . 'field_options.price,' . DB_PREFIX . 'field_options.currency,' . DB_PREFIX . 'field_options.option_name')
                ->from(DB_PREFIX . 'event')
                ->join(DB_PREFIX . 'event_form', DB_PREFIX . 'event_form.event_id = ' . DB_PREFIX . 'event.event_id', 'inner')
                ->join(DB_PREFIX . 'form_fields', DB_PREFIX . 'form_fields.form_id = ' . DB_PREFIX . 'event_form.form_id', 'inner')
                ->join(DB_PREFIX . 'field_options', DB_PREFIX . 'field_options.field_id = ' . DB_PREFIX . 'form_fields.field_id', 'inner')
                ->where(DB_PREFIX . 'event.event_id', $even_id)
                ->where(DB_PREFIX . 'form_fields.field_name', $field_name)
                ->where(DB_PREFIX . 'field_options.option_value', $option_value)
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    public function getOrderSubmission($order_id, $form_id) {
        $query = $this->db->select(DB_PREFIX . 'form_' . $form_id . '.*')
                ->from(DB_PREFIX . 'form_' . $form_id)
                ->join(DB_PREFIX . 'order_submision', DB_PREFIX . 'order_submision.submision_id = ' . DB_PREFIX . 'form_' . $form_id . '.submission_id', 'inner')
                ->where(DB_PREFIX . 'order_submision.order_id', $order_id)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    /*
     * vrati vsetky data ohladne submmission na odosielanie pre email
     */

    public function getSubmissionData($submission_id, $form_id) {
        
    }

}
