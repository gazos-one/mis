<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration_Cotisation extends CI_Controller {

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
  $data['title']='Configuration Cotisation';
  $data['stitle']='Configuration Cotisation';

  $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


  $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

  $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');

  $this->load->view('Configuration_Cotisation_Add_View',$data);
}

public function listing()
{
  $data['title']='Configuration Cotisation'; 
  $data['stitle']='Configuration Cotisation';

  $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


  $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

  $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');

  $this->load->view('Cotisation_New_Views',$data);
}

public function addCategorie()
{

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $datas=array('DESCRIPTION'=>$DESCRIPTION);
  $ID_EMPLOI = $this->Model->insert_last_id('cotisation_categorie',$datas);

  echo '<option value="'.$ID_EMPLOI.'">'.$this->input->post('DESCRIPTION').'</option>';

}


public function get_nombre()
{
  $ID_CATEGORIE_COTISATION_MEMBRE=$this->input->post('ID_CATEGORIE_COTISATION_MEMBRE');
  $ID_GROUPE=$this->input->post('ID_GROUPE');

  $request=$this->Model->getRequeteOne("SELECT count(membre_assurances.ID_MEMBRE) as nbr_membre FROM `membre_assurances` join membre_groupe_membre on membre_assurances.ID_MEMBRE=membre_groupe_membre.ID_MEMBRE join membre_membre on membre_groupe_membre.ID_MEMBRE  =membre_membre.ID_MEMBRE WHERE 1 and membre_assurances.ID_CATEGORIE_ASSURANCE=".$ID_CATEGORIE_COTISATION_MEMBRE." and membre_groupe_membre.ID_GROUPE=".$ID_GROUPE." and membre_membre.STATUS=1 and membre_membre.IS_AFFILIE=0");




  echo $request['nbr_membre'];


}

public function addPeriode()
{

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $NB_JOURS=$this->input->post('NB_JOURS');
  $datas=array('DESCRIPTION'=>$DESCRIPTION,'NB_JOURS'=>$NB_JOURS);
  $ID_PERIODE_COTISATION = $this->Model->insert_last_id('cotisation_periode',$datas);

  echo '<option value="'.$ID_PERIODE_COTISATION.'">'.$this->input->post('DESCRIPTION').'</option>';

} 


public function add()
{
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_GROUPE=$this->input->post('ID_GROUPE');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $Nombre=$this->input->post('NOMBRE');
  $PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  $USER_ID=$this->session->userdata('MIS_ID_USER');
  $AYANT_DROIT=$this->input->post('AYANT_DROIT');

  $MONTANT=$MONTANT_COTISATION*$Nombre;

  $this->form_validation->set_rules('MONTANT_COTISATION', 'Montant', 'required');
  $this->form_validation->set_rules('ID_GROUPE', 'Groupe', 'required');
  $this->form_validation->set_rules('ID_CATEGORIE_COTISATION', 'categorie', 'required');
  $this->form_validation->set_rules('NOMBRE', 'Nombre', 'required');
  $this->form_validation->set_rules('ID_PERIODE_COTISATION', 'Mois de cotisation', 'required');
  if ($this->form_validation->run() == FALSE) {
    $data['title']='Configuration Cotisation';
    $data['stitle']='Configuration Cotisation';

    $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


    $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

    $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');

    $message = "<div class='alert alert-danger' id='message'>
    Enregistement des cotisations a echoué
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));

    $this->load->view('Configuration_Cotisation_Add_View',$data);
  } else {

    $this->Model->create('cotisation_cotisation_new',array('PRIX_UNITAIRE'=>$MONTANT_COTISATION,'MONTANT_COTISATION'=>$MONTANT,'ID_GROUPE'=>$ID_GROUPE,'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_COTISATION,'NOMBRE'=>$Nombre,'MOIS_COTISATION'=>$PERIODE_COTISATION,'AYANT_DROIT'=>$AYANT_DROIT,'USER_SAVER'=>$USER_ID));

    $message = "<div class='alert alert-success' id='message'>
    Cotisation enregistr&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('cotisation/Configuration_Cotisation'));    
  }
}


