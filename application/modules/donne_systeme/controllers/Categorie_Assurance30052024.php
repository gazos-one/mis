<?php
class Categorie_Assurance  extends CI_Controller{
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

      $resultat=$this->Model->getRequete('SELECT ID_CATEGORIE_ASSURANCE, syst_categorie_assurance.STATUS, IF(syst_categorie_assurance.STATUS=1, "Actif", "Innactif") AS NSTATUS, syst_categorie_assurance.DESCRIPTION AS ADESC, DROIT_AFFILIATION, COTISATION_MENSUELLE, PLAFOND_COUVERTURE_HOSP_JOURS, syst_regime_assurance.DESCRIPTION AS RASSU FROM syst_categorie_assurance JOIN syst_regime_assurance ON syst_regime_assurance.ID_REGIME_ASSURANCE = syst_categorie_assurance.ID_REGIME_ASSURANCE');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          if ($key['STATUS'] == 1) {
            $stat = 'Actif';
            $fx = 'desactiver';
            $col = 'btn-danger';
            $titr = 'Désactiver';
            $stitr = 'voulez-vous désactiver la categorie d\'assurance ';
            $bigtitr = 'Désactivation de la categorie';
          }
          else{
            $stat = 'Innactif';
            $fx = 'reactiver';
            $col = 'btn-success';
            $titr = 'Réactiver';
            $stitr = 'voulez-vous réactiver la categorie d\'assurance  ';
            $bigtitr = 'Réactivation de la categorie';
          }

          $tablemedic=$this->Model->getRequete('SELECT syst_couverture_medicament.DESCRIPTION, syst_categorie_assurance_medicament.POURCENTAGE FROM `syst_categorie_assurance_medicament` JOIN syst_couverture_medicament ON syst_couverture_medicament.ID_COUVERTURE_MEDICAMENT = syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT WHERE syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE = '.$key['ID_CATEGORIE_ASSURANCE'].'');
          $tablestruc=$this->Model->getRequete('SELECT * FROM syst_categorie_assurance_type_structure JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE WHERE syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = '.$key['ID_CATEGORIE_ASSURANCE'].'');
          $nbmembre=$this->Model->getRequeteOne('SELECT COUNT(*) AS nb FROM membre_assurances WHERE membre_assurances.ID_CATEGORIE_ASSURANCE = '.$key['ID_CATEGORIE_ASSURANCE'].' AND membre_assurances.STATUS = 1');

          $tabmed = '<table class="table">';
          foreach ($tablemedic as $keymed) {
            $tabmed .= '<tr><td>'.$keymed['DESCRIPTION'].'</td><td>'.$keymed['POURCENTAGE'].'%</td></tr>';
          }
          $tabmed .= '</table>';

          $tabstru = '<table class="table">';
          foreach ($tablestruc as $tablest) {
            $tabstru .= '<tr><td>'.$tablest['DESCRIPTION'].'</td><td>'.$tablest['POURCENTAGE'].'%</td></tr>';
          }
          $tabstru .= '</table>';


          $colabo=array();
          $colabo[]=$key['RASSU'];
          $colabo[]=$key['ADESC'];
          $colabo[]='<div class="text-right">'.number_format($key['DROIT_AFFILIATION'],0,","," ").'</div>';
          $colabo[]='<div class="text-right">'.number_format($key['COTISATION_MENSUELLE'],0,","," ").'</div>';
          $colabo[]='<div class="text-right">'.number_format($key['PLAFOND_COUVERTURE_HOSP_JOURS'],0,","," ").'/Jours</div>';
          $colabo[]='<div class="text-right">'.number_format($nbmembre['nb'],0,","," ").'</div>';
          $colabo[]=$key['NSTATUS'];
          
