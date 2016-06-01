<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of News model
 *
 * @author ws
 */
class News_model extends CI_Model {

    public function __construct() {
//        $this->load->database();
    }

    public function get_news($slug = FALSE) {
        if ($slug === FALSE) {
            $query = $this->db->get('news');
            return $query->result_array();
        }
        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }

    public function set_news() {
        $this->load->helper('url');
        
        $slug = url_title($this->input->post('title'), 'dash', TRUE);
        
        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text')
        );
        
        return $this->db->insert('news', $data);
    }

    
    public function test_Service() {
        
        
        $data = array(
            'title' =>"test_Service",
            'slug' => "test_Service",
            'text' => "content:----------------------------------test_Service"
        );
        
        return $this->db->insert('news', $data);
    }
}
