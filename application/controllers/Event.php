<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Event
 *
 * @author frantisekferancik
 */
class Event extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->model('anonco/event_m');
        $this->load->model('anonco/form_m');
        $this->load->model('anonco/country_m');


        $this->load->library('anonco/Submission_lib');
        $this->load->library('form_validation');
    }

    public function index() {
        
    }

    public function detail($url) {
        $event = $this->event_m->getEventDetailUrl($url);
        
        
        $breadCrumb[] = array(
            'text' => 'Úvod',
            'href' => site_url(),
        );
        $breadCrumb[] = array(
            'text' => $event->name,
            'href' => site_url('event/detail/'.$event->url),
        );

        
        $this->template->load(TEMPLATE . 'template', TEMPLATE . 'event/detail', array(
            'event' => $event,
            'title' => $event->name . " | Anonco.sk",
            'keywords' => $event->name . " anonco.sk",
            'breadcrumb' => $breadCrumb,
            'page_title' => $event->name,
                )
        );
    }
    
    
    public function table_competitors($url){
        $event = $this->event_m->getEventDetailUrl($url);
        $form = $this->event_m->getActiveFormEvent($event->event_id);
        $submissions = $this->submission_m->getActiveSubmissionsEvent($form->form_id);
        
        foreach ($submissions as $key => $row) {
            $option  = $this->form_m->getFieldOptionName($event->event_id,'kategoria',$row->kategoria);
            $submissions[$key]->kategoria = $option->option_name;
            $country = $this->country_m->getCountryAsCode($row->country);
            $submissions[$key]->country = $country;
        }
        
        $breadCrumb[] = array(
            'text' => 'Úvod',
            'href' => site_url(),
        );
        $breadCrumb[] = array(
            'text' => $event->name,
            'href' => site_url('event/detail/'.$event->url),
        );
        $breadCrumb[] = array(
            'text' => 'Registrovaní pretekári',
            'href' => site_url('event/table_competitors/'.$event->url),
        );
        
        $this->template->load(TEMPLATE . 'template', TEMPLATE . 'event/table_competitors', array(
            'event' => $event,
            'title' => $event->name . " | Anonco.sk",
            'keywords' => $event->name . " anonco.sk",
            'breadcrumb' => $breadCrumb,
            'page_title' => $event->name,
            'submissions' => $submissions
                )
        );
    }
    
    public function table_competitors_frame($url){
        $event = $this->event_m->getEventDetailUrl($url);
        $form = $this->event_m->getActiveFormEvent($event->event_id);
        $submissions = $this->submission_m->getActiveSubmissionsEvent($form->form_id);
        
        foreach ($submissions as $key => $row) {
            $option  = $this->form_m->getFieldOptionName($event->event_id,'kategoria',$row->kategoria);
            $submissions[$key]->kategoria = $option->option_name;
            $country = $this->country_m->getCountryAsCode($row->country);
            $submissions[$key]->country = $country;
        }
        
        
        
        $this->template->load(TEMPLATE . 'template_frame', TEMPLATE . 'event/table_competitors_frame', array(
            
            'submissions' => $submissions
                )
        );
    }

    public function addSubmission() {
        $post_data = $this->input->post(null, TRUE);

        $event = $this->event_m->getEventDetailId($post_data['event_id']);

        $form = $this->event_m->getActiveFormEvent($event->event_id);

        $form_fields = $this->form_m->getFormFields($form->form_id);


        foreach ($form_fields as $key => $field) {
            $this->form_validation->set_rules($field->field_name, $field->field_label, createRuleValidation($field));
        }

        if ($this->form_validation->run()) {//ked prejde validacia
            $this->submission_lib->addSubmissionUserData($post_data);
            if($post_data['submission_hash'] == 0){
                $count_submission = $post_data['count_submision']+1;
            }else{
                $count_submission = $post_data['count_submision'];
            }
            
            echo json_encode(array('count_submission'=> $count_submission));
            
            //nacitanie user data submission a zobrazenie v lavej casti stranky
//            preVarDump("validacia presla");
        } else { //neprejde validacia
            preVarDump("validacia nepresla");
            preVarDump(validation_errors());
        }
    }

    private function calculateSubmisions($event_id, $submissions) {
        $return = array(
            'price' => 0,
            'currency' => null,
        );
        foreach ($submissions as $row) {
            foreach ($row as $key => $value) {
                $temp = $this->submission_m->getPriceSubmision($event_id, $key, $value);
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

    public function sumary() {

        $sub_temp = $this->session->userdata('submission');
        $submissions = array();
        $count = 0;
        foreach ($sub_temp as $key => $sub) {
            $submissions[$count] = $sub;
            $temp = $this->submission_m->getKatData($sub['event_id'], "kategoria", $sub['kategoria']);
            $submissions[$count]['kategoria_name'] = $temp->option_name;
            $submissions[$count]['kategoria_price'] = $temp->price . ' ' . $temp->currency;
            $count++;
        }

        $event = $this->event_m->getEventDetailId($submissions[0]['event_id']);


        $sub_total = $this->calculateSubmisions($submissions[0]['event_id'], $submissions);

        $breadCrumb[] = array(
            'text' => 'Úvod',
            'href' => site_url(),
        );
        $breadCrumb[] = array(
            'text' => $event->name,
            'href' => site_url('event/detail/'.$event->url),
        );
        $breadCrumb[] = array(
            'text' => 'Registrácia',
            'href' => site_url('event/registration/'.$event->url),
        );
        $breadCrumb[] = array(
            'text' => 'Sumár',
            'href' => site_url('event/sumary'),
        );


        $this->template->load(TEMPLATE . 'template', TEMPLATE . 'checkout/sumary', array(
            'submissions' => $submissions,
            'sub_total' => $sub_total,
            'event' => $event,
            'title' => $event->name . " sumár | Anonco.sk",
            'keywords' => $event->name . ", anonco.sk",
            'breadcrumb' => $breadCrumb,
            'page_title' => $event->name,
        ));
    }

    public function registration($url) {
        $event = $this->event_m->getEventDetailUrl($url);

        $form = $this->event_m->getActiveFormEvent($event->event_id);

        $form_fields = $this->form_m->getFormFields($form->form_id);


        foreach ($form_fields as $key => $field) {
            $this->form_validation->set_rules($field->field_name, $field->field_label, createRuleValidation($field));
        }

        if ($this->form_validation->run()) {//ked prejde validacia
            $insert_data = array();
            foreach ($form_fields as $key => $field) {
                $insert_data[$field->col_name] = $this->input->post($field->field_name, TRUE);
            }
            $this->submission_lib->createSubmission($event, $form, $insert_data);

            redirect(site_url('event/registracia_uspesna/' . $event->url));
        } else { //neprejde validacia
        }

        $submissions = $this->session->userdata('submission');

        $sub_total = $this->calculateSubmisions($event->event_id, $submissions);

        $breadCrumb[] = array(
            'text' => 'Úvod',
            'href' => site_url(),
        );
        $breadCrumb[] = array(
            'text' => $event->name,
            'href' => site_url('event/detail/'.$event->url),
        );
        $breadCrumb[] = array(
            'text' => 'Registrácia',
            'href' => site_url('event/registration/'.$event->url),
        );

        $this->template->load(TEMPLATE . 'template', TEMPLATE . 'event/registration', array(
            'event' => $event,
            'form' => $form,
            'fields' => $form_fields,
            'event_url' => createUrlEventDetail($event->url . '/'),
            'submissions' => $submissions,
            'sub_total' => $sub_total,
            'title' => $event->name . " registrácia | Anonco.sk",
            'keywords' => $event->name . " registrácia,  anonco.sk",
            'page_title' => $event->name,
            'breadcrumb' => $breadCrumb,
        ));
    }

    public function newSubmission($event_id) {
        $event = $this->event_m->getEventDetailId($event_id);

        $form = $this->event_m->getActiveFormEvent($event->event_id);

        $form_fields = $this->form_m->getFormFields($form->form_id);
        $submission_count = intval($this->input->post('submision_count', TRUE));

        $submission_count += 1;

        $new_submission = $this->load->view(TEMPLATE . 'event/add_new_submission', array(
            'event' => $event,
            'form' => $form,
            'fields' => $form_fields,
            'submission_count' => $submission_count,
                ), TRUE);

        echo json_encode(array("new_submission" => $new_submission, "submission_count" => $submission_count));
    }

    public function editSubmission() {
        $submission_hash = $this->input->post("submission_hash", TRUE);

        $submissions = $this->session->userdata('submission');



        $submission_data = $submissions[$submission_hash];

        $event = $this->event_m->getEventDetailId($submission_data['event_id']);

        $form = $this->event_m->getActiveFormEvent($event->event_id);

        $form_fields = $this->form_m->getFormFields($form->form_id);

        $html = $this->load->view(TEMPLATE . 'event/form', array('event' => $event, 'fields' => $form_fields, 'submissions' => $submission_data), TRUE);

        echo json_encode(array('html' => $html));
    }

    public function deletSubmission() {
        $submission_hash = $this->input->post("submission_hash", TRUE);

        $submissions = $this->session->userdata('submission');
        unset($submissions[$submission_hash]);

        $this->session->set_userdata(array('submission' => $submissions));
    }

    public function confirm() {
        
    }

    public function registracia_uspesna() {
        $this->template->load(TEMPLATE . 'template', TEMPLATE . 'event/thank_you_page');
    }

    public function getSubmissionList() {
        $submissions = $this->session->userdata('submission');

        $sub_total = $this->calculateSubmisions($this->input->post('event_id', TRUE), $submissions);
        if (count($submissions) > 0) {
            echo json_encode(array('html' => $this->load->view(TEMPLATE . 'event/submissionList', array('submissions' => $submissions, 'sub_total' => $sub_total), TRUE)));
        } else {
            echo json_encode(array('html' => ""));
        }
    }

}
