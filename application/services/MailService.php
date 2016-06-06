<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MailService extends CI_Service {

    public function __construct() {
        parent::__construct();

//        $this->load->model('TasksModel');
    }

    public function sendMail($name) {

        $this->email->from($this->config->item('smtp_user'), '111');
        $this->email->to('wus@zsgjs.com');
//        $this->email->cc('another@another-example.com');
//        $this->email->bcc('them@their-example.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();
    }

}
