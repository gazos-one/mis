<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cotisation_New extends CI_Controller {

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
    $data['title']=' Cotisation';
    $data['stitle']=' Cotisation';

    // $data['ID_COTISATION']=$ID_COTISATION;
    $data['membre']=$this->Model->getRequete("SELECT membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM FROM membre_membre LEFT JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION WHERE cotisation_categorie_membre.STATUS=1");

    $data['groupe']= $this->Model->getList("membre_groupe");
    
    $this->load->view('Cotisation_New_Views',$data);
    }

    
    public function groupe()
    {
    $data['title']=' Cotisation';
    $data['stitle']=' Cotisation';

    // $data['ID_COTISATION']=$ID_COTISATION;
    $data['groupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` WHERE STATUS =1");
    $this->load->view('Ajout_Cotisation_Groupe_Add_View',$data);
    }


    public function getMembre()
    { 

    $ID_MEMBRES=$this->input->post('ID_MEMBRE');
    
    $donne_cotisation=$this->Model->getRequeteOne("SELECT cotisation_categorie_membre.ID_CATEGORIE_COTISATION_MEMBRE, membre_membre.ID_MEMBRE, cotisation_montant_cotisation.ID_MONTANT_COTISATION, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_montant_cotisation.ID_PERIODE_COTISATION, cotisation_periode.NB_JOURS FROM cotisation_categorie_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_categorie_membre.ID_MEMBRE JOIN cotisation_montant_cotisation ON cotisation_categorie_membre.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE cotisation_categorie_membre.STATUS = 1 AND membre_membre.ID_MEMBRE = ".$this->input->post('ID_MEMBRE')." ");



$sts1 = date("Y-m-01", strtotime($this->input->post('MOIS_DEBUT_COTISATION')));
$sts2 = date("Y-m-t", strtotime($this->input->post('MOIS_FIN_COTISATION')));


$ts1 = strtotime($sts1);
$ts2 = strtotime($sts2);

$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);

$month1 = date('m', $ts1);
$month2 = date('m', $ts2);

$ndiff = (($year2 - $year1) * 12) + ($month2 - $month1);
$diff = $ndiff + 1;
// echo  $diff.'<br>';

$resultat = "<table id='examples' class='table' style='width:100%'>
          <thead>
          <tr>
                  <th colspan='2' class='text-center'>Periode: ".$sts1." a ".$sts2."</th>
              </tr>
              <tr>
                  <th>Periode de paiement</th>
                  <th>Paiement</th>
              </tr>
          </thead>
          <tbody>";
$montant = 0;

for($i = 0; $i < $diff; $i++){

    $effectiveDate = date('Y-m', strtotime("+".$i." months", strtotime($sts1)));

    $nonpaie=$this->Model->getRequeteOne('SELECT DATE_FORMAT(cotisation_cotisation.MOIS_COTISATION, "%Y-%m") FROM cotisation_cotisation WHERE 1 AND cotisation_cotisation.ID_MEMBRE = '.$this->input->post('ID_MEMBRE').' AND DATE_FORMAT(cotisation_cotisation.MOIS_COTISATION, "%Y-%m") like "'.$effectiveDate.'" ');

    if (empty($nonpaie)) {
      $montant += $donne_cotisation['MONTANT_COTISATION'];
           $resultat.="<tr>
                  <td>".$effectiveDate." 
                  <input type='hidden' name='MOIS_COTISATION[]' value='".$effectiveDate."'>
                  </td>
                  <td>".$donne_cotisation['MONTANT_COTISATION']."</td>
              </tr>";
    }

}
    $resultat.='<tfooter>
              <tr>
                  <th>Total</th>
                  <th>'.$montant.'</th>
              </tr>
          </tfooter></tbody></table> ';
    $resultat.="<script>
    $(document).ready(function() {
      $('#examples').DataTable( {
          'paging':   false,
          'ordering': false,
          'info':     false,
          'searching':   false
      } );
  } );
  </script>";

  $resultat .='<div class="row" style="margin-top: 5px">
                                            <div class="col-12" id="divdata">
                                            <input type="submit" class="btn btn-primary btn-block" value="Enregistrer" />
                                            </div>
                                        </div>';
  echo $resultat;

    } 


    public function getMembregroupe()
    { 

    $ID_GROUPE=$this->input->post('ID_GROUPE');

    $listegroup = $this->Model->getRequete('SELECT membre_groupe_membre.ID_MEMBRE FROM `membre_groupe` JOIN membre_groupe_membre ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_groupe_membre.ID_MEMBRE where membre_groupe.ID_GROUPE = '.$ID_GROUPE.' '); 
    // print_r($listegroup);

    $sts1 = date("Y-m-01", strtotime($this->input->post('MOIS_DEBUT_COTISATION')));
    $sts2 = date("Y-m-t", strtotime($this->input->post('MOIS_FIN_COTISATION')));

    $ts1 = strtotime($sts1);
    $ts2 = strtotime($sts2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $ndiff = (($year2 - $year1) * 12) + ($month2 - $month1);
    $diff = $ndiff + 1;

    $resultat = "
  <table class='table'>
  <tr>
                  <th class='text-center'>Periode: ".$sts1." a ".$sts2."</th>
              </tr>
  </table>  
    <table id='examples' class='table' style='width:100%'>
          <thead>
          
              <tr>
                  <th>Affili&eacute;</th>
                  <th>Periode de paiement</th>
                  <th>Paiement</th>
              </tr>
          </thead>
          <tbody>";


         

    $montant = 0;

    foreach ($listegroup as $value) {
        $donne_cotisation=$this->Model->getRequeteOne("SELECT cotisation_categorie_membre.ID_CATEGORIE_COTISATION_MEMBRE, membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, cotisation_montant_cotisation.ID_MONTANT_COTISATION, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_montant_cotisation.ID_PERIODE_COTISATION, cotisation_periode.NB_JOURS FROM cotisation_categorie_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_categorie_membre.ID_MEMBRE JOIN cotisation_montant_cotisation ON cotisation_categorie_membre.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE cotisation_categorie_membre.STATUS = 1 AND membre_membre.ID_MEMBRE = ".$value['ID_MEMBRE']." ");

        
// echo  $diff.'<br>';

for($i = 0; $i < $diff; $i++){

    $effectiveDate = date('Y-m', strtotime("+".$i." months", strtotime($sts1)));

    $nonpaie=$this->Model->getRequeteOne('SELECT DATE_FORMAT(cotisation_cotisation.MOIS_COTISATION, "%Y-%m") FROM cotisation_cotisation WHERE 1 AND cotisation_cotisation.ID_MEMBRE = '.$value['ID_MEMBRE'].' AND DATE_FORMAT(cotisation_cotisation.MOIS_COTISATION, "%Y-%m") like "'.$effectiveDate.'" ');

    if (empty($nonpaie)) {
      $montant += $donne_cotisation['MONTANT_COTISATION'];
           $resultat.="<tr>
                  <td>".$donne_cotisation['NOM']." ".$donne_cotisation['PRENOM']."</td>
                  <td>".$effectiveDate." 
                  <input type='hidden' name='MOIS_COTISATION[]' value='".$effectiveDate."'>
                  </td>
                  <td>".$donne_cotisation['MONTANT_COTISATION']."</td>
              </tr>";
    }

}
    }


    

    $resultat.='<tfooter>
              <tr>
                  <th colspan="2">Total</th>
                  <th>'.$montant.'</th>
              </tr>
          </tfooter></tbody></table> ';
    $resultat.="<script>
    $(document).ready(function() {
      $('#examples').DataTable( {
          'paging':   true,
          'ordering': true,
          'info':     true,
          'searching':   true
      } );
  } );
  </script>";

  $resultat .='<div class="row" style="margin-top: 5px">
                                            <div class="col-12" id="divdata">
                                            <input type="submit" class="btn btn-primary btn-block" value="Enregistrer" />
                                            </div>
                                        </div>';
  echo $resultat;

    } 

    public function add()
    {
      $ID_MEMBRE = $this->input->post('ID_MEMBRE');
      $COLLABORATEUR_ID_ARRAY = $this->input->post('MOIS_COTISATION');
      // $MOIS_COTISATION=$this->input->post('MOIS_COTISATION'); 
      // $onerow =$this->Model->getRequeteOne('SELECT coti_type_membre.COTISATION_MENSUELLE FROM coti_membre JOIN coti_type_membre ON coti_type_membre.ID_TYPE_MEMBRE = coti_membre.ID_TYPE_MEMBRE WHERE  coti_membre.ID_MEMBRE ="'.$ID_MEMBRE.'" ');
      $onerow=$this->Model->getRequeteOne("SELECT cotisation_categorie_membre.ID_CATEGORIE_COTISATION , cotisation_montant_cotisation.MONTANT_COTISATION FROM cotisation_categorie_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_categorie_membre.ID_MEMBRE JOIN cotisation_montant_cotisation ON cotisation_categorie_membre.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE cotisation_categorie_membre.STATUS = 1 AND membre_membre.ID_MEMBRE = ".$ID_MEMBRE." ");

      // echo "<pre>";
      foreach ($COLLABORATEUR_ID_ARRAY as $MOIS_COTISATION) {

      $datas=array(
                    'ID_MEMBRE'=>$ID_MEMBRE,
                    'ID_CATEGORIE_COTISATION'=>$onerow['ID_CATEGORIE_COTISATION'],
                    'MONTANT_COTISATION'=>$onerow['MONTANT_COTISATION'],
                    'MOIS_COTISATION'=>$MOIS_COTISATION.'-01',
                    'USER_SAVER'=>$this->session->userdata('MIS_ID_USER'),
                  );
      echo "<pre>";
      // print_r($datas);
      $this->Model->insert_last_id('cotisation_cotisation',$datas);
      }

      $message = "<div class='alert alert-success' id='message'>
                              Cotisation enregistr&eacute; avec succés
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Ajout_Cotisation'));    
    } 



    public function addgroupe()
    {
    //   $ID_MEMBRE = $this->input->post('ID_MEMBRE');

      $ID_GROUPE=$this->input->post('ID_GROUPE');

    $listegroup = $this->Model->getRequete('SELECT membre_groupe_membre.ID_MEMBRE FROM `membre_groupe` JOIN membre_groupe_membre ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_groupe_membre.ID_MEMBRE where membre_groupe.ID_GROUPE = '.$ID_GROUPE.' '); 

    foreach ($listegroup as $value) {
      $ID_MEMBRE = $value['ID_MEMBRE'];
      $COLLABORATEUR_ID_ARRAY = $this->input->post('MOIS_COTISATION');
      $onerow=$this->Model->getRequeteOne("SELECT cotisation_categorie_membre.ID_CATEGORIE_COTISATION , cotisation_montant_cotisation.MONTANT_COTISATION FROM cotisation_categorie_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_categorie_membre.ID_MEMBRE JOIN cotisation_montant_cotisation ON cotisation_categorie_membre.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE cotisation_categorie_membre.STATUS = 1 AND membre_membre.ID_MEMBRE = ".$ID_MEMBRE." ");

        // echo "<pre>";
      foreach ($COLLABORATEUR_ID_ARRAY as $MOIS_COTISATION) {

      $datas=array(
                    'ID_MEMBRE'=>$ID_MEMBRE,
                    'ID_CATEGORIE_COTISATION'=>$onerow['ID_CATEGORIE_COTISATION'],
                    'MONTANT_COTISATION'=>$onerow['MONTANT_COTISATION'],
                    'MOIS_COTISATION'=>$MOIS_COTISATION.'-01',
                    'USER_SAVER'=>$this->session->userdata('MIS_ID_USER'),
                  );
    //   echo "<pre>";
    //   print_r($datas);

      $nonpaie=$this->Model->getRequeteOne('SELECT DATE_FORMAT(cotisation_cotisation.MOIS_COTISATION, "%Y-%m") FROM cotisation_cotisation WHERE 1 AND cotisation_cotisation.ID_MEMBRE = '.$ID_MEMBRE.' AND DATE_FORMAT(cotisation_cotisation.MOIS_COTISATION, "%Y-%m") like "'.$MOIS_COTISATION.'" ');

    if (empty($nonpaie)) {
        $this->Model->insert_last_id('cotisation_cotisation',$datas);
    }

        
      }

    }

    

    
    

      $message = "<div class='alert alert-success' id='message'>
                              Cotisation enregistr&eacute; avec succés
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Ajout_Cotisation/groupe'));    
    } 
   





}