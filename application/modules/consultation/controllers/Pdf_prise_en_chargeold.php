<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Pdf_prise_en_charge extends CI_Controller {

  function __construct() {
    parent::__construct();
    include APPPATH.'third_party/fpdf/fpdf.php'; 

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
  $data['title']='Enregistrement de prise en charge';
  $data['stitle']='Enregistrement de Prise en Charge';
  $data['periode'] = $this->Model->getListOrdertwo('syst_couverture_structure',array(),'DESCRIPTION'); 
  $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
  $data['affilie']= $this->Model->getList("membre_membre",array('IS_AFFILIE'=>0));
  $data['groupe']= $this->Model->getList("membre_groupe");
  $data['tconsultation'] = $this->Model->getRequete('SELECT * FROM consultation_type WHERE ID_CONSULTATION_TYPE IN (1,2,5,6,8)'); 
  $data['CategorieAssurance'] = $this->Model->getListOrdertwo('syst_categorie_assurance',array('ID_REGIME_ASSURANCE'=>1,'STATUS'=>1),'DESCRIPTION');

  $this->load->view('Prise_en_charge_Add_View',$data);
}

public function categorieType()
{

  $tablestruc=$this->Model->getRequete('SELECT * FROM syst_categorie_assurance_type_structure JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE WHERE syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = '.$this->input->post('ID_CATEGORIE_ASSURANCE').'');
  $datas= '<option value="">-- Sélectionner --</option>';
  foreach($tablestruc as $commun){
    $datas.= '<option value="'.$commun["ID_TYPE_STRUCTURE"].'">'.$commun["DESCRIPTION"].'</option>';
  }
  $datas.= '';
  echo $datas;
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

}



public function add()
{

  $this->form_validation->set_rules('ID_GROUPE', 'Groupe', 'required');
  $this->form_validation->set_rules('TYPE_AFFILIE', 'Type Affilie', 'required');
  $this->form_validation->set_rules('ID_MEMBRE', 'Membre', 'required');
  $this->form_validation->set_rules('DATE_CONSULTATION', 'Date', 'required');
  $this->form_validation->set_rules('ID_CONSULTATION_TYPE', 'Type de consultation', 'required');



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

    $data= array(
      'ID_GROUPE'=>$this->input->post('ID_GROUPE'),
      'ID_TYPE_STRUCTURE'=>$this->input->post('ID_TYPE_STRUCTURE'),
      'ID_STRUCTURE'=>$this->input->post('ID_STRUCTURE'),
      'TYPE_AFFILIE'=>$this->input->post('TYPE_AFFILIE'),
      'ID_MEMBRE'=>$this->input->post('ID_MEMBRE'),
      'DATE_CONSULTATION'=>$this->input->post('DATE_CONSULTATION'),       
      'ID_CONSULTATION_TYPE'=>$this->input->post('ID_CONSULTATION_TYPE'),       
    );

    
    $this->Model->insert_last_id('prise_en_charge_hospitalisation',$data);

    $message = "<div class='alert alert-success' id='message'>
    Consultation enregistr&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('consultation/Pdf_prise_en_charge'));  

  }
  

}


