<?php
class Province  extends CI_Controller{
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

      $resultat=$this->Model->getRequete('SELECT * FROM syst_provinces');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $colabo=array();
          $colabo[]=$key['PROVINCE_ID'];
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
        $this->table->set_heading(array('Numero ou Code','Nom',));
        $data['title'] = " Province";
        $data['stitle'] = " Province";
        $data['employe']=$tabledata;

        // print_r($data);
        // exit();
        $this->load->view('Province_List_View',$data);

    }
    


}