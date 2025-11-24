<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paiment_facture extends CI_Controller {

  public function __construct() {
    parent::__construct();
    

    
  }

  



 public function index()
 {
  $data['title']=' Affili&eacute;';
  $data['stitle']=' Affili&eacute;';

  $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 

  $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");

  $data['pharmacies'] = $this->Model->getList('consultation_pharmacie',array('STATUS'=>1)); 
  $data['hopitaux'] = $this->Model->getList('masque_stucture_sanitaire'); 
  
  
  $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));

  $this->load->view('paiement_Add_View',$data);
}



public function add()
{

  $DATE_ENREGISTREMENT=$this->input->post('DATE_ENREGISTREMENT');
  $NUMERO_FACTURE=$this->input->post('NUMERO_FACTURE');
  $ID_TYPE=$this->input->post('ID_TYPE');
  $ID_STRUCTURE=$this->input->post('ID_STRUCTURE');
  $ID_PHARMACIE=$this->input->post('ID_PHARMACIE');
  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $NUMERO_COMPTE=$this->input->post('NUMERO_COMPTE');
  $MONTANT=$this->input->post('MONTANT');
  $BANQUE=$this->input->post('BANQUE');
  $OBSERVATION=$this->input->post('OBSERVATION');
  $MOI_ANNEE=$this->input->post('MOI_ANNEE');
  

  // echo $PROVINCE_ID;exit();
  $this->form_validation->set_rules('DATE_ENREGISTREMENT', "Date d'enregitrement", 'required');
  $this->form_validation->set_rules('NUMERO_FACTURE', 'Numero facture', 'required');
  $this->form_validation->set_rules('ID_TYPE', 'type de structure', 'required');
  if($ID_TYPE==1){
    $this->form_validation->set_rules('ID_STRUCTURE', 'hopital', 'required');
  }

  if($ID_TYPE==2){
    $this->form_validation->set_rules('ID_PHARMACIE', 'Pharmacie', 'required');
  }
  $this->form_validation->set_rules('DESCRIPTION', 'Libellés', 'required');
  $this->form_validation->set_rules('NUMERO_COMPTE', 'Numero de compte', 'required');
  $this->form_validation->set_rules('MONTANT', 'Montant', 'required');
  $this->form_validation->set_rules('BANQUE', 'Banque', 'required');





  if ($this->form_validation->run() == FALSE){
   $data['title']=' Affili&eacute;';
   $data['stitle']=' Affili&eacute;';

   $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 

   $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");

   $data['pharmacies'] = $this->Model->getList('consultation_pharmacie',array('STATUS'=>1)); 
   $data['hopitaux'] = $this->Model->getList('masque_stucture_sanitaire'); 


   $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));

   $this->load->view('paiement_Add_View',$data);
 }
 else{

  $facturations = $this->Model->getOne('facturation_affilie',array('NUMERO_FACTURE'=>$NUMERO_FACTURE));  

  if(empty($facturations)){

    $datas=array(
     'DATE_ENREGISTREMENT'=>$DATE_ENREGISTREMENT,
     'NUMERO_FACTURE'=>$NUMERO_FACTURE,
     'ID_TYPE'=>$ID_TYPE,
     'ID_STRUCTURE'=>$ID_STRUCTURE,
     'ID_PHARMACIE'=>$ID_PHARMACIE,
     'DESCRIPTION'=>$DESCRIPTION,
     'NUMERO_COMPTE'=>$NUMERO_COMPTE,
     'MOI_ANNEE'=>$MOI_ANNEE,
     'MONTANT'=>$MONTANT,
     'BANQUE'=>$BANQUE,
     'OBSERVATION'=>$OBSERVATION,
     'ID_USER'=>$this->session->userdata('MIS_ID_USER')
   );

    $ID_FACTURE = $this->Model->insert_last_id('facturation_affilie',$datas);

    $message = "<div class='alert alert-success' id='message'>
    Facture Enregistré avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('paiment/Paiment_facture/liste'));  
  }else{

   $message = "<div class='alert alert-info' id='message'>
   la facture existe déjà
   <button type='button' class='close' data-dismiss='alert'>&times;</button>
   </div>";
   $this->session->set_flashdata(array('message'=>$message));

   $data['title']=' Affili&eacute;';
   $data['stitle']=' Affili&eacute;';

   $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 

   $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");

   $data['pharmacies'] = $this->Model->getList('consultation_pharmacie',array('STATUS'=>1)); 
   $data['hopitaux'] = $this->Model->getList('masque_stucture_sanitaire'); 


   $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));

   $this->load->view('paiement_Add_View',$data);
 }  

}


}
public function liste()
{
  $data['title']=' Liste';
  $data['stitle']=' liste';

  $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 

  $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");

  $data['pharmacies'] = $this->Model->getList('consultation_pharmacie',array('STATUS'=>1)); 
  $data['hopitaux'] = $this->Model->getList('masque_stucture_sanitaire'); 
  
  
  $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));

  $this->load->view('paiement_facture_List_View',$data);
}


