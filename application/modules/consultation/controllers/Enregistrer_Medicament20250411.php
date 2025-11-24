<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enregistrer_Medicament extends CI_Controller {

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
    $data['title']=' Medicament';
    $data['stitle']=' Medicament';
    $data['periode'] = $this->Model->getListOrdertwo('consultation_pharmacie',array(),'DESCRIPTION'); 
    $data['medoc'] = $this->Model->getListOrdertwo('masque_medicament',array(),'DESCRIPTION'); 
    // $data['ID_COTISATION']=$ID_COTISATION;
    // $data['membre']=$this->Model->getRequete("SELECT membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM FROM membre_membre LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION WHERE cotisation_categorie_membre.STATUS=1");
    $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
    $data['commune'] = $this->Model->getList('syst_communes');
    $data['groupe']= $this->Model->getList("membre_groupe");

    $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
    $data['affilie']= $this->Model->getList("membre_membre",array('IS_AFFILIE'=>0));
    //   $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
    $this->load->view('Enregistrer_Medicament_Add_View',$data);
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

    
    public function getaffilie()
    {
    $commune= $this->Model->getList("membre_membre",array('CODE_PARENT'=>$this->input->post('TYPE_AFFILIE')));
    $affi= $this->Model->getOne("membre_membre",array('ID_MEMBRE'=>$this->input->post('TYPE_AFFILIE')));
    $datas= '<option value="">-- Sélectionner --</option>';
    $datas.= '<option value="'.$this->input->post('TYPE_AFFILIE').'">Lui meme ('.$affi["NOM"].' '.$affi["PRENOM"].')</option>';
    foreach($commune as $commun){
    $datas.= '<option value="'.$commun["ID_MEMBRE"].'">'.$commun["NOM"].' '.$commun["PRENOM"].'</option>';
    }
    $datas.= '';
    echo $datas;
    }

    
    public function getmedoc()
    {
    $commune= $this->Model->getList("masque_medicament",array('ID_COUVERTURE_MEDICAMENT'=>$this->input->post('ID_COUVERTURE_MEDICAMENT')));
    $datas= '<option value="">-- Sélectionner --</option>';
    foreach($commune as $commun){
    $datas.= '<option value="'.$commun["ID_MEDICAMENT"].'">'.$commun["DESCRIPTION"].'</option>';
    }
    $datas.= '';
    echo $datas;
    }

    

    public function add_tocart()
    {

        $datas=array(
            'ID_COUVERTURE_MEDICAMENT'=>$this->input->post('ID_COUVERTURE_MEDICAMENT'),
            'ID_MEDICAMENT'=>$this->input->post('ID_MEDICAMENT'),
            'MONTANT_UNITAIRE_SANS_TAUX'=>$this->input->post('MONTANT_UNITAIRE_SANS_TAUX'),
            'QUANTITE'=>$this->input->post('QUANTITE'),
            'POURCENTAGE'=>$this->input->post('POURCENTAGE'),
            'ID_CONSULTATION_MEDICAMENT'=>$this->input->post('ID_MEMBRE').'_'.$this->input->post('NUM_BORDERAUX'),
            
          );

$this->Model->insert_last_id('consultation_medicament_details',$datas);
    $commune= $this->Model->getRequete("SELECT ID_CONSULTATION_MEDICAMENT_DETAILS, syst_couverture_medicament.DESCRIPTION AS TYPE_MEDICAMENT, masque_medicament.DESCRIPTION AS MEDICAMENT, MONTANT_UNITAIRE_SANS_TAUX, QUANTITE, POURCENTAGE, (((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) * POURCENTAGE) /100 ) AS TOTAL_PORCENTAGE, (MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) AS TOTAL_BRUT, ((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) - (((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) * POURCENTAGE) /100 )) AS PAYABLE FROM `consultation_medicament_details` JOIN syst_couverture_medicament ON syst_couverture_medicament.ID_COUVERTURE_MEDICAMENT = consultation_medicament_details.ID_COUVERTURE_MEDICAMENT JOIN masque_medicament ON masque_medicament.ID_MEDICAMENT = consultation_medicament_details.ID_MEDICAMENT WHERE 1 AND ID_CONSULTATION_MEDICAMENT LIKE '".$this->input->post('ID_MEMBRE')."_".$this->input->post('NUM_BORDERAUX')."'  ");

    $datas= '<table class="table">';
    $datas.='<tr>
                <td><b>Type</b></td>
                <td><b>Medicament</b></td>
                <td class="text-right"><b>Prix Brut</b></td>
                <td class="text-right"><b>Quantite</b></td>
                <td class="text-right"><b>%</b></td>
                <td class="text-right"><b>Total</b></td>
                <td class="text-right"><b>A Payer</b></td>
                <td></td>
            </tr>';
    $totolpayabe =0;
    $totalbrut =0;
    foreach($commune as $commun){
    $totolpayabe +=$commun["PAYABLE"];
    $totalbrut +=$commun["TOTAL_BRUT"];
    $datas.= '<tr>
                <td>'.$commun["TYPE_MEDICAMENT"].'</td>
                <td>'.$commun["MEDICAMENT"].'</td>
                <td class="text-right">'.$commun["MONTANT_UNITAIRE_SANS_TAUX"].'</td>
                <td class="text-right">'.$commun["QUANTITE"].'</td>
                <td class="text-right">'.$commun["POURCENTAGE"].'</td>
                <td class="text-right">'.$commun["TOTAL_BRUT"].'</td>
                <td class="text-right">'.$commun["PAYABLE"].'</td>
                <td><a class="btn btn-danger btn-xs" onclick="remove_cart('.$commun['ID_CONSULTATION_MEDICAMENT_DETAILS'].')" href="#" role="button">Enlever</a>
                </td>
            </tr>';
                    
    }
    $datas.='<tr>
                <td colspan="5"><b>Total</b></td>
                
                <td class="text-right"><b>'.$totalbrut.'</b></td>
                <td class="text-right"><b>'.$totolpayabe.'</b></td>
                <td></td>
            </tr>';
    $datas.= '</table>';
    echo $datas;
    }

    
    public function remove_cart()
    {




$old = $this->Model->getOne('consultation_medicament_details',array('ID_CONSULTATION_MEDICAMENT_DETAILS'=>$this->input->post('ID_CONSULTATION_MEDICAMENT_DETAILS')));

$this->Model->delete('consultation_medicament_details',array('ID_CONSULTATION_MEDICAMENT_DETAILS'=>$this->input->post('ID_CONSULTATION_MEDICAMENT_DETAILS')));


$commune= $this->Model->getRequete("SELECT ID_CONSULTATION_MEDICAMENT_DETAILS, syst_couverture_medicament.DESCRIPTION AS TYPE_MEDICAMENT, masque_medicament.DESCRIPTION AS MEDICAMENT, MONTANT_UNITAIRE_SANS_TAUX, QUANTITE, POURCENTAGE, (((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) * POURCENTAGE) /100 ) AS TOTAL_PORCENTAGE, (MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) AS TOTAL_BRUT, ((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) - (((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) * POURCENTAGE) /100 )) AS PAYABLE FROM `consultation_medicament_details` JOIN syst_couverture_medicament ON syst_couverture_medicament.ID_COUVERTURE_MEDICAMENT = consultation_medicament_details.ID_COUVERTURE_MEDICAMENT JOIN masque_medicament ON masque_medicament.ID_MEDICAMENT = consultation_medicament_details.ID_MEDICAMENT WHERE 1 AND ID_CONSULTATION_MEDICAMENT LIKE '".$old['ID_CONSULTATION_MEDICAMENT']."'  ");

$datas= '<table class="table">';
$datas.='<tr>
            <td><b>Type</b></td>
            <td><b>Medicament</b></td>
            <td class="text-right"><b>Prix Brut</b></td>
            <td class="text-right"><b>Quantite</b></td>
            <td class="text-right"><b>%</b></td>
            <td class="text-right"><b>Total</b></td>
            <td class="text-right"><b>A Payer</b></td>
            <td></td>
        </tr>';
$totolpayabe =0;
$totalbrut =0;
foreach($commune as $commun){
$totolpayabe +=$commun["PAYABLE"];
$totalbrut +=$commun["TOTAL_BRUT"];
$datas.= '<tr>
            <td>'.$commun["TYPE_MEDICAMENT"].'</td>
            <td>'.$commun["MEDICAMENT"].'</td>
            <td class="text-right">'.$commun["MONTANT_UNITAIRE_SANS_TAUX"].'</td>
            <td class="text-right">'.$commun["QUANTITE"].'</td>
            <td class="text-right">'.$commun["POURCENTAGE"].'</td>
            <td class="text-right">'.$commun["TOTAL_BRUT"].'</td>
            <td class="text-right">'.$commun["PAYABLE"].'</td>
            <td><a class="btn btn-danger btn-xs" onclick="remove_cart('.$commun['ID_CONSULTATION_MEDICAMENT_DETAILS'].')" href="#" role="button">Enlever</a>
            </td>
        </tr>';
                
}
$datas.='<tr>
            <td colspan="5"><b>Total</b></td>
            
            <td class="text-right"><b>'.$totalbrut.'</b></td>
            <td class="text-right"><b>'.$totolpayabe.'</b></td>
            <td></td>
        </tr>';
$datas.= '</table>';
echo $datas;
    }

    public function getpourcentage()
    {
    $commune= $this->Model->getRequeteOne("SELECT * FROM syst_categorie_assurance_medicament JOIN syst_couverture_medicament ON syst_couverture_medicament.ID_COUVERTURE_MEDICAMENT = syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE JOIN membre_carte ON membre_carte.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE JOIN membre_carte_membre ON membre_carte_membre.ID_CARTE = membre_carte.ID_CARTE WHERE syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT = ".$this->input->post('ID_COUVERTURE_MEDICAMENT')." AND membre_carte_membre.ID_MEMBRE = ".$this->input->post('ID_MEMBRE')." ORDER BY membre_carte_membre.ID_CARTE_MEMBRE DESC LIMIT 1");
    // echo $commune['POURCENTAGE'];

    if (!empty($commune['POURCENTAGE'])) {
        echo $commune['POURCENTAGE'];
      }
      else{
        $parrent= $this->Model->getRequeteOne("SELECT CODE_PARENT FROM membre_membre WHERE ID_MEMBRE = ".$this->input->post('ID_MEMBRE')." LIMIT 1");
        $npa= $this->Model->getRequeteOne("SELECT * FROM syst_categorie_assurance_medicament JOIN syst_couverture_medicament ON syst_couverture_medicament.ID_COUVERTURE_MEDICAMENT = syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE JOIN membre_carte ON membre_carte.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE JOIN membre_carte_membre ON membre_carte_membre.ID_CARTE = membre_carte.ID_CARTE WHERE syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT = ".$this->input->post('ID_COUVERTURE_MEDICAMENT')." AND membre_carte_membre.ID_MEMBRE = ".$parrent['CODE_PARENT']." ORDER BY membre_carte_membre.ID_CARTE_MEMBRE DESC LIMIT 1");
        echo $npa['POURCENTAGE'];

      }
    // print_r($datas);
    }

    

   
    public function add()
    {

        $datas = array(
            'ID_PHARMACIE' => $this->input->post('ID_PHARMACIE'),
            'TYPE_AFFILIE' => $this->input->post('TYPE_AFFILIE'),
            'ID_MEMBRE' => $this->input->post('ID_MEMBRE'),
            'DATE_CONSULTATION' => $this->input->post('DATE_CONSULTATION'),
            'NUM_BORDERAUX' => $this->input->post('NUM_BORDERAUX'),
            'MEDECIN' => $this->input->post('MEDECIN'),
            'MONTANT_TOTAL_ACHAT' =>0,
            'MONTANT_A_PAYE_MIS' =>0,
            'MONTANT_PAYER_AFFILIE' =>0,
        );
        // echo'<pre>';
        // print_r($datas);
        // echo'</pre>';


        $ID_CONSULTATION_MEDICAMENT = $this->Model->insert_last_id('consultation_medicament',$datas);
        $OLD_ID_CONSULTATION_MEDICAMENT = $this->input->post('ID_MEMBRE')."_".$this->input->post('NUM_BORDERAUX');
        $this->Model->update('consultation_medicament_details',array('ID_CONSULTATION_MEDICAMENT'=>$OLD_ID_CONSULTATION_MEDICAMENT),array('ID_CONSULTATION_MEDICAMENT'=>$ID_CONSULTATION_MEDICAMENT));

        $new_data = $this->Model->getRequeteOne('SELECT SUM((((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) * POURCENTAGE) /100 )) AS TOTAL_PORCENTAGE, SUM((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE)) AS TOTAL_BRUT, SUM(((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) - (((MONTANT_UNITAIRE_SANS_TAUX * QUANTITE) * POURCENTAGE) /100 ))) AS PAYABLE FROM `consultation_medicament_details`  WHERE 1 AND ID_CONSULTATION_MEDICAMENT LIKE '.$ID_CONSULTATION_MEDICAMENT.' ');

        $this->Model->update('consultation_medicament',array('ID_CONSULTATION_MEDICAMENT'=>$ID_CONSULTATION_MEDICAMENT),array('MONTANT_TOTAL_ACHAT'=>$new_data['TOTAL_BRUT'],'MONTANT_A_PAYE_MIS'=>$new_data['TOTAL_PORCENTAGE'],'MONTANT_PAYER_AFFILIE'=>$new_data['PAYABLE']));
        
 

      $message = "<div class='alert alert-success' id='message'>
                              Enregistr&eacute; avec succés
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('consultation/Enregistrer_Medicament'));    
    } 
   

    public function addStructure()
    {
  
    $DESCRIPTION=$this->input->post('DESCRIPTION');
    $PROVINCE_ID=$this->input->post('PROVINCE_ID');
    $COMMUNE_ID=$this->input->post('COMMUNE_ID');
   
    $datas=array('DESCRIPTION'=>$DESCRIPTION,'COMMUNE_ID'=>$COMMUNE_ID,'PROVINCE_ID'=>$PROVINCE_ID);
    $ID_STRUCTURE = $this->Model->insert_last_id('consultation_pharmacie',$datas);
  
    echo '<option value="'.$ID_PHARMACIE.'">'.$this->input->post('DESCRIPTION').'</option>';
  
    }

    
    public function addMedicament()
    {
  
    $DESCRIPTION=$this->input->post('DESCRIPTIONS');
    $ID_COUVERTURE_MEDICAMENT=$this->input->post('ID_COUVERTURE_MEDICAMENTS');
    $COMMUNE_ID=$this->input->post('COMMUNE_ID');
   
    $datas=array('DESCRIPTION'=>$DESCRIPTION,'ID_COUVERTURE_MEDICAMENT'=>$ID_COUVERTURE_MEDICAMENT);
    $ID_MEDICAMENT = $this->Model->insert_last_id('masque_medicament',$datas);
  
    echo '<option value="'.$ID_MEDICAMENT.'">'.$this->input->post('DESCRIPTIONS').'</option>';
  
    }



}