public function add_addhesion()
{
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_GROUPE=$this->input->post('ID_GROUPE');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $Nombre=$this->input->post('NOMBRE');
  $MOIS_COTISATION=$this->input->post('MOIS_COTISATION');
  $USER_ID=$this->session->userdata('MIS_ID_USER');

  $MONTANT=$MONTANT_COTISATION*$Nombre;


  $this->form_validation->set_rules('MONTANT_COTISATION', 'Montant', 'required');
  $this->form_validation->set_rules('ID_GROUPE', 'Groupe', 'required');
  $this->form_validation->set_rules('ID_CATEGORIE_COTISATION', 'categorie', 'required');
  $this->form_validation->set_rules('NOMBRE', 'Nombre', 'required');
  $this->form_validation->set_rules('MOIS_COTISATION', 'Mois de cotisation', 'required');

  if ($this->form_validation->run() == FALSE) {
    $data['title']='Configuration Cotisation';
    $data['stitle']='Configuration Cotisation';

    $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


    $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

    $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');
    $message = "<div class='alert alert-danger' id='message'>
    Enregistement des frais d'adhesion   a echoué
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $this->load->view('Configuration_Cotisation_Add_View',$data);
  } else {



    $this->Model->create('cotisation_frais_adhesion_new',array('PRIX_UNITAIRE'=>$MONTANT_COTISATION,'MONTANT_COTISATION'=>$MONTANT,'ID_GROUPE'=>$ID_GROUPE,'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_COTISATION,'NOMBRE'=>$Nombre,'MOIS_COTISATION'=>$MOIS_COTISATION,'USER_SAVER'=>$USER_ID));

    $message = "<div class='alert alert-success' id='message'>
    Frais d'adhesion enregistr&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('cotisation/Configuration_Cotisation'));    
  }
}



public function add_frais_carte()
{
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_GROUPE=$this->input->post('ID_GROUPE');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $Nombre=$this->input->post('NOMBRE');
  $MOIS_COTISATION=$this->input->post('MOIS_COTISATION');
  $USER_ID=$this->session->userdata('MIS_ID_USER');

  $MONTANT=$MONTANT_COTISATION*$Nombre;

  $this->form_validation->set_rules('MONTANT_COTISATION', 'Montant', 'required');
  $this->form_validation->set_rules('ID_GROUPE', 'Groupe', 'required');
  $this->form_validation->set_rules('ID_CATEGORIE_COTISATION', 'categorie', 'required');
  $this->form_validation->set_rules('NOMBRE', 'Nombre', 'required');
  $this->form_validation->set_rules('MOIS_COTISATION', 'Mois de cotisation', 'required');

  if ($this->form_validation->run() == FALSE) {
    $data['title']='Configuration Cotisation';
    $data['stitle']='Configuration Cotisation';

    $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


    $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

    $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');

    $message = "<div class='alert alert-danger' id='message'>
    Enregistement des frais de confection des cartes  a echoué
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));

    $this->load->view('Configuration_Cotisation_Add_View',$data);
  } else {

    $this->Model->create('cotisation_frais_cartes_new',array('PRIX_UNITAIRE'=>$MONTANT_COTISATION,'MONTANT_COTISATION'=>$MONTANT,'ID_GROUPE'=>$ID_GROUPE,'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_COTISATION,'NOMBRE'=>$Nombre,'MOIS_COTISATION'=>$MOIS_COTISATION,'USER_SAVER'=>$USER_ID));

    $message = "<div class='alert alert-success' id='message'>
    Frais de confection des cartes enregistr&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('cotisation/Configuration_Cotisation'));    
  }    

}

public function liste()
{


$mois= $this->input->post('MOIS');
$ID_GROUPE= $this->input->post('ID_GROUPE');

$CRIT='';
if (!empty($mois)) {
 $CRIT.=' AND MOIS_COTISATION='.$mois.' ';
}


if (!empty($ID_GROUPE)) {
 $CRIT.=' AND cotisation_cotisation_new.ID_GROUPE='.$ID_GROUPE.' ';
}

 

 $query_principal='SELECT cotisation_cotisation_new.ID_COTISATION,cotisation_cotisation_new.PRIX_UNITAIRE,cotisation_cotisation_new.`MOIS_COTISATION`,cotisation_cotisation_new.`ID_GROUPE`,cotisation_cotisation_new.`ID_CATEGORIE_ASSURANCE`,membre_groupe.NOM_GROUPE,syst_categorie_assurance.DESCRIPTION,cotisation_cotisation_new.MONTANT_COTISATION,cotisation_cotisation_new.NOMBRE FROM `cotisation_cotisation_new` join membre_groupe on cotisation_cotisation_new.ID_GROUPE=membre_groupe.ID_GROUPE join syst_categorie_assurance on cotisation_cotisation_new.ID_CATEGORIE_ASSURANCE=syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE 1 '.$CRIT.'';


 $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $limit = 'LIMIT 0,10';
 if ($_POST['length'] != -1) {
  $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
}

$order_column=array("cotisation_cotisation_new.ID_COTISATION");

$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY membre_groupe.NOM_GROUPE  ASC';

$search = !empty($_POST['search']['value']) ? (' AND (  membre_groupe.NOM_GROUPE LIKE "%' . $var_search . '%" or cotisation_cotisation_new.MONTANT_COTISATION LIKE "%' . $var_search . '%" or syst_categorie_assurance.DESCRIPTION LIKE "%' . $var_search . '%" or cotisation_cotisation_new.`MOIS_COTISATION` LIKE "%' . $var_search . '%" )') :'';

$critaire = '';

$groupby='';

$query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
$query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
$resultat = $this->Model->datatable($query_secondaire);


$tabledata=array();

foreach ($resultat as $key) 
{

  $chambr=array();


  $PRIX_UNITAIRE=$key->PRIX_UNITAIRE;

  $chambr[]=$key->ID_COTISATION; 
  $chambr[]='<div class="text-right">'.$key->NOM_GROUPE.'</div>';
  $chambr[]='<div class="text-right">'.$key->MOIS_COTISATION.'</div>';
  $chambr[]='<div class="text-right">'.$key->DESCRIPTION.'</div>';;
  $chambr[]='<div class="text-right">'.number_format($key->NOMBRE,0,","," ").'</div>';

  $chambr[]='<div class="text-right">'.number_format($PRIX_UNITAIRE,0,","," ").'</div>';
  $chambr[]='<div class="text-right">'.number_format($key->MONTANT_COTISATION,0,","," ").'</div>';


  $chambr[]='<div class="modal fade" id="deletecot'.$key->ID_COTISATION.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Liste des Medicaments pris</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
             <h3> Voulez-vous vraiment effectuer la suppression ?</h3>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                 <a class="btn btn-danger btn-md" href="'.base_url('cotisation/Configuration_Cotisation/delete_cot/'.$key->ID_COTISATION).'">Oui</a>
                
              </div>
            </div>
          </div>
        </div>





  <div class="dropdown ">
  <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
  <span class="caret"></span></a>
  <ul class="dropdown-menu dropdown-menu-right">
  <li><a class="dropdown-item" target="__blank" href="'.base_url('cotisation/Facture_pdf_cotisation_mensuellle/charge_pdf/'.$key->ID_COTISATION.'').'">Facture </a> </li>
  <li><a class="dropdown-item"  href="'.base_url('cotisation/Configuration_Cotisation/index_update/'.$key->ID_COTISATION.'').'">Modifier </a> </li>
   <li><a class="dropdown-item" data-toggle="modal" data-target="#deletecot'.$key->ID_COTISATION.'" href="#"> Supprimer</a> </li>
  </ul>
  </div>';

  $tabledata[]=$chambr;

}



$output = array(
 "draw" => intval($_POST['draw']),
 "recordsTotal" => $this->Model->all_data($query_principal),
 "recordsFiltered" => $this->Model->filtrer($query_filter),
 "data" => $tabledata
);
echo json_encode($output);

}




public function liste_adhesion()
{

 $mois= $this->input->post('MOIS');
$ID_GROUPE= $this->input->post('ID_GROUPE');

$CRIT='';
if (!empty($mois)) {
 $CRIT.=' AND MOIS_COTISATION='.$mois.' ';
}


if (!empty($ID_GROUPE)) {
 $CRIT.=' AND cotisation_frais_adhesion_new.ID_GROUPE='.$ID_GROUPE.' ';
}

 $query_principal='SELECT cotisation_frais_adhesion_new.ID_COTISATION_ADHESION,cotisation_frais_adhesion_new.PRIX_UNITAIRE,cotisation_frais_adhesion_new.`MOIS_COTISATION`,cotisation_frais_adhesion_new.`ID_GROUPE`,cotisation_frais_adhesion_new.`ID_CATEGORIE_ASSURANCE`,membre_groupe.NOM_GROUPE,syst_categorie_assurance.DESCRIPTION,cotisation_frais_adhesion_new.MONTANT_COTISATION,cotisation_frais_adhesion_new.NOMBRE FROM `cotisation_frais_adhesion_new` join membre_groupe on cotisation_frais_adhesion_new.ID_GROUPE=membre_groupe.ID_GROUPE join syst_categorie_assurance on cotisation_frais_adhesion_new.ID_CATEGORIE_ASSURANCE=syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE 1 '.$CRIT.'';

 $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $limit = 'LIMIT 0,10';
 if ($_POST['length'] != -1) {
  $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
}

$order_column=array("cotisation_frais_adhesion_new.ID_COTISATION_ADHESION");

$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY membre_groupe.NOM_GROUPE  ASC';

$search = !empty($_POST['search']['value']) ? (' AND (  membre_groupe.NOM_GROUPE LIKE "%' . $var_search . '%" or cotisation_frais_adhesion_new.MONTANT_COTISATION LIKE "%' . $var_search . '%" or syst_categorie_assurance.DESCRIPTION LIKE "%' . $var_search . '%" or cotisation_frais_adhesion_new.`MOIS_COTISATION` LIKE "%' . $var_search . '%" )') :'';

$critaire = '';

$groupby='';

$query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
$query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
$resultat = $this->Model->datatable($query_secondaire);


$tabledata=array();

foreach ($resultat as $key) 
{

  $chambr=array();


  $PRIX_UNITAIRE=$key->PRIX_UNITAIRE;

  $chambr[]=$key->ID_COTISATION_ADHESION; 
  $chambr[]='<div class="text-right">'.$key->NOM_GROUPE.'</div>';
  $chambr[]='<div class="text-right">'.$key->MOIS_COTISATION.'</div>';
  $chambr[]='<div class="text-right">'.$key->DESCRIPTION.'</div>';;
  $chambr[]='<div class="text-right">'.number_format($key->NOMBRE,0,","," ").'</div>';

  $chambr[]='<div class="text-right">'.number_format($PRIX_UNITAIRE,0,","," ").'</div>';
  $chambr[]='<div class="text-right">'.number_format($key->MONTANT_COTISATION,0,","," ").'</div>';


  $chambr[]='
  <div class="modal fade" id="deletead'.$key->ID_COTISATION_ADHESION.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Liste des cotisations</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
             <h3> Voulez-vous vraiment effectuer la suppression ?</h3>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                 <a class="btn btn-danger btn-md" href="'.base_url('cotisation/Configuration_Cotisation/delete_ad/'.$key->ID_COTISATION_ADHESION).'">Oui</a>
                
              </div>
            </div>
          </div>
        </div>

  <div class="dropdown ">
  <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
  <span class="caret"></span></a>
  <ul class="dropdown-menu dropdown-menu-right">
  
  <li><a class="dropdown-item"  href="'.base_url('cotisation/Configuration_Cotisation/index_update_adhesion/'.$key->ID_COTISATION_ADHESION.'').'">Modifier </a> </li>

   <li><a class="dropdown-item" data-toggle="modal" data-target="#deletead'.$key->ID_COTISATION_ADHESION.'" href="#"> Supprimer</a> </li>

  </ul>
  </div>';

  $tabledata[]=$chambr;

}



$output = array(
 "draw" => intval($_POST['draw']),
 "recordsTotal" => $this->Model->all_data($query_principal),
 "recordsFiltered" => $this->Model->filtrer($query_filter),
 "data" => $tabledata
);
echo json_encode($output);

}


public function liste_carte()
{


$mois= $this->input->post('MOIS');
$ID_GROUPE= $this->input->post('ID_GROUPE');

$CRIT='';
if (!empty($mois)) {
 $CRIT.=' AND MOIS_COTISATION='.$mois.' ';
}


if (!empty($ID_GROUPE)) {
 $CRIT.=' AND cotisation_frais_cartes_new.ID_GROUPE='.$ID_GROUPE.' ';
}

 $query_principal='SELECT cotisation_frais_cartes_new.ID_COTISATION_CARTES,cotisation_frais_cartes_new.PRIX_UNITAIRE,cotisation_frais_cartes_new.`MOIS_COTISATION`,cotisation_frais_cartes_new.`ID_GROUPE`,cotisation_frais_cartes_new.`ID_CATEGORIE_ASSURANCE`,membre_groupe.NOM_GROUPE,syst_categorie_assurance.DESCRIPTION,cotisation_frais_cartes_new.MONTANT_COTISATION,cotisation_frais_cartes_new.NOMBRE FROM `cotisation_frais_cartes_new` join membre_groupe on cotisation_frais_cartes_new.ID_GROUPE=membre_groupe.ID_GROUPE join syst_categorie_assurance on cotisation_frais_cartes_new.ID_CATEGORIE_ASSURANCE=syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE 1 '.$CRIT.'';


 $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $limit = 'LIMIT 0,10';
 if ($_POST['length'] != -1) {
  $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
}

$order_column=array("cotisation_frais_cartes_new.ID_COTISATION_CARTES");

$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY membre_groupe.NOM_GROUPE  ASC';

$search = !empty($_POST['search']['value']) ? (' AND (  membre_groupe.NOM_GROUPE LIKE "%' . $var_search . '%" or cotisation_frais_cartes_new.MONTANT_COTISATION LIKE "%' . $var_search . '%" or syst_categorie_assurance.DESCRIPTION LIKE "%' . $var_search . '%" or cotisation_frais_cartes_new.`MOIS_COTISATION` LIKE "%' . $var_search . '%" )') :'';

$critaire = '';

$groupby='';

$query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
$query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
$resultat = $this->Model->datatable($query_secondaire);


$tabledata=array();

foreach ($resultat as $key) 
{

  $chambr=array();


  $PRIX_UNITAIRE=$key->PRIX_UNITAIRE;

  $chambr[]=$key->ID_COTISATION_CARTES; 
  $chambr[]='<div class="text-right">'.$key->NOM_GROUPE.'</div>';
  $chambr[]='<div class="text-right">'.$key->MOIS_COTISATION.'</div>';
  $chambr[]='<div class="text-right">'.$key->DESCRIPTION.'</div>';;
  $chambr[]='<div class="text-right">'.number_format($key->NOMBRE,0,","," ").'</div>';

  $chambr[]='<div class="text-right">'.number_format($PRIX_UNITAIRE,0,","," ").'</div>';
  $chambr[]='<div class="text-right">'.number_format($key->MONTANT_COTISATION,0,","," ").'</div>';


  $chambr[]='
   <div class="modal fade" id="deletecart'.$key->ID_COTISATION_CARTES.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Liste des cotisations</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
             <h3> Voulez-vous vraiment effectuer la suppression ?</h3>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                 <a class="btn btn-danger btn-md" href="'.base_url('cotisation/Configuration_Cotisation/delete_cart/'.$key->ID_COTISATION_CARTES).'">Oui</a>
                
              </div>
            </div>
          </div>
        </div>

  <div class="dropdown ">
  <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
  <span class="caret"></span></a>
  <ul class="dropdown-menu dropdown-menu-right">
  <li><a class="dropdown-item"  href="'.base_url('cotisation/Configuration_Cotisation/index_update_carte/'.$key->ID_COTISATION_CARTES.'').'">Modifier </a> </li>

  <li><a class="dropdown-item" data-toggle="modal" data-target="#deletecart'.$key->ID_COTISATION_CARTES.'" href="#"> Supprimer</a> </li>
  </ul>
  </div>';

  $tabledata[]=$chambr;

}



$output = array(
 "draw" => intval($_POST['draw']),
 "recordsTotal" => $this->Model->all_data($query_principal),
 "recordsFiltered" => $this->Model->filtrer($query_filter),
 "data" => $tabledata
);
echo json_encode($output);

}



public function index_update($id)
{
      // echo "In dev";
  $data['title']='Configuration Cotisation';
  $data['stitle']='Configuration Cotisation';
  $data['cotisation'] = $this->Model->getRequeteOne('SELECT * FROM `cotisation_cotisation_new` WHERE ID_COTISATION = '.$id.''); 
  $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION');  

  $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


  $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

  $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');
  $this->load->view('Configuration_Cotisation_Update_View',$data);
}


public function update()
{
  $ID_COTISATION=$this->input->post('ID_COTISATION');
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_GROUPE=$this->input->post('ID_GROUPE');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $Nombre=$this->input->post('NOMBRE');
  $PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  $USER_ID=$this->session->userdata('MIS_ID_USER');
  $AYANT_DROIT=$this->input->post('AYANT_DROIT');

  $MONTANT=$MONTANT_COTISATION*$Nombre;

  $this->form_validation->set_rules('MONTANT_COTISATION', 'Montant', 'required');
  $this->form_validation->set_rules('ID_GROUPE', 'Groupe', 'required');
  $this->form_validation->set_rules('ID_CATEGORIE_COTISATION', 'categorie', 'required');
  $this->form_validation->set_rules('NOMBRE', 'Nombre', 'required');
  $this->form_validation->set_rules('ID_PERIODE_COTISATION', 'Mois de cotisation', 'required');
  if ($this->form_validation->run() == FALSE) {
    $data['title']='Configuration Cotisation';
    $data['stitle']='Configuration Cotisation';

    $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


    $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

    $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');

    $message = "<div class='alert alert-danger' id='message'>
    Enregistement des cotisations a echoué
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));

    $this->load->view('Configuration_Cotisation_Update_View',$data);
  } else {

    $this->Model->update('cotisation_cotisation_new',array('ID_COTISATION'=>$ID_COTISATION),array('PRIX_UNITAIRE'=>$MONTANT_COTISATION,'MONTANT_COTISATION'=>$MONTANT,'ID_GROUPE'=>$ID_GROUPE,'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_COTISATION,'NOMBRE'=>$Nombre,'MOIS_COTISATION'=>$PERIODE_COTISATION,'AYANT_DROIT'=>$AYANT_DROIT,'USER_SAVER'=>$USER_ID));

    $message = "<div class='alert alert-success' id='message'>
    Cotisation enregistr&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('cotisation/Configuration_Cotisation/listing'));    
  }  

}