public function listing()
{

  $ID_STRUCTURE=$this->input->post('ID_STRUCTURE');
  $STATUT_PAIE=$this->input->post('STATUT_PAIE');

  $hopital=''; 
  if(!empty($ID_STRUCTURE)){
    $hopital=' AND faf.ID_STRUCTURE='.$ID_STRUCTURE;
  }

  $condi=''; 
  if(!empty($STATUT_PAIE)){
    $condi=' AND STATUT_PAIE='.$STATUT_PAIE;
  }

  $query_principal ="SELECT ID_FACTURE, NUMERO_FACTURE, mas.DESCRIPTION AS hopital, ID_TYPE,BANQUE,DATE_ENREGISTREMENT,OBSERVATION, cp.DESCRIPTION AS pharmacie, faf.DESCRIPTION, NUMERO_COMPTE, MONTANT,STATUT_PAIE, DATE_INSERT FROM facturation_affilie faf LEFT JOIN masque_stucture_sanitaire mas ON mas.ID_STRUCTURE=faf.ID_STRUCTURE LEFT JOIN consultation_pharmacie cp ON cp.ID_PHARMACIE=faf.ID_PHARMACIE WHERE ID_TYPE=1 ".$hopital." ".$condi." " ;

  $var_search = !empty($_POST['search']['value']) ? $this->db->escape_like_str($_POST['search']['value']) : null;

  $limit = 'LIMIT 0,10';

  if (isset($_POST['length']) && $_POST['length'] != -1) {
    $limit = 'LIMIT ' . (isset($_POST["start"]) ? $_POST["start"] : 0) . ',' . $_POST["length"];
  }

  $order_by = '';

  $order_column = array('ID_FACTURE', 'NUMERO_FACTURE', 'mas.DESCRIPTION', 'cp.DESCRIPTION', 'faf.DESCRIPTION', 'BANQUE', 'NUMERO_COMPTE', 'MONTANT');

  $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NUMERO_FACTURE ASC';

  $search = !empty($_POST['search']['value']) ? 
  "AND NUMERO_FACTURE LIKE '%$var_search%' OR mas.DESCRIPTION LIKE '%$var_search%' OR cp.DESCRIPTION LIKE '%$var_search%' OR faf.DESCRIPTION LIKE '%$var_search%' OR BANQUE LIKE '%$var_search%'  OR NUMERO_COMPTE LIKE '%$var_search%'" 
  : '';

  $critaire = '';

  $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
  $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

  $membres = $this->Model->datatable($query_secondaire);

  $data = array();
  foreach ($membres as $key) {
    $row = array();

    if ($key->STATUT_PAIE == 1) {
      $stat = 'Payé';
      $todel = '';
    }
    else{
      $stat = 'Non payé';

      $todel = '<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#payer'.$key->ID_FACTURE.'"> Payer </a> </li>';
    }
    $row[] = date("d-m-Y", strtotime($key->DATE_ENREGISTREMENT));
    $row[] = $key->NUMERO_FACTURE;
    $row[] = $key->DESCRIPTION;
    $row[] = $key->hopital;
    $row[] = $key->BANQUE;
    $row[] = $key->NUMERO_COMPTE;  
    $row[] = $key->MONTANT;
    $row[] = $stat ; 
    $row[] = $key->OBSERVATION ?  $key->OBSERVATION : 'N/A';

    $row[]='<div class="modal fade" id="supprimermembre'.$key->ID_FACTURE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Suppression du faacture</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <h6><b>Mr/Mme ,  Voulez-vous vraiment supprimer le facture de ('.$key->hopital.')?</b><br>Cette action est irréversible</h6>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
    <a href="'.base_url('paiment/Paiment_facture/supprimer/'.$key->ID_FACTURE).'" class="btn btn-danger">Supprimer</a>
    </div>
    </div>
    </div>
    </div>



    <div class="modal fade" id="payer'.$key->ID_FACTURE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Suppression du faacture</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <h6><b>Mr/Mme ,  Voulez-vous vraiment payer le facture de ('.$key->hopital.')?</b><br></h6>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
    <a href="'.base_url('paiment/Paiment_facture/payer/'.$key->ID_FACTURE).'" class="btn btn-danger">Supprimer</a>
    </div>
    </div>
    </div>
    </div>
    

    <div class="dropdown ">
    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
    <span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right">
    <li><a class="dropdown-item" href="'.base_url('paiment/Paiment_facture/index_update/'.$key->ID_FACTURE).'"> Modifier</a> </li>
    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#supprimermembre'.$key->ID_FACTURE.'"> Supprimer </a> </li>
    '.$todel.'
    

    </ul>
    </div>';
    $data[] = $row;
  }

  $output = array(
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $this->Model->all_data($query_principal),
    "recordsFiltered" => $this->Model->filtrer($query_filter),
    "data" => $data
  );
  echo json_encode($output);
  exit;
}

