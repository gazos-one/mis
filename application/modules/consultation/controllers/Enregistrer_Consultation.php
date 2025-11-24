<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Enregistrer_Consultation extends CI_Controller {

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
      $data['title']='Enregistrement Consultation';
      $data['stitle']='Enregistrement Consultation';
      $data['periode'] = $this->Model->getListOrdertwo('syst_couverture_structure',array(),'DESCRIPTION'); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['affilie']= $this->Model->getList("membre_membre",array('IS_AFFILIE'=>0));
      $data['groupe']= $this->Model->getList("membre_groupe");
      $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
      $data['coptique'] = $this->Model->getListOrdertwo('consultation_centre_optique',array(),'DESCRIPTION');

      $this->load->view('Enregistrer_Consultation_Add_View',$data);
    }

    public function getstructure()
    {
    $commune= $this->Model->getList("masque_stucture_sanitaire",array('ID_TYPE_STRUCTURE'=>$this->input->post('ID_TYPE_STRUCTURE')));
    $datas= '<option value="">-- Sélectionner --</option>';
    foreach($commune as $commun){
    $datas.= '<option value="'.$commun["ID_STRUCTURE"].'">'.$commun["DESCRIPTION"].'</option>';
    }
    $datas.= '';
    echo $datas;
    }

    public function getaffilie_by_group()
    {
    $commune= $this->Model->getRequete("SELECT membre_membre.ID_MEMBRE,membre_membre.NOM,membre_membre.PRENOM,membre_membre.CODE_AFILIATION FROM membre_membre join membre_groupe_membre on membre_membre.ID_MEMBRE=membre_groupe_membre.ID_MEMBRE where membre_groupe_membre.ID_GROUPE=".$this->input->post('ID_GROUPE')."");
    
    $datas= '<option value="">-- Sélectionner --</option>';
   
    foreach($commune as $commun){
    $datas.= '<option value="'.$commun["ID_MEMBRE"].'">'.$commun["NOM"].' '.$commun["PRENOM"].' ('.$commun["CODE_AFILIATION"].')</option>';
    }
    $datas.= '';
    echo $datas;
    }

    
    public function getaffilie()
    {
    $commune= $this->Model->getList("membre_membre",array('CODE_PARENT'=>$this->input->post('TYPE_AFFILIE')));
    $affi= $this->Model->getOne("membre_membre",array('ID_MEMBRE'=>$this->input->post('TYPE_AFFILIE')));
    $datas= '<option value="">-- Sélectionner --</option>';
    $datas.= '<option value="'.$this->input->post('TYPE_AFFILIE').'">Lui meme ('.$affi["NOM"].' '.$affi["PRENOM"].')</option>';
    foreach($commune as $commun){
    $datas.= '<option value="'.$commun["ID_MEMBRE"].'">'.$commun["NOM"].' '.$commun["PRENOM"].'  ('.$commun["CODE_AFILIATION"].')</option>';
    }
    $datas.= '';
    echo $datas;
    }

    public function getpourcentage()
    {
    $commune= $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.POURCENTAGE FROM membre_carte_membre JOIN membre_carte ON membre_carte.ID_CARTE = membre_carte_membre.ID_CARTE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE 1 AND membre_carte_membre.ID_MEMBRE = ".$this->input->post('ID_MEMBRE')." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = ".$this->input->post('ID_TYPE_STRUCTURE')." ORDER BY membre_carte.ID_CARTE DESC LIMIT 1");

    if (!empty($commune['POURCENTAGE'])) {
      echo $commune['POURCENTAGE'];
    }
    else{
      $parrent= $this->Model->getRequeteOne("SELECT CODE_PARENT FROM membre_membre WHERE ID_MEMBRE = ".$this->input->post('ID_MEMBRE')." LIMIT 1");

      $nparrent= $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.POURCENTAGE FROM membre_carte_membre JOIN membre_carte ON membre_carte.ID_CARTE = membre_carte_membre.ID_CARTE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE 1 AND membre_carte_membre.ID_MEMBRE = ".$parrent['CODE_PARENT']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = ".$this->input->post('ID_TYPE_STRUCTURE')." LIMIT 1");
      echo $nparrent['POURCENTAGE'];

    }

    
    // print_r($datas);
    }

