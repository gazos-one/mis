<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Acceuil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Is_Connected(); 
    }

    public function Is_Connected()
       {
       if (empty($this->session->userdata('MIS_ID_USER')))
        {
         redirect(base_url('Login/'));
        }
       }



    public function index()
    {
      $data = array();
      $data['stitle']='Accueil';
      $this->load->view('Acceuil_View',$data);
    }




}
?>