<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Liste_Consultation_Hopital extends CI_Controller
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
      
       public function indexs()
       {
        $data['title'] = " Consultation";
        $data['stitle']=' Consultation';
        
        $data['STATUS_PAIEMENT']=0;
        $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');
        $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
       
        $this->load->view('Liste_Consultation_Hopital_List_View',$data);
        
       }
 
    public function index()
    {


      $ANNEE=$this->input->post('ANNEE');
      $ID_CONSULTATION_TYPE=$this->input->post('ID_CONSULTATION_TYPE');
      $STATUS_PAIEMENT=$this->input->post('STATUS_PAIEMENT');
      $MOIS=$this->input->post('MOIS');


      $crit_pyment=' AND consultation_consultation.STATUS_PAIEMENT = '.$STATUS_PAIEMENT.'';
          
      if (!empty($ANNEE)) {
        $data['ANNEE']=$ANNEE;
        $critaireanne= ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
      }   
      else{
        $ANNEE = date('Y');
        $data['ANNEE']=date('Y');
        $critaireanne = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
      }

      if (!empty($MOIS)) {
        
        $critaireanne= ' AND DATE_FORMAT(DATE_CONSULTATION,"%m") Like "%'.$MOIS.'%"';
      }   
      else{
        $MOIS = date('m');
        
        $critaireanne = ' AND DATE_FORMAT(DATE_CONSULTATION,"%m") Like "%'.$MOIS.'%"';
      }


      if (!empty($ID_CONSULTATION_TYPE)) {
        $data['ID_CONSULTATION_TYPE']=$ID_CONSULTATION_TYPE;
        $critaire2= ' AND ID_CONSULTATION_TYPE  = '.$ID_CONSULTATION_TYPE.' ';
      }   
      else{
        $ID_CONSULTATION_TYPE = 1;
        $data['ID_CONSULTATION_TYPE']= 1;
        $critaire2 = ' ';
      }


      $query_principal = 'SELECT DISTINCT(consultation_consultation.ID_STRUCTURE), masque_stucture_sanitaire.DESCRIPTION AS HOPITAL, COUNT(consultation_consultation.ID_CONSULTATION) AS NOMBRE, SUM(consultation_consultation.MONTANT_CONSULTATION) AS MONTANT_CONSULTATION, SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT_A_PAYER FROM consultation_consultation JOIN masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation.ID_STRUCTURE WHERE 1 '.$crit_pyment.' AND consultation_consultation.ID_CONSULTATION_TYPE NOT IN (3,7) '.$critaireanne.' '.$critaire2.' ';
 
     $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
     $limit = 'LIMIT 0,10';
     if ($_POST['length'] != -1) {
       $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
     }
 
     $order_by = '';
     if (!empty($order_by)) {
       $order_by .= isset($_POST['order']) ? ' ORDER BY ' . $_POST['order']['0']['column'] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ID_CLIENT ASC';
     }
 
     $search = !empty($_POST['search']['value']) ? (' AND (masque_stucture_sanitaire.DESCRIPTION LIKE "%' . $var_search . '%" )') :'';
 
     $critaire = '';
     $order_by="  ORDER BY masque_stucture_sanitaire.DESCRIPTION";
     $groupby='GROUP BY ID_STRUCTURE, HOPITAL';
 
     $query_secondaire = $query_principal . '  ' . $critaire . '  ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
     $query_filter = $query_principal . ' ' . $critaire . '  ' . $search. ' ' . $groupby;
     $fetch_client = $this->Model->datatable($query_secondaire);

     //       $resultatcentre=$this->Model->getRequete('SELECT DISTINCT(consultation_consultation.ID_STRUCTURE), consultation_centre_optique.DESCRIPTION AS HOPITAL, COUNT(consultation_consultation.ID_CONSULTATION) AS NOMBRE, SUM(consultation_consultation.MONTANT_CONSULTATION) AS MONTANT_CONSULTATION, SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT_A_PAYER FROM consultation_consultation JOIN consultation_centre_optique ON consultation_centre_optique.ID_CENTRE_OPTIQUE = consultation_consultation.ID_STRUCTURE WHERE 1 '.$critaire .' '.$critaire2.' AND consultation_consultation.STATUS_PAIEMENT = 0 AND consultation_consultation.ID_CONSULTATION_TYPE IN (3,7) GROUP BY ID_STRUCTURE, HOPITAL');
// '.$critaire .' '.$critaire2.'
     $query_principals = 'SELECT DISTINCT(consultation_consultation.ID_STRUCTURE), consultation_centre_optique.DESCRIPTION AS HOPITAL, COUNT(consultation_consultation.ID_CONSULTATION) AS NOMBRE, SUM(consultation_consultation.MONTANT_CONSULTATION) AS MONTANT_CONSULTATION, SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT_A_PAYER FROM consultation_consultation JOIN consultation_centre_optique ON consultation_centre_optique.ID_CENTRE_OPTIQUE = consultation_consultation.ID_STRUCTURE WHERE 1 '.$crit_pyment.' AND consultation_consultation.ID_CONSULTATION_TYPE IN (3,7)  '.$critaireanne.' '.$critaire2.' ';
 
     $var_searchs = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
     $limits = 'LIMIT 0,10';
     if ($_POST['length'] != -1) {
       $limits = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
     }
 
     $order_bys = '';
     if (!empty($order_bys)) {
       $order_bys .= isset($_POST['order']) ? ' ORDER BY ' . $_POST['order']['0']['column'] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ID_CLIENT ASC';
     }
 
     $searchs = !empty($_POST['search']['value']) ? (' AND (consultation_centre_optique.DESCRIPTION LIKE "%' . $var_searchs . '%" )') :'';
 
     $critaires = '';
     $order_bys="ORDER BY consultation_centre_optique.DESCRIPTION";
     $groupby='GROUP BY ID_STRUCTURE, HOPITAL';
 
     $query_secondaires = $query_principals . ' ' . $critaires . ' ' . $searchs . ' ' . $groupby . ' ' . $order_bys . '   ' . $limits;
     $query_filters = $query_principals . ' ' . $critaires . ' ' . $searchs. ' ' . $groupby;

    //  print_r($query_secondaires);die();
     $fetch_clients = $this->Model->datatable($query_secondaires);

     $resultall = array_merge($fetch_clients, $fetch_client);
 
     $data = array();
     
     foreach ($resultall as $val)
     {
      //  if($val->STATUT=='Actif'){
      //   $user='désactiver';
      // }else{
      //  $user='activer';
      // }
       $post = array();
      //  $post[] = $u++;
       $post[] = $val->HOPITAL;
       $post[] = $val->NOMBRE;
       $post[]='<div class="text-right">'.number_format($val->MONTANT_CONSULTATION,0,',',' ').'</div>';
       $post[]='<div class="text-right">'.number_format($val->MONTANT_A_PAYER,0,',',' ').'</div>';
       $post[] = $ANNEE;
       $post[] = $MOIS;
      // '.$critaireanne .'
        $listes=$this->Model->getRequete('SELECT membre_membre.NOM, membre_membre.PRENOM,COALESCE(aff.NOM, membre_membre.NOM) AS ANOM, COALESCE(aff.PRENOM, membre_membre.PRENOM) AS APRENOM,COALESCE(aff.ID_MEMBRE, membre_membre.ID_MEMBRE) AS ID_MEMBRE, consultation_consultation.DATE_CONSULTATION, consultation_consultation.NUM_BORDERAUX, consultation_consultation.MONTANT_CONSULTATION, consultation_consultation.POURCENTAGE_C, consultation_consultation.POURCENTAGE_A, consultation_consultation.MONTANT_A_PAYER, membre_groupe.NOM_GROUPE FROM `consultation_consultation` JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_consultation.ID_MEMBRE LEFT JOIN membre_membre aff ON aff.ID_MEMBRE = membre_membre.CODE_PARENT LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE 1 '.$crit_pyment.' AND ID_STRUCTURE = '.$val->ID_STRUCTURE.'');

        $tableliste = "<table class='table tabless' id='tabless'><thead>
          <tr>
              
              <th style='width: 250px;'>Affili&eacute;e</th>
              <th style='width: 150px;'>Patient</th>
              <th style='width: 50px;'>Date </th>
              <th>Borderaux</th>
              <th style='width: 25px;'>Montant</th>
              <th>%</th>
              <th>Groupe</th>
          </tr>
      </thead><tbody>";
      $deta = '';
        foreach ($listes as $value) {

          


        $cconsultationa=$this->Model->getRequete('SELECT consultation_consultation.ID_CONSULTATION, consultation_consultation.ID_CONSULTATION_TYPE,  CASE WHEN consultation_consultation.ID_CONSULTATION_TYPE IN (3, 7) THEN consultation_centre_optique.DESCRIPTION ELSE masque_stucture_sanitaire.DESCRIPTION END AS STRUCTURE, consultation_consultation.DATE_CONSULTATION, consultation_consultation.POURCENTAGE_A, consultation_consultation.MONTANT_A_PAYER AS MONTANT_A_PAYER, IF(consultation_consultation.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT, membre_groupe.NOM_GROUPE, syst_couverture_structure.DESCRIPTION AS ID_TYPE_STRUCTURE, IF(aff.CODE_PARENT IS NULL, "A", "AD") AFFIL, consultation_type.DESCRIPTION, consultation_consultation.STATUS_PAIEMENT AS STATUS_P FROM    consultation_consultation  LEFT JOIN  masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation.ID_STRUCTURE LEFT JOIN  consultation_centre_optique ON consultation_centre_optique.ID_CENTRE_OPTIQUE = consultation_consultation.ID_STRUCTURE JOIN  membre_membre aff ON aff.ID_MEMBRE = consultation_consultation.ID_MEMBRE  LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = consultation_consultation.ID_TYPE_STRUCTURE JOIN consultation_type ON consultation_type.ID_CONSULTATION_TYPE = consultation_consultation.ID_CONSULTATION_TYPE WHERE consultation_consultation.ID_MEMBRE = '.$value['ID_MEMBRE'].'');

        $cconsultationb=$this->Model->getRequete('SELECT consultation_consultation.ID_CONSULTATION, consultation_consultation.ID_CONSULTATION_TYPE,  CASE WHEN consultation_consultation.ID_CONSULTATION_TYPE IN (3, 7) THEN consultation_centre_optique.DESCRIPTION ELSE masque_stucture_sanitaire.DESCRIPTION END AS STRUCTURE, consultation_consultation.DATE_CONSULTATION, consultation_consultation.POURCENTAGE_A, consultation_consultation.MONTANT_A_PAYER AS MONTANT_A_PAYER, IF(consultation_consultation.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT, membre_groupe.NOM_GROUPE, syst_couverture_structure.DESCRIPTION AS ID_TYPE_STRUCTURE,IF(aff.CODE_PARENT IS NULL, "A", "AD") AFFIL, consultation_type.DESCRIPTION, consultation_consultation.STATUS_PAIEMENT AS STATUS_P FROM    consultation_consultation  LEFT JOIN  masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation.ID_STRUCTURE LEFT JOIN  consultation_centre_optique ON consultation_centre_optique.ID_CENTRE_OPTIQUE = consultation_consultation.ID_STRUCTURE JOIN  membre_membre aff ON aff.ID_MEMBRE = consultation_consultation.ID_MEMBRE  LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = consultation_consultation.ID_TYPE_STRUCTURE JOIN consultation_type ON consultation_type.ID_CONSULTATION_TYPE = consultation_consultation.ID_CONSULTATION_TYPE WHERE consultation_consultation.TYPE_AFFILIE = '.$value['ID_MEMBRE'].' AND consultation_consultation.ID_MEMBRE != '.$value['ID_MEMBRE'].'');

        $cmedicamenta=$this->Model->getRequete('SELECT consultation_medicament.ID_CONSULTATION_MEDICAMENT AS ID_CONSULTATION, "Pharmacie" AS ID_CONSULTATION_TYPE, consultation_pharmacie.DESCRIPTION AS STRUCTURE, consultation_medicament.DATE_CONSULTATION, "-" AS POURCENTAGE_A, consultation_medicament.MONTANT_A_PAYE_MIS AS MONTANT_A_PAYER, IF(consultation_medicament.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT, membre_groupe.NOM_GROUPE, "-" AS ID_TYPE_STRUCTURE, IF(aff.CODE_PARENT IS NULL, "A", "AD") AFFIL, "Pharmacie" AS DESCRIPTION, consultation_medicament.STATUS_PAIEMENT AS STATUS_P FROM consultation_medicament JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE JOIN membre_membre aff ON aff.ID_MEMBRE = consultation_medicament.ID_MEMBRE LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE consultation_medicament.ID_MEMBRE = '.$value['ID_MEMBRE'].'');

        $cmedicamentb=$this->Model->getRequete('SELECT consultation_medicament.ID_CONSULTATION_MEDICAMENT AS ID_CONSULTATION, "Pharmacie" AS ID_CONSULTATION_TYPE, consultation_pharmacie.DESCRIPTION AS STRUCTURE, consultation_medicament.DATE_CONSULTATION, "-" AS POURCENTAGE_A, consultation_medicament.MONTANT_A_PAYE_MIS AS MONTANT_A_PAYER, IF(consultation_medicament.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT, membre_groupe.NOM_GROUPE, "-" AS ID_TYPE_STRUCTURE, IF(aff.CODE_PARENT IS NULL, "A", "AD") AFFIL, "Pharmacie" AS DESCRIPTION, consultation_medicament.STATUS_PAIEMENT AS STATUS_P FROM consultation_medicament JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE JOIN membre_membre aff ON aff.ID_MEMBRE = consultation_medicament.ID_MEMBRE LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE consultation_medicament.TYPE_AFFILIE = '.$value['ID_MEMBRE'].' AND consultation_medicament.ID_MEMBRE != '.$value['ID_MEMBRE'].'');


        
        $modaldet="<div class='modal fade' id='myModal".$value['ID_MEMBRE']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
  <div class='modal-dialog modal-xl' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        
        <h4 class='modal-title' id='myModalLabel'>Consomation de ".$value['ANOM']." ".$value['APRENOM']."</h4>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
      </div>
      <div class='modal-body'>";
      $modaldet .= '<div class="row">
      <div class="col-md-3"><b>Nom</b></div>
      <div class="col-md-1"><b>Date</b></div>
      <div class="col-md-1"><b>Type</b></div>
      <div class="col-md-4"><b>Structure</b></div>
      <div class="col-md-2"><b>Montant</b></div>
      <div class="col-md-1"><b>Groupe</b></div>
    </div>';
    $result = array_merge($cconsultationa, $cconsultationb,$cmedicamenta,$cmedicamentb);
    foreach ($result as $cvaluea) {
  
      
    $modaldet .= '<div class="row">
      <div class="col-md-3">'.$cvaluea['NOM'].' '.$cvaluea['PRENOM'].' ('.$cvaluea['AFFIL'].')</div>
      <div class="col-md-1">'.$cvaluea['DATE_CONSULTATION'].'</div>
      <div class="col-md-1">'.$cvaluea['DESCRIPTION'].'</div>
      <div class="col-md-4">'.$cvaluea['STRUCTURE'].' ('.$cvaluea['ID_TYPE_STRUCTURE'].')</div>
      <div class="col-md-2">'.number_format($cvaluea['MONTANT_A_PAYER'],0,',',' ').' ('.$cvaluea['POURCENTAGE_A'].'%) - '.$cvaluea['STATUS_PAIEMENT'].'</div>
      <div class="col-md-1">'.$cvaluea['NOM_GROUPE'].'</div>
    </div>';
    }
      

      $modaldet .="</div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Fermer</button>
      </div>
    </div>
  </div>
</div>";
        

        $tableliste .= $modaldet."";
        


         $deta.= "<tr>
            
          <td>".$value['ANOM']." ".$value['APRENOM']." <button type='button' class='btn btn-primary btn-xs' data-toggle='modal' data-target='#myModal".$value['ID_MEMBRE']."'>Historique Consomation</button>
          </td>
          <td>".$value['NOM']." ".$value['PRENOM']."</td>
          <td>".$value['DATE_CONSULTATION']."</td>
          <td>".$value['NUM_BORDERAUX']."</td>
          <td class='text-right'>".number_format($value['MONTANT_A_PAYER'],0,',',' ')."</td>
          <td class='text-right'>".$value['POURCENTAGE_A']."</td>
          <td>".$value['NOM_GROUPE']."</td>
          </tr>";
          
        }


       

        $tableliste .= $deta."</tbody></table>";

       $post[]='
       <div class="modal fade" id="desactcat'.$val->ID_STRUCTURE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Liste des consultations: '.$val->HOPITAL.'</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">             
              '.$tableliste.'
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div> 
        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#desactcat'.$val->ID_STRUCTURE.'">Apercu</button>';
       
        $post[] = '<a class="btn btn-primary btn-xs" href="'.base_url('consultation/Liste_Consultation_Hopital/details/'.$val->ID_STRUCTURE.'/'.$ANNEE.'/0').'"> D&eacute;tails Paiements </a>';
         //$post[] = '<a class="btn btn-danger btn-xs" href="'.base_url('consultation/Liste_Consultation_Hopital/delete/'.$val->ID_CONSULTATION).'"> Supprimer</a>';
       //  $post[] = '<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" title="Supprimer la consultation"   data-target="#delet'.$val->ID_CONSULTATION.'"><i class="fas fa-trash"></i></button>

       // <div class="modal fade" id="delet'.$val->ID_CONSULTATION.'"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       //      <div class="modal-dialog" role="document">
       //               <div class="modal-content">
       //                 <div class="modal-header">
       //                  <h5 class="modal-title" id="exampleModalLabel">Voulez-vous supprimer cette consultation ?</h5>
       //                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       //                     <span aria-hidden="true">&times;</span>
       //                   </button>
       //                 </div>
       //                 <div class="modal-body">
                    
       //                 </div>
       //                 <div class="modal-footer">
       //                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
       //                   <a class="btn btn-danger btn-md" href="' . base_url("client/Client/traiter/". md5($val->ID_CLIENT)) . '">Oui</a>
       //                 </div>
       //              </div>
       //             </div>
       //           </div>

       //  ';

   

      //  $post[] = $val->TEL_CLIENT.'<br>'.$val->EMAIL_CLIENT;
      //  $post[] = $val->ADRESSE;
      //  $post[] = $val->DEVIS;
      //  $post[] = $val->STATUT;
      //  $post[] = date('d/m/Y H:i:s', strtotime($val->DATE_INSERTION));
      //  $action = "<a class='btn btn-success btn-sm' href='".base_url('client/Client/edit/').md5($val->ID_CLIENT)."'><i class='fas fa-edit'></i></a>
      //         <button type='button' class='btn btn-danger btn-sm btn-hapus' data-toggle='modal' data-target='#exampleModal".$val->ID_CLIENT."'>
      //            <i class='fas fa-trash'></i></button>";
 
      // $action .= "<div class='modal fade' id='exampleModal".$val->ID_CLIENT."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      //       <div class='modal-dialog' role='document'>
      //                <div class='modal-content'>
      //                  <div class='modal-header'>
      //                    <h5 class='modal-title' id='exampleModalLabel'>Voulez-vous ".$user." le client ".$val->NOM_CLIENT." ?</h5>
      //                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
      //                      <span aria-hidden='true'>&times;</span>
      //                    </button>
      //                  </div>
      //                  <div class='modal-body'>
                       
      //                  </div>
      //                  <div class='modal-footer'>
      //                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Non</button>
      //                    <a class='btn btn-danger btn-md' href='" . base_url('client/Client/traiter/'. md5($val->ID_CLIENT)) . "'>Oui</a>
      //                  </div>
      //                </div>
      //              </div>
      //            </div>";
      //  $post[]=$action;
       $data[] = $post;
 
     }
     $output = array(
       "draw" => intval($_POST['draw']),
       "recordsTotal" => $this->Model->all_data($query_principal),
       "recordsFiltered" => $this->Model->filtrer($query_filter),
       "data" => $data
     );
     echo json_encode($output);


//     $ID_CONSULTATION_TYPE=$this->input->post('ID_CONSULTATION_TYPE');

    


//     $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
 

//     $data['ID_CONSULTATION_TYPE']=$ID_CONSULTATION_TYPE;
      


//       if (!empty($ID_CONSULTATION_TYPE)) {
//         $data['ID_CONSULTATION_TYPE']=$ID_CONSULTATION_TYPE;
//         $critaire2= ' AND ID_CONSULTATION_TYPE  = '.$ID_CONSULTATION_TYPE.' ';
//       }   
//       else{
//         $ID_CONSULTATION_TYPE = 0;
//         $data['ID_CONSULTATION_TYPE']= 0;
//         $critaire2 = ' ';
//       }




      

      
//       $totals=$this->Model->getRequeteOne('SELECT COUNT(consultation_consultation.ID_CONSULTATION) AS NOMBRE, SUM(consultation_consultation.MONTANT_CONSULTATION) AS MONTANT_CONSULTATION, SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT_A_PAYER FROM consultation_consultation JOIN masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation.ID_STRUCTURE WHERE consultation_consultation.STATUS_PAIEMENT = 0  '.$critaire.' '.$critaire2 );

//       $data['TOTAL'] = 'Hopitaux concern&eacute;: '.$totals['NOMBRE'];
  
//       $tabledata=array();

//       $result = array_merge($resultat, $resultatcentre);
      
//       foreach ($result as $key) 
//          {

     
//      }


    }

    public function details($id,$critaire,$status)
    {

      $data['title']=' Consultation ';
      $data['stitle']=' Consultation ';
  
    $data['list']=$this->Model->getRequete('SELECT consultation_consultation.ID_CONSULTATION, membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, COALESCE(aff.NOM, membre_membre.NOM) AS ANOM, COALESCE(aff.PRENOM, membre_membre.PRENOM) AS APRENOM, IF(membre_membre.IS_AFFILIE = 0, "Affilie", "Ayant droit") AS IS_AFFILIE, consultation_consultation.DATE_CONSULTATION, consultation_consultation.NUM_BORDERAUX, consultation_consultation.POURCENTAGE_A, consultation_consultation.MONTANT_A_PAYER , membre_groupe.NOM_GROUPE FROM `consultation_consultation` JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_consultation.ID_MEMBRE LEFT JOIN membre_membre aff ON aff.ID_MEMBRE = membre_membre.CODE_PARENT  LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = aff.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE consultation_consultation.ID_STRUCTURE = '.$id.' AND DATE_FORMAT(consultation_consultation.DATE_CONSULTATION,"%Y") Like "%'.$critaire.'%" AND consultation_consultation.STATUS_PAIEMENT = '.$status.'');

    

    $tot=$this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_CONSULTATION) AS MONTANT_CONSULTATION, SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT_A_PAYER, COUNT(*) AS TOTAL FROM `consultation_consultation` JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_consultation.ID_MEMBRE WHERE 1 AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$critaire.'%" AND consultation_consultation.STATUS_PAIEMENT = '.$status.' AND ID_STRUCTURE = '.$id.'');
 
    $data['TOTAL']=$tot['TOTAL'];
    $data['ANNEE']=$critaire;
    $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');
    $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
 
      
      if (!empty($ANNEE)) {
        $data['ANNEE']=$ANNEE;
        $critaire= ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$critaire.'%"';
      }   
      else{
        $ANNEE = date('Y');
        $data['ANNEE']=date('Y');
        $critaire = '';
      }
  
      $this->load->view('Liste_Consultation_Hopital_Details_View',$data);
    }

    public function listing()
    {
      
    
    $data['title'] = " Consultation";
    $data['stitle']=' Consultation';
    $data['STATUS_PAIEMENT']=1;
     
    $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');

    $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 

    $this->load->view('Liste_Consultation_Hopital_List_View',$data);

   }

    
    public function payement($id, $dates)
    {
      $this->Model->update('consultation_consultation',array('ID_CONSULTATION'=>$id),array('STATUS_PAIEMENT'=>1));
      $message = "<div class='alert alert-success' id='message'>
                            Paiement enregistré avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('consultation/Liste_Consultation_Hopital/listing')); 

    }
       
 }
?>