public function index_update_adhesion($id)
{
      // echo "In dev";
  $data['title']='Configuration Cotisation';
  $data['stitle']='Configuration Cotisation';
  $data['cotisation'] = $this->Model->getRequeteOne('SELECT * FROM `cotisation_frais_adhesion_new` WHERE ID_COTISATION_ADHESION = '.$id.''); 
  $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION');  
  $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 
  $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 
  $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');
  $this->load->view('Configuration_Cotisation_Update_Adhesion_View',$data);
}


public function update_adhesion()
{

  $ID_COTISATION_ADHESION=$this->input->post('ID_COTISATION_ADHESION');
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_GROUPE=$this->input->post('ID_GROUPE');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $Nombre=$this->input->post('NOMBRE');
  $PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  $USER_ID=$this->session->userdata('MIS_ID_USER');


  $MONTANT=$MONTANT_COTISATION*$Nombre;

  $this->form_validation->set_rules('MONTANT_COTISATION', 'Montant', 'required');
  $this->form_validation->set_rules('ID_GROUPE', 'Groupe', 'required');
  $this->form_validation->set_rules('ID_CATEGORIE_COTISATION', 'categorie', 'required');
  $this->form_validation->set_rules('NOMBRE', 'Nombre', 'required');
  $this->form_validation->set_rules('ID_PERIODE_COTISATION', 'Mois de cotisation', 'required');
  if ($this->form_validation->run() == FALSE) {
   $data['title']='Configuration Cotisation';
   $data['stitle']='Configuration Cotisation';
   $data['cotisation'] = $this->Model->getRequeteOne('SELECT * FROM `cotisation_frais_adhesion_new` WHERE ID_COTISATION_ADHESION = '.$id.''); 
   $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION');  
   $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 
   $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 
   $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');

   
   $message = "<div class='alert alert-danger' id='message'>
   Enregistement des cotisations a echoué
   <button type='button' class='close' data-dismiss='alert'>&times;</button>
   </div>";
   $this->session->set_flashdata(array('message'=>$message));
   $this->load->view('Configuration_Cotisation_Update_Adhesion_View',$data);
 } else {

  $this->Model->update('cotisation_frais_adhesion_new',array('ID_COTISATION_ADHESION'=>$ID_COTISATION_ADHESION),array('PRIX_UNITAIRE'=>$MONTANT_COTISATION,'MONTANT_COTISATION'=>$MONTANT,'ID_GROUPE'=>$ID_GROUPE,'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_COTISATION,'NOMBRE'=>$Nombre,'MOIS_COTISATION'=>$PERIODE_COTISATION,'USER_SAVER'=>$USER_ID));

  $message = "<div class='alert alert-success' id='message'>
  Cotisation enregistr&eacute; avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('cotisation/Configuration_Cotisation/listing'));    
}  

}



public function index_update_carte($id)
{
      // echo "In dev";
  $data['title']='Configuration Cotisation';
  $data['stitle']='Configuration Cotisation';
  $data['cotisation'] = $this->Model->getRequeteOne('SELECT * FROM `cotisation_frais_cartes_new` WHERE ID_COTISATION_CARTES = '.$id.''); 
  $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION');  

  $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


  $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

  $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');
  $this->load->view('Configuration_Cotisation_Update_Cartes_View',$data);
}


public function update_carte()
{
  $ID_COTISATION_CARTES=$this->input->post('ID_COTISATION_CARTES');
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_GROUPE=$this->input->post('ID_GROUPE');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $Nombre=$this->input->post('NOMBRE');
  $PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  $USER_ID=$this->session->userdata('MIS_ID_USER');

  $MONTANT=$MONTANT_COTISATION*$Nombre;

  $this->form_validation->set_rules('MONTANT_COTISATION', 'Montant', 'required');
  $this->form_validation->set_rules('ID_GROUPE', 'Groupe', 'required');
  $this->form_validation->set_rules('ID_CATEGORIE_COTISATION', 'categorie', 'required');
  $this->form_validation->set_rules('NOMBRE', 'Nombre', 'required');
  $this->form_validation->set_rules('ID_PERIODE_COTISATION', 'Mois de cotisation', 'required');
  if ($this->form_validation->run() == FALSE) {
    $data['title']='Configuration Cotisation';
    $data['stitle']='Configuration Cotisation';
    $data['cotisation'] = $this->Model->getRequeteOne('SELECT * FROM `cotisation_frais_cartes_new` WHERE ID_COTISATION_CARTES = '.$id.''); 
    $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION');  

    $data['groupe'] = $this->Model->getListOrdertwo('membre_groupe',array(),'NOM_GROUPE'); 


    $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 

    $data['categorie'] = $this->Model->getRequete('SELECT `ID_CATEGORIE_ASSURANCE`,`DESCRIPTION` FROM `syst_categorie_assurance` GROUP BY DESCRIPTION');

    $message = "<div class='alert alert-danger' id='message'>
    Enregistement des cotisations a echoué
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));

    $this->load->view('Configuration_Cotisation_Update_Cartes_View',$data);
  } else {

    $this->Model->update('cotisation_frais_cartes_new',array('ID_COTISATION_CARTES'=>$ID_COTISATION_CARTES),array('PRIX_UNITAIRE'=>$MONTANT_COTISATION,'MONTANT_COTISATION'=>$MONTANT,'ID_GROUPE'=>$ID_GROUPE,'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_COTISATION,'NOMBRE'=>$Nombre,'MOIS_COTISATION'=>$PERIODE_COTISATION,'USER_SAVER'=>$USER_ID));

    $message = "<div class='alert alert-success' id='message'>
    Cotisation enregistr&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('cotisation/Configuration_Cotisation/listing'));    
  }  

}


public function desactiver($id)
{
  $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$id),array('IS_ACTIF'=>0));
  $message = "<div class='alert alert-success' id='message'>
  Cotisation désactivé avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('cotisation/Configuration_Cotisation/listing'));
}

public function delete_cot($id)
{
  $this->Model->delete('cotisation_cotisation_new',array('ID_COTISATION'=>$id));
  $message = "<div class='alert alert-danger' id='message'>
  Cotisation supprimé avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('cotisation/Configuration_Cotisation/listing'));
}

public function delete_ad($id)
{
  $this->Model->delete('cotisation_frais_adhesion_new',array('ID_COTISATION_ADHESION'=>$id));
  $message = "<div class='alert alert-danger' id='message'>
  Frais adhésion supprimé avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('cotisation/Configuration_Cotisation/listing'));
}

public function delete_cart($id)
{
  $this->Model->delete('cotisation_frais_cartes_new',array('ID_COTISATION_CARTES'=>$id));
  $message = "<div class='alert alert-danger' id='message'>
  Frais carte supprimé avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('cotisation/Configuration_Cotisation/listing'));
}


public function reactiver($id)
{
  $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$id),array('IS_ACTIF'=>1));
  $message = "<div class='alert alert-success' id='message'>
  Cotisation Réactivé avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('cotisation/Configuration_Cotisation/listing')); 
}


}
?>