public function liste_phare()
{
  $data['title']=' Liste';
  $data['stitle']=' liste';

  $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 


  $data['pharmacies'] = $this->Model->getList('consultation_pharmacie',array('STATUS'=>1)); 
  $data['hopitaux'] = $this->Model->getList('masque_stucture_sanitaire'); 
  
  
  $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));

  $this->load->view('paiement_facture_phare_List_View',$data);
}


public function listing_phare()
{

  $ID_PHARMACIE=$this->input->post('ID_PHARMACIE');
  $STATUT_PAIE=$this->input->post('STATUT_PAIE');

  $pharmacie=''; 
  if(!empty($ID_PHARMACIE)){
    $hopital=' AND faf.ID_PHARMACIE='.$ID_PHARMACIE;
  }

  $condi=''; 
  if(!empty($STATUT_PAIE)){
    $condi=' AND STATUT_PAIE='.$STATUT_PAIE;
  }

  $query_principal ='SELECT ID_FACTURE, NUMERO_FACTURE, mas.DESCRIPTION AS hopital, ID_TYPE,BANQUE,DATE_ENREGISTREMENT,OBSERVATION, faf.DESCRIPTION, cp.DESCRIPTION AS pharmacie,  NUMERO_COMPTE, MONTANT,STATUT_PAIE, DATE_INSERT FROM facturation_affilie faf LEFT JOIN masque_stucture_sanitaire mas ON mas.ID_STRUCTURE=faf.ID_STRUCTURE LEFT JOIN consultation_pharmacie cp ON cp.ID_PHARMACIE=faf.ID_PHARMACIE WHERE faf.ID_TYPE=2 '.$pharmacie.' '.$condi.'';

  $var_search = !empty($_POST['search']['value']) ? $this->db->escape_like_str($_POST['search']['value']) : null;

  $limit = 'LIMIT 0,10';

  if (isset($_POST['length']) && $_POST['length'] != -1) {
    $limit = 'LIMIT ' . (isset($_POST["start"]) ? $_POST["start"] : 0) . ',' . $_POST["length"];
  }

  $order_by = '';

  $order_column = array('ID_FACTURE', 'NUMERO_FACTURE', 'mas.DESCRIPTION', 'cp.DESCRIPTION', 'faf.DESCRIPTION', 'BANQUE', 'NUMERO_COMPTE', 'MONTANT');

  $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NUMERO_FACTURE ASC';

  $search = !empty($_POST['search']['value']) ? 
  "AND NUMERO_FACTURE LIKE '%$var_search%' OR mas.DESCRIPTION LIKE '%$var_search%' OR cp.DESCRIPTION LIKE '%$var_search%' OR faf.DESCRIPTION LIKE '%$var_search%' OR BANQUE LIKE '%$var_search%'  OR NUMERO_COMPTE LIKE '%$var_search%'" 
  : '';

  $critaire = '';

  $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
  $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

  $membres = $this->Model->datatable($query_secondaire);

  $data = array();
  foreach ($membres as $key) {
    $row = array();

    if ($key->STATUT_PAIE == 1) {
      $stat = 'Payé';
      $todel = '';
    }
    else{
      $stat = 'Non payé';

      $todel = '<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#payer'.$key->ID_FACTURE.'"> Payer </a> </li>';
    }
    $row[] = date("d-m-Y", strtotime($key->DATE_ENREGISTREMENT));
    $row[] = $key->NUMERO_FACTURE;
    $row[] = $key->DESCRIPTION;
    $row[] = $key->pharmacie;
    $row[] = $key->BANQUE;
    $row[] = $key->NUMERO_COMPTE; 
    $row[] = $key->MONTANT; 
    $row[] = $stat ; 
    $row[] = $key->OBSERVATION ?  $key->OBSERVATION : 'N/A';

    $row[]='<div class="modal fade" id="supprimermembre'.$key->ID_FACTURE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Suppression du faacture</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <h6><b>Mr/Mme ,  Voulez-vous vraiment supprimer le facture de ('.$key->pharmacie.')?</b><br>Cette action est irréversible</h6>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
    <a href="'.base_url('paiment/Paiment_facture/supprimer/'.$key->ID_FACTURE).'" class="btn btn-danger">Supprimer</a>
    </div>
    </div>
    </div>
    </div>
    



    <div class="modal fade" id="payer'.$key->ID_FACTURE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Suppression du faacture</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <h6><b>Mr/Mme ,  Voulez-vous vraiment payer le facture de ('.$key->pharmacie.')?</b><br></h6>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
    <a href="'.base_url('paiment/Paiment_facture/payer/'.$key->ID_FACTURE).'" class="btn btn-danger">Supprimer</a>
    </div>
    </div>
    </div>
    </div>
    

    <div class="dropdown ">
    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
    <span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right">
    <li><a class="dropdown-item" href="'.base_url('paiment/Paiment_facture/index_update/'.$key->ID_FACTURE).'"> Modifier</a> </li>
    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#supprimermembre'.$key->ID_FACTURE.'"> Supprimer </a> </li>
    '.$todel.'
    </ul>
    </div>';
    $data[] = $row;
  }

  $output = array(
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $this->Model->all_data($query_principal),
    "recordsFiltered" => $this->Model->filtrer($query_filter),
    "data" => $data
  );
  echo json_encode($output);
  exit;
}

