<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Liste_Medicament_Pharmacie extends CI_Controller
{
	
	function __construct()
	{
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


 public function index($value='')
 {

  $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_medicament');

  $data['STATUS_PAIEMENT']=0;

  $ANNEE = date('Y');
  $data['YEAR'] = $ANNEE; 

  $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';

  $totals=$this->Model->getRequeteOne('SELECT COUNT(consultation_medicament.ID_CONSULTATION_MEDICAMENT) AS NOMBRE, SUM(consultation_medicament.MONTANT_TOTAL_ACHAT) AS MONTANT_TOTAL_ACHAT, SUM(MONTANT_A_PAYE_MIS) AS MONTANT_MIS FROM `consultation_medicament` JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE  WHERE 1 AND  consultation_medicament.STATUS_PAIEMENT = 0  '.$critaire );

  $data['TOTAL'] = 'TOTAL: '.$totals['NOMBRE'];

  $data['title'] = " Medicament";
  $data['stitle']=' Medicament';

  $this->load->view('Liste_Medicament_Pharmacie_List_View',$data);

}


public function liste()
{

  $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_medicament');

  $ANNEE=$this->input->post('ANNEE');
  $STATUS_PAIEMENT=$this->input->post('STATUS_PAIEMENT');
  $MOIS=$this->input->post('MOIS');


  $crit=" AND consultation_medicament.STATUS_PAIEMENT = ".$STATUS_PAIEMENT."";



  if (!empty($ANNEE)) {

    $critaire= ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
  }   
  else{
    $ANNEE = date('Y');

    $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
  }

  if (!empty($MOIS)) {

    $critaire= ' AND DATE_FORMAT(DATE_CONSULTATION,"%m") Like "%'.$MOIS.'%"';
  }   
  else{
    $MOIS = date('m');

    $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%m") Like "%'.$MOIS.'%"';
  }



  $query_principal='SELECT DISTINCT(consultation_pharmacie.DESCRIPTION) AS PHARMACIE, consultation_pharmacie.ID_PHARMACIE, COUNT(consultation_medicament.ID_CONSULTATION_MEDICAMENT) AS NOMBRE, SUM(consultation_medicament.MONTANT_TOTAL_ACHAT) AS MONTANT_TOTAL_ACHAT, SUM(MONTANT_A_PAYE_MIS) AS MONTANT_MIS FROM `consultation_medicament` JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE WHERE 1 '.$critaire .' '.$crit.'  GROUP BY consultation_pharmacie.DESCRIPTION, consultation_pharmacie.ID_PHARMACIE';


  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
  $limit = 'LIMIT 0,10';
  if ($_POST['length'] != -1) {
    $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
  }

  $order_column=array("consultation_pharmacie.DESCRIPTION");

  $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY consultation_pharmacie.ID_PHARMACIE  ASC';

  $search = !empty($_POST['search']['value']) ? (' AND consultation_pharmacie.DESCRIPTION LIKE "%' . $var_search . '%")') :'';

  $critaire = '';

  $groupby='';

  $query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
  $query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
  $resultat = $this->Model->datatable($query_secondaire);



  
  $tabledata=array();

  foreach ($resultat as $key) 
  {

    $chambr=array();

    $listes=$this->Model->getRequete('SELECT membre_membre.NOM, membre_membre.PRENOM, IF(aff.CODE_PARENT IS NULL, membre_membre.NOM, aff.NOM) AS ANOM, IF(aff.CODE_PARENT IS NULL, membre_membre.PRENOM, aff.PRENOM) AS APRENOM, DATE_CONSULTATION, NUM_BORDERAUX, DESCRIPTION, MONTANT_UNITAIRE_SANS_TAUX AS PU, QUANTITE, consultation_medicament_details.POURCENTAGE, membre_groupe.NOM_GROUPE, consultation_medicament.ID_CONSULTATION_MEDICAMENT, (consultation_medicament_details.QUANTITE * consultation_medicament_details.MONTANT_UNITAIRE_SANS_TAUX) AS PT, (consultation_medicament_details.QUANTITE * consultation_medicament_details.MONTANT_UNITAIRE_SANS_TAUX) * POURCENTAGE / 100 AS PRIX_MIS FROM `consultation_medicament` JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_medicament.ID_MEMBRE JOIN consultation_medicament_details ON consultation_medicament_details.ID_CONSULTATION_MEDICAMENT = consultation_medicament.ID_CONSULTATION_MEDICAMENT JOIN masque_medicament ON masque_medicament.ID_MEDICAMENT = consultation_medicament_details.ID_MEDICAMENT JOIN membre_membre aff ON aff.ID_MEMBRE = membre_membre.CODE_PARENT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE JOIN membre_groupe ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE WHERE 1  '.$critaire .' '.$crit.' AND ID_PHARMACIE = '.$key->ID_PHARMACIE.' ');

    $nombre=count($listes);

    $chambr[]=$key->PHARMACIE; 
    $chambr[]='<div class="text-right">'.number_format($nombre,0,","," ").'</div>';
    $chambr[]='<div class="text-right">'.number_format($key->MONTANT_TOTAL_ACHAT,0,","," ").'</div>';
    $chambr[]='<div class="text-right">'.number_format($key->MONTANT_MIS,0,","," ").'</div>';
    $chambr[]='<div class="text-right">'.number_format($key->MONTANT_TOTAL_ACHAT - $key->MONTANT_MIS,0,","," ").'</div>';
    $chambr[]=$ANNEE;
    $chambr[]=$MOIS;
    $chambr[]='
    <div class="dropdown ">
    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
    <span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right">
    <li><a class="dropdown-item" href="#" onclick="get_detail_histo('.$key->ID_PHARMACIE.')"> Apercus </a> </li>
    <li><a class="dropdown-item" href="'.base_url('consultation/Liste_Medicament_Pharmacie/details/'.$key->ID_PHARMACIE.'/'.$ANNEE.'/0').'">Paiements </a> </li>

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

public function details($id,$critaire,$status)
{

  $data['title']=' Medicament ';
  $data['stitle']=' Medicament ';


  $data['list']=$this->Model->getRequete('SELECT consultation_medicament.ID_CONSULTATION_MEDICAMENT, NOM, PRENOM, DATE_CONSULTATION, NUM_BORDERAUX, consultation_medicament.MONTANT_TOTAL_ACHAT, consultation_medicament.MONTANT_A_PAYE_MIS FROM `consultation_medicament` JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_medicament.ID_MEMBRE WHERE 1 AND DATE_CONSULTATION LIKE "'.$critaire.'%" AND STATUS_PAIEMENT = '.$status.' AND ID_PHARMACIE = '.$id.' ');
  $tot=$this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_CONSULTATION) AS MONTANT_CONSULTATION, SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT_A_PAYER, COUNT(*) AS TOTAL FROM `consultation_consultation` JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_consultation.ID_MEMBRE WHERE 1 AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$critaire.'%" AND consultation_consultation.STATUS_PAIEMENT = '.$status.' AND ID_STRUCTURE = '.$id.'');



  $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_medicament');
  $data['TOTAL']=$tot['TOTAL'];
  $data['ANNEE']=$critaire;
  
  $this->load->view('Liste_Medicament_Pharmacie_Details_View',$data);
}

public function listing()
{
 $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_medicament');

 $data['STATUS_PAIEMENT']=1;

 $ANNEE = date('Y');
 $data['YEAR'] = $ANNEE;

 $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';

 $totals=$this->Model->getRequeteOne('SELECT COUNT(consultation_medicament.ID_CONSULTATION_MEDICAMENT) AS NOMBRE, SUM(consultation_medicament.MONTANT_TOTAL_ACHAT) AS MONTANT_TOTAL_ACHAT, SUM(MONTANT_A_PAYE_MIS) AS MONTANT_MIS FROM `consultation_medicament` JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE  WHERE 1 AND  consultation_medicament.STATUS_PAIEMENT = 1  '.$critaire );

 $data['TOTAL'] = 'TOTAL: '.$totals['NOMBRE'];

 $data['title'] = " Medicament";
 $data['stitle']=' Medicament';

 $this->load->view('Liste_Medicament_Pharmacie_List_View',$data);

}


public function paiement()
{
  if ($this->input->post('ID_CONSULTATION_MEDICAMENT_DETAILS') != NULL) {
    $ID_CONSULTATION_MEDICAMENT_DETAILS = $this->input->post('ID_CONSULTATION_MEDICAMENT_DETAILS');
    $arraySansDoublon = [];
    foreach ($ID_CONSULTATION_MEDICAMENT_DETAILS as $optionID) {
      $cons=$this->Model->getRequeteOne('SELECT ID_CONSULTATION_MEDICAMENT FROM `consultation_medicament_details` WHERE  ID_CONSULTATION_MEDICAMENT_DETAILS = '.$optionID.'  ');
      $this->Model->update('consultation_medicament_details',array('ID_CONSULTATION_MEDICAMENT_DETAILS'=>$optionID),array('STATUS_MEDICAMENT'=>1));

            // Traitez l'ID de la case à cocher sélectionnée
            // echo "Case à cocher sélectionnée : " . $optionID . "- ".$cons['ID_CONSULTATION_MEDICAMENT']."<br>";
      if (!in_array($cons['ID_CONSULTATION_MEDICAMENT'], $arraySansDoublon)) {
        $arraySansDoublon[] = $cons['ID_CONSULTATION_MEDICAMENT'];
      }
    }

        // print_r($arraySansDoublon);
        // echo'<br>';
    $inClause = implode(", ", $arraySansDoublon);
        // echo $inClause;
        // echo'<br>';
    $medicament=$this->Model->getRequete('SELECT ID_CONSULTATION_MEDICAMENT FROM `consultation_medicament` WHERE ID_CONSULTATION_MEDICAMENT IN ('.$inClause.')');

    foreach ($medicament as $kvalue) {
      $det=$this->Model->getRequeteOne('SELECT COUNT(ID_CONSULTATION_MEDICAMENT_DETAILS) as nombre FROM `consultation_medicament_details` WHERE STATUS_MEDICAMENT = 0 AND ID_CONSULTATION_MEDICAMENT = '.$kvalue['ID_CONSULTATION_MEDICAMENT'].' ');

      if ($det['nombre']==0) {
        $this->Model->update('consultation_medicament',array('ID_CONSULTATION_MEDICAMENT'=>$kvalue['ID_CONSULTATION_MEDICAMENT']),array('STATUS_PAIEMENT'=>1));
      }
      else{

        $newdet=$this->Model->getRequeteOne('SELECT COUNT(ID_CONSULTATION_MEDICAMENT_DETAILS) as nombre FROM `consultation_medicament_details` WHERE STATUS_MEDICAMENT = 1 AND ID_CONSULTATION_MEDICAMENT = '.$kvalue['ID_CONSULTATION_MEDICAMENT'].' ');

        if ($newdet['nombre']!=0) {

          $this->Model->update('consultation_medicament',array('ID_CONSULTATION_MEDICAMENT'=>$kvalue['ID_CONSULTATION_MEDICAMENT']),array('STATUS_PAIEMENT'=>2));

        }
      }


    }

  }


  $message = "<div class='alert alert-success' id='message'>
  Enregistr&eacute; avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('consultation/Liste_Medicament_Pharmacie'));    

}

public function listings()
{
 $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_medicament');

 $data['STATUS_PAIEMENT']=2;

 $ANNEE = date('Y');
 $data['YEAR'] = $ANNEE;
 $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';

 $totals=$this->Model->getRequeteOne('SELECT COUNT(consultation_medicament.ID_CONSULTATION_MEDICAMENT) AS NOMBRE, SUM(consultation_medicament.MONTANT_TOTAL_ACHAT) AS MONTANT_TOTAL_ACHAT, SUM(MONTANT_A_PAYE_MIS) AS MONTANT_MIS FROM `consultation_medicament` JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE  WHERE 1 AND  consultation_medicament.STATUS_PAIEMENT = 2  '.$critaire );

 $data['TOTAL'] = 'TOTAL: '.$totals['NOMBRE'];

 $data['title'] = " Medicament";
 $data['stitle']=' Medicament';

 $this->load->view('Liste_Medicament_Pharmacie_List_View',$data);
}

public function get_total($value='')
{
  $year=$this->input->post('YEAR');


  $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$year.'%"';
  $totals=$this->Model->getRequeteOne('SELECT COUNT(consultation_medicament.ID_CONSULTATION_MEDICAMENT) AS NOMBRE, SUM(consultation_medicament.MONTANT_TOTAL_ACHAT) AS MONTANT_TOTAL_ACHAT, SUM(MONTANT_A_PAYE_MIS) AS MONTANT_MIS FROM `consultation_medicament` JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE  WHERE 1 AND  consultation_medicament.STATUS_PAIEMENT = '.$this->input->post('STATUS_PAIEMENT').'  '.$critaire );

  $year= 'TOTAL: '.$totals['NOMBRE'];

  echo $year;
}



function details_histo(){

  $ID_PHARMACIE=$this->input->post('id');
  $query_principal='SELECT membre_membre.NOM, membre_membre.PRENOM, IF(aff.CODE_PARENT IS NULL, membre_membre.NOM, aff.NOM) AS ANOM, IF(aff.CODE_PARENT IS NULL, membre_membre.PRENOM, aff.PRENOM) AS APRENOM, DATE_CONSULTATION, NUM_BORDERAUX, DESCRIPTION, MONTANT_UNITAIRE_SANS_TAUX AS PU, QUANTITE, consultation_medicament_details.POURCENTAGE, membre_groupe.NOM_GROUPE, consultation_medicament.ID_CONSULTATION_MEDICAMENT, (consultation_medicament_details.QUANTITE * consultation_medicament_details.MONTANT_UNITAIRE_SANS_TAUX) AS PT, (consultation_medicament_details.QUANTITE * consultation_medicament_details.MONTANT_UNITAIRE_SANS_TAUX) * POURCENTAGE / 100 AS PRIX_MIS FROM `consultation_medicament` JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_medicament.ID_MEMBRE JOIN consultation_medicament_details ON consultation_medicament_details.ID_CONSULTATION_MEDICAMENT = consultation_medicament.ID_CONSULTATION_MEDICAMENT JOIN masque_medicament ON masque_medicament.ID_MEDICAMENT = consultation_medicament_details.ID_MEDICAMENT JOIN membre_membre aff ON aff.ID_MEMBRE = membre_membre.CODE_PARENT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE JOIN membre_groupe ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE WHERE 1  AND ID_PHARMACIE = '.$ID_PHARMACIE.' ';


  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
  $limit = 'LIMIT 0,10';
  if ($_POST['length'] != -1) {
    $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
  }

  $order_column=array("DESCRIPTION");

  $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY ID_PHARMACIE  ASC';

  $search = !empty($_POST['search']['value']) ? (' AND DESCRIPTION LIKE "%' . $var_search . '%")') :'';

  $critaire = '';

  $groupby='';

  $query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
  $query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
  $resultat = $this->Model->datatable($query_secondaire);

  $tabledata=array();

  foreach ($resultat as $key) 
  {

    $chambr=array();

    $chambr[]=$key->ANOM .''.$key->APRENOM; 
    $chambr[]=$key->NOM .''.$key->PRENOM; 
    $chambr[]=$key->DESCRIPTION;
    $chambr[]=date("d-m-Y", strtotime($key->DATE_CONSULTATION));
    $chambr[]=$key->NUM_BORDERAUX;
    $chambr[]='<div class="text-right">'.number_format($key->QUANTITE,0,","," ").'</div>';
    $chambr[]='<div class="text-right">'.number_format($key->PT,0,","," ").'</div>';
    $chambr[]='<div class="text-right">'.number_format($key->PRIX_MIS,0,","," ").'</div>';
    $chambr[]=$key->NOM_GROUPE;


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



}
?>