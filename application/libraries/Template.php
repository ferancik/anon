<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    var $template_data = array();
    private $CI;
    

    function __construct() {
        $this->CI = & get_instance();
    }

    function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    function load($template = '', $view = '', $view_data = array(), $return = FALSE) {
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        $this->set("title", $view_data['title']);
        $this->set("description", $view_data['meta_desc']);
        $this->set("keywords", $view_data['meta_tags']);
        if (isset($view_data['breadCrumb'])) {
            $this->set("breadcrumb", $view_data['breadCrumb']);
        }
        if (isset($view_data['page_title'])) {
            $this->set("page_title", $view_data['page_title']);
        }
        $this->CI->load->view($template, $this->template_data, $return);
    }

}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */