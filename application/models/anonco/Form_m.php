<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form_m
 *
 * @author frantisekferancik
 */
class Form_m extends CI_Model {

    public function getFormFields($form_id) {
        $query = $this->db->select()
                ->from(DB_PREFIX . 'form_fields')
                ->where('form_id', $form_id)
                ->order_by('order', 'asc')
                ->get();
        $fields = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $field) {
                
                switch ($field->field_type) {
                    case "radios":
                        $fields[$key] = $field;
                        $fields[$key]->options = $this->getFieldOptions($field->field_id);
                        break;
                    case "checkboxes":
                        $fields[$key] = $field;
                        $fields[$key]->options = $this->getFieldOptions($field->field_id);
                        break;
                    case "select":
                        if ($field->is_country == 0) {
                            $fields[$key] = $field;
                            $fields[$key]->options = $this->getFieldOptions($field->field_id);
                        } else {
                            $fields[$key] = $field;
                            $fields[$key]->options = $this->getFieldOptionsCountry($field->field_id);
                        }
                        break;
                    default:
                        $fields[$key] = $field;
                }

                $fields[$key]->validation = $this->getFieldValidationRules($field->field_id);
            }
            return $fields;
        }
    }

    /*
     * $field_id = id fieldu vo formulari
     * 
     * vrati polozky ktore sa maju nachadzat v selectboxe, checkboxe alebo radion buttone
     */

    public function getFieldOptions($field_id) {
        $query = $this->db->select()
                ->from(DB_PREFIX . 'field_options')
                ->where('field_id', $field_id)
                ->order_by('order', 'asc')
                ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    
    public function getFieldOptionsCountry(){
        $query = $this->db->select("iso_code_2 as option_value, name as option_name")
                           ->from(DB_PREFIX.'country')
                           ->where('status', 1)
                           ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getFieldValidationRules($field_id) {
        $query = $this->db->select()
                ->from(DB_PREFIX . 'field_validation')
                ->where('field_id', $field_id)
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    /*
     * Vrati form fields aj vsetky jeho nastavenia 
     */

    public function getFieldAsName($event_id, $field_name) {
        $query = $this->db->select()
                ->from(DB_PREFIX . 'form_fields')
                ->join(DB_PREFIX . 'event_form', DB_PREFIX . 'event_form.form_id = ' . DB_PREFIX . 'form_fields.form_id')
                ->where(DB_PREFIX . 'event_form.event_id', $event_id)
                ->where(DB_PREFIX . 'form_fields.field_name', $field_name)
                ->get();
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $field = $query->row();
            switch ($field->field_type) {
                case "radios":
                    $field->options = $this->getFieldOptions($field->field_id);
                    break;
                case "checkboxes":
                    $field->options = $this->getFieldOptions($field->field_id);
                    break;
                case "select":
                    $field->options = $this->getFieldOptions($field->field_id);
                    break;
            }
            return $field;
        }
        return FALSE;
    }
    
    public function getFieldOptionName($event_id, $field_name, $option_value){
        $query = $this->db->select()
                ->from(DB_PREFIX . 'form_fields')
                ->join(DB_PREFIX . 'event_form', DB_PREFIX . 'event_form.form_id = ' . DB_PREFIX . 'form_fields.form_id')
                ->where(DB_PREFIX . 'event_form.event_id', $event_id)
                ->where(DB_PREFIX . 'form_fields.field_name', $field_name)
                ->get();
        if ($query->num_rows() > 0) {
            $field = $query->row();
            $field->options = $this->getFieldOptions($field->field_id);
            foreach ($field->options as $key => $option) {
                if($option->option_value == $option_value){
                    return $option;
                }
            }
        }
        
    }

    public function getFormAsEvent_id($event_id) {
        $query = $this->db->select(DB_PREFIX . 'forms.*')
                ->from(DB_PREFIX . 'forms')
                ->join(DB_PREFIX . 'event_form', DB_PREFIX . 'event_form.form_id = ' . DB_PREFIX . 'forms.form_id', 'inner')
                ->where(DB_PREFIX . 'event_form.event_id', $event_id)
                ->limit(1)
                ->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

}