public function index_update($id)
{

  $data['title']=' Liste';
  $data['stitle']=' liste';

  $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 

  $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");

  $data['pharmacies'] = $this->Model->getList('consultation_pharmacie',array('STATUS'=>1)); 
  $data['hopitaux'] = $this->Model->getList('masque_stucture_sanitaire'); 

  $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));

  $data['facturations'] = $this->Model->getOne('facturation_affilie',array('ID_FACTURE'=>$id));  

  $this->load->view('paiement_Update_View',$data);
}


public function update()
{


  $DATE_ENREGISTREMENT=$this->input->post('DATE_ENREGISTREMENT');
  $NUMERO_FACTURE=$this->input->post('NUMERO_FACTURE');
  $ID_TYPE=$this->input->post('ID_TYPE');
  $ID_STRUCTURE=$this->input->post('ID_STRUCTURE');
  $ID_PHARMACIE=$this->input->post('ID_PHARMACIE');
  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $NUMERO_COMPTE=$this->input->post('NUMERO_COMPTE');
  $MONTANT=$this->input->post('MONTANT');
  $BANQUE=$this->input->post('BANQUE');
  $OBSERVATION=$this->input->post('OBSERVATION');
  $MOI_ANNEE=$this->input->post('MOI_ANNEE');

  $id=$this->input->post('ID_FACTURE');


  $this->form_validation->set_rules('DATE_ENREGISTREMENT', "Date d'enregitrement", 'required');
  $this->form_validation->set_rules('NUMERO_FACTURE', 'Numero facture', 'required');
  $this->form_validation->set_rules('ID_TYPE', 'type de structure', 'required');
  if($ID_TYPE==1){
    $this->form_validation->set_rules('ID_STRUCTURE', 'hopital', 'required');
  }

  if($ID_TYPE==2){
    $this->form_validation->set_rules('ID_PHARMACIE', 'Pharmacie', 'required');
  }
  $this->form_validation->set_rules('DESCRIPTION', 'Libellés', 'required');
  $this->form_validation->set_rules('NUMERO_COMPTE', 'Numero de compte', 'required');
  $this->form_validation->set_rules('MONTANT', 'Montant', 'required');
  $this->form_validation->set_rules('BANQUE', 'Banque', 'required');



  if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
    Affili&eacute; non modifi&eacute;
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $data['title']=' Liste';
    $data['stitle']=' liste';

    $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 

    $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");

    $data['pharmacies'] = $this->Model->getList('consultation_pharmacie',array('STATUS'=>1)); 
    $data['hopitaux'] = $this->Model->getList('masque_stucture_sanitaire'); 


    $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));


    $data['facturations'] = $this->Model->getOne('facturation_affilie',array('ID_FACTURE'=>$id)); 

    $this->load->view('paiement_Update_View',$data);
  }
  else{

    $datas=array(
     'DATE_ENREGISTREMENT'=>$DATE_ENREGISTREMENT,
     'NUMERO_FACTURE'=>$NUMERO_FACTURE,
     'ID_TYPE'=>$ID_TYPE,
     'ID_STRUCTURE'=>$ID_STRUCTURE,
     'ID_PHARMACIE'=>$ID_PHARMACIE,
     'DESCRIPTION'=>$DESCRIPTION,
     'NUMERO_COMPTE'=>$NUMERO_COMPTE,
     'MOI_ANNEE'=>$MOI_ANNEE,
     'MONTANT'=>$MONTANT,
     'BANQUE'=>$BANQUE,
     'OBSERVATION'=>$OBSERVATION,
     'ID_USER'=>$this->session->userdata('MIS_ID_USER')
   );

    $this->Model->update('facturation_affilie',array('ID_FACTURE'=>$id),$datas);

    $message = "<div class='alert alert-success' id='message'>
    Facture modifi&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('paiment/Paiment_facture/liste'));    
  }

}

