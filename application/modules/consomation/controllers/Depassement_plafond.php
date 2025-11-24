<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Depassement_plafond extends CI_Controller {

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
  $data['title']='Liste des affilies';

  $this->load->view('depassement_plafond_view',$data);

}

public function liste()
{


 $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $limit = 'LIMIT 0,10';
 if ($_POST['length'] != -1) {
   $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
 }
 
 $order_by = '';
 if (!empty($order_by)) {
   $order_by .= isset($_POST['order']) ? ' ORDER BY ' . $_POST['order']['0']['column'] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY membre_membre.ID_MEMBRE ASC';
 }
 
 $search = !empty($_POST['search']['value']) ? (' AND (NOM LIKE "%' . $var_search . '%" or PRENOM LIKE "%' . $var_search . '%" or TELEPHONE LIKE "%' . $var_search . '%" or CNI LIKE "%' . $var_search . '%" or NOM_GROUPE LIKE "%' . $var_search . '%"  )') :'';
 
 $critaire = '';
 $order_by="  ORDER BY ID_MEMBRE";
 $groupby='GROUP BY ID_MEMBRE';

 $query_principal=" SELECT membre_membre.ID_MEMBRE, NOM, PRENOM, membre_groupe.NOM_GROUPE,TELEPHONE,CNI,CODE_AFILIATION,syst_categorie_assurance.PLAFOND_ANNUEL FROM `membre_membre` JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE JOIN membre_assurances ON membre_membre.ID_MEMBRE = membre_assurances.ID_MEMBRE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_assurances.ID_CATEGORIE_ASSURANCE WHERE `IS_AFFILIE` = 0 AND membre_membre.STATUS=1 ";
 
 $query_secondaire = $query_principal . '  ' . $critaire . '  ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
 $query_filter = $query_principal . ' ' . $critaire . '  ' . $search. ' ' . $groupby;
 $fetch_client = $this->Model->datatable($query_secondaire);

 $tabledata=array();

 foreach ($fetch_client as $key) 
 {

  $res=$this->Model->getRequeteOne('SELECT membre_groupe.`NOM_GROUPE` FROM `membre_groupe` JOIN membre_groupe_membre on membre_groupe.ID_GROUPE=membre_groupe_membre.ID_GROUPE WHERE 1 and membre_groupe_membre.ID_MEMBRE='.$key->ID_MEMBRE.'');


  $consultation_affilier=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION,membre_groupe.ID_GROUPE ,c.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE c.TYPE_AFFILIE ='.$key->ID_MEMBRE.' AND c.ID_MEMBRE ='.$key->ID_MEMBRE.' AND YEAR(c.DATE_CONSULTATION) = "' .intval(date('Y')).'"');

  $consultation_ayant=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION,membre_groupe.ID_GROUPE ,c.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE c.TYPE_AFFILIE ='.$key->ID_MEMBRE.' AND c.ID_MEMBRE !='.$key->ID_MEMBRE.' AND YEAR(c.DATE_CONSULTATION) = "' .intval(date('Y')).'" ');

  $consultation_medicament_affilier=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments,COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT,membre_groupe.ID_GROUPE,cm.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE  cm.TYPE_AFFILIE ='.$key->ID_MEMBRE.' AND cm.ID_MEMBRE ='.$key->ID_MEMBRE.' AND YEAR(cm.DATE_CONSULTATION) = "' . intval(date('Y')).'" ');

  $consultation_medicament_ayant=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments,COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT,membre_groupe.ID_GROUPE,cm.DATE_CONSULTATION FROM membre_membre m LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = m.ID_MEMBRE JOIN membre_groupe ON membre_groupe.ID_GROUPE = mgm.ID_GROUPE  WHERE  cm.TYPE_AFFILIE ='.$key->ID_MEMBRE.' AND cm.ID_MEMBRE !='.$key->ID_MEMBRE.' AND YEAR(cm.DATE_CONSULTATION) = "' . intval(date('Y')).'"');


  $M_CONSULTATION = $consultation_affilier['M_CONSULTATION'] + $consultation_ayant['M_CONSULTATION'];
  $M_MEDICAMENT = $consultation_medicament_affilier['M_MEDICAMENT'] + $consultation_medicament_ayant['M_MEDICAMENT'];
  $C_TOTAL = $M_CONSULTATION + $M_MEDICAMENT;
  

  $plafond=intval($key->PLAFOND_ANNUEL)*0.65;

  $plafonner='';
  if ($C_TOTAL > $plafond) {
    $plafonner = '<span style="color:red;">Dépassé</span>';
  } else {
    $plafonner = '<span style="color:green;">OK</span>';
  }


  $nom_groupe="N/A";

  if (!empty($res)) {
    $nom_groupe=$res['NOM_GROUPE'];
  }
  // $newDate = date("d-m-Y", strtotime($key->FIN_SUR_LA_CARTE));


  $chambr=array();
  $chambr[]=$key->ID_MEMBRE;
  $chambr[]=$key->NOM.' '.$key->PRENOM;
  $chambr[]=$key->CODE_AFILIATION;
  $chambr[]=$key->CNI;
  $chambr[]=$key->TELEPHONE;  
  $chambr[]=$key->NOM_GROUPE;
  $chambr[]=number_format($C_TOTAL, 0, ',', ' ');  
  $chambr[]=number_format($plafond, 0, ',', ' ');
  $chambr[]=$plafonner;




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





public function modificationgroupe()
{
  $ID_MEMBRE = $this->input->post('id');
  $result = $ID_MEMBRE;
    // $carte = $this->Model->getRequeteOne('Select * from membre_carte_membre WHERE ID_CARTE = '.$selected['ID_CARTE'].' limit 1'); 
  $resultat=$this->Model->getRequeteOne('SELECT membre_groupe.ID_GROUPE,membre_membre.ID_MEMBRE,CODE_AFILIATION, NOM, PRENOM, CNI, DATE_ADHESION, membre_membre.STATUS, IS_AFFILIE, membre_groupe.NOM_GROUPE FROM `membre_membre` JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE 1 and membre_membre.ID_MEMBRE='.$ID_MEMBRE.'');

  $result =' <form id="FormDatachange" action="'.base_url().'membre/Membre/changegroupe" method="POST" enctype="multipart/form-data">
  <div class="modal-body">

  <table class="table">

  <tr>
  <td>
  Groupe
  </td>
  <td>
  <select name="ID_GROUPE2" id="ID_GROUPE2" class="form-control">
  <option value="">Select</option>';

  $groupe = $this->Model->getList('membre_groupe'); 

  foreach ($groupe as $key => $value) {
    $select="";
    if ($value['ID_GROUPE']==$resultat['ID_GROUPE']) {
     $select="selected";
   }
   $result.='<option '.$select.' value="'.$value['ID_GROUPE'].'">'.$value['NOM_GROUPE'].'</option>';
 }


 $result.='</select>
 <font color="red" id="erID_GROUPE"></font>
 <input type="hidden" class="form-control" id="ID_MEMBRE" name="ID_MEMBRE" value="'.$resultat['ID_MEMBRE'].'" />
 </td>
 </tr>
 </table>

 </div>
 <div class="modal-footer justify-content-between">
 <input type="button" onclick="send_modif()" value="Enregistrer" class="btn btn-primary"/>
 <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
 </div>
 </form>';
 echo $result;

}


public function modificationdateaffilie()
{
  $ID_MEMBRE = $this->input->post('id');
  $result = $ID_MEMBRE;
    // $carte = $this->Model->getRequeteOne('Select * from membre_carte_membre WHERE ID_CARTE = '.$selected['ID_CARTE'].' limit 1'); 
  $carte=$this->Model->getRequeteOne('SELECT membre_membre.ID_MEMBRE, membre_membre.DATE_FIN, membre_membre.DATE_ADHESION FROM membre_membre where ID_MEMBRE = '.$ID_MEMBRE.' ');

  $result =' <form id="FormDatachange" action="'.base_url().'membre/Membre/changedate" method="POST" enctype="multipart/form-data">
  <div class="modal-body"> 
  <table class="table">
  <tr>
  <td colspan="2">Modification des dates</td>
  </tr>
  <tr>
  <td>
  <label>Date d\'adhesion</label><br>
  <input type="date" class="form-control" id="DATE_ADHESION2" name="DATE_ADHESION2" value="'.$carte['DATE_ADHESION'].'" />
  <font color="red" id="erDATE_ADHESION"></font>
  </td>
  <td>
  <input type="hidden" class="form-control" id="ID_MEMBRE" name="ID_MEMBRE" value="'.$carte['ID_MEMBRE'].'" />
  <label>Date fin</label><br>
  <input type="date" class="form-control" id="DATE_FIN" name="DATE_FIN" value="'.$carte['DATE_FIN'].'" />
  <font color="red" id="erDATE_FIN2"></font>

  </td>
  </tr>
  </table>

  </div>
  <div class="modal-footer justify-content-between">
  <input type="button" onclick="send_modif()" value="Enregistrer" class="btn btn-primary"/>
  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
  </div>
  </form>';
  echo $result;
}


public function modif_date()
{
  $ID_MEMBRE = $this->input->post('id');
  $result = $ID_MEMBRE;
    // $carte = $this->Model->getRequeteOne('Select * from membre_carte_membre WHERE ID_CARTE = '.$selected['ID_CARTE'].' limit 1'); 
  $carte=$this->Model->getRequeteOne('SELECT membre_carte_membre.ID_MEMBRE, membre_carte_membre.FIN_SUR_LA_CARTE, membre_carte_membre.DEBUT_SUR_LA_CARTE FROM membre_carte_membre where ID_MEMBRE = '.$ID_MEMBRE.' ');

  $result =' <form id="FormDatachange" action="'.base_url().'membre/Membre/changedate" method="POST" enctype="multipart/form-data">
  <div class="modal-body"> 
  <table class="table">
  <tr>
  <td colspan="2">Modification des dates</td>
  </tr>
  <tr>
  <td>
  <label>Date debut de la carte</label><br>
  <input type="date" class="form-control" id="DATE_ADHESION2" name="DATE_ADHESION2" value="'.$carte['DEBUT_SUR_LA_CARTE'].'" />
  <font color="red" id="erDATE_ADHESION"></font>
  </td>
  <td>
  <input type="hidden" class="form-control" id="ID_MEMBRE" name="ID_MEMBRE" value="'.$carte['ID_MEMBRE'].'" />
  <label>Date fin</label><br>
  <input type="date" class="form-control" id="DATE_FIN" name="DATE_FIN" value="'.$carte['FIN_SUR_LA_CARTE'].'" />
  <font color="red" id="erDATE_FIN2"></font>

  </td>
  </tr>
  </table>

  </div>
  <div class="modal-footer justify-content-between">
  <input type="button" onclick="send_modif()" value="Enregistrer" class="btn btn-primary"/>
  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
  </div>
  </form>';
  echo $result;
}

public function changedate()
{
  $DATE_ADHESION=$this->input->post('DATE_ADHESION2');
  $DATE_FIN=$this->input->post('DATE_FIN');
  $ID_MEMBRE=$this->input->post('ID_MEMBRE');

  $carte=$this->Model->getRequeteOne('SELECT membre_carte_membre.ID_CARTE FROM membre_carte_membre where ID_MEMBRE = '.$ID_MEMBRE.' ');


  $this->Model->update('membre_carte_membre',array('ID_MEMBRE'=>$ID_MEMBRE),array('DEBUT_SUR_LA_CARTE'=>$DATE_ADHESION,'FIN_SUR_LA_CARTE'=>$DATE_FIN));


  $message = "<div class='alert alert-success' id='message'>
  Date chang&eacute; avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('membre/Membre/listing'));   
      // MIS02016-0000218  14-12-2021  14-12-2022



}




public function changegroupe($value='')
{
 $membre_id=$this->input->post('ID_MEMBRE');
 $groupe_id=$this->input->post('ID_GROUPE2');

 $this->Model->update('membre_groupe_membre',array('ID_MEMBRE'=>$membre_id),array('ID_GROUPE'=>$groupe_id));
 $donnees=$this->Model->getRequete('SELECT ID_MEMBRE from membre_membre where CODE_PARENT='.$membre_id.'');

 foreach ($donnees as $key => $value) {
   $this->Model->update('membre_groupe_membre',array('ID_MEMBRE'=>$value['ID_MEMBRE']),array('ID_GROUPE'=>$groupe_id));
 }


 $message = "<div class='alert alert-success' id='message'>
 Modification avec succés
 <button type='button' class='close' data-dismiss='alert'>&times;</button>
 </div>";
 $this->session->set_flashdata(array('message'=>$message));
 redirect(base_url('membre/Membre/listing'));  
}

public function index_update($id)
{

  $data['title']=' Affili&eacute;';
  $data['stitle']=' Affili&eacute;';
  $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
  $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
  $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
  $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
  $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
  $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");
  $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
  $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
  $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
  $data['agroupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` ORDER BY NOM_GROUPE ASC");
  $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  


  $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
  $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
  $todaydate = strtotime(date('Y-m-d'));
  $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
  $realdate = date('d/m/Y', $realdate);
  $data['datemin'] = $realdate;


  $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
  $todaydates = strtotime(date($selected['DATE_NAISSANCE']));
  $realdates = date('d/m/Y', $todaydates);
      // echo $realdates;
      // exit();

  $data['selecteds'] = $realdates;

  $this->load->view('Membre_Update_View',$data);
}


public function update()
{


  $NOM=$this->input->post('NOM');
  $PRENOM=$this->input->post('PRENOM');
  $CNI=$this->input->post('CNI');
  $DATE_ADHESION=$this->input->post('DATE_ADHESION');
  $CODE_AFILIATION=$this->input->post('CODE_AFILIATION');
  $TELEPHONE=$this->input->post('TELEPHONE');
  $ID_SEXE=$this->input->post('ID_SEXE');
  $COMMUNE_ID=$this->input->post('COMMUNE_ID');
  $PROVINCE_ID=$this->input->post('PROVINCE_ID');
  $ID_GROUPE_SANGUIN=$this->input->post('ID_GROUPE_SANGUIN');
  $ID_EMPLOI=$this->input->post('ID_EMPLOI');
  $ID_AGENCE=$this->input->post('ID_AGENCE');
  $DATE_NAISSANCE=$this->input->post('DATE_NAISSANCE');
  $ADRESSE=$this->input->post('ADRESSE');
  $DATE_DEBUT=$this->input->post('DATE_ADHESION');
  $ID_MEMBRE=$this->input->post('ID_MEMBRE');


  $this->form_validation->set_rules('NOM', 'Nom', 'required');
  $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');
  $this->form_validation->set_rules('TELEPHONE', 'Telephone', 'required');
  $this->form_validation->set_rules('ID_SEXE', 'Sexe', 'required');
  $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
  $this->form_validation->set_rules('COMMUNE_ID', 'Commune', 'required');
  $this->form_validation->set_rules('DATE_NAISSANCE', 'Date de naissance', 'required');

  if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
    Affili&eacute; non modifi&eacute;
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $data['title']=' Affili&eacute;';
    $data['stitle']=' Affili&eacute;';
    $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE)); 
    $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
    $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
    $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
    $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
    $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");
    $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
    $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
    $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
    $data['agroupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` ORDER BY NOM_GROUPE ASC");
    $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  


    $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
    $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
    $todaydate = strtotime(date('Y-m-d'));
    $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
    $realdate = date('d/m/Y', $realdate);
    $data['datemin'] = $realdate;

    $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  
    $todaydates = strtotime(date($selected['DATE_NAISSANCE']));
    $realdates = date('d/m/Y', $todaydates);
    $data['selecteds'] = $realdates;

    $this->load->view('Membre_Update_View',$data);
  }
  else{

    $datas=array('NOM'=>$NOM,
     'PRENOM'=>$PRENOM,
     'CNI'=>$CNI,
     'DATE_ADHESION'=>$DATE_ADHESION,
     'CODE_AFILIATION'=>$CODE_AFILIATION,
     'TELEPHONE'=>$TELEPHONE,
     'ID_SEXE'=>$ID_SEXE,
     'COMMUNE_ID'=>$COMMUNE_ID,
     'PROVINCE_ID'=>$PROVINCE_ID,
     'ID_GROUPE_SANGUIN'=>$ID_GROUPE_SANGUIN,
     'ID_EMPLOI'=>$ID_EMPLOI,
     'ID_AGENCE'=>$ID_AGENCE,
     'DATE_NAISSANCE'=>$DATE_NAISSANCE,
     'ADRESSE'=>$ADRESSE,
   );
    // echo "<pre>";
    // print_r($datas);
    $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$datas);

    $repPhotoo =FCPATH.'/uploads/image_membre';
    $code=uniqid();
    $logo_societe = $_FILES['URL_PHOTO']['name'];

    if ($logo_societe != null) {
      $config['upload_path'] ='./uploads/image_membre/';
      $config['allowed_types'] = '*';
      $test = explode('.', $logo_societe);
      $ext = end($test);
      $name = $code.'_membre.' . $ext;
      $config['file_name'] =$name;
        if(!is_dir($repPhotoo)) //create the folder if it does not already exists   
        {
          mkdir($repPhotoo,0777,TRUE);                                                  
        }
        $this->upload->initialize($config);
        $this->upload->do_upload('URL_PHOTO');
        $image_name_main=$config['file_name'];
        $data_image=$this->upload->data();
        $data_pict=array('URL_PHOTO'=>$image_name_main);
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$data_pict);
      }




      $message = "<div class='alert alert-success' id='message'>
      Affili&eacute; modifi&eacute; avec succés
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Membre/listing'));    

    }

  }


  public function details($id)
  {



    if (empty($this->Model->getOne('membre_membre_qr',array('ID_MEMBRE'=>$id)))) {
      $this->get_qr_code($id);

    }

    $data['title']=' Affili&eacute;';
    $data['stitle']=' Affili&eacute;';
    $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
    $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
    $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
    $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
    $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
    $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");
    $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
    $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
    $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
    $data['agroupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` ORDER BY NOM_GROUPE ASC");
    $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
    $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$id,'IS_AFFILIE'=>1));

    $aff = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$id,'IS_AFFILIE'=>1));
    foreach ($aff as $affilies) {
      if (empty($this->Model->getOne('membre_membre_qr',array('ID_MEMBRE'=>$affilies['ID_MEMBRE'])))) {
        $this->get_qr_code($affilies['ID_MEMBRE']);    
      }
    }

    $this->load->view('Membre_Details_View',$data);
  }


  
  public function index_update_ayant($id)
  {

    $data['title']=' Affili&eacute;';
    $data['stitle']=' Affili&eacute;';
    $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
    $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
    $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
    $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
    $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
    $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");
    $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
    $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
    $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
    $data['agroupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` ORDER BY NOM_GROUPE ASC");
    $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  



    $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
    $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
    $todaydate = strtotime(date('Y-m-d'));
    $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
    $realdate = date('d/m/Y', $realdate);
    $data['datemin'] = $realdate;


    $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
    $todaydates = strtotime(date($selected['DATE_NAISSANCE']));
    $realdates = date('d/m/Y', $todaydates);

    $data['selecteds'] = $realdates;
    $this->load->view('Membre_Update_Ayant_View',$data);
  }


  public function update_ayant_droit()
  {


    $NOM=$this->input->post('NOM');
    $PRENOM=$this->input->post('PRENOM');
    $CNI=$this->input->post('CNI');
    $DATE_ADHESION=$this->input->post('DATE_ADHESION');
    $CODE_AFILIATION=$this->input->post('CODE_AFILIATION');
    $TELEPHONE=$this->input->post('TELEPHONE');
    $ID_SEXE=$this->input->post('ID_SEXE');
    $COMMUNE_ID=$this->input->post('COMMUNE_ID');
    $PROVINCE_ID=$this->input->post('PROVINCE_ID');
    $ID_GROUPE_SANGUIN=$this->input->post('ID_GROUPE_SANGUIN');
    $ID_EMPLOI=$this->input->post('ID_EMPLOI');
    $ID_AGENCE=$this->input->post('ID_AGENCE');
    $DATE_NAISSANCE=$this->input->post('DATE_NAISSANCE');
    $ADRESSE=$this->input->post('ADRESSE');
    $DATE_DEBUT=$this->input->post('DATE_ADHESION');
    $ID_MEMBRE=$this->input->post('ID_MEMBRE');
    $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE)); 

    $this->form_validation->set_rules('NOM', 'Nom', 'required');
    $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');
    $this->form_validation->set_rules('ID_SEXE', 'Sexe', 'required');
    $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
    $this->form_validation->set_rules('COMMUNE_ID', 'Nom', 'required');
    $this->form_validation->set_rules('ID_GROUPE_SANGUIN', 'Nom', 'required');

    if ($this->form_validation->run() == FALSE){
      $message = "<div class='alert alert-danger' id='message'>
      Affili&eacute; non modifi&eacute;
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      </div>";
      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` ORDER BY NOM_GROUPE ASC");
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  


      $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
      $todaydate = strtotime(date('Y-m-d'));
      $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      $realdate = date('d/m/Y', $realdate);
      $data['datemin'] = $realdate;


      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  
      $todaydates = strtotime(date($selected['DATE_NAISSANCE']));
      $realdates = date('d/m/Y', $todaydates);
      $data['selecteds'] = $realdates;

      $this->load->view('Membre_Update_Ayant_View',$data);
    }
    else{

      $datas=array('NOM'=>$NOM,
       'PRENOM'=>$PRENOM,
       'CNI'=>$CNI,
       'DATE_ADHESION'=>$DATE_ADHESION,
       'CODE_AFILIATION'=>$CODE_AFILIATION,
       'TELEPHONE'=>$TELEPHONE,
       'ID_SEXE'=>$ID_SEXE,
       'COMMUNE_ID'=>$COMMUNE_ID,
       'PROVINCE_ID'=>$PROVINCE_ID,
       'ID_GROUPE_SANGUIN'=>$ID_GROUPE_SANGUIN,
       'ID_EMPLOI'=>$ID_EMPLOI,
       'ID_AGENCE'=>$ID_AGENCE,
       'DATE_NAISSANCE'=>$DATE_NAISSANCE,
       'ADRESSE'=>$ADRESSE,
     );
    // echo "<pre>";
    // print_r($datas);
      $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$datas);

      $repPhotoo =FCPATH.'/uploads/image_membre';
      $code=uniqid();
      $logo_societe = $_FILES['URL_PHOTO']['name'];

      if ($logo_societe != null) {
        $config['upload_path'] ='./uploads/image_membre/';
        $config['allowed_types'] = '*';
        $test = explode('.', $logo_societe);
        $ext = end($test);
        $name = $code.'_membre.' . $ext;
        $config['file_name'] =$name;
        if(!is_dir($repPhotoo)) //create the folder if it does not already exists   
        {
          mkdir($repPhotoo,0777,TRUE);                                                  
        }
        $this->upload->initialize($config);
        $this->upload->do_upload('URL_PHOTO');
        $image_name_main=$config['file_name'];
        $data_image=$this->upload->data();
        $data_pict=array('URL_PHOTO'=>$image_name_main);
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$data_pict);
      }




      $message = "<div class='alert alert-success' id='message'>
      Affili&eacute; modifi&eacute; avec succés
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      // redirect(base_url('membre/Membre/listing'));    
      redirect(base_url('membre/Membre/ayant_droits/'.$selected['CODE_PARENT']));    

    }

  }


  public function ayant_droits($id)
  { 
    $data['title']=' Affili&eacute;';
    $data['stitle']=' Affili&eacute;';
    $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
    $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
    $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
    $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
    $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
    $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC"); 
    $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
    $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
    $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
    $data['agroupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` ORDER BY NOM_GROUPE ASC"); 
    $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
    $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$id,'IS_AFFILIE'=>1));

    $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
    $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
    $todaydate = strtotime(date('Y-m-d'));
    $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
    $realdate = date('d/m/Y', $realdate);
    $data['datemin'] = $realdate;
    $data['display_modal'] = 0;

    $this->load->view('Membre_Ayant_Droits_View',$data);
  }



  public function ayant_droits_add()
  {


    $NOM=$this->input->post('NOM');
    $PRENOM=$this->input->post('PRENOM');
    $CNI=$this->input->post('CNI');
    $DATE_ADHESION=$this->input->post('DATE_ADHESION');
    $CODE_AFILIATION=$this->input->post('CODE_AFILIATION');
    $TELEPHONE=$this->input->post('TELEPHONE');
    $ID_SEXE=$this->input->post('ID_SEXE');
    $ID_GROUPE_SANGUIN=$this->input->post('ID_GROUPE_SANGUIN');
    $DATE_NAISSANCE=$this->input->post('DATE_NAISSANCE');
    $ADRESSE=$this->input->post('ADRESSE');
    $DATE_DEBUT=$this->input->post('DATE_ADHESION');
    $ID_MEMBRE=$this->input->post('ID_MEMBRE');
    $IS_CONJOINT=$this->input->post('IS_CONJOINT');

    $NOM_DOCUMENT=$this->input->post('NOM_DOCUMENT');
    $ATT_DOCUMENT=$this->input->post('ATT_DOCUMENT');
    $DATE_DOCUMENT=$this->input->post('DATE_DOCUMENT');

    $this->form_validation->set_rules('NOM', 'Nom', 'required');
    $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');
    $this->form_validation->set_rules('ID_SEXE', 'Sexe', 'required');
    $this->form_validation->set_rules('ID_GROUPE_SANGUIN', 'Groupe Sanguin', 'required');
    $this->form_validation->set_rules('DATE_NAISSANCE', 'Date de naissance', 'required');
    $this->form_validation->set_rules('IS_CONJOINT', 'Conjoint', 'required');

    $date1 = new DateTime($this->input->post('DATE_NAISSANCE'));
    $date2 = new DateTime(date('Y-m-d'));

    $date1 = $date1->format('Y');
    $date2 = $date2->format('Y');

    $date_test=$date2-$date1;

    if ($this->input->post('IS_CONJOINT')==0 && $date_test>=18) {
      $this->form_validation->set_rules('NOM_DOCUMENT', 'Nom document', 'required');
      $this->form_validation->set_rules('ATT_DOCUMENT', 'Document', 'callback_validate_file');
      $this->form_validation->set_rules('DATE_DOCUMENT', 'Date document', 'required');
    }
   // $this->form_validation->set_rules('URL_PHOTO', 'Photo', 'required');


    if ($this->form_validation->run() == FALSE){


      $message = "<div class='alert alert-danger' id='message'>
      Ayant droit non enregistr&eacute;
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` ORDER BY NOM_GROUPE ASC"); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  
      $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$ID_MEMBRE,'IS_AFFILIE'=>1));
      $data['display_modal'] = 1;
      $this->load->view('Membre_Ayant_Droits_View',$data);
    }
    else{
      $parentmembre = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));
      $COMMUNE_ID=0;
      $PROVINCE_ID=0;
      $ID_EMPLOI=0;
      $ID_AGENCE=0;
      if (!empty($parentmembre)) {
        $COMMUNE_ID=$parentmembre['COMMUNE_ID'];
        $PROVINCE_ID=$parentmembre['PROVINCE_ID'];
        $ID_EMPLOI=$parentmembre['ID_EMPLOI'];
        $ID_AGENCE=$parentmembre['ID_AGENCE'];
      }


      $repPhotoos =FCPATH.'/uploads/image_membre';
      $codes=uniqid();
      $logo_societes = $_FILES['ATT_DOCUMENT']['name'];
      $configs['upload_path'] ='./uploads/image_membre/';
      $configs['allowed_types'] = '*';
      $tests = explode('.', $logo_societes);
      $exts = end($tests);
      $names = $codes.'_document.' . $exts;
      $configs['file_name'] =$names;
        if(!is_dir($repPhotoos)) //create the folder if it does not already exists   
        {
          mkdir($repPhotoos,0777,TRUE);                                                           
        }
        $this->upload->initialize($configs);
        $this->upload->do_upload('ATT_DOCUMENT');
        $image_name_mains=$configs['file_name'];
        $data_images=$this->upload->data();

        $datas=array('NOM'=>$NOM,
         'PRENOM'=>$PRENOM,
         'CNI'=>$CNI,
         'DATE_ADHESION'=>$DATE_ADHESION,
         'CODE_AFILIATION'=>$CODE_AFILIATION,
         'TELEPHONE'=>$TELEPHONE,
         'ID_SEXE'=>$ID_SEXE,
         'COMMUNE_ID'=>$COMMUNE_ID,
         'PROVINCE_ID'=>$PROVINCE_ID,
         'ID_GROUPE_SANGUIN'=>$ID_GROUPE_SANGUIN,
         'ID_EMPLOI'=>$ID_EMPLOI,
         'ID_AGENCE'=>$ID_AGENCE,
         'DATE_NAISSANCE'=>$DATE_NAISSANCE,
         'ADRESSE'=>$ADRESSE,
         'IS_AFFILIE'=>1,
         'CODE_PARENT'=>$ID_MEMBRE,
         'IS_CONJOINT'=>$IS_CONJOINT,

         'NOM_DOCUMENT'=>$NOM_DOCUMENT,
         'ATT_DOCUMENT'=>$image_name_mains,
         'DATE_DOCUMENT'=>$DATE_DOCUMENT,

       );
    // echo "<pre>";
    // print_r($datas);
        $ID_MEMBRES = $this->Model->insert_last_id('membre_membre',$datas);

        $assumembre = $this->Model->getList('membre_assurances',array('ID_MEMBRE'=>$ID_MEMBRE,'STATUS'=>1));
        foreach ($assumembre as $keys) {
          $ID_CATEGORIE_ASSURANCE=$keys['ID_CATEGORIE_ASSURANCE'];
          $ID_REGIME_ASSURANCE=$keys['ID_REGIME_ASSURANCE'];

          $dataass=array('ID_MEMBRE'=>$ID_MEMBRES,
           'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
           'ID_REGIME_ASSURANCE'=>$ID_REGIME_ASSURANCE,
           'DATE_DEBUT'=>$DATE_DEBUT
         );
          $this->Model->insert_last_id('membre_assurances',$dataass);
    // print_r($dataass);
        }

        $groupmembre = $this->Model->getList('membre_groupe_membre',array('ID_MEMBRE'=>$ID_MEMBRE,'STATUS'=>1));
        foreach ($groupmembre as $keys) {
          $ID_GROUPE=$keys['ID_GROUPE'];
          $datagroupe=array('ID_MEMBRE'=>$ID_MEMBRES,
           'ID_GROUPE'=>$ID_GROUPE,
           'DATE_DEBUT'=>$DATE_DEBUT
         );
          $this->Model->insert_last_id('membre_groupe_membre',$datagroupe);

    // print_r($datagroupe);
        }



        $repPhotoo =FCPATH.'/uploads/image_membre';
        $code=uniqid();
        $logo_societe = $_FILES['URL_PHOTO']['name'];
        $config['upload_path'] ='./uploads/image_membre/';
        $config['allowed_types'] = '*';
        $test = explode('.', $logo_societe);
        $ext = end($test);
        $name = $code.'_membre.' . $ext;
        $config['file_name'] =$name;
        if(!is_dir($repPhotoo)) //create the folder if it does not already exists   
        {
          mkdir($repPhotoo,0777,TRUE);                                                           
        }
        $this->upload->initialize($config);
        $this->upload->do_upload('URL_PHOTO');
        $image_name_main=$config['file_name'];
        $data_image=$this->upload->data();

        $data_pict=array('URL_PHOTO'=>$image_name_main);
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRES),$data_pict);





        // $data_picts=array('ATT_DOCUMENT'=>$image_name_mains);
        // $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRES),$data_picts);

    // exit();
        $message = "<div class='alert alert-success' id='message'>
        Ayant droit enregistr&eacute; avec succés
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        </div>";
        $this->session->set_flashdata(array('message'=>$message));
        redirect(base_url('membre/Membre/ayant_droits/'.$ID_MEMBRE));    

      }
    }

    public function upload_file($input_name)
    { 
      $nom_file = $_FILES[$input_name]['tmp_name'];
      $nom_champ = $_FILES[$input_name]['name'];
      $ext=pathinfo($nom_champ, PATHINFO_EXTENSION); 
      $repertoire_fichier = FCPATH . 'uploads';  
      $code=uniqid(); 
      $name=$code . 'doc.' .$ext; 
      $file_link = $repertoire_fichier . $name;


        // $fichier = basename($nom_champ);
      if (!is_dir($repertoire_fichier)) { 
        mkdir($repertoire_fichier, 0777, TRUE); 
      } 
      move_uploaded_file($nom_file, $file_link); 
      return $name; 
    }


  // public function desactiver($id)
  //   {
  //     $this->Model->update('masque_stucture_sanitaire',array('ID_STRUCTURE'=>$id),array('STATUS'=>0));
  //     $message = "<div class='alert alert-success' id='message'>
  //                           Stucture sanitaire désactivé avec succés
  //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
  //                     </div>";
  //     $this->session->set_flashdata(array('message'=>$message));
  //     redirect(base_url('saisie/Structure_Sanitaire/listing')); 
  //   }

  // public function reactiver($id)
  //   {
  //     $this->Model->update('masque_stucture_sanitaire',array('ID_STRUCTURE'=>$id),array('STATUS'=>1));
  //     $message = "<div class='alert alert-success' id='message'>
  //                           Stucture sanitaire Réactivé avec succés
  //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
  //                     </div>";
  //     $this->session->set_flashdata(array('message'=>$message));
  //     redirect(base_url('saisie/Structure_Sanitaire/listing')); 
  //   }

    public function desactiver_ayant_droit($id)
    {
      $parentmembre = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
      $this->Model->update('membre_groupe_membre',array('ID_MEMBRE'=>$id),array('STATUS'=>0,'DATE_FIN'=>date('Y-m-d H:i')));
      $this->Model->update('membre_assurances',array('ID_MEMBRE'=>$id),array('STATUS'=>0,'DATE_FIN'=>date('Y-m-d H:i')));
      $this->Model->update('membre_membre',array('ID_MEMBRE'=>$id),array('STATUS'=>0));
      // membre_groupe_membre DATE_FIN
      // membre_assurances
      // membre_membre
      $message = "<div class='alert alert-danger' id='message'>
      Ayant droit désactivé avec succés
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      // redirect(base_url('saisie/Structure_Sanitaire/listing')); 
      redirect(base_url('membre/Membre/ayant_droits/'.$parentmembre['CODE_PARENT']));    

    }


    public function reactiver_ayant_droit($id)
    {
      $parentmembre = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
      $this->Model->update('membre_groupe_membre',array('ID_MEMBRE'=>$id),array('STATUS'=>1,'DATE_FIN'=>NULL));
      $this->Model->update('membre_assurances',array('ID_MEMBRE'=>$id),array('STATUS'=>1,'DATE_FIN'=>NULL));
      $this->Model->update('membre_membre',array('ID_MEMBRE'=>$id),array('STATUS'=>1));
      // membre_groupe_membre DATE_FIN
      // membre_assurances
      // membre_membre
      $message = "<div class='alert alert-success' id='message'>
      Ayant droit réactivé avec succés
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      // redirect(base_url('saisie/Structure_Sanitaire/listing')); 
      redirect(base_url('membre/Membre/ayant_droits/'.$parentmembre['CODE_PARENT']));    

    }

    public function supprimer($id)
    {

      // echo $id;

      $membre = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
      $groupe = $this->Model->getOne('membre_groupe_membre',array('ID_MEMBRE'=>$id));
      $affilie = $this->Model->getRequete('SELECT * FROM membre_membre WHERE CODE_PARENT = '.$membre['ID_MEMBRE'].'');

      // echo 'First '.$membre['ID_MEMBRE'].'<br>';
      foreach ($affilie as $keys) {
        $groupeaf = $this->Model->getOne('membre_groupe_membre',array('ID_MEMBRE'=>$keys['ID_MEMBRE']));
        // echo $keys['ID_MEMBRE'].' - '.$groupeaf['ID_GROUPE_MEMBRE'].'<br>';
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$keys['ID_MEMBRE']),array('STATUS'=>0));
        $this->Model->update('membre_groupe_membre',array('ID_MEMBRE'=>$keys['ID_MEMBRE']),array('STATUS'=>0));
      }

      $carte = $this->Model->getOne('membre_carte_membre',array('ID_MEMBRE'=>$id));
      // echo 'Carte '.$carte['ID_CARTE'];

      $this->Model->update('membre_carte_membre',array('ID_CARTE'=>$carte['ID_CARTE']),array('STATUS'=>0));
      $this->Model->update('membre_carte',array('ID_CARTE'=>$carte['ID_CARTE']),array('STATUS'=>0,'DATE_FIN_VALIDITE'=>date('Y-m-d')));
      $this->Model->update('membre_membre',array('ID_MEMBRE'=>$id),array('STATUS'=>0));
      $this->Model->update('membre_groupe_membre',array('ID_MEMBRE'=>$id),array('STATUS'=>0));



      $message = "<div class='alert alert-success' id='message'>
      Affili&eacute; effac&eacute; avec succés
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Membre/listing'));  

      
      

      
      


    }


    public function assurances_index($id)
    {

      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi']=$this->Model->getRequete("SELECT * FROM `masque_emploi` ORDER BY DESCRIPTION ASC");
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance',array('ID_REGIME_ASSURANCE'=>1)); 
      $data['agroupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` ORDER BY NOM_GROUPE ASC");
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
      $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$id,'IS_AFFILIE'=>1));
      $data['aassurances'] = $this->Model->getRequete('SELECT * FROM membre_assurances LEFT JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_assurances.ID_CATEGORIE_ASSURANCE WHERE membre_assurances.ID_MEMBRE = '.$id.' ');
      $this->load->view('Membre_Assurance_Index_View',$data);
    }


    
    public function update_assurances()
    {

      $ID_MEMBRE_ASSURANCE=$this->input->post('ID_MEMBRE_ASSURANCE');
      $ID_CATEGORIE_ASSURANCE=$this->input->post('ID_CATEGORIE_ASSURANCE');
      $DATE_DEBUT=$this->input->post('DATE_DEBUT');
      // echo $ID_MEMBRE_ASSURANCE.'<br>';
      // echo $ID_CATEGORIE_ASSURANCE.'<br>';
      // echo $DATE_DEBUT.'<br>';

    // $datax=array('ID_MEMBRE'=>$ID_MEMBRE,
    //              'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
    //              'ID_REGIME_ASSURANCE'=>$ID_REGIME_ASSURANCE,
    //              'DATE_DEBUT'=>$DATE_DEBUT
    //             );
      $donneab = $this->Model->getOne('membre_assurances',array('ID_MEMBRE_ASSURANCE'=>$ID_MEMBRE_ASSURANCE));

    // print_r($donneab);


      $allmem=$this->Model->getList('membre_membre',array('IS_AFFILIE'=>1,'CODE_PARENT'=>$donneab['ID_MEMBRE']));
    // echo "<pre>";
    // print_r($allmem);

      foreach ($allmem as $key) {
        $this->Model->update('membre_assurances',array('ID_MEMBRE'=>$key['ID_MEMBRE'],'ID_CATEGORIE_ASSURANCE'=>$donneab['ID_CATEGORIE_ASSURANCE']),array('ID_CATEGORIE_ASSURANCE'=>$this->input->post('ID_CATEGORIE_ASSURANCE')));
      }

      $this->Model->update('membre_assurances',array('ID_MEMBRE'=>$donneab['ID_MEMBRE'],'ID_CATEGORIE_ASSURANCE'=>$donneab['ID_CATEGORIE_ASSURANCE']),array('ID_CATEGORIE_ASSURANCE'=>$this->input->post('ID_CATEGORIE_ASSURANCE')));


      $cart = $this->Model->getOne('membre_carte_membre',array('ID_MEMBRE'=>$donneab['ID_MEMBRE']));

      $this->Model->update('membre_carte',array('ID_CARTE'=>$cart['ID_CARTE']),array('ID_CATEGORIE_ASSURANCE'=>$this->input->post('ID_CATEGORIE_ASSURANCE')));



      $message = "<div class='alert alert-success' id='message'>
      Categorie modifié avec succés
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Membre/listing'));  

    }


    function get_qr_code($id)
    {

     $info=$this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
     $name=date('Ymdhis').$id;
     $lien=base_url('membre/Membres/details_one/'.$id);
     $this->notifications->generateQrcode($lien,$name);
     $this->Model->insert_last_id('membre_membre_qr',array('ID_MEMBRE'=>$id,'PATH_QR_CODE'=>$name.'.png'));

     

   }

   public function validate_file() {
    if (empty($_FILES['ATT_DOCUMENT']['name'])) {
      $this->form_validation->set_message('validate_file', 'The {field} field is required.');
      return FALSE;
    }
    return TRUE;
  }



}
?>