<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recherche extends CI_Controller {

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


 public function get_commune()
 {
  $commune= $this->Model->getList("syst_communes",array('PROVINCE_ID'=>$this->input->post('provine_id')));
  $datas= '<option value="">-- Sélectionner --</option>';
  foreach($commune as $commun){
    $datas.= '<option value="'.$commun["COMMUNE_ID"].'">'.$commun["COMMUNE_NAME"].'</option>';
  }
  $datas.= '';
  echo $datas;
}



public function index()
{

  $data['title'] = " Agence";
  $data['stitle']=' Agence';
  $data['groupes']=$this->Model->getRequete("SELECT * FROM `membre_groupe` WHERE STATUS=1 ORDER BY NOM_GROUPE ASC");
  $this->load->view('Recherche_View',$data);

}


public function search_data()
{
     $customRadio = $this->input->post('customRadio');
     $ageMin = $this->input->post('ageMin');
     $ageMax = $this->input->post('ageMax');

     $ID_GROUPE = $this->input->post('ID_GROUPE');


     $affilie="";
     if(isset($customRadio)){
      $affilie='AND mm.IS_AFFILIE = '.$customRadio;
    }else{
      $affilie='AND mm.IS_AFFILIE =3 ';
    }

    $age="";
    if(!empty($ageMin) && !empty($ageMax)){
      $age=' AND TIMESTAMPDIFF(YEAR, mm.DATE_NAISSANCE, CURDATE()) BETWEEN '.$ageMin.' AND '.$ageMax ;    
    }

     $groupe="";
     if(!empty($ID_GROUPE)){
      $groupe='AND mg.ID_GROUPE = '.$ID_GROUPE;
    }


  $query_principal ='SELECT mm.ID_MEMBRE, mm.CODE_AFILIATION, mm.NOM, mm.PRENOM, mm.CNI, mm.DATE_ADHESION, mm.STATUS, mm.IS_AFFILIE, mg.NOM_GROUPE, TIMESTAMPDIFF(YEAR, mm.DATE_NAISSANCE, CURDATE()) AS AGE, mm.DATE_NAISSANCE,mg.ID_GROUPE 
FROM membre_membre mm 
JOIN membre_groupe_membre mgm ON mgm.ID_MEMBRE = mm.ID_MEMBRE 
LEFT JOIN membre_groupe mg ON mg.ID_GROUPE = mgm.ID_GROUPE 
WHERE mm.DATE_NAISSANCE IS NOT NULL AND mm.STATUS=1 ' . $affilie . ' ' . $age . '  '.$groupe.'';




    $var_search = !empty($_POST['search']['value']) ? $this->db->escape_like_str($_POST['search']['value']) : null;

  // $limit = 'LIMIT 0,10';

  // if ($_POST['length'] != -1) {
  //   $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
  // }
    $limit = ($_POST['length'] != -1) ? 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '';

  $order_by = '';

  $order_column = array('ID_MEMBRE', 'concat(NOM ," ",PRENOM)', 'CODE_AFILIATION', 'CNI', 'DATE_ADHESION', 'DATE_NAISSANCE', 'NOM_GROUPE');

  $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY mm.DATE_ADHESION ASC';

  $search = !empty($_POST['search']['value']) ? 
    "AND (concat(NOM ,' ',PRENOM) LIKE '%$var_search%' OR CODE_AFILIATION LIKE '%$var_search%' OR CNI LIKE '%$var_search%' OR NOM_GROUPE LIKE '%$var_search%' OR date_format(DATE_ADHESION,'%d-%m-%Y') LIKE '%$var_search%')" 
    : '';

  $critaire = '';

  $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
  $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

    $membres = $this->Model->datatable($query_secondaire);

   $data = array();
   foreach ($membres as $key) {
    $row = array();


        if ($key->STATUS == 1) {
          $stat = 'Actif';
          $fx = 'desactiver';
          $col = 'btn-danger';
          $titr = 'Désactiver';
          $stitr = 'voulez-vous désactiver ce membre ';
          $bigtitr = 'Désactivation du membre';
          $todel = '<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#supprimermembre'.$key->ID_MEMBRE.'"> Désactiver la personne </a> </li>';
        }
        else{
          $stat = 'Innactif';
          $fx = 'reactiver';
          $col = 'btn-success';
          $titr = 'Réactiver';
          $stitr = 'voulez-vous réactiver ce membre ';
          $bigtitr = 'Réactivation du membre';
          $todel = '';
        }

        $row[] = $key->NOM.' '.$key->PRENOM;
        $row[] = $key->CODE_AFILIATION;
        $row[] = $key->CNI;
        $row[] = date("d-m-Y", strtotime($key->DATE_ADHESION));
        $row[] = $this->calculateAge($key->DATE_NAISSANCE); // Exemple pour l'âge
        $row[] = $key->NOM_GROUPE;
        $row[] = ($key->STATUS == 1) ? 'Actif' : 'Inactif';
         $row[]='<div class="modal fade" id="supprimermembre'.$key->ID_MEMBRE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Suppression du membre</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <h6><b>Mr/Mme ,  Voulez-vous vraiment désactiver de manière définitive ce membre ('.$key->NOM.' '.$key->PRENOM.')?</b><br>Cette action est irréversible</h6>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="'.base_url('membre/Membre/supprimer/'.$key->ID_MEMBRE).'" class="btn '.$col.'">Désactiver</a>
        </div>
        </div>
        </div>
        </div>
        <div class="modal fade" id="desactcat'.$key->ID_MEMBRE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key->NOM.' '.$key->PRENOM.')?</h6>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="'.base_url('membre/Membre/'.$fx.'/'.$key->ID_MEMBRE).'" class="btn '.$col.'">'.$titr.'</a>
        </div>
        </div>
        </div>
        </div>

        <div class="dropdown ">
        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
        <span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="'.base_url('membre/Membre/details/'.$key->ID_MEMBRE).'"> Détail </a> </li>
        
        <li><a class="dropdown-item" href="'.base_url('membre/Membre/index_update/'.$key->ID_MEMBRE).'"> Modifier</a> </li>
        <li><a class="dropdown-item" href="'.base_url('membre/Membre/ayant_droits/'.$key->ID_MEMBRE).'"> Ajouter/Enlever ayant droit </a> </li>
        <li><a class="dropdown-item" href="'.base_url('membre/Membre/assurances_index/'.$key->ID_MEMBRE).'"> Modifier la Categorie d\'assurance </a> </li>

        <li><a class="dropdown-item" href="#" onclick="get_modal('.$key->ID_MEMBRE.')"> Modifier le groupe de l’affilié  </a> </li>
        
        
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

    function calculateAge($birthDate) {
    // Convert the birth date to a DateTime object
      $birthDate = new DateTime($birthDate);
    $today = new DateTime(); // Get today's date
    $age = $today->diff($birthDate); // Calculate the difference

    return $age->y; // Return the age in years
  }



}
?>