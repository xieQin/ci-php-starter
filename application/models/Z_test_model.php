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
class Z_test_model extends CI_Model {

    public function __construct() {
//        $this->load->database();
    }

    public function set_data() {      
        
        $data = array(
            'id' => 1,
            'name' => name1
        );
        return $this->db->insert('t_test', $data);
    }

}