public function supprimer($id)
{
  $donne_facture= $this->Model->getOne('facturation_affilie',array('ID_FACTURE'=>$id));
  if(!empty($donne_facture)){

    $datas=array(
      'ID_FACTURE'=>$donne_facture['ID_FACTURE'],
      'DATE_ENREGISTREMENT'=>$donne_facture['DATE_ENREGISTREMENT'],
      'NUMERO_FACTURE'=>$donne_facture['NUMERO_FACTURE'],
      'ID_TYPE'=>$donne_facture['ID_TYPE'],
      'ID_STRUCTURE'=>$donne_facture['ID_STRUCTURE'],
      'ID_PHARMACIE'=>$donne_facture['ID_PHARMACIE'],
      'DESCRIPTION'=>$donne_facture['DESCRIPTION'],
      'NUMERO_COMPTE'=>$donne_facture['NUMERO_COMPTE'],
      'MOI_ANNEE'=>$donne_facture['MOI_ANNEE'],
      'MONTANT'=>$donne_facture['MONTANT'],
      'BANQUE'=>$donne_facture['BANQUE'],
      'OBSERVATION'=>$donne_facture['OBSERVATION'],
      'ID_USER'=>$this->session->userdata('MIS_ID_USER')
    );

    $ID_FACTURE = $this->Model->insert_last_id('facturation_affilie_historique',$datas);

    $this->Model->delete('facturation_affilie',array('ID_FACTURE'=>$id));

    $message = "<div class='alert alert-success' id='message'>
    Facture effac&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('paiment/Paiment_facture/liste'));    
  }

}

public function payer($id)
{

  $this->Model->update('facturation_affilie',array('ID_FACTURE'=>$id), array('STATUT_PAIE' => 1 ));


  $message = "<div class='alert alert-success' id='message'>
  Facture pay&eacute; avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('paiment/Paiment_facture/liste'));    


}



}
?>