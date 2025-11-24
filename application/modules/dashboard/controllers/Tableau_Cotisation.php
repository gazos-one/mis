<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Tableau_Cotisation extends CI_Controller
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

///il faudra ajouter le statut dans la table coti_membre pour savoir 
//si une personne est actif ou non
 
    public function index() 
    {

    $ID_CATEGORIE_ASSURANCE=$this->input->post('ID_CATEGORIE_ASSURANCE');   
    $ID_GROUPE=$this->input->post('ID_GROUPE');  
    $MOIS=$this->input->post('MOIS');

    // print_r($MOIS.'..'.$ID_GROUPE.'..'.$ID_CATEGORIE_ASSURANCE);exit();  


   $crit='';
   $crit1='';
   $crit2='';

  if (!empty($MOIS)) {
   $crit.=' and cotisation_cotisation_new.MOIS_COTISATION="'.$MOIS.'"';
   $crit1.=' and date_format(consultation_consultation.DATE_CONSULTATION,"%Y-%m")="'.$MOIS.'"';
   $crit2.=' and date_format(consultation_medicament.DATE_CONSULTATION,"%Y-%m")="'.$MOIS.'"';
   
   }


   if (!empty($ID_CATEGORIE_ASSURANCE)) {
    $crit.=' and cotisation_cotisation_new.ID_CATEGORIE_ASSURANCE='.$ID_CATEGORIE_ASSURANCE.'';
   }




   if (!empty($ID_GROUPE)) {
     $crit.=' and cotisation_cotisation_new.ID_GROUPE='.$ID_GROUPE.'';
   }
   
     

    $ID_CATEGORIE_ASSURANCE=$this->input->post('ID_CATEGORIE_ASSURANCE');   


    $data['groupe'] = $this->Model->getList('membre_groupe'); 
    // $data['cotisation'] = $this->Model->getList('cotisation_categorie');
    $data['cotisation'] = $this->Model->getList('syst_categorie_assurance');
    $data['groupe'] = $this->Model->getList('membre_groupe');



    $request=$this->Model->getRequete('SELECT SUM(`MONTANT_COTISATION`) as montant,cotisation_cotisation_new.ID_GROUPE,membre_groupe.NOM_GROUPE FROM `cotisation_cotisation_new` join membre_groupe on cotisation_cotisation_new.ID_GROUPE=membre_groupe.ID_GROUPE WHERE 1 '.$crit.' GROUP BY cotisation_cotisation_new.ID_GROUPE');
    
   $data1='';
   $categorie="";
   $data1="";
   $data2="";
   $data3=0;
   $data4=0;

   
   
    foreach ($request as $key => $value) {
            $categorie.="'";
            $mode=str_replace("'", "\'", $value['NOM_GROUPE']);
            $categorie.= $mode."',";
            $data1.=$value['montant'].",";
            $data4+=$value['montant'];

      $montant1=$this->Model->getRequeteOne('SELECT SUM(`MONTANT_A_PAYER`) as nbr1 FROM consultation_consultation join membre_groupe_membre on consultation_consultation.ID_MEMBRE=membre_groupe_membre.ID_MEMBRE join membre_assurances on membre_groupe_membre.ID_MEMBRE=membre_assurances.ID_MEMBRE WHERE membre_groupe_membre.ID_GROUPE='.$value['ID_GROUPE'].' '.$crit1.'');

      $montant2=$this->Model->getRequeteOne('SELECT SUM(`MONTANT_A_PAYE_MIS`) as nbr2 FROM `consultation_medicament` join membre_groupe_membre on consultation_medicament.ID_MEMBRE=membre_groupe_membre.ID_MEMBRE join membre_assurances on membre_groupe_membre.ID_MEMBRE=membre_assurances.ID_MEMBRE  WHERE membre_groupe_membre.ID_GROUPE='.$value['ID_GROUPE'].' '.$crit2.'');
     
      $montant11=0;
      $montant22=0;

      if ($montant1["nbr1"] != NULL) {
      $montant11=$montant1["nbr1"];
      
      }

      if ($montant2["nbr2"] != NULL) {
      $montant22=$montant2["nbr2"];
      }
      $montant_tot=$montant11+$montant22;

      $data2.=$montant_tot.",";
      $data3+=$montant_tot;
    }

    if (!empty($categorie)) {
    $categorie.="@";
    $categorie=str_replace(",@", "", $categorie); 
    $data1.="@";
    $data1=str_replace(",@", "", $data1); 
    $data2.="@";
    $data2=str_replace(",@", "", $data2); 
    }
    // $categorie=trim($categorie);
    // $categorie = str_replace("\n","",$categorie);
    // $categorie = str_replace("\r","",$categorie);
    // $categorie = str_replace("\t","",$categorie);
    // $categorie = str_replace('"','',$categorie);
    // $categorie = str_replace("'",'',$categorie);
    $data['categorie'] = $categorie;
    $data['data1'] = $data1;
    $data['data2'] = $data2;
    $data['data3'] = $data3;
    $data['data4'] = $data4;



    $data['title'] = " Cotisation";
    $data['stitle']=' Cotisation';
    $data['is_retard'] = 0; 
    $this->load->view('Tableau_Cotisation_View',$data);
    }

    public function liste()
    {
    $MOIS=$this->input->post('MOIS');
   
      if (!empty($MOIS)) {
        $critaire= ' AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%"';
      }   
      else{
        $critaire = '';
      }

      $ID_GROUPE = $this->input->post('ID_GROUPE');
    if ($ID_GROUPE != null) {
        $condi2 = ' AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' ';
        $data['ID_GROUPE'] = $this->input->post('ID_GROUPE');
    }
    else{
        $condi2 = '';
        $data['ID_GROUPE'] = NULL;
    }


    $ID_CATEGORIE_COTISATION = $this->input->post('ID_CATEGORIE_COTISATION');
    if ($ID_CATEGORIE_COTISATION != null) {
        $condi4 = ' AND cotisation_cotisation.ID_CATEGORIE_COTISATION = '.$ID_CATEGORIE_COTISATION.' ';
        $data['ID_CATEGORIE_COTISATION'] = $this->input->post('ID_CATEGORIE_COTISATION');
    }
    else{
        $condi4 = '';
        $data['ID_CATEGORIE_COTISATION'] = NULL;
    }

      $query_principal='SELECT cotisation_cotisation.ID_COTISATION, cotisation_cotisation.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, cotisation_cotisation.ID_CATEGORIE_COTISATION, cotisation_categorie.DESCRIPTION AS DESCIPTION_CATEGORIE, cotisation_cotisation.MONTANT_COTISATION, cotisation_cotisation.MOIS_COTISATION, cotisation_cotisation.DATE_INSERTION, membre_groupe.NOM_GROUPE FROM cotisation_cotisation JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_cotisation.ID_MEMBRE JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_cotisation.ID_CATEGORIE_COTISATION LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE WHERE 1 '.$critaire.' '.$condi2.' '.$condi4;

       $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $limit = 'LIMIT 0,10';
        if ($_POST['length'] != -1) {
        $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
 
        $order_column=array("membre_membre.NOM","membre_membre.PRENOM","cotisation_categorie.DESCRIPTION","cotisation_cotisation.MONTANT_COTISATION","cotisation_cotisation.MOIS_COTISATION","cotisation_cotisation.DATE_INSERTION","membre_groupe.NOM_GROUPE");

         $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY cotisation_cotisation.ID_COTISATION  ASC';
 
        $search = !empty($_POST['search']['value']) ? (' AND (membre_membre.NOM LIKE "%' . $var_search . '%" OR membre_membre.PRENOM LIKE "%' . $var_search . '%" OR cotisation_categorie.DESCRIPTION LIKE "%' . $var_search . '%" OR cotisation_cotisation.MONTANT_COTISATION LIKE "%' . $var_search . '%" OR cotisation_cotisation.MOIS_COTISATION LIKE "%' . $var_search . '%" OR cotisation_cotisation.DATE_INSERTION LIKE "%' . $var_search . '%" OR membre_groupe.NOM_GROUPE LIKE "%' . $var_search . '%")') :'';
 
      $critaire = '';
    
       $groupby='';
 
       $query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
       $query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
       $resultat = $this->Model->datatable($query_secondaire);
     
      

     
  
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $chambr=array();

          $date=date_create($key->DATE_INSERTION);
          $DATE_CREATION = date_format($date,"d-m-Y"); 
          $chambr[]=$key->NOM.' '.$key->PRENOM; 
          $chambr[]=$key->MONTANT_COTISATION;
          $chambr[]=$key->DESCIPTION_CATEGORIE;
          $chambr[]=$key->MOIS_COTISATION;
          $chambr[]=$key->NOM_GROUPE;
          $chambr[]=$DATE_CREATION;
                          
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

    public function liste_retard()
    {
    $MOIS=$this->input->post('MOIS');
     $ID_GROUPE = $this->input->post('ID_GROUPE');
    if ($ID_GROUPE != null) {
        $condi2 = ' AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' ';
      
    }
    else{
        $condi2 = '';
      
    }


    $ID_CATEGORIE_COTISATION = $this->input->post('ID_CATEGORIE_COTISATION');
    if ($ID_CATEGORIE_COTISATION != null) {
        $condi4 = ' AND cotisation_categorie.ID_CATEGORIE_COTISATION = '.$ID_CATEGORIE_COTISATION.' ';
      
    }
    else{
        $condi4 = '';
     
    }


    
      
      if (!empty($MOIS)) {
     
       $critaire = ' AND cotisation_categorie_membre.ID_MEMBRE NOT IN (SELECT cotisation_cotisation.ID_MEMBRE FROM cotisation_cotisation WHERE 1 AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%")';
      }   
      else{
 
       $MOIS = date('Y-m');
    
       $critaire = ' AND cotisation_categorie_membre.ID_MEMBRE NOT IN (SELECT cotisation_cotisation.ID_MEMBRE FROM cotisation_cotisation WHERE 1 AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%")';

      }


      $query_principal='SELECT cotisation_categorie_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_categorie.DESCRIPTION AS DESCIPTION_CATEGORIE, membre_groupe.NOM_GROUPE FROM cotisation_categorie_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_categorie_membre.ID_MEMBRE JOIN cotisation_montant_cotisation ON cotisation_montant_cotisation.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION LEFT JOIN membre_groupe_membre ON membre_membre.ID_MEMBRE = membre_groupe_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE 1 AND DATE_FORMAT(cotisation_categorie_membre.DATE_DEBUT,"%Y-%m") <= "'.$MOIS.'" AND cotisation_categorie_membre.STATUS = 1 '.$critaire.' '.$condi2.' '.$condi4;


       $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $limit = 'LIMIT 0,10';
        if ($_POST['length'] != -1) {
        $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
 
        $order_column=array("membre_membre.NOM","membre_membre.PRENOM","cotisation_categorie.DESCRIPTION","cotisation_montant_cotisation.MONTANT_COTISATION","membre_groupe.NOM_GROUPE");

         $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY cotisation_categorie_membre.ID_MEMBRE  ASC';
 
        $search = !empty($_POST['search']['value']) ? (' AND (membre_membre.NOM LIKE "%' . $var_search . '%" OR membre_membre.PRENOM LIKE "%' . $var_search . '%" OR cotisation_categorie.DESCRIPTION LIKE "%' . $var_search . '%" OR cotisation_montant_cotisation.MONTANT_COTISATION LIKE "%' . $var_search . '%"  OR membre_groupe.NOM_GROUPE LIKE "%' . $var_search . '%")') :'';
 
      $critaire = '';
    
       $groupby='';
 
       $query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
       $query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
       $resultat = $this->Model->datatable($query_secondaire);
     
      

     
  
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $chambr=array();

          // $date=date_create($key->DATE_INSERTION);
          // $DATE_CREATION = date_format($date,"d-m-Y"); 
          $chambr[]=$key->NOM.' '.$key->PRENOM; 
          $chambr[]=$key->MONTANT_COTISATION;
          $chambr[]=$key->DESCIPTION_CATEGORIE;
          $chambr[]=$MOIS;
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





    public function listing()
    {
     $data['groupe'] = $this->Model->getList('membre_groupe'); 
    $data['cotisation'] = $this->Model->getList('cotisation_categorie');

    $data['title'] = " Cotisation";
    $data['stitle']=' Cotisation';
    $data['is_retard'] = 0;
    $this->load->view('Liste_Cotisation_List_Retard_View',$data);

    }

     public function get_total1($value='')
    {
    $MOIS=$this->input->post('MOIS');
 
   
      
      if (!empty($MOIS)) {
        $critaire= ' AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%"';
      }   
      else{
        $critaire = '';
      }

      $ID_GROUPE = $this->input->post('ID_GROUPE');
    if ($ID_GROUPE != null) {
        $condi2 = ' AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' ';
        $data['ID_GROUPE'] = $this->input->post('ID_GROUPE');
    }
    else{
        $condi2 = '';
        $data['ID_GROUPE'] = NULL;
    }
     $ID_CATEGORIE_COTISATION = $this->input->post('ID_CATEGORIE_COTISATION');
    if ($ID_CATEGORIE_COTISATION != null) {
        $condi4 = ' AND cotisation_cotisation.ID_CATEGORIE_COTISATION = '.$ID_CATEGORIE_COTISATION.' ';
     
    }
    else{
        $condi4 = '';
       
    }

    
      $totals=$this->Model->getRequeteOne('SELECT SUM(cotisation_cotisation.MONTANT_COTISATION) AS TOTALS, COUNT(cotisation_cotisation.MONTANT_COTISATION) AS NOMBRE FROM cotisation_cotisation JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_cotisation.ID_MEMBRE JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_cotisation.ID_CATEGORIE_COTISATION LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE 1 '.$critaire.' '.$condi2.' '.$condi4 );
// number_format()
      $TOTAL = 'Total: '.number_format($totals['TOTALS'],0,'.',' ');
      $NOMBRE = 'Nombre Cotisation '.$totals['NOMBRE'];
    $donnee=' <h1 class="m-0 text-dark"> &nbsp; '.$TOTAL.'</h1>
            <h3 class="text-primary text-left" id="nombre">&nbsp;'.$NOMBRE.'</h3>';
    echo $donnee;
    }


    public function get_total2($value='')
    {
    $MOIS=$this->input->post('MOIS');
 

      $ID_GROUPE = $this->input->post('ID_GROUPE');
    if ($ID_GROUPE != null) {
        $condi2 = ' AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' ';
        $data['ID_GROUPE'] = $this->input->post('ID_GROUPE');
    }
    else{
        $condi2 = '';
        $data['ID_GROUPE'] = NULL;
    }


    $ID_CATEGORIE_COTISATION = $this->input->post('ID_CATEGORIE_COTISATION');
    if ($ID_CATEGORIE_COTISATION != null) {
        $condi4 = ' AND cotisation_categorie.ID_CATEGORIE_COTISATION = '.$ID_CATEGORIE_COTISATION.' ';
        $data['ID_CATEGORIE_COTISATION'] = $this->input->post('ID_CATEGORIE_COTISATION');
    }
    else{
        $condi4 = '';
        $data['ID_CATEGORIE_COTISATION'] = NULL;
    }


      if (!empty($MOIS)) {
       $data['MOIS']=$MOIS;
       $critaire = ' AND cotisation_categorie_membre.ID_MEMBRE NOT IN (SELECT cotisation_cotisation.ID_MEMBRE FROM cotisation_cotisation WHERE 1 AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%")';
      }   
      else{
    
       
       $MOIS = date('Y-m');
       $data['MOIS']=date('Y-m');
       $critaire = ' AND cotisation_categorie_membre.ID_MEMBRE NOT IN (SELECT cotisation_cotisation.ID_MEMBRE FROM cotisation_cotisation WHERE 1 AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%")';

      }

    $resultat=$this->Model->getRequete('SELECT cotisation_categorie_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_categorie.DESCRIPTION AS DESCIPTION_CATEGORIE, membre_groupe.NOM_GROUPE FROM cotisation_categorie_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_categorie_membre.ID_MEMBRE JOIN cotisation_montant_cotisation ON cotisation_montant_cotisation.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION LEFT JOIN membre_groupe_membre ON membre_membre.ID_MEMBRE = membre_groupe_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE 1 AND DATE_FORMAT(cotisation_categorie_membre.DATE_DEBUT,"%Y-%m") <= "'.$MOIS.'" AND cotisation_categorie_membre.STATUS = 1 '.$critaire.' '.$condi2.' '.$condi4 );


    $TOTAL = 0;
    $NUMBER = 0;
    
      
    foreach ($resultat as $key) 
     {

       $TOTAL += $key['MONTANT_COTISATION'] ;
       $NUMBER ++;
     
     }

    //  $data['TOTAL'] = 'TOTAL: '.$TOTAL;

     $TOTAL = 'Total: '.number_format($TOTAL,0,'.',' ');
     $NOMBRE = 'Nb Cotisation Manquant: '.$NUMBER;
   




    $donnee=' <h1 class="m-0 text-dark"> &nbsp; '.$TOTAL.'</h1>
            <h3 class="text-primary text-left" id="nombre">&nbsp;'.$NOMBRE.'</h3>';
    echo $donnee;
    }

       
 }
?>