public function liste()
{
  $data['title']=' Liste';
  $data['stitle']=' liste';

  $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 

  // $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");

  // $data['pharmacies'] = $this->Model->getList('consultation_pharmacie',array('STATUS'=>1)); 
  // $data['hopitaux'] = $this->Model->getList('masque_stucture_sanitaire'); 
  
  
  // $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));

  $this->load->view('Prise_En_Charge_List_View',$data);
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

  $query_principal ="SELECT `ID_PRISE_CHARGE`,scs.DESCRIPTION AS type_structure, sca.DESCRIPTION AS categorie,sca.PLAFOND_COUVERTURE_HOSP_JOURS, mss.DESCRIPTION AS structure_sanitaire, concat(mm.NOM,' ',mm.PRENOM) AS affilie, concat(mbr.NOM,' ',mbr.PRENOM) AS beneficiare ,mbr.IS_CONJOINT, `DATE_CONSULTATION`, `STATUS_PAIEMENT`, ct.DESCRIPTION as type_consultation, `DATE_INSERT` FROM  prise_en_charge_hospitalisation pech JOIN syst_couverture_structure scs ON pech.ID_TYPE_STRUCTURE=scs.ID_TYPE_STRUCTURE JOIN consultation_type ct ON pech.ID_CONSULTATION_TYPE=ct.ID_CONSULTATION_TYPE JOIN masque_stucture_sanitaire mss ON mss.ID_STRUCTURE=pech.ID_STRUCTURE JOIN membre_membre mm ON mm.ID_MEMBRE=pech.TYPE_AFFILIE JOIN membre_membre mbr ON mbr.ID_MEMBRE=pech.ID_MEMBRE JOIN membre_carte_membre mcm ON mcm.ID_MEMBRE=pech.TYPE_AFFILIE JOIN membre_carte mc ON mc.ID_CARTE=mcm.ID_CARTE JOIN syst_categorie_assurance sca ON sca.ID_CATEGORIE_ASSURANCE=mc.ID_CATEGORIE_ASSURANCE WHERE 1 ";

  $var_search = !empty($_POST['search']['value']) ? $this->db->escape_like_str($_POST['search']['value']) : null;

  $limit = 'LIMIT 0,10';

  if (isset($_POST['length']) && $_POST['length'] != -1) {
    $limit = 'LIMIT ' . (isset($_POST["start"]) ? $_POST["start"] : 0) . ',' . $_POST["length"];
  }

  $order_by = '';

  $order_column = array('ID_PRISE_CHARGE', 'scs.DESCRIPTION', ' sca.DESCRIPTION', 'concat(mm.NOM,"",mm.PRENOM)', 'concat(mbr.NOM," ",mbr.PRENOM)', ' ct.DESCRIPTION', 'MONTANT_A_PAYER', 'DATE_CONSULTATION');

  $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ID_PRISE_CHARGE ASC';

  $search = !empty($_POST['search']['value']) ? 
  "AND scs.DESCRIPTION LIKE '%$var_search%' OR sca.DESCRIPTION LIKE '%$var_search%' OR mss.DESCRIPTION LIKE '%$var_search%' OR concat(mm.NOM,' ',mm.PRENOM) LIKE '%$var_search%' OR ct.DESCRIPTION LIKE '%$var_search%'  OR concat(mbr.NOM,' ',mbr.PRENOM) LIKE '%$var_search%'" 
  : '';

  $critaire = '';

  $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
  $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

  $membres = $this->Model->datatable($query_secondaire);

  $data = array();
  foreach ($membres as $key) {
    $row = array();
    $row[] = date("d-m-Y", strtotime($key->DATE_CONSULTATION));
    $row[] = $key->categorie;
    $row[] = $key->structure_sanitaire;
    $row[] = $key->affilie;
    $row[] = $key->beneficiare;
    

    $row[]='

    <div class="dropdown ">
    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
    <span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right">
    <li><a class="dropdown-item" target="_blank" href="'.base_url('consultation/Pdf_prise_en_charge/prise_en_charge_pdf/'.$key->ID_PRISE_CHARGE).'"> Pdf</a> </li>
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


public function prise_en_charge_pdf($id){


  $donne=$this->Model->getRequeteOne("SELECT `ID_PRISE_CHARGE`,scs.DESCRIPTION AS type_structure, sca.DESCRIPTION AS categorie,sca.PLAFOND_COUVERTURE_HOSP_JOURS, mss.DESCRIPTION AS structure_sanitaire, concat(mm.NOM,' ',mm.PRENOM) AS affilie,pech.TYPE_AFFILIE,mm.ID_MEMBRE,mm.CNI, concat(mbr.NOM,' ',mbr.PRENOM) AS beneficiare ,mbr.ID_MEMBRE AS beneficie_id,mbr.IS_CONJOINT,mbr.DATE_NAISSANCE,mbr.URL_PHOTO,mm.CODE_AFILIATION,sgs.DESCRIPTION AS groupe_sanguin, `DATE_CONSULTATION`, `STATUS_PAIEMENT`, ct.DESCRIPTION as type_consultation,scats.POURCENTAGE, `DATE_INSERT`,mgm.NOM_GROUPE,sca.PLAFOND_ANNUEL,sca.PLAFOND_CESARIENNE,sca.ID_CATEGORIE_ASSURANCE,pech.ID_TYPE_STRUCTURE FROM  prise_en_charge_hospitalisation pech JOIN syst_couverture_structure scs ON pech.ID_TYPE_STRUCTURE=scs.ID_TYPE_STRUCTURE JOIN consultation_type ct ON pech.ID_CONSULTATION_TYPE=ct.ID_CONSULTATION_TYPE JOIN masque_stucture_sanitaire mss ON mss.ID_STRUCTURE=pech.ID_STRUCTURE JOIN membre_membre mm ON mm.ID_MEMBRE=pech.TYPE_AFFILIE JOIN membre_membre mbr ON mbr.ID_MEMBRE=pech.ID_MEMBRE JOIN membre_groupe mgm ON mgm.ID_GROUPE=pech.ID_GROUPE JOIN syst_groupe_sanguin sgs ON sgs.ID_GROUPE_SANGUIN=mbr.ID_GROUPE_SANGUIN JOIN membre_carte_membre mcm ON mcm.ID_MEMBRE=pech.TYPE_AFFILIE JOIN membre_carte mc ON mc.ID_CARTE=mcm.ID_CARTE JOIN syst_categorie_assurance sca ON sca.ID_CATEGORIE_ASSURANCE=mc.ID_CATEGORIE_ASSURANCE JOIN syst_categorie_assurance_type_structure scats ON scats.ID_CATEGORIE_ASSURANCE=sca.ID_CATEGORIE_ASSURANCE WHERE 1 AND pech.ID_PRISE_CHARGE=".$id);

  $consultation_affilier=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION,membre_groupe.ID_GROUPE ,c.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE c.TYPE_AFFILIE ='.$donne['ID_MEMBRE'].' AND c.ID_MEMBRE ='.$donne['ID_MEMBRE'].' AND YEAR(c.DATE_CONSULTATION) = "' .intval(date('Y')).'" ');

  $consultation_ayant=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION,membre_groupe.ID_GROUPE ,c.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE c.TYPE_AFFILIE ='.$donne['ID_MEMBRE'].' AND c.ID_MEMBRE !='.$donne['ID_MEMBRE'].' AND YEAR(c.DATE_CONSULTATION) = "' .intval(date('Y')).'" ');

  $consultation_medicament_affilier=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments,COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT,membre_groupe.ID_GROUPE,cm.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE  cm.TYPE_AFFILIE ='.$donne['ID_MEMBRE'].' AND cm.ID_MEMBRE ='.$donne['ID_MEMBRE'].' AND YEAR(cm.DATE_CONSULTATION) = "' . intval(date('Y')).'" ');

  $consultation_medicament_ayant=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments,COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT,membre_groupe.ID_GROUPE,cm.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE  cm.TYPE_AFFILIE ='.$donne['ID_MEMBRE'].' AND cm.ID_MEMBRE !='.$donne['ID_MEMBRE'].' AND YEAR(cm.DATE_CONSULTATION) = "' . intval(date('Y')).'" ');


  $M_CONSULTATION = $consultation_affilier['M_CONSULTATION'] + $consultation_ayant['M_CONSULTATION'];
  $M_MEDICAMENT = $consultation_medicament_affilier['M_MEDICAMENT'] + $consultation_medicament_ayant['M_MEDICAMENT'];
  $C_TOTAL = $M_CONSULTATION + $M_MEDICAMENT;
  
// if(!empty($resultata['M_CONSULTATION']) && $resultata['M_CONSULTATION']<$donne['PLAFOND_ANNUEL']){}
  $plafond=intval($donne['PLAFOND_ANNUEL'])*0.7;
  
  $plafond_use=0;
  if(!empty($C_TOTAL)){

    if($C_TOTAL <= $plafond){
     $plafond_use=$donne['PLAFOND_CESARIENNE'];
   }else{
     $plafond_exist=intval($donne['PLAFOND_ANNUEL'])-intval($C_TOTAL);
     $plafond_use=$plafond_exist;
   }

 }else{
  $plafond_use=$donne['PLAFOND_CESARIENNE'];
}

$pourcentage=$this->Model->getRequeteOne('SELECT `ID_CATEGORIE_TYPE_STRUCTURE`, `ID_CATEGORIE_ASSURANCE`, `ID_TYPE_STRUCTURE`, `POURCENTAGE` FROM `syst_categorie_assurance_type_structure` WHERE ID_TYPE_STRUCTURE='.$donne['ID_TYPE_STRUCTURE'].' AND ID_CATEGORIE_ASSURANCE='.$donne['ID_CATEGORIE_ASSURANCE']);


$anne=date('Y');
$code = str_pad($id, 5, '0', STR_PAD_LEFT);
$code_valide =$code.' '.'DG/MIS/'.$anne;

$carte=$donne['CNI'] ? $donne['CNI'] : "N/A";

$benefic_type='';

if($donne['TYPE_AFFILIE']==$donne['beneficie_id']){
  $benefic_type='Lui-même';
}elseif ($donne['IS_CONJOINT']==1) {
  $benefic_type='Conjoint';
}elseif ($donne['IS_CONJOINT']==0) {
  $benefic_type='Enfant';
}

$sanguin=$donne['groupe_sanguin'] ? $donne['groupe_sanguin'] : "N/A";

$pdf = new FPDF(); 
$pdf->AddPage('P', 'A4');
$pdf->SetMargins(0, 0, 0);
$pdf->Image(FCPATH. 'assets/img/mis_logo/logo_mis.png',5,5,160,0);
$imagePath = FCPATH . '/uploads/image_membre/' . $donne['URL_PHOTO'];

if (file_exists($imagePath)) {
  $pdf->Image($imagePath, 170, 5, 25, 0);
} else {
  $pdf->Image(FCPATH. 'assets/img/mis_logo/image_personne.png', 170, 5, 25,0);

}
$pdf->Ln(26);
$pdf->SetFont('Times','B',15);
$pdf->Cell(25,7,utf8_decode(""),0,'R');
$pdf->Cell(40,7,utf8_decode("CERTIFICAT DE PRISE EN CHARGE N° :".$code_valide),0,'R');
$textWidth = $pdf->GetStringWidth(utf8_decode("CERTIFICAT DE PRISE EN CHARGE N° :"));
$pdf->Line(25, 37 + 7, 80 + $textWidth, 37 + 7);
$pdf->Ln(8);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(60,5,utf8_decode("Nom et prénom de l'affilié(e) : "),0,'L');
$pdf->Cell(80,5,utf8_decode($donne['affilie']),0,'R');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(60,5,utf8_decode("Code de l'affilié(e) : "),0,'L');
$pdf->Cell(80,5,utf8_decode($donne['CODE_AFILIATION']),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(60,5,utf8_decode("Société ou Employeur : "),0,'L');
$pdf->Cell(80,5,utf8_decode($donne['NOM_GROUPE']),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(60,5,utf8_decode("Catégorie de l'affilié(e) : "),0,'L');
$pdf->Cell(80,5,utf8_decode($donne['categorie']),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(65,5,utf8_decode("No Carte d'identité de l'affilié(e) : "),0,'L');
$pdf->Cell(80,5,utf8_decode($carte),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(40,5,utf8_decode("Bénéficiaire :  "),0,'L');
$pdf->Cell(80,5,utf8_decode($benefic_type),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(60,5,utf8_decode("Nom et Prénom du bénéficiaire :  "),0,'L');
$pdf->Cell(80,5,utf8_decode($donne['beneficiare']),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(60,5,utf8_decode("Date de Naissance : "),0,'L');
$pdf->Cell(80,5,utf8_decode(date("d-m-Y", strtotime($donne['DATE_NAISSANCE']))),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(60,5,utf8_decode("Groupe sanguin : "),0,'L');
$pdf->Cell(80,5,utf8_decode($sanguin),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(60, 5, utf8_decode("Lui est accordée une autorisation de soins en  "), 0, 'L');
$pdf->SetFont('Times','B',13);
$pdf->Cell(25,5,utf8_decode(""),0,'R');
$pdf->Cell(40,5,utf8_decode($donne['type_consultation']),0,'L');
$pdf->Ln(5);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(40, 5, utf8_decode(" à la formation sanitaire : "), 0, 'L');
$pdf->SetFont('Times','B',13);
$pdf->Cell(10,5,utf8_decode(""),0,'R');
$pdf->Cell(40,5,utf8_decode($donne['structure_sanitaire']),0,'L');
$pdf->Ln(8);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(90,5,utf8_decode("Le Taux de couverture pour les soins de santé : "),0,'L');
$pdf->Cell(80,5,utf8_decode($pourcentage['POURCENTAGE'].' %'),0,'L');
$pdf->Ln(8);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(110,5,utf8_decode("Plafond de couverture pour les chambres d'hospitalisation:  "),0,'L');
$pdf->Cell(70,5,utf8_decode(!empty($donne['PLAFOND_COUVERTURE_HOSP_JOURS']) ? number_format($donne['PLAFOND_COUVERTURE_HOSP_JOURS'], 0, ',', ' ').' Fbu' : 'N/A'),0,'L');
$pdf->Ln(8);
$pdf->SetFont('Times','',13);
$pdf->Cell(20,5,utf8_decode(""),0,'R');
$pdf->Cell(80,5,utf8_decode("Plafond de couverture par la MIS santé : "),0,'L');
$pdf->Cell(80,5,utf8_decode(number_format($plafond_use, 0, ',', ' ').' Fbu'),0,'L');

$pdf->Ln(8);
$pdf->SetFont('Times','I',13);
$pdf->Cell(20,7,utf8_decode(""),0,'R');
$pdf->Cell(100,7,utf8_decode("NB : "),0,'L');
$pdf->Ln(7);
$pdf->SetFont('Times','I',13);
$pdf->Cell(30,7,utf8_decode(""),0,'R');
$pdf->Cell(100,7,utf8_decode(" En cas d'une maladie chronique ou épidémiologique : "),0,'L');
$pdf->Cell(80,7,utf8_decode(''),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','I',13);
$pdf->Cell(40,7,utf8_decode(""),0,'R');
$pdf->MultiCell(150,4,utf8_decode(" La MIS Santé ne couvre que lors d'une découverte fortuite, la consultation et les examens Complémentaires seulement ;
 "),0,'L');
    // $pdf->Ln(5);
$pdf->SetFont('Times','I',13);
$pdf->Cell(40,7,utf8_decode(""),0,'R');
$pdf->MultiCell(150,4,utf8_decode("Généralement, la MIS Santé ne couvre en aucun cas les soins et le traitement liés à une pathologie chronique déjà connue ;"),0,'L');
$pdf->Ln(4);
$pdf->SetFont('Times','I',13);
$pdf->Cell(40,7,utf8_decode(""),0,'R');
$pdf->Cell(100,7,utf8_decode(" La MIS Santé ne couvre aucune maladie épidémiologique."),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','I',13);
$pdf->Cell(30,7,utf8_decode(""),0,'R');
$pdf->Cell(100,7,utf8_decode(" Les autres conditions particulières restent toujours applicables "),0,'L');
$pdf->Ln(6);
$pdf->SetFont('Times','B',15);
$pdf->Cell(20,7,utf8_decode(""),0,'R');
$pdf->Cell(100,7,utf8_decode("La MIS Santé vous souhaite la bonne Guérison. "),0,'L');
$pdf->SetFont('Times','B',15);
$pdf->Ln(9);
$pdf->Cell(100,7,utf8_decode(""),0,'R'); 
$pdf->Cell(30, 8, utf8_decode("Fait à Bujumbura, le ".date("d/m/Y", strtotime($donne['DATE_CONSULTATION'])).""), 0, 1, 'L');

$pdf->Ln(1);
$pdf->Cell(100,7,utf8_decode(""),0,'R'); 
$pdf->Cell(30, 8, utf8_decode("POUR CERTIFICATION"), 0, 1, 'L'); 

$pdf->Ln(1);
$pdf->Cell(100,7,utf8_decode(""),0,'R'); 
$pdf->Cell(30, 8, utf8_decode("Directeur Général de la MIS Santé"), 0, 1, 'L');

$pdf->Ln(1); 
$pdf->Cell(110,7,utf8_decode(""),0,'R'); 
$pdf->Cell(30, 10, utf8_decode("NIYONSABA Solange"), 0, 1, 'L');

$qrcodes = $this->Model->getRequeteOne("SELECT membre_membre_qr.PATH_QR_CODE FROM membre_membre_qr  WHERE ID_MEMBRE = ".$donne['ID_MEMBRE']." ");
$qrcode_path = FCPATH . 'uploads/QRCODE/' . $qrcodes['PATH_QR_CODE'];

// Vérifier si le fichier existe localement
if (file_exists($qrcode_path)) {
    // Utiliser le chemin local
    $image = $qrcode_path;
    $pdf->Cell(25,25,$pdf->Image($image,15,220,25,25),0,0,'C');

}


$x1 = 10; 
$y1 = 260; 
$x2 = 200; 
$y2 = 260;

// Tracer la ligne
$pdf->Line($x1, $y1, $x2, $y2);

// Configuration du pied de page
$pdf->SetY($y1+3);
$pdf->SetFont('Times', 'B', 8);
// Numéro de page (Page X/Y)
$pdf->Cell(0, 5, utf8_decode('679/A ; Avenue Pierre NGENDANDUMWE, Central Building, 1er étage, Bureau 202 - Tél : (+257) 22 28 10 29 / 77 527 805 / 65 771 286 ') , 0, 0, 'C');
$pdf->Ln(4); // Espacement entre les lignes

// Copyright
$pdf->Cell(0, 5, utf8_decode('E-mail : missante2020@gmail.com '), 0, 0, 'C');

$pdf->Output('I');

}




}
