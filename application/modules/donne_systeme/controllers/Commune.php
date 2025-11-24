<?php
class Commune  extends CI_Controller{
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

      $resultat=$this->Model->getRequete('SELECT * FROM `syst_communes` join syst_provinces ON syst_provinces.PROVINCE_ID = syst_communes.PROVINCE_ID ');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {
          $colabo=array();
          $colabo[]=$key['COMMUNE_ID'];
          $colabo[]=$key['COMMUNE_NAME'];
          $colabo[]=$key['PROVINCE_NAME'];
          // $colabo[]='';
          // $colabo[]='';
                                
       $tabledata[]=$colabo;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Code ou Numero','Commune','Province'));
        $data['title'] = " Commune";
        $data['stitle'] = " Commune";
        $data['employe']=$tabledata;

        // print_r($data);
        // exit();
        $this->load->view('Commune_List_View',$data);

    }
    


}