// public function addCategorie()
//   {

//   $DESCRIPTION=$this->input->post('DESCRIPTION');
//   $datas=array('DESCRIPTION'=>$DESCRIPTION);
//   $ID_EMPLOI = $this->Model->insert_last_id('cotisation_categorie',$datas);

//   echo '<option value="'.$ID_EMPLOI.'">'.$this->input->post('DESCRIPTION').'</option>';

//   }



// public function addPeriode()
//   {

//   $DESCRIPTION=$this->input->post('DESCRIPTION');
//   $NB_JOURS=$this->input->post('NB_JOURS');
//   $datas=array('DESCRIPTION'=>$DESCRIPTION,'NB_JOURS'=>$NB_JOURS);
//   $ID_PERIODE_COTISATION = $this->Model->insert_last_id('cotisation_periode',$datas);

//   echo '<option value="'.$ID_PERIODE_COTISATION.'">'.$this->input->post('DESCRIPTION').'</option>';

//   }


  public function add()
  {


  // $this->form_validation->set_rules('ID_TYPE_STRUCTURE', 'Type de Structure', 'required');
  $this->form_validation->set_rules('ID_GROUPE', 'Groupe', 'required');
  $this->form_validation->set_rules('TYPE_AFFILIE', 'Type Affilie', 'required');
  $this->form_validation->set_rules('ID_MEMBRE', 'Membre', 'required');
  $this->form_validation->set_rules('DATE_CONSULTATION', 'Date', 'required');
  $this->form_validation->set_rules('NUM_BORDERAUX', 'Borderaux', 'required');
  $this->form_validation->set_rules('MONTANT_CONSULTATION', 'Montant Consultation', 'required');
  $this->form_validation->set_rules('POURCENTAGE_C', 'Pourcentage ', 'required');
  $this->form_validation->set_rules('POURCENTAGE_A', 'Pourcentage', 'required');
  $this->form_validation->set_rules('MONTANT_A_PAYER', 'Montant A payer', 'required');
  $this->form_validation->set_rules('MEDECIN', 'Medecin', 'required');

  if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger'>
                            Consultation non enregistr&eacute;e
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $data['title']='Enregistrement Consultation';
      $data['stitle']='Enregistrement Consultation';
      $data['periode'] = $this->Model->getListOrdertwo('syst_couverture_structure',array(),'DESCRIPTION'); 
      $data['affilie']= $this->Model->getList("membre_membre",array('IS_AFFILIE'=>0));
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
      $data['coptique'] = $this->Model->getListOrdertwo('consultation_centre_optique',array(),'DESCRIPTION'); 
      $data['groupe']= $this->Model->getList("membre_groupe");

      $this->load->view('Enregistrer_Consultation_Add_View',$data);
   }
   else{
    if ($this->input->post('ID_CONSULTATION_TYPE') == 3) {
      $STRUC = $this->input->post('ID_CENTRE_OPTIQUE');
    }
    else{
      $STRUC = $this->input->post('ID_STRUCTURE');
    }
    $this->Model->insert_last_id('consultation_consultation',
  array('ID_TYPE_STRUCTURE'=>$this->input->post('ID_TYPE_STRUCTURE'),
        'ID_STRUCTURE'=>$STRUC,
        'TYPE_AFFILIE'=>$this->input->post('TYPE_AFFILIE'),
        'ID_MEMBRE'=>$this->input->post('ID_MEMBRE'),
        'DATE_CONSULTATION'=>$this->input->post('DATE_CONSULTATION'),
        'NUM_BORDERAUX'=>$this->input->post('NUM_BORDERAUX'),
        'MONTANT_CONSULTATION'=>$this->input->post('MONTANT_CONSULTATION'),
        'POURCENTAGE_C'=>$this->input->post('POURCENTAGE_C'),
        'POURCENTAGE_A'=>$this->input->post('POURCENTAGE_A'),
        'MONTANT_A_PAYER'=>$this->input->post('MONTANT_A_PAYER'),
        'MEDECIN'=>$this->input->post('MEDECIN'),
        'EXAMEN'=>$this->input->post('EXAMEN'),        
        'ID_CONSULTATION_TYPE'=>$this->input->post('ID_CONSULTATION_TYPE'),        
        )
      );

  
  

  $message = "<div class='alert alert-success' id='message'>
                            Consultation enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('consultation/Enregistrer_Consultation'));  

   }
    

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

  public function addStructure()
  {

  $ID_TYPE_STRUCTURE=$this->input->post('ID_TYPE_STRUCTURE_NEW');
  $NOMSTRUCTURE=$this->input->post('NOMSTRUCTURE');
  $PROVINCE_ID=$this->input->post('PROVINCE_ID');
  $COMMUNE_ID=$this->input->post('COMMUNE_ID');
 
  $datas=array('ID_TYPE_STRUCTURE'=>$ID_TYPE_STRUCTURE,'DESCRIPTION'=>$NOMSTRUCTURE,'PROVINCE_ID'=>$PROVINCE_ID,'COMMUNE_ID'=>$COMMUNE_ID);
  $ID_STRUCTURE = $this->Model->insert_last_id('masque_stucture_sanitaire',$datas);

  echo '<option value="'.$ID_STRUCTURE.'">'.$this->input->post('NOMSTRUCTURE').'</option>';

  }


  
  public function addCentreOp()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $PROVINCE_ID=$this->input->post('PROVINCE_IDCO');
  $COMMUNE_ID=$this->input->post('COMMUNE_IDCO');
 
  $datas=array('DESCRIPTION'=>$DESCRIPTION,'PROVINCE_ID'=>$PROVINCE_ID,'COMMUNE_ID'=>$COMMUNE_ID);
  $ID_STRUCTURE = $this->Model->insert_last_id('consultation_centre_optique',$datas);

  echo '<option value="'.$ID_STRUCTURE.'">'.$this->input->post('DESCRIPTION').'</option>';

  }