          $colabo[]='<div class="modal fade" id="desactcat'.$key['ID_CATEGORIE_ASSURANCE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">D&eacute;tails pour '.$key['ADESC'].'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
      <div class="col-md-6">
      <h5 class="text-center">T. de couverture dans les Structures de soins</h5>
      '.$tabstru.'
      </div>
      <div class="col-md-6">
      <h5 class="text-center">T. de couverture des médicaments</h5>
      '.$tabmed.'
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="activa'.$key['ID_CATEGORIE_ASSURANCE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key['ADESC'].')?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="'.base_url('donne_systeme/Categorie_Assurance/'.$fx.'/'.$key['ID_CATEGORIE_ASSURANCE']).'" class="btn '.$col.'">'.$titr.'</a>
      </div>
    </div>
  </div>
</div>

<div class="dropdown">
                                       <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                                       <span class="caret"></span></a>
                                       <ul class="dropdown-menu dropdown-menu-right">
                                       <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_CATEGORIE_ASSURANCE'].'"> D&eacute;tails </a></li>
                                       <li><a class="dropdown-item" href="'.base_url("donne_systeme/Categorie_Assurance/index_update/".$key['ID_CATEGORIE_ASSURANCE']).'"> Modifier </a> </li>
                                       <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#activa'.$key['ID_CATEGORIE_ASSURANCE'].'"> '.$titr.' </a> </li>
                                       
                                       </ul>
                                     </div>
                                     ';

       $tabledata[]=$colabo;
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Regime Assurance','Intitulé','Droit d\'affiliation','Cotisation mensuelle','Plafond hosp.','Nb Membres','Status','D&eacute;tails'));
        $data['title'] = " Categorie d'assurance";
        $data['stitle'] = " Categorie d'assurance";
        $data['employe']=$tabledata;

        // print_r($data);
        // exit();
        $this->load->view('Categorie_Assurance_List_View',$data);

    }


    public function index_add()
    {

      $data['title'] = " Categorie d'assurance";
      $data['stitle'] = " Categorie d'assurance";
      $data['regime']=$this->Model->getRequete('SELECT * FROM `syst_regime_assurance` order by DESCRIPTION');
      $this->load->view('Categorie_Assurance_Add_View',$data);

    }


    
    public function add()
    {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $DROIT_AFFILIATION=$this->input->post('DROIT_AFFILIATION');
  $COTISATION_MENSUELLE=$this->input->post('COTISATION_MENSUELLE');
  $PLAFOND_COUVERTURE_HOSP_JOURS=$this->input->post('PLAFOND_COUVERTURE_HOSP_JOURS');
  $ID_REGIME_ASSURANCE=$this->input->post('ID_REGIME_ASSURANCE');
  $MED_GEN=$this->input->post('MED_GEN');
  $MED_SEP=$this->input->post('MED_SEP');
  $STRUCT_A=$this->input->post('STRUCT_A');
  $STRUCT_B=$this->input->post('STRUCT_B');
  $STRUCT_C=$this->input->post('STRUCT_C');

  
  $this->form_validation->set_rules('DESCRIPTION', 'Nom', 'required|is_unique[syst_categorie_assurance.DESCRIPTION]');
  $this->form_validation->set_rules('DROIT_AFFILIATION', 'Droit affiliation', 'required');
  $this->form_validation->set_rules('COTISATION_MENSUELLE', 'Cotisation Mensuele', 'required');
  $this->form_validation->set_rules('PLAFOND_COUVERTURE_HOSP_JOURS', 'Plafonf couverture', 'required');
  $this->form_validation->set_rules('ID_REGIME_ASSURANCE', 'Regime assurance', 'required');
  $this->form_validation->set_rules('MED_GEN', 'Medicament Generique', 'required');
  $this->form_validation->set_rules('MED_SEP', 'Medicament Specialise', 'required');
  $this->form_validation->set_rules('STRUCT_A', 'Structure A', 'required');
  $this->form_validation->set_rules('STRUCT_B', 'Structure B', 'required');
  $this->form_validation->set_rules('STRUCT_C', 'Structure C', 'required');

   if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger'>
                            Categorie Assurance non enregistr&eacute; de cong&eacute; non enregistr&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $data['title'] = " Categorie d'assurance";
    $data['stitle'] = " Categorie d'assurance";
    $data['regime']=$this->Model->getRequete('SELECT * FROM `syst_regime_assurance` order by DESCRIPTION');
    $this->load->view('Categorie_Assurance_Add_View',$data);
   }
   else{

    $datacatass=array(
                       'DESCRIPTION'=>$DESCRIPTION,
                       'DROIT_AFFILIATION'=>$DROIT_AFFILIATION,
                       'COTISATION_MENSUELLE'=>$COTISATION_MENSUELLE,
                       'PLAFOND_COUVERTURE_HOSP_JOURS'=>$PLAFOND_COUVERTURE_HOSP_JOURS,
                       'ID_REGIME_ASSURANCE'=>$ID_REGIME_ASSURANCE,
                      );

                      
                      
    $ID_CATEGORIE_ASSURANCE = $this->Model->insert_last_id('syst_categorie_assurance',$datacatass);

    $couvmedpourgeneric=array(
      'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
      'ID_COUVERTURE_MEDICAMENT'=>1,
      'POURCENTAGE'=>$MED_GEN,
     );
     $this->Model->insert_last_id('syst_categorie_assurance_medicament',$couvmedpourgeneric);

     $couvmedpourspecia=array(
      'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
      'ID_COUVERTURE_MEDICAMENT'=>2,
      'POURCENTAGE'=>$MED_SEP,
     );
     $this->Model->insert_last_id('syst_categorie_assurance_medicament',$couvmedpourspecia);


     $couvmedpourstruun=array(
      'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
      'ID_TYPE_STRUCTURE'=>1,
      'POURCENTAGE'=>$STRUCT_A,
     );
     $this->Model->insert_last_id('syst_categorie_assurance_type_structure',$couvmedpourstruun);

     $couvmedpourstrudeux=array(
      'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
      'ID_TYPE_STRUCTURE'=>2,
      'POURCENTAGE'=>$STRUCT_B,
     );
     $this->Model->insert_last_id('syst_categorie_assurance_type_structure',$couvmedpourstrudeux);

     $couvmedpourstrutroi=array(
      'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
      'ID_TYPE_STRUCTURE'=>3,
      'POURCENTAGE'=>$STRUCT_C,
     );
     $this->Model->insert_last_id('syst_categorie_assurance_type_structure',$couvmedpourstrutroi);


    $message = "<div class='alert alert-success' id='message'>
                            Categorie enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('donne_systeme/Categorie_Assurance'));  
   }

    }



    
    public function index_update($id)
    {

      $data['title'] = " Categorie d'assurance";
      $data['stitle'] = " Categorie d'assurance";
      $data['data']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance` WHERE ID_CATEGORIE_ASSURANCE = '.$id.'');
      $data['regime']=$this->Model->getRequete('SELECT * FROM `syst_regime_assurance` order by DESCRIPTION');
      $data['struca']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_type_structure`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_TYPE_STRUCTURE = 1');
      $data['strucb']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_type_structure`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_TYPE_STRUCTURE = 2');
      $data['strucc']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_type_structure`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_TYPE_STRUCTURE = 3');
      $data['med1']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_medicament`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_COUVERTURE_MEDICAMENT = 1');
      $data['med2']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_medicament`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_COUVERTURE_MEDICAMENT = 2');
      $this->load->view('Categorie_Assurance_Update_View',$data);

    }


    public function update()
    {

  $ID_CATEGORIE_ASSURANCE=$this->input->post('ID_CATEGORIE_ASSURANCE');
  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $DROIT_AFFILIATION=$this->input->post('DROIT_AFFILIATION');
  $COTISATION_MENSUELLE=$this->input->post('COTISATION_MENSUELLE');
  $PLAFOND_COUVERTURE_HOSP_JOURS=$this->input->post('PLAFOND_COUVERTURE_HOSP_JOURS');
  $ID_REGIME_ASSURANCE=$this->input->post('ID_REGIME_ASSURANCE');
  $MED_GEN=$this->input->post('MED_GEN');
  $MED_SEP=$this->input->post('MED_SEP');
  $STRUCT_A=$this->input->post('STRUCT_A');
  $STRUCT_B=$this->input->post('STRUCT_B');
  $STRUCT_C=$this->input->post('STRUCT_C');

  
  $this->form_validation->set_rules('DESCRIPTION', 'Nom', 'required');
  $this->form_validation->set_rules('DROIT_AFFILIATION', 'Droit affiliation', 'required');
  $this->form_validation->set_rules('COTISATION_MENSUELLE', 'Cotisation Mensuele', 'required');
  $this->form_validation->set_rules('PLAFOND_COUVERTURE_HOSP_JOURS', 'Plafonf couverture', 'required');
  $this->form_validation->set_rules('ID_REGIME_ASSURANCE', 'Regime assurance', 'required');
  $this->form_validation->set_rules('MED_GEN', 'Medicament Generique', 'required');
  $this->form_validation->set_rules('MED_SEP', 'Medicament Specialise', 'required');
  $this->form_validation->set_rules('STRUCT_A', 'Structure A', 'required');
  $this->form_validation->set_rules('STRUCT_B', 'Structure B', 'required');
  $this->form_validation->set_rules('STRUCT_C', 'Structure C', 'required');

   if ($this->form_validation->run() == FALSE){
      $id=$ID_CATEGORIE_ASSURANCE;
      $data['title'] = " Categorie d'assurance";
      $data['stitle'] = " Categorie d'assurance";
      $data['data']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance` WHERE ID_CATEGORIE_ASSURANCE = '.$id.'');
      $data['regime']=$this->Model->getRequete('SELECT * FROM `syst_regime_assurance` order by DESCRIPTION');
      $data['struca']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_type_structure`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_TYPE_STRUCTURE = 1');
      $data['strucb']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_type_structure`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_TYPE_STRUCTURE = 2');
      $data['strucc']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_type_structure`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_TYPE_STRUCTURE = 3');
      $data['med1']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_medicament`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_COUVERTURE_MEDICAMENT = 1');
      $data['med2']=$this->Model->getRequeteOne('SELECT * FROM `syst_categorie_assurance_medicament`  WHERE ID_CATEGORIE_ASSURANCE = '.$id.' AND ID_COUVERTURE_MEDICAMENT = 2');
      $this->load->view('Categorie_Assurance_Update_View',$data);
   }
   else{

    $datacatass=array(
                       'DESCRIPTION'=>$DESCRIPTION,
                       'DROIT_AFFILIATION'=>$DROIT_AFFILIATION,
                       'COTISATION_MENSUELLE'=>$COTISATION_MENSUELLE,
                       'PLAFOND_COUVERTURE_HOSP_JOURS'=>$PLAFOND_COUVERTURE_HOSP_JOURS,
                       'ID_REGIME_ASSURANCE'=>$ID_REGIME_ASSURANCE,
                      );

                    
    $this->Model->update('syst_categorie_assurance',array('ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE),$datacatass);  

    $couvmedpourgeneric=array('POURCENTAGE'=>$MED_GEN);
     $this->Model->update('syst_categorie_assurance_medicament',array('ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,'ID_COUVERTURE_MEDICAMENT'=>1,),$couvmedpourgeneric);  

     $couvmedpourspecia=array('POURCENTAGE'=>$MED_SEP);
     $this->Model->update('syst_categorie_assurance_medicament',array('ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,'ID_COUVERTURE_MEDICAMENT'=>2,),$couvmedpourspecia);  


     $couvmedpourstruun=array('POURCENTAGE'=>$STRUCT_A);
     $this->Model->update('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,'ID_TYPE_STRUCTURE'=>1,),$couvmedpourstruun); 

     $couvmedpourstrudeux=array('POURCENTAGE'=>$STRUCT_B);
     $this->Model->update('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,'ID_TYPE_STRUCTURE'=>2,),$couvmedpourstrudeux); 

     $couvmedpourstrutroi=array('POURCENTAGE'=>$STRUCT_C);
     $this->Model->update('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,'ID_TYPE_STRUCTURE'=>3,),$couvmedpourstrutroi);


    $message = "<div class='alert alert-success' id='message'>
                            Categorie enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('donne_systeme/Categorie_Assurance'));  
   }

    }
    

    public function desactiver($id)
    {
      $this->Model->update('syst_categorie_assurance',array('ID_CATEGORIE_ASSURANCE'=>$id),array('STATUS'=>0));
      $message = "<div class='alert alert-success' id='message'>
                            Catégorie désactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('donne_systeme/Categorie_Assurance')); 
    }

  public function reactiver($id)
    {
      $this->Model->update('syst_categorie_assurance',array('ID_CATEGORIE_ASSURANCE'=>$id),array('STATUS'=>1));
      $message = "<div class='alert alert-success' id='message'>
                            Catégorie Réactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('donne_systeme/Categorie_Assurance')); 
    }


}