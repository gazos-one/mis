<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Centre_Optique extends CI_Controller {

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
      $data['title']=' Centre Optique';
      $data['stitle']=' Centre Optique';
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getList('syst_communes');
      $this->load->view('Centre_Optique_Add_View',$data);
    }


 public function get_commune()
  {
  $commune= $this->Model->getList("syst_communes",array('PROVINCE_ID'=>$this->input->post('provine_id')));
  $datas= '<option value="">-- Sélectionner --</option>';
  foreach($commune as $commun){
  $datas.= '<option value="'.$commun["COMMUNE_ID"].'">'.$commun["COMMUNE_NAME"].'</option>';
  }
  $datas.= '';
  echo $datas;
  }


    public function add()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $PROVINCE_ID=$this->input->post('PROVINCE_ID');
  $COMMUNE_ID=$this->input->post('COMMUNE_ID');

   $this->form_validation->set_rules('DESCRIPTION', 'Nom', 'required');
   $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
   $this->form_validation->set_rules('COMMUNE_ID', 'Commune', 'required');

   if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
    Centre Optique non enregistr&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $data['title']=' Centre Optique';
    $data['stitle']=' Centre Optique';
    $data['province'] = $this->Model->getListOrdertwo('syst_provinces'); 
    $data['commune'] = $this->Model->getList('syst_communes');
    $this->load->view('Centre_Optique_Add_View',$data);
   }
   else{

    $datas=array('DESCRIPTION'=>$DESCRIPTION,
                 'PROVINCE_ID'=>$PROVINCE_ID,
                 'COMMUNE_ID'=>$COMMUNE_ID,
                );


    $this->Model->insert_last_id('consultation_centre_optique',$datas);
  
    $message = "<div class='alert alert-success' id='message'>
    Centre Optique enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Centre_Optique/listing'));    

   }
   

  }

     public function listing()
    {

      $resultat=$this->Model->getRequete('SELECT consultation_centre_optique.ID_CENTRE_OPTIQUE, consultation_centre_optique.DESCRIPTION AS NOMSTRUCTURE, syst_provinces.PROVINCE_NAME, syst_communes.COMMUNE_NAME, consultation_centre_optique.STATUS FROM consultation_centre_optique JOIN syst_provinces ON syst_provinces.PROVINCE_ID = consultation_centre_optique.PROVINCE_ID JOIN syst_communes ON syst_communes.COMMUNE_ID = consultation_centre_optique.COMMUNE_ID');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {
          if ($key['STATUS'] == 1) {
            $stat = 'Actif';
            $fx = 'desactiver';
            $col = 'btn-danger';
            $titr = 'Désactiver';
            $stitr = 'voulez-vous désactiver le Centre Optique ';
            $bigtitr = 'Désactivation du Centre Optique';
          }
          else{
            $stat = 'Innactif';
            $fx = 'reactiver';
            $col = 'btn-success';
            $titr = 'Réactiver';
            $stitr = 'voulez-vous réactiver le Centre Optique ';
            $bigtitr = 'Réactivation du Centre Optique';
          }
          $chambr=array();
          $chambr[]=$key['NOMSTRUCTURE'];
          $chambr[]=$key['PROVINCE_NAME'];  
          $chambr[]=$key['COMMUNE_NAME'];  
          $chambr[]=$stat;
          $chambr[]='<div class="modal fade" id="desactcat'.$key['ID_CENTRE_OPTIQUE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key['NOMSTRUCTURE'].')?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="'.base_url('saisie/Centre_Optique/'.$fx.'/'.$key['ID_CENTRE_OPTIQUE']).'" class="btn '.$col.'">'.$titr.'</a>
      </div>
    </div>
  </div>
</div>

          <div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="'.base_url('saisie/Centre_Optique/index_update/'.$key['ID_CENTRE_OPTIQUE']).'"> Modifier </a> </li>
                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_CENTRE_OPTIQUE'].'"> '.$titr.' </a> </li>
                    </ul>
                  </div>';
         
                          
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Nom','Province','Commune','Status','Option'));
        $data['title'] = " Centre Optique";
        $data['chamb']=$tabledata;
        $data['stitle']=' Centre Optique';
        $this->load->view('Centre_Optique_List_View',$data);

    }

    public function index_update($id)
    {

      $data['title']=' Centre Optique';
      $data['stitle']=' Centre Optique';
      $selected = $this->Model->getOne('consultation_centre_optique',array('ID_CENTRE_OPTIQUE'=>$id)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['selected'] = $this->Model->getOne('consultation_centre_optique',array('ID_CENTRE_OPTIQUE'=>$id)); 
      $this->load->view('Centre_Optique_Update_View',$data);
    }


     public function update()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $PROVINCE_ID=$this->input->post('PROVINCE_ID');
  $COMMUNE_ID=$this->input->post('COMMUNE_ID');
  $ID_CENTRE_OPTIQUE=$this->input->post('ID_CENTRE_OPTIQUE');

   $this->form_validation->set_rules('DESCRIPTION', 'Nom', 'required');
   $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
   $this->form_validation->set_rules('COMMUNE_ID', 'Commune', 'required');

   if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
    Centre Optique non enregistr&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      $data['title']=' Centre Optique';
      $data['stitle']=' Centre Optique';
      $selected = $this->Model->getOne('consultation_centre_optique',array('ID_CENTRE_OPTIQUE'=>$ID_CENTRE_OPTIQUE)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['selected'] = $this->Model->getOne('consultation_centre_optique',array('ID_CENTRE_OPTIQUE'=>$ID_CENTRE_OPTIQUE)); 
      $this->load->view('Centre_Optique_Update_View',$data);
   }
   else{

    $datas=array('DESCRIPTION'=>$DESCRIPTION,
                 'PROVINCE_ID'=>$PROVINCE_ID,
                 'COMMUNE_ID'=>$COMMUNE_ID,
                );

    $this->Model->update('consultation_centre_optique',array('ID_CENTRE_OPTIQUE'=>$ID_CENTRE_OPTIQUE),$datas);
  
    $message = "<div class='alert alert-success' id='message'>
    Centre Optique modifi&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Centre_Optique/listing'));    

   }

  }


  public function desactiver($id)
    {
      $this->Model->update('consultation_centre_optique',array('ID_CENTRE_OPTIQUE'=>$id),array('STATUS'=>0));
      $message = "<div class='alert alert-success' id='message'>
      Centre Optique désactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Centre_Optique/listing')); 
    }

  public function reactiver($id)
    {
      $this->Model->update('consultation_centre_optique',array('ID_CENTRE_OPTIQUE'=>$id),array('STATUS'=>1));
      $message = "<div class='alert alert-success' id='message'>
      Centre Optique Réactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Centre_Optique/listing')); 
    }

    public function details()
    {
      $data['title']=' Client';
      $data['stitle']=' Client';
      $this->load->view('Client_Details_View',$data);
    }



}
?>