//   public function listing()
//   {
    

//       $resultat=$this->Model->getRequete('SELECT cotisation_montant_cotisation.ID_MONTANT_COTISATION, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_categorie.DESCRIPTION AS DESC_CATEGORIE, cotisation_periode.DESCRIPTION AS DESC_PERIODE, cotisation_periode.NB_JOURS, cotisation_montant_cotisation.IS_ACTIF, IF(cotisation_montant_cotisation.IS_ACTIF=1, "Actif", "Innactif") AS STATUS_COTISATION FROM cotisation_montant_cotisation JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE 1');
//       // $resultatlast=$this->Model->getRequeteOne('SELECT ID_MEMBRE FROM `membre_membre` WHERE IS_AFFILIE = 0 order by ID_MEMBRE DESC limit 1');
//       //WHERE reservation_chambre.STATUT_RESERV_ID=1
//       $tabledata=array();
      
//       foreach ($resultat as $key) 
//          {

//           if ($key['IS_ACTIF'] == 1) {
//             // $stat = 'Actif';
//             $fx = 'desactiver';
//             $col = 'btn-danger';
//             $titr = 'Désactiver';
//             $stitr = 'voulez-vous désactiver la cotisation ';
//             $bigtitr = 'Désactivation de la cotisation';
//           }
//           else{
//             // $stat = 'Innactif';
//             $fx = 'reactiver';
//             $col = 'btn-success';
//             $titr = 'Réactiver';
//             $stitr = 'voulez-vous réactiver la cotisation ';
//             $bigtitr = 'Réactivation de la cotisation';
//           }

         

