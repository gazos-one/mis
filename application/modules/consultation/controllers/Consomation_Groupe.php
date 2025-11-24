<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Consomation_Groupe extends CI_Controller
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
    $ANNEE=$this->input->post('ANNEE');
    // $ID_CONSULTATION_TYPE=$this->input->post('ID_CONSULTATION_TYPE');

    

    
    $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');

    // $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
 
    $data['ANNEE']=$ANNEE;
    // $data['ID_CONSULTATION_TYPE']=$ID_CONSULTATION_TYPE;
      
      if (!empty($ANNEE)) {
        $ANNEE = $ANNEE;
        $data['ANNEE']=$ANNEE;
        // $critaire= ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
      }   
      else{
        $ANNEE = date('Y');
        $data['ANNEE']=date('Y');
        // $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
      }

    //   if (!empty($ID_CONSULTATION_TYPE)) {
    //     $data['ID_CONSULTATION_TYPE']=$ID_CONSULTATION_TYPE;
    //     $critaire2= ' AND consultation_consultation.ID_CONSULTATION_TYPE  = '.$ID_CONSULTATION_TYPE.' ';
    //   }   
    //   else{
    //     $ID_CONSULTATION_TYPE = 0;
    //     $data['ID_CONSULTATION_TYPE']= 0;
    //     $critaire2 = ' ';
    //   }

      $resultat=$this->Model->getRequete('SELECT DISTINCT(membre_groupe.NOM_GROUPE) AS NOM_GROUPE, membre_groupe.ID_GROUPE, COUNT(membre_groupe_membre.ID_MEMBRE) AS NOMBRE FROM membre_groupe LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE WHERE membre_groupe_membre.STATUS = 1 GROUP BY membre_groupe.NOM_GROUPE, membre_groupe.ID_GROUPE');
      // '.$critaire.' '.$critaire2.'


      $data['TOTAL'] = '-';
      // $ANNEE = 2024;
  
      $tabledata=array();

      // $result = array_merge($resultat, $resultatcentre);
      
      foreach ($resultat as $key) 
         {

          $detailsr=$this->Model->getRequete('SELECT m.ID_MEMBRE, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION, COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT, COALESCE(SUM(c.MONTANT_A_PAYER), 0) + COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS C_TOTAL, syst_categorie_assurance.PLAFOND_ANNUEL, syst_categorie_assurance.PLAFOND_COUVERTURE_HOSP_JOURS, syst_categorie_assurance.PLAFOND_LUNETTE, syst_categorie_assurance.PLAFOND_MONTURES, syst_categorie_assurance.PLAFOND_PROTHESES_DENTAIRES, syst_categorie_assurance.PLAFOND_PHARMACEUTICAL, syst_categorie_assurance.PLAFOND_CESARIENNE, syst_categorie_assurance.PLAFOND_SCANNER FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE JOIN membre_assurances ON m.ID_MEMBRE = membre_assurances.ID_MEMBRE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_assurances.ID_CATEGORIE_ASSURANCE LEFT JOIN membre_groupe_membre mg ON mg.ID_MEMBRE = m.ID_MEMBRE WHERE m.CODE_PARENT IS NULL AND (YEAR(c.DATE_CONSULTATION) = 2024 OR YEAR(cm.DATE_CONSULTATION) = 2024) AND membre_assurances.STATUS = 1 AND mg.ID_GROUPE = '.$key['ID_GROUPE'].' GROUP BY m.ID_MEMBRE, m.NOM, m.PRENOM, syst_categorie_assurance.PLAFOND_ANNUEL, syst_categorie_assurance.PLAFOND_COUVERTURE_HOSP_JOURS,syst_categorie_assurance.PLAFOND_LUNETTE, syst_categorie_assurance.PLAFOND_MONTURES, syst_categorie_assurance.PLAFOND_PROTHESES_DENTAIRES, syst_categorie_assurance.PLAFOND_PHARMACEUTICAL, syst_categorie_assurance.PLAFOND_CESARIENNE, syst_categorie_assurance.PLAFOND_SCANNER');
          $M_CONSULTATION = 0;
          $nb_medicam = 0;
          $M_MEDICAMENT = 0;
          $C_TOTAL = 0;
          $PLAFOND_ANNUEL = 0;
          foreach ($detailsr as $detail) {
            $resultata=$this->Model->getRequeteOne('SELECT m.CODE_PARENT, COUNT(DISTINCT c.ID_CONSULTATION) AS nb_consultations, COUNT(DISTINCT cm.ID_CONSULTATION_MEDICAMENT) AS nb_medicaments, COALESCE(SUM(c.MONTANT_A_PAYER), 0) AS M_CONSULTATION, COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS M_MEDICAMENT, COALESCE(SUM(c.MONTANT_A_PAYER), 0) + COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS TOTAL, COALESCE(SUM(c.MONTANT_A_PAYER), 0) + COALESCE(SUM(cm.MONTANT_A_PAYE_MIS), 0) AS C_TOTAL FROM membre_membre m LEFT JOIN consultation_consultation c ON m.ID_MEMBRE = c.ID_MEMBRE LEFT JOIN consultation_medicament cm ON m.ID_MEMBRE = cm.ID_MEMBRE WHERE m.CODE_PARENT = '.$detail['ID_MEMBRE'].' AND (YEAR(c.DATE_CONSULTATION) = "'.$ANNEE.'" OR YEAR(cm.DATE_CONSULTATION) = "'.$ANNEE.'")  GROUP BY m.CODE_PARENT');
            // $nb_consultation+=$detail['nb_consultations'];
            $M_CONSULTATION += $detail['M_CONSULTATION'] + $resultata['M_CONSULTATION'];
            $nb_medicam+=$detail['nb_medicaments'];
            $M_MEDICAMENT += $detail['M_MEDICAMENT'] + $resultata['M_MEDICAMENT'];
            $C_TOTAL += $detail['C_TOTAL'] + $resultata['C_TOTAL'];
            $PLAFOND_ANNUEL += $detail['PLAFOND_ANNUEL']*$key['NOMBRE'];
            
          }

          $chambr=array();
          
          // 
          // 
          // $chambr[]=$key['NOM'].' '.$key['PRENOM'].''; 
          // 
          // 
          // $chambr[]='<div class="text-right">'.number_format($key['PLAFOND_ANNUEL'],0,' ',' ').'</div>';
          $chambr[]=$key['NOM_GROUPE']; 
          $chambr[]=$key['NOMBRE']; 
          $chambr[]='<div class="text-right">'.number_format($M_CONSULTATION,0,' ',' ').'</div>'; 
          $chambr[]='<div class="text-right">'.number_format($M_MEDICAMENT,0,' ',' ').'</div>';
          $chambr[]='<div class="text-right">'.number_format($C_TOTAL,0,' ',' ').'</div>';
          $chambr[]='<div class="text-right">'.number_format($PLAFOND_ANNUEL,0,' ',' ').'</div>';
          // $chambr[]=$nb_medicam; 
          
          // $chambr[]='';
                          
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Groupe','N membre', 'M Consultation','M Pharmacie','Total','Plafond'));
        
        $data['title'] = " Consomation";
        $data['stitle']=' Consomation';
        $data['chamb']=$tabledata;
        $this->load->view('Consomation_Groupe_Liste_View',$data);

    }

    public function details($ID_MEMBRE,$ANNEE)
    {
    //  echo $ID_MEMBRE;
    //  echo '<br>';
    //  echo $ANNE;
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
     
     




    //   $this->Model->insert_last_id('consultation_consultation_archive',
    //   array(
    //     'ID_CONSULTATION'=>$resultat['ID_CONSULTATION'],
    //     'ID_TYPE_STRUCTURE'=>$resultat['ID_TYPE_STRUCTURE'],
    //     'ID_STRUCTURE'=>$resultat['ID_STRUCTURE'],
    //     'TYPE_AFFILIE'=>$resultat['TYPE_AFFILIE'],
    //     'ID_MEMBRE'=>$resultat['ID_MEMBRE'],
    //     'DATE_CONSULTATION'=>$resultat['DATE_CONSULTATION'],
    //     'NUM_BORDERAUX'=>$resultat['NUM_BORDERAUX'],
    //     'MONTANT_CONSULTATION'=>$resultat['MONTANT_CONSULTATION'],
    //     'POURCENTAGE_C'=>$resultat['POURCENTAGE_C'],
    //     'POURCENTAGE_A'=>$resultat['POURCENTAGE_A'],
    //     'MONTANT_A_PAYER'=>$resultat['MONTANT_A_PAYER'],
    //     'MEDECIN'=>$resultat['MEDECIN'],
    //     'EXAMEN'=>$resultat['EXAMEN'],        
    //     'ID_CONSULTATION_TYPE'=>$resultat['ID_CONSULTATION_TYPE'],        
    //     'MOTIF'=>$this->input->post('MOTIF'),        
    //     'USER_ARCHIVE'=>$this->session->userdata('MIS_ID_USER'),        
    //     )
    //     );
    //     $this->Model->delete('consultation_consultation',array('ID_CONSULTATION'=>$resultat['ID_CONSULTATION'],));
    
    
  
    // $message = "<div class='alert alert-success' id='message'>
    //                           Consultation archiv&eacute; avec succés
    //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
    //                     </div>";
    //   $this->session->set_flashdata(array('message'=>$message));
    //     redirect(base_url('consultation/Liste_Consultation'));  
    $this->load->view('Consomation_Details_View',$data);
    }

    // public function listing()
    // {
    //   $ANNEE=$this->input->post('ANNEE');
    // $ID_CONSULTATION_TYPE=$this->input->post('ID_CONSULTATION_TYPE');

    

    
    // $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation_archive');

    // $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
 
    // $data['ANNEE']=$ANNEE;
    // $data['ID_CONSULTATION_TYPE']=$ID_CONSULTATION_TYPE;
      
    //   if (!empty($ANNEE)) {
    //     $data['ANNEE']=$ANNEE;
    //     $critaire= ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
    //   }   
    //   else{
    //     $ANNEE = date('Y');
    //     $data['ANNEE']=date('Y');
    //     $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
    //   }

    //   if (!empty($ID_CONSULTATION_TYPE)) {
    //     $data['ID_CONSULTATION_TYPE']=$ID_CONSULTATION_TYPE;
    //     $critaire2= ' AND consultation_consultation_archive.ID_CONSULTATION_TYPE  = '.$ID_CONSULTATION_TYPE.' ';
    //   }   
    //   else{
    //     $ID_CONSULTATION_TYPE = 0;
    //     $data['ID_CONSULTATION_TYPE']= 0;
    //     $critaire2 = ' ';
    //   }

    //   $resultat=$this->Model->getRequete('SELECT consultation_consultation_archive.ID_CONSULTATION,consultation_consultation_archive.ID_STRUCTURE,  membre_membre.NOM, membre_membre.PRENOM,  membre_membre.CNI,  consultation_consultation_archive.DATE_CONSULTATION, consultation_consultation_archive.NUM_BORDERAUX, consultation_consultation_archive.MONTANT_CONSULTATION, consultation_consultation_archive.EXAMEN, consultation_consultation_archive.MEDECIN, consultation_consultation_archive.STATUS_PAIEMENT, consultation_consultation_archive.MONTANT_A_PAYER, consultation_consultation_archive.POURCENTAGE_A, consultation_type.DESCRIPTION AS TYPE, CASE  WHEN consultation_type.ID_CONSULTATION_TYPE IN (3, 7) THEN consultation_centre_optique.DESCRIPTION ELSE masque_stucture_sanitaire.DESCRIPTION END AS STRUCTURE FROM consultation_consultation_archive JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_consultation_archive.ID_MEMBRE JOIN consultation_type ON consultation_type.ID_CONSULTATION_TYPE = consultation_consultation_archive.ID_CONSULTATION LEFT JOIN consultation_centre_optique ON consultation_centre_optique.ID_CENTRE_OPTIQUE = consultation_consultation_archive.ID_STRUCTURE LEFT JOIN  masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation_archive.ID_STRUCTURE WHERE      consultation_consultation_archive.STATUS_PAIEMENT = 0 '.$critaire.' '.$critaire2.'');
    //   // '.$critaire.' '.$critaire2.'


    //   $data['TOTAL'] = '-';
  
    //   $tabledata=array();

    //   // $result = array_merge($resultat, $resultatcentre);
      
    //   foreach ($resultat as $key) 
    //      {

    //       $chambr=array();
          
          

    //       $chambr[]=$key['NOM'].' '.$key['PRENOM'].' ('.$key['CNI'].')'; 
    //       $chambr[]=$key['DATE_CONSULTATION'];
    //       $chambr[]=$key['NUM_BORDERAUX'];
    //       $chambr[]=$key['MONTANT_CONSULTATION'];          
    //       $chambr[]=$key['MONTANT_A_PAYER'];
    //       $chambr[]=$key['POURCENTAGE_A'].'%';
    //       $chambr[]=$key['TYPE'];
    //       $chambr[]=$key['STRUCTURE'];
                          
    //    $tabledata[]=$chambr;
     
    //  }

    //     $template = array(
    //         'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
    //         'table_close' => '</table>'
    //     );
    //     $this->table->set_template($template);
    //     $this->table->set_heading(array('Patient','Date','#','Total','Mis','%','Type','Structure'));
    //     $data['title'] = " Consultation";
    //     $data['stitle']=' Consultation';
    //     $data['chamb']=$tabledata;
    //     $this->load->view('Consultation_Liste_View',$data);

    // }

    
  
       
 }
?>