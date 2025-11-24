<?php
class Couverture_Structure_Sanitaire  extends CI_Controller{
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

      $resultat=$this->Model->getRequete('SELECT * FROM syst_couverture_structure');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $colabo=array();
          $colabo[]=$key['ID_TYPE_STRUCTURE'];
          $colabo[]=$key['DESCRIPTION'];
          $colabo[]='';
          $colabo[]='';
                                
       $tabledata[]=$colabo;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('#','Type de Structure','Nb Structure','Nb Membres'));
        $data['title'] = " Structure sanitaire";
        $data['stitle'] = " Structure sanitaire";
        $data['employe']=$tabledata;

        // print_r($data);
        // exit();
        $this->load->view('Couverture_Structure_Sanitaire_List_View',$data);

    }
    


}