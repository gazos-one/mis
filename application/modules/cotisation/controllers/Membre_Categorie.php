<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Membre_Categorie extends CI_Controller {

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


//     public function index()
//     {
//       $data['title']='Membre par categorie';
//       $data['stitle']='Membre par categorie';
//       $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 
//       $data['categorie'] = $this->Model->getListOrdertwo('cotisation_categorie_membre',array(),'DESCRIPTION'); 

      
      
//       // $todaydate = strtotime(date('Y-m-d'));
//       // $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
//       // $realdate = date('d/m/Y', $realdate);
//       // $data['datemin'] = $realdate;
//       $this->load->view('Configuration_Cotisation_Add_View',$data);
//     }

// public function addCategorie()
//   {

//   $DESCRIPTION=$this->input->post('DESCRIPTION');
//   $datas=array('DESCRIPTION'=>$DESCRIPTION);
//   $ID_EMPLOI = $this->Model->insert_last_id('cotisation_categorie_membre',$datas);

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


//   public function add()
//   {
//   $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
//   $ID_CATEGORIE_COTISATION_MEMBRE=$this->input->post('ID_CATEGORIE_COTISATION_MEMBRE');
//   $ID_PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');

//   $this->Model->insert_last_id('cotisation_montant_cotisation',array('MONTANT_COTISATION'=>$MONTANT_COTISATION, 'ID_CATEGORIE_COTISATION_MEMBRE'=>$ID_CATEGORIE_COTISATION_MEMBRE, 'ID_PERIODE_COTISATION'=>$ID_PERIODE_COTISATION));

//   $message = "<div class='alert alert-success' id='message'>
//                             Cotisation enregistr&eacute; avec succés
//                             <button type='button' class='close' data-dismiss='alert'>&times;</button>
//                       </div>";
//     $this->session->set_flashdata(array('message'=>$message));
//       redirect(base_url('cotisation/Configuration_Cotisation/listing'));    

//   }

  public function index()
  {
    $data['anne_aff']=$this->Model->getRequete("SELECT DISTINCT YEAR(membre_membre.DATE_ADHESION) AS DATE_ADHESION FROM `membre_membre`");
    $data['groupe'] = $this->Model->getList('membre_groupe'); 


    $DATE_ADHESION = $this->input->post('DATE_ADHESION');
    if ($DATE_ADHESION != null) {
        $condi1 = ' AND membre_membre.DATE_ADHESION like "%'.$DATE_ADHESION.'%" ';
        $data['DATE_ADHESION'] = $this->input->post('DATE_ADHESION');
    }
    else{
        $condi1 = '';
        $data['DATE_ADHESION'] = NULL;
    }
    
    $ID_GROUPE = $this->input->post('ID_GROUPE');
    if ($ID_GROUPE != null) {
        $condi2 = ' AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' ';
        $data['ID_GROUPE'] = $this->input->post('ID_GROUPE');
    }
    else{
        $condi2 = '';
        $data['ID_GROUPE'] = NULL;
    }


      $resultat=$this->Model->getRequete("SELECT membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, syst_sexe.DESCRIPTION, membre_membre.DATE_NAISSANCE , IF(membre_membre.IS_AFFILIE =0, 'Affilie', 'Ayant Droit') AS STATUS_MEMBRE, cotisation_categorie.DESCRIPTION AS DESCRIPTION_CATEGORIE, cotisation_categorie_membre.ID_CATEGORIE_COTISATION_MEMBRE, cotisation_categorie_membre.ID_CATEGORIE_COTISATION, cotisation_categorie_membre.DATE_DEBUT, cotisation_categorie_membre.DATE_FIN FROM membre_membre LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN syst_sexe ON syst_sexe.ID_SEXE = membre_membre.ID_SEXE LEFT JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE=membre_membre.ID_MEMBRE WHERE membre_membre.IS_AFFILIE = 0 AND cotisation_categorie_membre.ID_MEMBRE IS NULL ".$condi1." ".$condi2." ");
      $tabledata=array();

      $selections = $this->Model->getRequete("SELECT cotisation_montant_cotisation.ID_MONTANT_COTISATION, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_categorie.DESCRIPTION AS DESC_CATEGORIE, cotisation_periode.DESCRIPTION AS DESC_PERIODE, cotisation_periode.NB_JOURS, cotisation_montant_cotisation.IS_ACTIF, cotisation_categorie.ID_CATEGORIE_COTISATION FROM cotisation_montant_cotisation JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE 1");
      
      foreach ($resultat as $key) 
         {

          if ($key['ID_CATEGORIE_COTISATION'] == NULL) {
            $stat = ' ';
            $identifiant = $key['ID_MEMBRE'];
            $modal = '<div class="modal fade" id="attribuer'.$identifiant.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel">Attribution de la categorie</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
       <div class="row">
          <div class="col-md-6">Nom:</div>
          <div class="col-md-6">'.$key['NOM'].' '.$key['PRENOM'].' </div>
          <div class="col-md-6">Categorie Actuelle:</div>
          <div class="col-md-6">'.$key['DESCRIPTION_CATEGORIE'].'</div>
          <div class="col-md-6">Date de Naissance:</div>
          <div class="col-md-6">'.$key['DATE_NAISSANCE'].'</div>
          <div class="col-md-6">Sexe:</div>
          <div class="col-md-6">'.$key['DESCRIPTION'].'</div>
       </div>
       <form id="FormData" action="'.base_url().'cotisation/Membre_Categorie/add" method="POST" enctype="multipart/form-data">
       <div class="row">
       <input type="hidden" name="ID_MEMBRE" class="form-control" value="'.$key['ID_MEMBRE'].'" id="ID_MEMBRE">
          <div class="col-md-12 text-center"><h3>Nouvelle categorie du membre</h3></div>

          <div class="col-md-4">Nouvelle categorie:</div>
          <div class="col-md-8">
            <select class="form-control"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION">
                            <option value="">-- Sélectionner --</option>';
                            
                          foreach ($selections as $values) { 
                             
                              $modal.='<option value="'.$values['ID_CATEGORIE_COTISATION'].'">'.$values['DESC_CATEGORIE'].' ('.$values['MONTANT_COTISATION'].'/'.$values['DESC_PERIODE'].')</option>';
                              
                           } 
                          
           $modal.=' </select>
          </div>
       </div>
       <div class="row">
        <div class="col-md-6 text-left"><br>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </div>
        <div class="col-md-6 text-right"><br>
        <input type="submit" value="Enregistrer" class="btn btn-success"/>
        </div>

       </div>
       </form>         
       </div>
     </div>
   </div>
 </div>';
            // $fx = 'desactiver';
            // $col = 'btn-success';
            $titr = 'Attribuer';
            // $stitr = 'voulez-vous désactiver la cotisation ';
            // $bigtitr = 'Désactivation de la cotisation';
          }
          else{
            $stat = $key['DESCRIPTION_CATEGORIE'];
            $identifiant = $key['ID_MEMBRE'].'_'.$key['ID_CATEGORIE_COTISATION_MEMBRE'];;

            $modal = '<div class="modal fade" id="attribuer'.$identifiant.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel">Modification de la categorie</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
       <div class="row">
          <div class="col-md-6">Nom:</div>
          <div class="col-md-6">'.$key['NOM'].' '.$key['PRENOM'].' </div>
          <div class="col-md-6">Categorie Actuelle:</div>
          <div class="col-md-6">'.$key['DESCRIPTION_CATEGORIE'].'</div>
          <div class="col-md-6">Date de Naissance:</div>
          <div class="col-md-6">'.$key['DATE_NAISSANCE'].'</div>
          <div class="col-md-6">Sexe:</div>
          <div class="col-md-6">'.$key['DESCRIPTION'].'</div>
          <div class="col-md-6">Periode</div>
          <div class="col-md-6">'.$key['DATE_DEBUT'].' - '.$key['DATE_FIN'].'</div>
       </div>
       <form id="FormData" action="'.base_url().'cotisation/Membre_Categorie/update" method="POST" enctype="multipart/form-data">
       <div class="row">
       <input type="hidden" name="ID_MEMBRE" class="form-control" value="'.$key['ID_MEMBRE'].'" id="ID_MEMBRE">
          <div class="col-md-12 text-center"><h3>Nouvelle categorie du membre</h3></div>

          <div class="col-md-4">Nouvelle categorie:</div>
          <div class="col-md-8">
            <select class="form-control"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION">
                            <option value="">-- Sélectionner --</option>';
                            
                          foreach ($selections as $values) { 
                             if ($values['ID_CATEGORIE_COTISATION'] == $key['ID_CATEGORIE_COTISATION']) {
                               $modal.='<option value="'.$values['ID_CATEGORIE_COTISATION'].'" selected>'.$values['DESC_CATEGORIE'].' ('.$values['MONTANT_COTISATION'].'/'.$values['DESC_PERIODE'].')</option>';
                             }
                             else{
                              $modal.='<option value="'.$values['ID_CATEGORIE_COTISATION'].'">'.$values['DESC_CATEGORIE'].' ('.$values['MONTANT_COTISATION'].'/'.$values['DESC_PERIODE'].')</option>';
                             }                     
                           } 
                          
           $modal.=' </select>
          </div>
       </div>
       <div class="row">
        <div class="col-md-3 text-left"><br>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </div>
        <div class="col-md-6 text-left"><br>
        <a class="btn btn-danger" href="'.base_url('cotisation/Membre_Categorie/annuler/'.$key['ID_MEMBRE']).'"> Retirer affectation </a>
        </div>
        <div class="col-md-3 text-right"><br>
        <input type="submit" value="Enregistrer" class="btn btn-success"/>
        </div>

       </div>
       </form>         
       </div>
     </div>
   </div>
 </div>';

            $titr = 'Modifier ou Retirer';
          }         

          $chambr=array();
          $chambr[]=$key['NOM'].' '.$key['PRENOM'];
          $chambr[]=$key['DESCRIPTION'];
          $chambr[]=$key['DATE_NAISSANCE'];  
          // $chambr[]=$newDate;  
          $chambr[]=$key['STATUS_MEMBRE'];  
          $chambr[]=$stat;
          // if ($resultatlast['ID_MEMBRE'] == $key['ID_MEMBRE']) {
            // $todel = '<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#supprimermembre'.$key['ID_MEMBRE'].'"> Supprimer la personne </a> </li>';
          // }
          // else{
          //   $todel = '';
          // }
          // $chambr[]='
          $options=$modal.'<div class="dropdown ">
                     <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                     <span class="caret"></span></a>
                     <ul class="dropdown-menu dropdown-menu-right">';
                    //  if ($key['STATUS'] == 0) {
                      $options.='<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#attribuer'.$identifiant.'"> '.$titr.'  </a> </li>';  
                    // }
                    $options.=' </ul>
                   </div>';

                   $chambr[]=$options;
         
                          // <li><a class="dropdown-item" href="'.base_url('membre/Membre/index_update/'.$key['ID_MEMBRE']).'"> Ajouter/Enlever Groupe </a> </li>
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Nom','Sexe','Date Naissance','Status','Categorie','Option'));
       
        $data['chamb']=$tabledata;
        $data['title']='Membre par categorie';
        $data['stitle']='Affili&eacute; sans categorie';
        $this->load->view('Membre_Categorie_List_View',$data);
  }



  public function listing()
  {
    
    $data['anne_aff']=$this->Model->getRequete("SELECT DISTINCT YEAR(membre_membre.DATE_ADHESION) AS DATE_ADHESION FROM `membre_membre`");
    $data['groupe'] = $this->Model->getList('membre_groupe'); 
    $data['cotisation'] = $this->Model->getList('cotisation_categorie'); 

    $DATE_ADHESION = $this->input->post('DATE_ADHESION');
    if ($DATE_ADHESION != null) {
        $condi1 = ' AND membre_membre.DATE_ADHESION like "%'.$DATE_ADHESION.'%" ';
        $data['DATE_ADHESION'] = $this->input->post('DATE_ADHESION');
    }
    else{
        $condi1 = '';
        $data['DATE_ADHESION'] = NULL;
    }
    
    $ID_GROUPE = $this->input->post('ID_GROUPE');
    if ($ID_GROUPE != null) {
        $condi2 = ' AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' ';
        $data['ID_GROUPE'] = $this->input->post('ID_GROUPE');
    }
    else{
        $condi2 = '';
        $data['ID_GROUPE'] = NULL;
    }

    $AFFILIATION = $this->input->post('AFFILIATION');
    if ($AFFILIATION == NULL ) {
        $condi3 = '  ';
        $data['AFFILIATION'] = 9;
    }
    else if ($AFFILIATION == 0) {
        $condi3 = ' AND cotisation_frais_adhesion.ID_COTISATION_FRAIS_ADHESION IS NULL ';
        $data['AFFILIATION'] = 0;
    }
    else{
        $condi3 = 'AND cotisation_frais_adhesion.ID_COTISATION_FRAIS_ADHESION IS NOT NULL';
        $data['AFFILIATION'] = 1;
    }


    $ID_CATEGORIE_COTISATION = $this->input->post('ID_CATEGORIE_COTISATION');
    if ($ID_CATEGORIE_COTISATION != null) {
        $condi4 = ' AND cotisation_categorie_membre.ID_CATEGORIE_COTISATION = '.$ID_CATEGORIE_COTISATION.' ';
        $data['ID_CATEGORIE_COTISATION'] = $this->input->post('ID_CATEGORIE_COTISATION');
    }
    else{
        $condi4 = '';
        $data['ID_CATEGORIE_COTISATION'] = NULL;
    }


    
    $STATUS = $this->input->post('STATUS');
    if ($STATUS == NULL ) {
        $condi5 = '  ';
        $data['STATUS'] = 9;
    }
    else if ($STATUS == 0) {
        $condi5 = ' AND cotisation_categorie_membre.STATUS = 0 ';
        $data['STATUS'] = 0;
    }
    else{
        $condi5 = 'AND cotisation_categorie_membre.STATUS = 1';
        $data['STATUS'] = 1;
    }

      $resultat=$this->Model->getRequete("SELECT membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, syst_sexe.DESCRIPTION, membre_membre.DATE_NAISSANCE , IF(cotisation_categorie_membre.STATUS = 1, 'Actif', CONCAT('Inactif depuis ', ' ', cotisation_categorie_membre.DATE_FIN)) AS STATUS_MEMBRE, cotisation_categorie_membre.STATUS , cotisation_categorie.DESCRIPTION AS DESCRIPTION_CATEGORIE, cotisation_categorie_membre.ID_CATEGORIE_COTISATION_MEMBRE, cotisation_categorie_membre.ID_CATEGORIE_COTISATION, cotisation_categorie_membre.DATE_DEBUT, cotisation_categorie_membre.DATE_FIN, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_frais_adhesion.ID_COTISATION_FRAIS_ADHESION, membre_groupe.NOM_GROUPE, IF(cotisation_frais_adhesion.ID_COTISATION_FRAIS_ADHESION IS NULL, 'Non Payé','Payé' ) AFFILIATION FROM membre_membre LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN syst_sexe ON syst_sexe.ID_SEXE = membre_membre.ID_SEXE LEFT JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION JOIN cotisation_montant_cotisation ON cotisation_montant_cotisation.ID_CATEGORIE_COTISATION = cotisation_categorie.ID_CATEGORIE_COTISATION LEFT JOIN cotisation_frais_adhesion ON cotisation_frais_adhesion.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE membre_membre.IS_AFFILIE = 0 AND cotisation_categorie_membre.ID_MEMBRE IS NOT NULL ".$condi1." ".$condi2." ".$condi3." ".$condi4." ".$condi5." ");
      $tabledata=array();

      $selections = $this->Model->getRequete("SELECT cotisation_montant_cotisation.ID_MONTANT_COTISATION, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_categorie.DESCRIPTION AS DESC_CATEGORIE, cotisation_periode.DESCRIPTION AS DESC_PERIODE, cotisation_periode.NB_JOURS, cotisation_montant_cotisation.IS_ACTIF, cotisation_categorie.ID_CATEGORIE_COTISATION FROM cotisation_montant_cotisation JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE 1");
      
      foreach ($resultat as $key) 
         {

          $cotisation = $this->Model->getRequeteOne("SELECT syst_categorie_assurance.DROIT_AFFILIATION FROM membre_carte_membre JOIN membre_carte ON membre_carte_membre.ID_CARTE = membre_carte.ID_CARTE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE membre_carte_membre.ID_MEMBRE = ".$key['ID_MEMBRE']." ");

          if ($key['ID_CATEGORIE_COTISATION'] == NULL) {
            $stat = ' ';
            $identifiant = $key['ID_MEMBRE'];
            $modal = '<div class="modal fade" id="attribuer'.$identifiant.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel">Attribution de la categorie</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
       <div class="row">
          <div class="col-md-6">Nom:</div>
          <div class="col-md-6">'.$key['NOM'].' '.$key['PRENOM'].' </div>
          <div class="col-md-6">Categorie Actuelle:</div>
          <div class="col-md-6">'.$key['DESCRIPTION_CATEGORIE'].'</div>
          <div class="col-md-6">Date de Naissance:</div>
          <div class="col-md-6">'.$key['DATE_NAISSANCE'].'</div>
          <div class="col-md-6">Sexe:</div>
          <div class="col-md-6">'.$key['DESCRIPTION'].'</div>
       </div>
       <form id="FormData" action="'.base_url().'cotisation/Membre_Categorie/add_new" method="POST" enctype="multipart/form-data">
       <div class="row">
       <input type="hidden" name="ID_MEMBRE" class="form-control" value="'.$key['ID_MEMBRE'].'" id="ID_MEMBRE">
          <div class="col-md-12 text-center"><h3>Nouvelle categorie du membre</h3></div>

          <div class="col-md-4">Nouvelle categorie:</div>
          <div class="col-md-8">
            <select class="form-control"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION">
                            <option value="">-- Sélectionner --</option>';
                            
                          foreach ($selections as $values) { 
                             
                              $modal.='<option value="'.$values['ID_CATEGORIE_COTISATION'].'">'.$values['DESC_CATEGORIE'].' ('.$values['MONTANT_COTISATION'].'/'.$values['DESC_PERIODE'].')</option>';
                              
                           } 
                          
           $modal.=' </select>
          </div>
       </div>
       <div class="row">
        <div class="col-md-6 text-left"><br>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </div>
        <div class="col-md-6 text-right"><br>
        <input type="submit" value="Enregistrer" class="btn btn-success"/>
        </div>

       </div>
       </form>         
       </div>
     </div>
   </div>
 </div>';
            // $fx = 'desactiver';
            // $col = 'btn-success';
            $titr = 'Attribuer';
            // $stitr = 'voulez-vous désactiver la cotisation ';
            // $bigtitr = 'Désactivation de la cotisation';
          }
          else{
            $stat = $key['DESCRIPTION_CATEGORIE'];
            $identifiant = $key['ID_MEMBRE'].'_'.$key['ID_CATEGORIE_COTISATION_MEMBRE'];;

            $modal = '<div class="modal fade" id="attribuer'.$identifiant.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel">Modification de la categorie</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
       <div class="row">
          <div class="col-md-6">Nom:</div>
          <div class="col-md-6">'.$key['NOM'].' '.$key['PRENOM'].' </div>
          <div class="col-md-6">Categorie Actuelle:</div>
          <div class="col-md-6">'.$key['DESCRIPTION_CATEGORIE'].'</div>
          <div class="col-md-6">Date de Naissance:</div>
          <div class="col-md-6">'.$key['DATE_NAISSANCE'].'</div>
          <div class="col-md-6">Sexe:</div>
          <div class="col-md-6">'.$key['DESCRIPTION'].'</div>
          <div class="col-md-6">Periode</div>
          <div class="col-md-6">'.$key['DATE_DEBUT'].' - '.$key['DATE_FIN'].'</div>
       </div>
       <form id="FormData" action="'.base_url().'cotisation/Membre_Categorie/update" method="POST" enctype="multipart/form-data">
       <div class="row">
       <input type="hidden" name="ID_MEMBRE" class="form-control" value="'.$key['ID_MEMBRE'].'" id="ID_MEMBRE">
          <div class="col-md-12 text-center"><h3>Nouvelle categorie du membre</h3></div>

          <div class="col-md-4">Nouvelle categorie:</div>
          <div class="col-md-8">
            <select class="form-control"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION">
                            <option value="">-- Sélectionner --</option>';
                            
                          foreach ($selections as $values) { 
                             if ($values['ID_CATEGORIE_COTISATION'] == $key['ID_CATEGORIE_COTISATION']) {
                               $modal.='<option value="'.$values['ID_CATEGORIE_COTISATION'].'" selected>'.$values['DESC_CATEGORIE'].' ('.$values['MONTANT_COTISATION'].'/'.$values['DESC_PERIODE'].')</option>';
                             }
                             else{
                              $modal.='<option value="'.$values['ID_CATEGORIE_COTISATION'].'">'.$values['DESC_CATEGORIE'].' ('.$values['MONTANT_COTISATION'].'/'.$values['DESC_PERIODE'].')</option>';
                             }                     
                           } 
                          
           $modal.=' </select>
          </div>
       </div>
       <div class="row">
        <div class="col-md-3 text-left"><br>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </div>
        <div class="col-md-6 text-left"><br>
        <a class="btn btn-danger" href="'.base_url('cotisation/Membre_Categorie/annuler/'.$key['ID_MEMBRE']).'"> Retirer affectation </a>
        </div>
        <div class="col-md-3 text-right"><br>
        <input type="submit" value="Enregistrer" class="btn btn-success"/>
        </div>

       </div>
       </form>         
       </div>
     </div>
   </div>
 </div>';
        $MONTANT_COTISATION = $cotisation['DROIT_AFFILIATION'];
        $modal .='<div class="modal fade" id="myModal'.$identifiant.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form id="FormData" action="'.base_url().'cotisation/Membre_Categorie/save_frai" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="ID_MEMBRE" class="form-control" value="'.$key['ID_MEMBRE'].'" id="ID_MEMBRE">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body text-left">
              <div class="row">
              <div class="col-md-12"> Enregistrement du payement frais d\'adhésion  </div>
              <div class="col-md-6"> Affilié  </div>
              <div class="col-md-6"> '.$key['NOM'].' '.$key['PRENOM'].' </div>
              <div class="col-md-6"> Montant </div>
              <div class="col-md-6"> <input type="text" name="MONTANT" class="form-control" value="'.$MONTANT_COTISATION.'" id="MONTANT"> </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" value="Enregistrer" class="btn btn-primary"/>
            </div>
            </form>
          </div>
        </div>
      </div>';
      
            $titr = 'Modifier ou Retirer';
          }         
          
          

          $chambr=array();
          $chambr[]=$key['NOM'].' '.$key['PRENOM'];
          $chambr[]=$key['NOM_GROUPE'];
          $chambr[]=$key['AFFILIATION'];  
          // $chambr[]=$newDate;  
          $chambr[]=$key['STATUS_MEMBRE'];  
          $chambr[]=$stat;
          // if ($resultatlast['ID_MEMBRE'] == $key['ID_MEMBRE']) {
            // $todel = '<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#supprimermembre'.$key['ID_MEMBRE'].'"> Supprimer la personne </a> </li>';
          // }
          // else{
          //   $todel = '';
          // }
          // $chambr[]='
          $options=$modal.'<div class="dropdown ">
                     <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                     <span class="caret"></span></a>
                     <ul class="dropdown-menu dropdown-menu-right">';

            if ($key['STATUS'] == 1) {
               $options.='<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#attribuer'.$identifiant.'"> '.$titr.'  </a> </li>';  
            }

            if ($key['ID_COTISATION_FRAIS_ADHESION'] == NULL) {
              $options.='<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal'.$identifiant.'"> Payer frais d\'adhésion  </a> </li>';  
            }
             
                     
          $options.='</ul>
                   </div>';
                   $chambr[]=$options;
         
                          // <li><a class="dropdown-item" href="'.base_url('membre/Membre/index_update/'.$key['ID_MEMBRE']).'"> Ajouter/Enlever Groupe </a> </li>
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Nom','Société','P. Affiliation','Status','Categorie','Option'));
       
        $data['chamb']=$tabledata;
        $data['title']='Membre par categorie';
        $data['stitle']='Affilie avec Categorie';
        $this->load->view('Membre_Categorie_List_View',$data);
  }

  public function add()
  {
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $ID_MEMBRE=$this->input->post('ID_MEMBRE');
  $DATE_DEBUT= date('Y-m-d');
  // $ID_PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  // $ID_MONTANT_COTISATION=$this->input->post('ID_MONTANT_COTISATION');
  // print_r(array('ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_MEMBRE'=>$ID_MEMBRE));

  $this->Model->insert_last_id('cotisation_categorie_membre',array('ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_MEMBRE'=>$ID_MEMBRE,'DATE_DEBUT'=>$DATE_DEBUT));

  $message = "<div class='alert alert-success' id='message'>
                            Affectation du membre avec sa categorie enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Membre_Categorie'));  


  }

  

  public function add_new()
  {
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $ID_MEMBRE=$this->input->post('ID_MEMBRE');
  $DATE_DEBUT= date('Y-m-d');
  // $ID_PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  // $ID_MONTANT_COTISATION=$this->input->post('ID_MONTANT_COTISATION');
  // print_r(array('ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_MEMBRE'=>$ID_MEMBRE));

  $this->Model->update('cotisation_categorie_membre',array('ID_MEMBRE'=>$ID_MEMBRE, 'STATUS'=>1),array('DATE_FIN'=>$DATE_DEBUT, 'STATUS'=>0));
  
  $this->Model->insert_last_id('cotisation_categorie_membre',array('ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_MEMBRE'=>$ID_MEMBRE,'DATE_DEBUT'=>$DATE_DEBUT));

  $message = "<div class='alert alert-success' id='message'>
                            Affectation du membre avec sa categorie enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Membre_Categorie'));  

      // SELECT * FROM `cotisation_categorie_membre`
      

  }

  public function addgroup()
  {
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $ID_GROUPE=$this->input->post('ID_GROUPE');
  $DATE_DEBUT= date('Y-m-d');

  

  $list = $this->Model->getRequete('SELECT membre_membre.ID_MEMBRE  FROM membre_membre LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE 1 AND membre_membre.IS_AFFILIE = 0 AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' AND cotisation_categorie_membre.ID_MEMBRE IS NULL');

  // echo'<pre>';
  // print_r($list);
    foreach ($list as $value) {
      // echo $value['ID_MEMBRE'].'<br>';
      $this->Model->insert_last_id('cotisation_categorie_membre',array('ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_MEMBRE'=>$value['ID_MEMBRE'],'DATE_DEBUT'=>$DATE_DEBUT));

    }


  

  $message = "<div class='alert alert-success' id='message'>
                            Affectation des membres de ce groupe avec sa categorie enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Membre_Categorie/groupe'));  


  }


  
  public function update()
  {
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $ID_MEMBRE=$this->input->post('ID_MEMBRE');
  $DATE_DEBUT= date('Y-m-d');
  // $ID_PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  // $ID_MONTANT_COTISATION=$this->input->post('ID_MONTANT_COTISATION');
  // print_r(array('ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_MEMBRE'=>$ID_MEMBRE));

  $this->Model->update('cotisation_categorie_membre',array('ID_MEMBRE'=>$ID_MEMBRE, 'STATUS'=>1),array('DATE_FIN'=>$DATE_DEBUT,'STATUS'=>0));
  $this->Model->insert_last_id('cotisation_categorie_membre',array('ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_MEMBRE'=>$ID_MEMBRE,'DATE_DEBUT'=>$DATE_DEBUT));
  

  $message = "<div class='alert alert-success' id='message'>
                            Modification de l'affectation du membre avec sa categorie enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Membre_Categorie/listing'));  


  }


 public function annuler($ID_MEMBRE)
  {
  $DATE_DEBUT= date('Y-m-d');

  $this->Model->update('cotisation_categorie_membre',array('ID_MEMBRE'=>$ID_MEMBRE, 'STATUS'=>1),array('DATE_FIN'=>$DATE_DEBUT, 'STATUS'=>0));
  

  $message = "<div class='alert alert-success' id='message'>
                            Annulation de l'affectation du membre avec sa categorie enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Membre_Categorie/listing'));  


  }


  public function save_frai()
  {
    $MONTANT=$this->input->post('MONTANT');
    $ID_MEMBRE=$this->input->post('ID_MEMBRE');
    $DATE_PAIEMENT= date('Y-m-d');
    

    $this->Model->insert_last_id('cotisation_frais_adhesion',array('MONTANT'=>$MONTANT, 'ID_MEMBRE'=>$ID_MEMBRE,'DATE_PAIEMENT'=>$DATE_PAIEMENT));

  $message = "<div class='alert alert-success' id='message'>
                            Enregistrement du payement des frais d'adhesion faite avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Membre_Categorie/listing'));


  }

  public function save_frai_groupe()
  {
    // $MONTANT=$this->input->post('MONTANT');
    $ID_GROUPE=$this->input->post('ID_GROUPE');
    $DATE_PAIEMENT= date('Y-m-d');

    $list = $this->Model->getRequete('SELECT membre_membre.ID_MEMBRE FROM membre_membre LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_frais_adhesion ON cotisation_frais_adhesion.ID_MEMBRE= membre_membre.ID_MEMBRE WHERE 1 AND membre_membre.IS_AFFILIE = 0 AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' AND cotisation_categorie_membre.ID_MEMBRE IS NOT NULL AND cotisation_frais_adhesion.ID_COTISATION_FRAIS_ADHESION IS NULL');

  // echo'<pre>';
  // print_r($list);
    foreach ($list as $value) {

      
      // $this->Model->insert_last_id('cotisation_categorie_membre',array('ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_MEMBRE'=>$value['ID_MEMBRE'],'DATE_DEBUT'=>$DATE_DEBUT));

       $cotisation = $this->Model->getRequeteOne("SELECT syst_categorie_assurance.DROIT_AFFILIATION FROM membre_carte_membre JOIN membre_carte ON membre_carte_membre.ID_CARTE = membre_carte.ID_CARTE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE membre_carte_membre.ID_MEMBRE = ".$value['ID_MEMBRE']." ");

      //  echo $value['ID_MEMBRE'].'-'.$cotisation['DROIT_AFFILIATION'].'<br>';

    $this->Model->insert_last_id('cotisation_frais_adhesion',array('MONTANT'=>$cotisation['DROIT_AFFILIATION'], 'ID_MEMBRE'=>$value['ID_MEMBRE'],'DATE_PAIEMENT'=>$DATE_PAIEMENT));


    }
    

   

  $message = "<div class='alert alert-success' id='message'>
                            Enregistrement du payement des frais d'adhesion du groupe faite avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Membre_Categorie/groupe'));


  }
  


  public function groupe()
  {
      // echo "In dev";
      $data['title']='Affiliation des membres de groupe';
      $data['stitle']='Affiliation des membres de groupe';
      $resultat = $this->Model->getRequete('SELECT * FROM `membre_groupe`'); 

      $selections = $this->Model->getRequete("SELECT cotisation_montant_cotisation.ID_MONTANT_COTISATION, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_categorie.DESCRIPTION AS DESC_CATEGORIE, cotisation_periode.DESCRIPTION AS DESC_PERIODE, cotisation_periode.NB_JOURS, cotisation_montant_cotisation.IS_ACTIF, cotisation_categorie.ID_CATEGORIE_COTISATION FROM cotisation_montant_cotisation JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE 1");

      foreach ($resultat as $key) 
         {

          $sans = $this->Model->getRequeteOne('SELECT COUNT(membre_membre.ID_MEMBRE) AS NOMBRE FROM membre_membre LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE 1 AND membre_membre.IS_AFFILIE = 0 AND membre_groupe_membre.ID_GROUPE = '.$key['ID_GROUPE'].' AND cotisation_categorie_membre.ID_MEMBRE IS NOT NULL');
          $avec = $this->Model->getRequeteOne('SELECT COUNT(membre_membre.ID_MEMBRE) AS NOMBRE FROM membre_membre LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE 1 AND membre_membre.IS_AFFILIE = 0 AND membre_groupe_membre.ID_GROUPE = '.$key['ID_GROUPE'].' AND cotisation_categorie_membre.ID_MEMBRE IS  NULL');

          $sans_cot = $this->Model->getRequeteOne('SELECT COUNT(membre_membre.ID_MEMBRE) AS NOMBRE FROM membre_membre LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_frais_adhesion ON cotisation_frais_adhesion.ID_MEMBRE= membre_membre.ID_MEMBRE WHERE 1 AND membre_membre.IS_AFFILIE = 0 AND membre_groupe_membre.ID_GROUPE = '.$key['ID_GROUPE'].' AND cotisation_categorie_membre.ID_MEMBRE IS NOT NULL AND cotisation_frais_adhesion.ID_COTISATION_FRAIS_ADHESION IS NULL');

          $avec_cot = $this->Model->getRequeteOne('SELECT COUNT(membre_membre.ID_MEMBRE) AS NOMBRE FROM membre_membre LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_frais_adhesion ON cotisation_frais_adhesion.ID_MEMBRE= membre_membre.ID_MEMBRE WHERE 1 AND membre_membre.IS_AFFILIE = 0 AND membre_groupe_membre.ID_GROUPE = '.$key['ID_GROUPE'].' AND cotisation_categorie_membre.ID_MEMBRE IS NOT NULL AND cotisation_frais_adhesion.ID_COTISATION_FRAIS_ADHESION IS NOT NULL');


          

          
          $modal = '<div class="modal fade" id="attribuer'.$key['ID_GROUPE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Attribution de la categorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <div class="row">
                 <div class="col-md-6">Nom du groupe:</div>
                 <div class="col-md-6"> '.$key['NOM_GROUPE'].' </div>
              </div>
              <form id="FormData" action="'.base_url().'cotisation/Membre_Categorie/addgroup" method="POST" enctype="multipart/form-data">
              <div class="row">
              <input type="hidden" name="ID_GROUPE" class="form-control" value="'.$key['ID_GROUPE'].'" id="ID_GROUPE">
                 <div class="col-md-12 text-center"><h3>Nouvelle categorie du membre</h3></div>
       
                 <div class="col-md-4">Nouvelle categorie:</div>
                 <div class="col-md-8">
                   <select class="form-control"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION">
                                   <option value="">-- Sélectionner --</option>';
                                   
                                 foreach ($selections as $values) { 
                                    
                                     $modal.='<option value="'.$values['ID_CATEGORIE_COTISATION'].'">'.$values['DESC_CATEGORIE'].' ('.$values['MONTANT_COTISATION'].'/'.$values['DESC_PERIODE'].')</option>';
                                     
                                  } 
                                 
                  $modal.=' </select>
                 </div>
              </div>
              <div class="row">
               <div class="col-md-6 text-left"><br>
               <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
               </div>
               <div class="col-md-6 text-right"><br>
               <input type="submit" value="Enregistrer" class="btn btn-success"/>
               </div>
       
              </div>
              </form>         
              </div>
            </div>
          </div>
        </div>';

        $modal .='<div class="modal fade" id="myModal'.$key['ID_GROUPE'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form id="FormData" action="'.base_url().'cotisation/Membre_Categorie/save_frai_groupe" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="ID_GROUPE" class="form-control" value="'.$key['ID_GROUPE'].'" id="ID_GROUPE">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body text-left">
              <div class="row">
              <div class="col-md-12"> Enregistrement du payement frais d\'adhésion  </div>
              <div class="col-md-6"> Affilié  </div>
              <div class="col-md-6"> Groupe selectionne </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" value="Enregistrer" class="btn btn-primary"/>
            </div>
            </form>
          </div>
        </div>
      </div>';

          $tot = $avec['NOMBRE']+$sans['NOMBRE'];
          $tot_cot = $avec_cot['NOMBRE']+$sans_cot['NOMBRE'];
          $chambr=array();
          $chambr[]=$key['NOM_GROUPE'];
          $chambr[]=$sans['NOMBRE'].' Sur '.$tot.' Sont affect&eacute;' ;
          $chambr[]=$avec_cot['NOMBRE'].' Sur '.$tot.' Ont pay&eacute;' ;
          $options= $modal.'<div class="dropdown ">
                     <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                     <span class="caret"></span></a>
                     <ul class="dropdown-menu dropdown-menu-right">
                     <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#attribuer'.$key['ID_GROUPE'].'"> Atribuer  </a> </li>
                     <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal'.$key['ID_GROUPE'].'"> Frais Adhesion  </a> </li>
                     </ul>
                   </div>';
                   
                   $chambr[]=$options;
         
                          // <li><a class="dropdown-item" href="'.base_url('membre/Membre/index_update/'.$key['ID_MEMBRE']).'"> Ajouter/Enlever Groupe </a> </li>
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Nom','Affectation','Frais Adhesion','Option'));
       
        $data['chamb']=$tabledata;

      $this->load->view('Membre_Categorie_List_View',$data);
  }

  
  // public function update()
  // {
  // $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  // $ID_CATEGORIE_COTISATION_MEMBRE=$this->input->post('ID_CATEGORIE_COTISATION_MEMBRE');
  // $ID_PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  // $ID_MONTANT_COTISATION=$this->input->post('ID_MONTANT_COTISATION');

  // $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$ID_MONTANT_COTISATION), array('MONTANT_COTISATION'=>$MONTANT_COTISATION, 'ID_CATEGORIE_COTISATION_MEMBRE'=>$ID_CATEGORIE_COTISATION_MEMBRE, 'ID_PERIODE_COTISATION'=>$ID_PERIODE_COTISATION));

  // $message = "<div class='alert alert-success' id='message'>
  //                           Cotisation modifi&eacute; avec succés
  //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
  //                     </div>";
  //   $this->session->set_flashdata(array('message'=>$message));
  //     redirect(base_url('cotisation/Membre_Categorie/listing'));    

  // }


  //  public function desactiver($id)
  //   {
  //     $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$id),array('IS_ACTIF'=>0));
  //     $message = "<div class='alert alert-success' id='message'>
  //                           Cotisation désactivé avec succés
  //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
  //                     </div>";
  //     $this->session->set_flashdata(array('message'=>$message));
  //     redirect(base_url('cotisation/Membre_Categorie/listing'));
  //   }

  // public function reactiver($id)
  //   {
  //     $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$id),array('IS_ACTIF'=>1));
  //     $message = "<div class='alert alert-success' id='message'>
  //                           Cotisation Réactivé avec succés
  //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
  //                     </div>";
  //     $this->session->set_flashdata(array('message'=>$message));
  //     redirect(base_url('cotisation/Membre_Categorie/listing')); 
  //   }
  

}
?>