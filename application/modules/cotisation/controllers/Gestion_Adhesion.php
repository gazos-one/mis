<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gestion_Adhesion extends CI_Controller {

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
    

    $data['title']=' Adhesion';
    $data['stitle']=' Adhesion';

    $data['groupe']=$this->Model->getRequete("SELECT * FROM `membre_groupe` WHERE STATUS =1");
   
    $this->load->view('Gestion_Adhesion_View',$data);
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


    public function getMembregroupe()
    { 


    $ID_GROUPE=$this->input->post('ID_GROUPE');

    $listegroup = $this->Model->getRequete('SELECT  membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM FROM membre_membre JOIN membre_groupe_membre on membre_membre.ID_MEMBRE=membre_groupe_membre.ID_MEMBRE WHERE  membre_membre.ID_MEMBRE not in (SELECT ID_MEMBRE FROM frais_adhesion_membres) and membre_groupe_membre.ID_GROUPE='.$ID_GROUPE.' and membre_membre.IS_AFFILIE=0'); 
  
   

    $resultat = "
  
    <table id='examples' class='table' style='width:100%'>
          <thead>
          
              <tr>
                  <th>#</th>
                  <th>Affili&eacute;</th>
                  
              </tr>
          </thead>
          <tbody>";

          // <th>Cocher tout <input type='checkbox' value='1' name='stage'></th>

$i=0;
    foreach ($listegroup as $value) {
$i++;  

        
  $resultat.="<tr>
              <td><input type='checkbox' value='".$value['ID_MEMBRE']."' name='stage".$i."'></td>
                  <td>".$value['NOM']." ".$value['PRENOM']."</td>
              </tr>";
    }


    $resultat.='
          </tbody></table> ';

    // $resultat.='<tfooter>
    //           <tr>
    //               <th colspan="2">Total</th>
    //               <th>'.$montant.'</th>
    //           </tr>
    //       </tfooter></tbody></table> ';
    $resultat.="<script>
    $(document).ready(function() {
      $('#examples').DataTable( {
          'paging':   false,
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



    public function addgroupe($value='')
    {
      $sub_array = array();

      $MONTANT=$this->input->post('MONTANT');
      $ID_GROUPE=$this->input->post('ID_GROUPE');
    



      $listegroup = $this->Model->getRequete('SELECT  membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM FROM membre_membre JOIN membre_groupe_membre on membre_membre.ID_MEMBRE=membre_groupe_membre.ID_MEMBRE WHERE  membre_membre.ID_MEMBRE not in (SELECT ID_MEMBRE FROM frais_adhesion_membres) and membre_groupe_membre.ID_GROUPE='.$ID_GROUPE.' and membre_membre.IS_AFFILIE=0');

      $i=0;
      foreach ($listegroup as $key => $value) 
      {
      $i++;

      if ($this->input->post('stage'.$i.'')!=null) 
      {

       $listegroup = $this->Model->getRequeteOne('SELECT  membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM FROM membre_membre JOIN membre_groupe_membre on membre_membre.ID_MEMBRE=membre_groupe_membre.ID_MEMBRE WHERE  membre_membre.ID_MEMBRE in (SELECT ID_MEMBRE FROM frais_adhesion_membres where ID_MEMBRE='.$this->input->post('stage'.$i.'').' ) and membre_groupe_membre.ID_GROUPE='.$ID_GROUPE.' and membre_membre.IS_AFFILIE=0');
      if (empty($listegroup)) 
      {

      $data_arr=array(
                      'ID_MEMBRE'=>$this->input->post('stage'.$i.''),
                      'MONTANT'=>$MONTANT,
                      );

       $this->Model->create('frais_adhesion_membres',$data_arr);
     
      }

      }

      }


      $data['message']='<div class="alert alert-success text-center" id="message">L\'enregistrement des droits faite avec succés</div>';
      $this->session->set_flashdata($data);





      redirect(base_url('cotisation/Gestion_Adhesion/liste'));
      # code...
    }


     function liste(){
 
     $data['groupe']=$this->Model->getList('membre_groupe');
     $data['title']="";


     $this->load->view("Adhesion_List_View",$data);
     }

function liste2()
{ 
$ID_GROUPE=$this->input->post('ID_GROUPE');
 $crit='';
 if (!empty($ID_GROUPE)) {
 $crit=' and membre_groupe_membre.ID_MEMBRE in (SELECT ID_MEMBRE FROM frais_adhesion_membres where 1 and membre_groupe_membre.ID_GROUPE='.$ID_GROUPE.')';
}

  $query_principal = 'SELECT  membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM,frais_adhesion_membres.MONTANT,membre_groupe_membre.ID_GROUPE,frais_adhesion_membres.DATE_ENREGISTREMENT as date_new FROM membre_membre JOIN frais_adhesion_membres on membre_membre.ID_MEMBRE=frais_adhesion_membres.ID_MEMBRE join membre_groupe_membre on frais_adhesion_membres.ID_MEMBRE=membre_groupe_membre.ID_MEMBRE WHERE 1 and membre_membre.IS_AFFILIE=0 '.$crit.'';


  

  // GROUP BY NOM_CLIENT, PRENOM_CLIENT, TEL_CLIENT
  $var_search = !empty($_POST["search"]["value"]) ? $_POST["search"]["value"] : null;
  $limit = 'LIMIT 0,10';

  $draw = isset($_POST['draw']);
  $start = isset($postData['start']);

  if (isset($_POST["length"]) && $_POST["length"] != -1) {
    $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
}
$order_by = '';
$search = !empty($_POST['search']['value']) ? (" AND (CONCAT(membre_membre.NOM,' ',membre_membre.PRENOM) LIKE '%$var_search%')") : '';
$order_column='';
$order_column = array('membre_membre.NOM');
$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY membre_membre.NOM ASC';

// $critaire = ' ';
//      if ($DATE_ADHESION != 0) {
//         $critaire .= ' AND membre_membre.DATE_ADHESION like "%'.$DATE_ADHESION.'%" ';
//         $data['DATE_ADHESION'] = $this->input->post('DATE_ADHESION');
//       }
//       else{
//         $critaire .= ' ';
//         $data['DATE_ADHESION'] = '';
//       }

      // if ($IS_TAKEN != 3 && $IS_TAKEN != NULL) {
      //   $critaire .= ' AND membre_membre_qr.IS_TAKEN = '.$IS_TAKEN.' ';
      //   $data['IS_TAKEN'] = $this->input->post('IS_TAKEN');
      // }
      // else{
      //   $critaire .= '';
      //   $data['IS_TAKEN'] = 3;
      // }
$critaire= '';

$query_secondaire=$query_principal.' '.$search.' '.$critaire.' '.$order_by.'   '.$limit;
$query_filter = $query_principal.' '.$search.' '.$critaire;
$fetch_cov_frais = $this->Model->datatable($query_secondaire);
$data = array();

foreach ($fetch_cov_frais as $row) {
    $post = array();
      
        $groupes = $this->Model->getRequeteOne('SELECT membre_groupe.NOM_GROUPE FROM membre_groupe_membre JOIN membre_groupe ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE WHERE membre_groupe_membre.ID_MEMBRE = '.$row->ID_MEMBRE.' ');
    $nom_groupe="N/A";
    if (!empty($groupes)) {
    $nom_groupe=$groupes['NOM_GROUPE'];
    }
        
    $post[] = $row->NOM.' '.$row->PRENOM;
    $post[] = $nom_groupe;
    $post[] = $row->MONTANT;
    $post[] = $row->date_new;
    // $newDatefin = date("d-m-Y", strtotime($row->DATE_FIN_VALIDITE));
    // $post[] = $newDatedebut;
    // $post[] = $newDatefin;
    // $post[] = $nban['NB_AYANT'];
    // if (!empty($groupes)) {
    // $post[] = $groupes['NOM_GROUPE'];
    //  } else {
    // $post[] = 'N/A';  
    //  }
    
    // $post[] = $row->STATUS_CARTE;
    // $post[] = '<div class="dropdown ">
    //                 <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
    //                 <span class="caret"></span></a>
    //                 <ul class="dropdown-menu dropdown-menu-right">
    //                 <li><a class="dropdown-item" href="#" onclick="get_client_affilie('.$row->ID_CARTE.')">Voir Membres</a> </li>
    //                 <li><a class="dropdown-item" href="'.base_url('membre/Carte_New/index_carte/'.$row->ID_CARTE).'"> Détail et Apercu</a> </li>
    //                 <li><a class="dropdown-item" href="#" onclick="modificationduree('.$row->ID_MEMBRE.')">Modifier la date de fin</a> </li>
    //                 </ul>
    //               </div>';
    
    $data[] = $post;
}

$output = array(
    "draw" => NULL,
    "recordsTotal" =>$this->Model->all_data($query_principal),
    "recordsFiltered" => $this->Model->filtrer($query_filter),
    "data" => $data
);
echo json_encode($output);


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



    // public function addgroupe()
    // {
    // //   $ID_MEMBRE = $this->input->post('ID_MEMBRE');

    //   $ID_GROUPE=$this->input->post('ID_GROUPE');

    // $listegroup = $this->Model->getRequete('SELECT membre_groupe_membre.ID_MEMBRE FROM `membre_groupe` JOIN membre_groupe_membre ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_MEMBRE = membre_groupe_membre.ID_MEMBRE where membre_groupe.ID_GROUPE = '.$ID_GROUPE.' '); 

    // foreach ($listegroup as $value) {
    //   $ID_MEMBRE = $value['ID_MEMBRE'];
    //   $COLLABORATEUR_ID_ARRAY = $this->input->post('MOIS_COTISATION');
    //   $onerow=$this->Model->getRequeteOne("SELECT cotisation_categorie_membre.ID_CATEGORIE_COTISATION , cotisation_montant_cotisation.MONTANT_COTISATION FROM cotisation_categorie_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_categorie_membre.ID_MEMBRE JOIN cotisation_montant_cotisation ON cotisation_categorie_membre.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE cotisation_categorie_membre.STATUS = 1 AND membre_membre.ID_MEMBRE = ".$ID_MEMBRE." ");

    //     // echo "<pre>";
    //   foreach ($COLLABORATEUR_ID_ARRAY as $MOIS_COTISATION) {

    //   $datas=array(
    //                 'ID_MEMBRE'=>$ID_MEMBRE,
    //                 'ID_CATEGORIE_COTISATION'=>$onerow['ID_CATEGORIE_COTISATION'],
    //                 'MONTANT_COTISATION'=>$onerow['MONTANT_COTISATION'],
    //                 'MOIS_COTISATION'=>$MOIS_COTISATION.'-01',
    //                 'USER_SAVER'=>$this->session->userdata('MIS_ID_USER'),
    //               );
    // //   echo "<pre>";
    // //   print_r($datas);

    //   $nonpaie=$this->Model->getRequeteOne('SELECT DATE_FORMAT(cotisation_cotisation.MOIS_COTISATION, "%Y-%m") FROM cotisation_cotisation WHERE 1 AND cotisation_cotisation.ID_MEMBRE = '.$ID_MEMBRE.' AND DATE_FORMAT(cotisation_cotisation.MOIS_COTISATION, "%Y-%m") like "'.$MOIS_COTISATION.'" ');

    // if (empty($nonpaie)) {
    //     $this->Model->insert_last_id('cotisation_cotisation',$datas);
    // }

        
    //   }

    // }

    

    
    

    //   $message = "<div class='alert alert-success' id='message'>
    //                           Cotisation enregistr&eacute; avec succés
    //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
    //                     </div>";
    //   $this->session->set_flashdata(array('message'=>$message));
    //   redirect(base_url('cotisation/Ajout_Cotisation/groupe'));    
    // } 
   





}