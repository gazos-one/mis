<?php
class Regime_Assurance  extends CI_Controller{
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

      $resultat=$this->Model->getRequete('SELECT * FROM syst_regime_assurance');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $colabo=array();
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
        $this->table->set_heading(array('Intitulé','Nb Categorie Assurances','Nb Membres'));
        $data['title'] = " Regime d'assurance";
        $data['stitle'] = " Regime d'assurance";
        $data['employe']=$tabledata;

        // print_r($data);
        // exit();
        $this->load->view('Regime_Assurance_List_View',$data);

    }
    


}