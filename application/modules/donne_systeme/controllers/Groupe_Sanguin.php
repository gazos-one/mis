<?php
class Groupe_Sanguin  extends CI_Controller{
    function __construct() {
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

      $resultat=$this->Model->getRequete('SELECT * FROM syst_groupe_sanguin');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $colabo=array();
          $colabo[]=$key['ID_GROUPE_SANGUIN'];
          $colabo[]=$key['DESCRIPTION'];
          $colabo[]='';
                                
       $tabledata[]=$colabo;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('#','Groupe Sanguin','Nb Membres'));
        $data['title'] = " Groupe Sanguin";
        $data['stitle'] = " Groupe Sanguin";
        $data['employe']=$tabledata;

        // print_r($data);
        // exit();
        $this->load->view('Groupe_Sanguin_List_View',$data);

    }
    


}