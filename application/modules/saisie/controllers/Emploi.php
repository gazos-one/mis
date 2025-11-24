<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Emploi extends CI_Controller {

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
      $data['title']=' Emploi';
      $data['stitle']=' Emploi';
      // $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      // $data['commune'] = $this->Model->getList('syst_communes');
      $this->load->view('Emploi_Add_View',$data);
    }



    public function add()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');

   $this->form_validation->set_rules('DESCRIPTION', 'Nom', 'required');

   if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
                            Emploi non enregistr&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $data['title']=' Emploi';
    $data['stitle']=' Emploi';
    $this->load->view('Emploi_Add_View',$data);
   }
   else{

    $datas=array('DESCRIPTION'=>$DESCRIPTION);


    $this->Model->insert_last_id('masque_emploi',$datas);
  
    $message = "<div class='alert alert-success' id='message'>
                            Emploi enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Emploi/listing'));    

   }
   

  }

     public function listing()
    {

      $resultat=$this->Model->getRequete('SELECT *  FROM masque_emploi');
      //WHERE reservation_chambre.STATUT_RESERV_ID=1
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {
          if ($key['STATUS'] == 1) {
            $stat = 'Actif';
            $fx = 'desactiver';
            $col = 'btn-danger';
            $titr = 'Désactiver';
            $stitr = 'voulez-vous désactiver l\'emploi ';
            $bigtitr = 'Désactivation de l\'emploi';
          }
          else{
            $stat = 'Innactif';
            $fx = 'reactiver';
            $col = 'btn-success';
            $titr = 'Réactiver';
            $stitr = 'voulez-vous réactiver l\'emploi ';
            $bigtitr = 'Réactivation de l\'emploi';
          }
          $chambr=array();
          $chambr[]=$key['DESCRIPTION'];  
          $chambr[]=$stat;
          $chambr[]='<div class="modal fade" id="desactcat'.$key['ID_EMPLOI'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key['DESCRIPTION'].')?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="'.base_url('saisie/Agence/'.$fx.'/'.$key['ID_EMPLOI']).'" class="btn '.$col.'">'.$titr.'</a>
      </div>
    </div>
  </div>
</div>

          <div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="'.base_url('saisie/Emploi/index_update/'.$key['ID_EMPLOI']).'"> Modifier </a> </li>
                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_EMPLOI'].'"> '.$titr.' </a> </li>
                    </ul>
                  </div>';
         
                          
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Nom','Status','Option'));
        $data['title'] = " Emploi";
        $data['chamb']=$tabledata;
        $data['stitle']=' Emploi';
        $this->load->view('Emploi_List_View',$data);

    }

    public function index_update($id)
    {
      $data['title']=' Emploi';
      $data['stitle']=' Emploi';
      $data['selected'] = $this->Model->getOne('masque_emploi',array('ID_EMPLOI'=>$id));
      $this->load->view('Emploi_Update_View',$data);
    }


     public function update()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $ID_EMPLOI=$this->input->post('ID_EMPLOI');

   $this->form_validation->set_rules('DESCRIPTION', 'Nom', 'required');

   if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
                            Emploi non modifi&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      $data['title']=' Emploi';
      $data['stitle']=' Emploi';
      $data['selected'] = $this->Model->getOne('masque_emploi',array('ID_EMPLOI'=>$ID_EMPLOI));
      $this->load->view('Emploi_Update_View',$data);
   }
   else{

    $datas=array('DESCRIPTION'=>$DESCRIPTION);


    $this->Model->update('masque_emploi',array('ID_EMPLOI'=>$ID_EMPLOI),$datas);
  
    $message = "<div class='alert alert-success' id='message'>
                            Emploi modifi&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Emploi/listing'));   

  }
}

  public function desactiver($id)
    {
      $this->Model->update('masque_emploi',array('ID_EMPLOI'=>$id),array('STATUS'=>0));
      $message = "<div class='alert alert-success' id='message'>
                            Emploi désactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Emploi/listing')); 
    }

  public function reactiver($id)
    {
      $this->Model->update('masque_emploi',array('ID_EMPLOI'=>$id),array('STATUS'=>1));
      $message = "<div class='alert alert-success' id='message'>
                            Emploi Réactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('saisie/Emploi/listing')); 
    }

   



}
?>