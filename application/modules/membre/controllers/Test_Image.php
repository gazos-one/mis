<?php
class Test_Image  extends CI_Controller{
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

        $data[]=array();
        $this->load->view('Test_Image_View',$data);

    }


    public function add()
    {
      
       $repPhotoo =FCPATH.'/uploads/image_membre_test';
        $code=uniqid();
        $logo_societe = $_FILES['URL_PHOTO']['name'];
        $config['upload_path'] ='./uploads/image_membre_test/';
        $config['allowed_types'] = '*';
        $test = explode('.', $logo_societe);
        $ext = end($test);
        $name = $code.'_membre.' . $ext;
        $config['file_name'] =$name;

        if(!is_dir($repPhotoo)) //create the folder if it does not already exists   
        {
            mkdir($repPhotoo,0777,TRUE);                            
        }

        $this->upload->initialize($config);
        $this->upload->do_upload('URL_PHOTO');
        $image_name_main=$config['file_name'];
        $data_image=$this->upload->data();



        // $configs['image_library'] = 'gd2';
        // $configs['source_image'] = FCPATH.'/uploads/image_membre_test/'.$name.'';
        // $configs['create_thumb'] = FALSE;
        // $configs['maintain_ratio'] = FALSE;
        // $configs['width'] = 866;
        // $configs['height'] = 1300;
        // $this->load->library('image_lib', $configs);
        // $this->image_lib->resize();

        // if (!$this->image_lib->resize())
        //   {
        //     echo $this->image_lib->display_errors();
        //   }

    }
    
    public function addphoto($value='')
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
    }


}