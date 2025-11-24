<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Consomation_Affilier extends CI_Controller
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

 public function index()
 {
  $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');

  $data['title'] = " Consomation";
  $data['stitle']=' Consomation';
  $data['IS_DEPLACEMENT']=0;
  $data['groupe'] = $this->Model->getList('membre_groupe');

  $this->load->view('Consultation_Liste_View',$data);
}
public function liste()
{
  $ANNEE=$this->input->post('ANNEE');
  $MOIS=$this->input->post('MOIS');
  $ID_GROUPE=$this->input->post('ID_GROUPE');

  $condi_anne = '';
  $condi_med = '';
  $condi_groupe = '';

// Vérification de l'année
  if (!empty($ANNEE)) {
    $condi_anne = ' AND YEAR(c.DATE_CONSULTATION) = "' . intval($ANNEE).'"';
    $condi_med = ' AND YEAR(cm.DATE_CONSULTATION) = "' . intval($ANNEE).'"';
    // Vérification du mois
    if (!empty($MOIS)) {
      $mois = str_pad(intval($MOIS), 2, '0', STR_PAD_LEFT); 
      $condi_anne = ' AND DATE_FORMAT(c.DATE_CONSULTATION, "%Y-%m") = "' . $ANNEE . '-' . $mois . '"';
      $condi_med = ' AND DATE_FORMAT(cm.DATE_CONSULTATION, "%Y-%m") = "' . $ANNEE . '-' . $mois . '"';
    }
  }else{
   $condi_anne = ' AND YEAR(c.DATE_CONSULTATION) = "' .intval(date('Y')).'" ';
   $condi_med = 'AND YEAR(cm.DATE_CONSULTATION) = "' . intval(date('Y')).'"';
   $ANNEE=intval(date('Y'));
 }

// Vérification du groupe
 if (!empty($ID_GROUPE)) {
  $condi_groupe = ' AND membre_groupe.ID_GROUPE = ' . intval($ID_GROUPE);
}

$query_principal=" SELECT membre_membre.ID_MEMBRE, NOM, PRENOM, membre_groupe.NOM_GROUPE,syst_categorie_assurance.* FROM `membre_membre` JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE JOIN membre_assurances ON membre_membre.ID_MEMBRE = membre_assurances.ID_MEMBRE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_assurances.ID_CATEGORIE_ASSURANCE WHERE `IS_AFFILIE` = 0 $condi_groupe ";


$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
$limit = 'LIMIT 0,10';
if ($_POST['length'] != -1) {
  $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
}

$order_column=array("NOM","PRENOM");

$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY membre_membre.ID_MEMBRE   ASC';

$search = !empty($_POST['search']['value']) ? (' AND (NOM LIKE "%' . $var_search . '%" OR PRENOM LIKE "%' . $var_search . '%")') :'';

$critaire = '';

$groupby='';

$query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
$query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
$resultat = $this->Model->datatable($query_secondaire);


$tabledata=array();


foreach ($resultat as $key) 
{

  $consultation_affilier=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION,membre_groupe.ID_GROUPE ,c.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE c.TYPE_AFFILIE ='.$key->ID_MEMBRE.' AND c.ID_MEMBRE ='.$key->ID_MEMBRE.'  '.$condi_anne.'  '.$condi_groupe.' ');

  $consultation_ayant=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION,membre_groupe.ID_GROUPE ,c.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE c.TYPE_AFFILIE ='.$key->ID_MEMBRE.' AND c.ID_MEMBRE !='.$key->ID_MEMBRE.' '.$condi_anne.' '.$condi_groupe.' ');

  $consultation_medicament_affilier=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments,COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT,membre_groupe.ID_GROUPE,cm.DATE_CONSULTATION FROM membre_membre m 
    LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE  cm.TYPE_AFFILIE ='.$key->ID_MEMBRE.' AND cm.ID_MEMBRE ='.$key->ID_MEMBRE.' '.$condi_med.' '.$condi_groupe.' ');

  $consultation_medicament_ayant=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments,COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT,membre_groupe.ID_GROUPE,cm.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE  cm.TYPE_AFFILIE = '.$key->ID_MEMBRE.' AND cm.ID_MEMBRE !='.$key->ID_MEMBRE.' '.$condi_med.' '.$condi_groupe.' ');



  $chambr=array();
  $M_CONSULTATION = $consultation_affilier['M_CONSULTATION'] + $consultation_ayant['M_CONSULTATION'];
  $M_MEDICAMENT = $consultation_medicament_affilier['M_MEDICAMENT'] + $consultation_medicament_ayant['M_MEDICAMENT'];
  $C_TOTAL = $M_CONSULTATION + $M_MEDICAMENT;
  // if (!empty($resultata)) {
  //   $M_CONSULTATION = $key->M_CONSULTATION + $resultata['M_CONSULTATION'];
  //   $M_MEDICAMENT = $key->M_MEDICAMENT + $resultata['M_MEDICAMENT'];
  //   $C_TOTAL = $key->C_TOTAL + $resultata['C_TOTAL'];
  // }



  $chambr[]=$key->NOM.' '.$key->PRENOM.''; 
  $chambr[]=$key->NOM_GROUPE; 
  $chambr[]='<div class="text-right">'.number_format($M_CONSULTATION,0,' ',' ').'</div>'; 
  $chambr[]='<div class="text-right">'.number_format($M_MEDICAMENT,0,' ',' ').'</div>';
  $chambr[]='<div class="text-right">'.number_format($C_TOTAL,0,' ',' ').'</div>';
  $chambr[]='<div class="text-right">'.number_format($key->PLAFOND_ANNUEL,0,' ',' ').'</div>';
  $chambr[]='<div class="dropdown ">
  <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
  <span class="caret"></span></a>
  <ul class="dropdown-menu dropdown-menu-right">

  <li><a class="dropdown-item" href="'.base_url('consultation/Consomation_Affilier/details/'.$key->ID_MEMBRE.'/'.$ANNEE.'').'"> D&eacute;tails </a> </li>
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

public function get_totals() {
  $ANNEE = $this->input->post('ANNEE');
  $MOIS = $this->input->post('MOIS');
  $ID_GROUPE = $this->input->post('ID_GROUPE');

  $condi_anne = '';
  $condi_groupe = '';

// Vérification de l'année
  if (!empty($ANNEE)) {
    $condi_anne = ' AND YEAR(DATE_CONSULTATION) = "' . intval($ANNEE).'"';
    
    // Vérification du mois
    if (!empty($MOIS)) {
      $mois = str_pad(intval($MOIS), 2, '0', STR_PAD_LEFT); 
      $condi_anne = ' AND DATE_FORMAT(DATE_CONSULTATION, "%Y-%m") = "' . $ANNEE . '-' . $mois . '"';
    }
  }else{
   $condi_anne = ' AND YEAR(DATE_CONSULTATION) = "' . intval(date('Y')).'"';
 }

// Vérification du groupe
 if (!empty($ID_GROUPE)) {
  $condi_groupe = ' AND mg.ID_GROUPE = ' . intval($ID_GROUPE).'';
}

$donne='
SELECT SUM(MONTANT_A_PAYER) AS MONTANT_A_PAYER_AF, mg.ID_GROUPE,DATE_CONSULTATION,mb.CODE_PARENT
FROM consultation_consultation cc 
JOIN membre_membre mb ON mb.ID_MEMBRE = cc.ID_MEMBRE 
JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = mb.ID_MEMBRE 
JOIN membre_groupe mg ON mg.ID_GROUPE = mgm.ID_GROUPE 
WHERE cc.ID_MEMBRE =cc.TYPE_AFFILIE ' . $condi_anne . ' ' . $condi_groupe;
// Requêtes pour les sommes
$sommeaff = $this->Model->getRequeteOne($donne);

$sommeayant = $this->Model->getRequeteOne('
  SELECT SUM(MONTANT_A_PAYER) AS MONTANT_A_PAYER_AYA , mg.ID_GROUPE,DATE_CONSULTATION
  FROM consultation_consultation cc 
  JOIN membre_membre mb ON mb.ID_MEMBRE = cc.ID_MEMBRE 
  JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = mb.ID_MEMBRE 
  JOIN membre_groupe mg ON mg.ID_GROUPE = mgm.ID_GROUPE 
  WHERE  cc.ID_MEMBRE !=cc.TYPE_AFFILIE ' . $condi_anne . ' ' . $condi_groupe
);

// Requête pour les sommes des médicaments
$sommeaffmed = $this->Model->getRequeteOne('
  SELECT SUM(MONTANT_A_PAYE_MIS) AS MONTANT_A_PAYER_AF_MED , mg.ID_GROUPE,DATE_CONSULTATION,mb.CODE_PARENT
  FROM consultation_medicament cc 
  JOIN membre_membre mb ON mb.ID_MEMBRE = cc.TYPE_AFFILIE 
  JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = mb.ID_MEMBRE 
  JOIN membre_groupe mg ON mg.ID_GROUPE = mgm.ID_GROUPE 
  WHERE cc.ID_MEMBRE =cc.TYPE_AFFILIE ' . $condi_anne . ' ' . $condi_groupe
);

$sommeayantmed = $this->Model->getRequeteOne('
  SELECT SUM(MONTANT_A_PAYE_MIS) AS MONTANT_A_PAYER_AYA_MED , mg.ID_GROUPE,DATE_CONSULTATION
  FROM consultation_medicament cc 
  JOIN membre_membre mb ON mb.ID_MEMBRE = cc.ID_MEMBRE 
  JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = mb.ID_MEMBRE 
  JOIN membre_groupe mg ON mg.ID_GROUPE = mgm.ID_GROUPE 
  WHERE cc.ID_MEMBRE !=cc.TYPE_AFFILIE ' . $condi_anne . ' ' . $condi_groupe
);

  // print_r($donne);exit();

$totalConsultation = $sommeaff['MONTANT_A_PAYER_AF'] + $sommeayant['MONTANT_A_PAYER_AYA'] ;
$totalMedicament = $sommeaffmed['MONTANT_A_PAYER_AF_MED'] + $sommeayantmed['MONTANT_A_PAYER_AYA_MED'] ;

$response = array(
  'totalConsultation' => $totalConsultation,
  'totalMedicament' => $totalMedicament,
  'totalAll' => $totalConsultation + $totalMedicament,
);

echo json_encode($response);
}


public function depacement()
{
  $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');

  $data['title'] = " Consomation";
  $data['stitle']=' Consomation';
  $data['IS_DEPLACEMENT']=1;


  $this->load->view('Consultation_Liste_View',$data);
}



public function depacementold()
{
  $ANNEE=$this->input->post('ANNEE');
  $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');
  $data['ANNEE']=$ANNEE;

  if (!empty($ANNEE)) {
    $ANNEE = $ANNEE;
    $data['ANNEE']=$ANNEE;
  }   
  else{
    $ANNEE = date('Y');
    $data['ANNEE']=date('Y');
  }


  $resultat=$this->Model->getRequete('SELECT m.ID_MEMBRE, m.NOM, m.PRENOM, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION, COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT, COALESCE(SUM(c.MONTANT_A_PAYER), 0) + COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS C_TOTAL, syst_categorie_assurance.PLAFOND_ANNUEL, syst_categorie_assurance.PLAFOND_COUVERTURE_HOSP_JOURS,syst_categorie_assurance.PLAFOND_LUNETTE, syst_categorie_assurance.PLAFOND_MONTURES, syst_categorie_assurance.PLAFOND_PROTHESES_DENTAIRES, syst_categorie_assurance.PLAFOND_PHARMACEUTICAL, syst_categorie_assurance.PLAFOND_CESARIENNE, syst_categorie_assurance.PLAFOND_SCANNER,membre_groupe.NOM_GROUPE FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE JOIN membre_assurances ON m.ID_MEMBRE = membre_assurances.ID_MEMBRE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_assurances.ID_CATEGORIE_ASSURANCE  JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE m.CODE_PARENT IS NULL AND (YEAR(c.DATE_CONSULTATION) = "'.$ANNEE.'" OR YEAR(cm.DATE_CONSULTATION) = "'.$ANNEE.'") AND membre_assurances.STATUS = 1 GROUP BY m.ID_MEMBRE, m.NOM, m.PRENOM, syst_categorie_assurance.PLAFOND_ANNUEL, syst_categorie_assurance.PLAFOND_COUVERTURE_HOSP_JOURS,syst_categorie_assurance.PLAFOND_LUNETTE, syst_categorie_assurance.PLAFOND_MONTURES, syst_categorie_assurance.PLAFOND_PROTHESES_DENTAIRES, syst_categorie_assurance.PLAFOND_PHARMACEUTICAL, syst_categorie_assurance.PLAFOND_CESARIENNE, syst_categorie_assurance.PLAFOND_SCANNER');

  $data['TOTAL'] = '-';
  
  $tabledata=array();

  foreach ($resultat as $key) 
  {

    $resultata=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION, COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT, COALESCE(SUM(c.MONTANT_A_PAYER), 0) + COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS TOTAL, COALESCE(SUM(c.MONTANT_A_PAYER), 0) + COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS C_TOTAL FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE WHERE m.CODE_PARENT = '.$key['ID_MEMBRE'].' AND (YEAR(c.DATE_CONSULTATION) = "'.$ANNEE.'" OR YEAR(cm.DATE_CONSULTATION) = "'.$ANNEE.'")  GROUP BY m.CODE_PARENT');

    $M_CONSULTATION = $key['M_CONSULTATION'] + $resultata['M_CONSULTATION'];
    $M_MEDICAMENT = $key['M_MEDICAMENT'] + $resultata['M_MEDICAMENT'];
    $C_TOTAL = $key['C_TOTAL'] + $resultata['C_TOTAL'];

    if ($C_TOTAL > $key['PLAFOND_ANNUEL']) {
      $chambr=array();

      $chambr[]=$key['NOM'].' '.$key['PRENOM'].''; 
      $chambr[]=$key['NOM_GROUPE']; 
      $chambr[]='<div class="text-right">'.number_format($M_CONSULTATION,0,' ',' ').'</div>'; 
      $chambr[]='<div class="text-right">'.number_format($M_MEDICAMENT,0,' ',' ').'</div>';
      $chambr[]='<div class="text-right">'.number_format($C_TOTAL,0,' ',' ').'</div>';
      $chambr[]='<div class="text-right">'.number_format($key['PLAFOND_ANNUEL'],0,' ',' ').'</div>';
      $chambr[]='<div class="dropdown ">
      <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
      <span class="caret"></span></a>
      <ul class="dropdown-menu dropdown-menu-right">                                                      
      <li><a class="dropdown-item" href="'.base_url('consultation/Consomation_Affilier/details/'.$key['ID_MEMBRE'].'/'.$ANNEE.'').'"> D&eacute;tails </a> </li>
      </ul>
      </div>';                          
      $tabledata[]=$chambr;

    }


  }

  $template = array(
    'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
    'table_close' => '</table>'
  );
  $this->table->set_template($template);
  $this->table->set_heading(array('Affili&eacute;','M Consultation','M Pharmacie','Total','Plafond',''));

  $data['title'] = " Consomation";
  $data['stitle']=' Consomation';
  $data['chamb']=$tabledata;
  $this->load->view('Consultation_Liste_View',$data);

}

public function details($ID_MEMBRE,$ANNEE)
{

 $details=$this->Model->getRequeteOne('SELECT NOM, PRENOM FROM membre_membre WHERE ID_MEMBRE = '.$ID_MEMBRE.'');

 $cconsultationa=$this->Model->getRequete('SELECT consultation_consultation.ID_CONSULTATION, consultation_consultation.ID_CONSULTATION_TYPE,  CASE WHEN consultation_consultation.ID_CONSULTATION_TYPE IN (3, 7) THEN consultation_centre_optique.DESCRIPTION ELSE masque_stucture_sanitaire.DESCRIPTION END AS STRUCTURE, consultation_consultation.DATE_CONSULTATION, consultation_consultation.POURCENTAGE_A, consultation_consultation.MONTANT_A_PAYER AS MONTANT_A_PAYER, IF(consultation_consultation.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT, membre_groupe.NOM_GROUPE, syst_couverture_structure.DESCRIPTION AS ID_TYPE_STRUCTURE, IF(aff.CODE_PARENT IS NULL, "A", "AD") AFFIL, consultation_type.DESCRIPTION, consultation_consultation.STATUS_PAIEMENT AS STATUS_P FROM    consultation_consultation  LEFT JOIN  masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation.ID_STRUCTURE LEFT JOIN  consultation_centre_optique ON consultation_centre_optique.ID_CENTRE_OPTIQUE = consultation_consultation.ID_STRUCTURE JOIN  membre_membre aff ON aff.ID_MEMBRE = consultation_consultation.ID_MEMBRE  LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = consultation_consultation.ID_TYPE_STRUCTURE JOIN consultation_type ON consultation_type.ID_CONSULTATION_TYPE = consultation_consultation.ID_CONSULTATION_TYPE WHERE consultation_consultation.ID_MEMBRE = '.$ID_MEMBRE.' AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"');

 $cconsultationb=$this->Model->getRequete('SELECT consultation_consultation.ID_CONSULTATION, consultation_consultation.ID_CONSULTATION_TYPE,  CASE WHEN consultation_consultation.ID_CONSULTATION_TYPE IN (3, 7) THEN consultation_centre_optique.DESCRIPTION ELSE masque_stucture_sanitaire.DESCRIPTION END AS STRUCTURE, consultation_consultation.DATE_CONSULTATION, consultation_consultation.POURCENTAGE_A, consultation_consultation.MONTANT_A_PAYER AS MONTANT_A_PAYER, IF(consultation_consultation.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT, membre_groupe.NOM_GROUPE, syst_couverture_structure.DESCRIPTION AS ID_TYPE_STRUCTURE,IF(aff.CODE_PARENT IS NULL, "A", "AD") AFFIL, consultation_type.DESCRIPTION, consultation_consultation.STATUS_PAIEMENT AS STATUS_P FROM    consultation_consultation  LEFT JOIN  masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation.ID_STRUCTURE LEFT JOIN  consultation_centre_optique ON consultation_centre_optique.ID_CENTRE_OPTIQUE = consultation_consultation.ID_STRUCTURE JOIN  membre_membre aff ON aff.ID_MEMBRE = consultation_consultation.ID_MEMBRE  LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = consultation_consultation.ID_TYPE_STRUCTURE JOIN consultation_type ON consultation_type.ID_CONSULTATION_TYPE = consultation_consultation.ID_CONSULTATION_TYPE WHERE consultation_consultation.TYPE_AFFILIE = '.$ID_MEMBRE.' AND consultation_consultation.ID_MEMBRE != '.$ID_MEMBRE.' AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"');

 $cmedicamenta=$this->Model->getRequete('SELECT consultation_medicament.ID_CONSULTATION_MEDICAMENT AS ID_CONSULTATION, "Pharmacie" AS ID_CONSULTATION_TYPE, consultation_pharmacie.DESCRIPTION AS STRUCTURE, consultation_medicament.DATE_CONSULTATION, "-" AS POURCENTAGE_A, consultation_medicament.MONTANT_A_PAYE_MIS AS MONTANT_A_PAYER, IF(consultation_medicament.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT, membre_groupe.NOM_GROUPE, "-" AS ID_TYPE_STRUCTURE, IF(aff.CODE_PARENT IS NULL, "A", "AD") AFFIL, "Pharmacie" AS DESCRIPTION, consultation_medicament.STATUS_PAIEMENT AS STATUS_P FROM consultation_medicament JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE JOIN membre_membre aff ON aff.ID_MEMBRE = consultation_medicament.ID_MEMBRE LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE consultation_medicament.ID_MEMBRE = '.$ID_MEMBRE.' AND YEAR(consultation_medicament.DATE_CONSULTATION) = "'.$ANNEE.'"');

 $cmedicamentb=$this->Model->getRequete('SELECT consultation_medicament.ID_CONSULTATION_MEDICAMENT AS ID_CONSULTATION, "Pharmacie" AS ID_CONSULTATION_TYPE, consultation_pharmacie.DESCRIPTION AS STRUCTURE, consultation_medicament.DATE_CONSULTATION, "-" AS POURCENTAGE_A, consultation_medicament.MONTANT_A_PAYE_MIS AS MONTANT_A_PAYER, IF(consultation_medicament.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT, membre_groupe.NOM_GROUPE, "-" AS ID_TYPE_STRUCTURE, IF(aff.CODE_PARENT IS NULL, "A", "AD") AFFIL, "Pharmacie" AS DESCRIPTION, consultation_medicament.STATUS_PAIEMENT AS STATUS_P FROM consultation_medicament JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE JOIN membre_membre aff ON aff.ID_MEMBRE = consultation_medicament.ID_MEMBRE LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE consultation_medicament.TYPE_AFFILIE = '.$ID_MEMBRE.' AND consultation_medicament.ID_MEMBRE != '.$ID_MEMBRE.' AND YEAR(consultation_medicament.DATE_CONSULTATION) = "'.$ANNEE.'"');

 $data['resultat'] = array_merge($cconsultationa, $cconsultationb,$cmedicamenta,$cmedicamentb);
 $data['stitle'] = 'Details de consomation de '.$details['NOM'].' '.$details['PRENOM'] ;
 $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  
 $data['selected'] = $selected;  
 $data['plafond'] = $this->Model->getRequeteOne('SELECT syst_categorie_assurance.PLAFOND_ANNUEL, syst_categorie_assurance.PLAFOND_COUVERTURE_HOSP_JOURS,syst_categorie_assurance.PLAFOND_LUNETTE, syst_categorie_assurance.PLAFOND_MONTURES, syst_categorie_assurance.PLAFOND_PROTHESES_DENTAIRES, syst_categorie_assurance.PLAFOND_PHARMACEUTICAL, syst_categorie_assurance.PLAFOND_CESARIENNE, syst_categorie_assurance.PLAFOND_SCANNER FROM membre_membre JOIN membre_assurances ON membre_membre.ID_MEMBRE = membre_assurances.ID_MEMBRE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_assurances.ID_CATEGORIE_ASSURANCE WHERE membre_membre.ID_MEMBRE = '.$ID_MEMBRE.'');  

 $aff_consu_tot = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$ID_MEMBRE.' AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
 $aff_med_tot = $this->Model->getRequeteOne('SELECT SUM(consultation_medicament.MONTANT_A_PAYE_MIS) AS MONTANT FROM consultation_medicament WHERE consultation_medicament.ID_MEMBRE =  '.$ID_MEMBRE.' AND YEAR(consultation_medicament.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
 $ayant_consu_tot = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.TYPE_AFFILIE = '.$ID_MEMBRE.' AND consultation_consultation.ID_MEMBRE != '.$ID_MEMBRE.' AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
 $ayant_med_tot = $this->Model->getRequeteOne('SELECT SUM(consultation_medicament.MONTANT_A_PAYE_MIS) AS MONTANT FROM consultation_medicament WHERE consultation_medicament.TYPE_AFFILIE = '.$ID_MEMBRE.' AND consultation_medicament.ID_MEMBRE != '.$ID_MEMBRE.' AND YEAR(consultation_medicament.DATE_CONSULTATION) = "'.$ANNEE.'"'); 

 $data['MONTANT_TOTAL']= $aff_consu_tot['MONTANT'] + $aff_med_tot['MONTANT'] + $ayant_consu_tot['MONTANT'] + $ayant_med_tot['MONTANT'];
 $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');
 $data['ANNEE']=$ANNEE;



 $this->load->view('Consomation_Details_View',$data);
}

}
?>