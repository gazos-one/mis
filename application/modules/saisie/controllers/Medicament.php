<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Medicament extends CI_Controller {

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
      $data['title']=' Medicament';
      $data['stitle']=' Medicament';
      $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
      $this->load->view('Medicament_Add_View',$data);
    }


    public function add()
    {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $ID_COUVERTURE_MEDICAMENT=$this->input->post('ID_COUVERTURE_MEDICAMENT');

   $this->form_validation->set_rules('DESCRIPTION', 'Nom', 'required');
   $this->form_validation->set_rules('ID_COUVERTURE_MEDICAMENT', 'Type de medicament', 'required');
   if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
                            Medicament non enregistr&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $data['title']=' Medicament';
    $data['stitle']=' Medicament';
    $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
    $this->load->view('Medicament_Add_View',$data);
   }
   else{

    $datas=array('DESCRIPTION'=>$DESCRIPTION,
                 'ID_COUVERTURE_MEDICAMENT'=>$ID_COUVERTURE_MEDICAMENT,
                );


    $this->Model->insert_last_id('masque_medicament',$datas);
  
    $message = "<div class='alert alert-success' id='message'>
                            Medicament enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Medicament/listing'));    

   }
   

  }

     public function listing()
    {

      $resultat=$this->Model->getRequete('SELECT masque_medicament.ID_MEDICAMENT, masque_medicament.DESCRIPTION as NMEDICAMENT, masque_medicament.STATUS, syst_couverture_medicament.DESCRIPTION AS NONCOUVERTURE FROM `masque_medicament` JOIN syst_couverture_medicament ON syst_couverture_medicament.ID_COUVERTURE_MEDICAMENT = masque_medicament.ID_COUVERTURE_MEDICAMENT');
      //WHERE reservation_chambre.STATUT_RESERV_ID=1
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {
          if ($key['STATUS'] == 1) {
            $stat = 'Actif';
            $fx = 'desactiver';
            $col = 'btn-danger';
            $titr = 'Désactiver';
            $stitr = 'voulez-vous désactiver le medicament ';
            $bigtitr = 'Désactivation du medicament';
          }
          else{
            $stat = 'Innactif';
            $fx = 'reactiver';
            $col = 'btn-success';
            $titr = 'Réactiver';
            $stitr = 'voulez-vous réactiver le medicament ';
            $bigtitr = 'Réactivation du medicament';
          }
          $chambr=array();
          $chambr[]=$key['NMEDICAMENT'];
          $chambr[]=$key['NONCOUVERTURE'];   
          $chambr[]=$stat;
          $chambr[]='<div class="modal fade" id="desactcat'.$key['ID_MEDICAMENT'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key['NMEDICAMENT'].')?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="'.base_url('saisie/Medicament/'.$fx.'/'.$key['ID_MEDICAMENT']).'" class="btn '.$col.'">'.$titr.'</a>
      </div>
    </div>
  </div>
</div>

          <div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="'.base_url('saisie/Medicament/index_update/'.$key['ID_MEDICAMENT']).'"> Modifier </a> </li>
                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_MEDICAMENT'].'"> '.$titr.' </a> </li>
                    </ul>
                  </div>';
         
                          
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Nom','Type','Status','Option'));
        $data['title'] = " Medicament";
        $data['chamb']=$tabledata;
        $data['stitle']=' Medicament';
        $this->load->view('Medicament_List_View',$data);

    }

    public function index_update($id)
    {

      $data['title']=' Medicament';
      $data['stitle']=' Medicament';
      $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
      $data['selected'] = $this->Model->getOne('masque_medicament',array('ID_MEDICAMENT'=>$id)); 
      $this->load->view('Medicament_Update_View',$data);
    }


     public function update()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $ID_COUVERTURE_MEDICAMENT=$this->input->post('ID_COUVERTURE_MEDICAMENT');
  $ID_MEDICAMENT=$this->input->post('ID_MEDICAMENT');

   $this->form_validation->set_rules('DESCRIPTION', 'Nom', 'required');
   $this->form_validation->set_rules('ID_COUVERTURE_MEDICAMENT', 'Type de medicament', 'required');
   if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
                            Medicament non modifi&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $data['title']=' Medicament';
    $data['stitle']=' Medicament';
    $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
    $data['selected'] = $this->Model->getOne('masque_medicament',array('ID_MEDICAMENT'=>$ID_MEDICAMENT)); 
    $this->load->view('Medicament_Update_View',$data);
   }
   else{

    $datas=array('DESCRIPTION'=>$DESCRIPTION,
                 'ID_COUVERTURE_MEDICAMENT'=>$ID_COUVERTURE_MEDICAMENT,
                );


    $this->Model->update('masque_medicament',array('ID_MEDICAMENT'=>$ID_MEDICAMENT),$datas);
  
    $message = "<div class='alert alert-success' id='message'>
                            Medicament modifi&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Medicament/listing'));    

   }

  }


  public function desactiver($id)
    {
      $this->Model->update('masque_medicament',array('ID_MEDICAMENT'=>$id),array('STATUS'=>0));
      $message = "<div class='alert alert-success' id='message'>
                            Medicament désactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Medicament/listing')); 
    }

  public function reactiver($id)
    {
      $this->Model->update('masque_medicament',array('ID_MEDICAMENT'=>$id),array('STATUS'=>1));
      $message = "<div class='alert alert-success' id='message'>
                            Medicament Réactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Medicament/listing')); 
    }

    
}
?>