//           $chambr=array();
//           $chambr[]=$key['DESC_CATEGORIE'];
//           $chambr[]=$key['DESC_PERIODE'].'('.$key['NB_JOURS'].')';
//           $chambr[]=$key['MONTANT_COTISATION'];  
//           // $chambr[]=$newDate;  
//           // $chambr[]=$nban['NB_AYANT'];  
//           $chambr[]=$key['STATUS_COTISATION'];
//           // if ($resultatlast['ID_MEMBRE'] == $key['ID_MEMBRE']) {
//             // $todel = '<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#supprimermembre'.$key['ID_MEMBRE'].'"> Supprimer la personne </a> </li>';
//           // }
//           // else{
//           //   $todel = '';
//           // }
//           $chambr[]='
//  <div class="modal fade" id="desactcat'.$key['ID_MONTANT_COTISATION'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
//    <div class="modal-dialog modal-sm">
//      <div class="modal-content">
//        <div class="modal-header">
//          <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
//          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
//            <span aria-hidden="true">&times;</span>
//          </button>
//        </div>
//        <div class="modal-body">
//          <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key['DESC_CATEGORIE'].' - '.$key['DESC_PERIODE'].' - '.$key['NB_JOURS'].' - '.$key['MONTANT_COTISATION'].')?</h6>
//        </div>
//        <div class="modal-footer">
//          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
//          <a href="'.base_url('cotisation/Enregistrer_Consultation/'.$fx.'/'.$key['ID_MONTANT_COTISATION']).'" class="btn '.$col.'">'.$titr.'</a>
//        </div>
//      </div>
//    </div>
//  </div>

//            <div class="dropdown ">
//                      <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
//                      <span class="caret"></span></a>
//                      <ul class="dropdown-menu dropdown-menu-right">
//                      <li><a class="dropdown-item" href="'.base_url('cotisation/Enregistrer_Consultation/details/'.$key['ID_MONTANT_COTISATION']).'"> Détail </a> </li>
//                      <li><a class="dropdown-item" href="'.base_url('cotisation/Enregistrer_Consultation/index_update/'.$key['ID_MONTANT_COTISATION']).'"> Modifier</a> </li>
//                      <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_MONTANT_COTISATION'].'"> '.$titr.' </a> </li>
//                      </ul>
//                    </div>';
         
//                           // <li><a class="dropdown-item" href="'.base_url('membre/Membre/index_update/'.$key['ID_MEMBRE']).'"> Ajouter/Enlever Groupe </a> </li>
//        $tabledata[]=$chambr;
     
//      }

//         $template = array(
//             'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
//             'table_close' => '</table>'
//         );
//         $this->table->set_template($template);
//         $this->table->set_heading(array('Nom','Periode (Nb Jours)','Montant','Status','Option'));
       
//         $data['chamb']=$tabledata;
//         $data['title']=' Configuration';
//         $data['stitle']=' Configuration';
//         $this->load->view('Enregistrer_Consultation_List_View',$data);
//   }

  public function details()
  {
    echo "In dev";
  }

  public function index_update($id)
  {
      // echo "In dev";
      $data['title']='Configuration Cotisation';
      $data['stitle']='Configuration Cotisation';
      $data['cotisation'] = $this->Model->getRequeteOne('SELECT * FROM `cotisation_montant_cotisation` WHERE ID_MONTANT_COTISATION = '.$id.''); 
      $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 
      $data['categorie'] = $this->Model->getListOrdertwo('cotisation_categorie',array(),'DESCRIPTION'); 

      
      
      // $todaydate = strtotime(date('Y-m-d'));
      // $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      // $realdate = date('d/m/Y', $realdate);
      // $data['datemin'] = $realdate;
      $this->load->view('Enregistrer_Consultation_Update_View',$data);
  }

  
  public function update()
  {
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $ID_PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  $ID_MONTANT_COTISATION=$this->input->post('ID_MONTANT_COTISATION');

  $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$ID_MONTANT_COTISATION), array('MONTANT_COTISATION'=>$MONTANT_COTISATION, 'ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_PERIODE_COTISATION'=>$ID_PERIODE_COTISATION));

  $message = "<div class='alert alert-success' id='message'>
                            Cotisation modifi&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Enregistrer_Consultation/listing'));    

  }


   public function desactiver($id)
    {
      $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$id),array('IS_ACTIF'=>0));
      $message = "<div class='alert alert-success' id='message'>
                            Cotisation désactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Enregistrer_Consultation/listing'));
    }

  public function reactiver($id)
    {
      $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$id),array('IS_ACTIF'=>1));
      $message = "<div class='alert alert-success' id='message'>
                            Cotisation Réactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('consultation/Enregistrer_Consultation/listing')); 
    }
  

}
?>