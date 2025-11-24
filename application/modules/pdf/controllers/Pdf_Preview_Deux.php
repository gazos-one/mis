<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf_Preview_Deux extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->model('ghislain_model');
        // $this->load->model('roles_model');
        // $this->load->library("MbxLibrary");
    }
    // public function type_assurance(){
    //   $prevcodeass=$this->uri->segment(4);
    //   $prevtypassurance = $this->uri->segment(5);
    //   $prevcapital = $this->uri->segment(6);
    //   $prevdateprised = $this->uri->segment(7);
    //   $prevecheance = $this->uri->segment(8);
    //   $prevecheanceun = $this->uri->segment(9);
    //   $prevassure = $this->uri->segment(10);
    //   $prevsoub = $this->uri->segment(11);
    //   $CODE_SOCIETE = $this->uri->segment(12);
    //   $duree = $this->uri->segment(13);
    //   $TYPE_ASSURANCES = $this->uri->segment(14);
    //   $perte = $this->uri->segment(15);
    //   $CODEUUID = $this->uri->segment(16);

                 


    //   $assur=1;
        
    //      $this->assurance_protection_sans_perte($assur);
        
      
      
    // }

    
    public function index($id){


      include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';
      // Parametre1/1/Parametre2/Parametre3/Parametre4/Parametre5/Parametre6/Parametre7/Parametre8/Parametre9/Parametre10/', '_blank', '');

        $ASSURANCE_TYPE_ID=$this->uri->segment(4);
        $typeass= $this->Model->getRequeteOne("Select * from assurance_type WHERE ASSURANCE_TYPE_ID =".$ASSURANCE_TYPE_ID." ");
        // echo $prevcodeass;
        // exit();
        $NUM_ASSURANCE = $this->uri->segment(5);
        $CODE_SOCIETE = $this->uri->segment(6);
        $banques= $this->Model->getRequeteOne("SELECT * FROM `creancier` WHERE `CODE_SOCIETE` LIKE  '".$CODE_SOCIETE."' ");
        $EFFEDU = $this->uri->segment(7);
        $EFFEDU = DateTime::createFromFormat('Ymd', $EFFEDU);
        $EFFEDU = $EFFEDU->format('d/m/Y'); 

        $ECHEANCE = $this->uri->segment(8);
        $ECHEANCE = DateTime::createFromFormat('Ymd', $ECHEANCE);
        $ECHEANCE = $ECHEANCE->format('d/m/Y'); 
        $SOUSCRIPTEUR_ID = $this->uri->segment(9);
        $preneur= $this->Model->getRequeteOne("Select * from souscripteur WHERE SOUSCRIPTEUR_ID =".$SOUSCRIPTEUR_ID." ");
        $ASSURANCE_ID = $this->uri->segment(10);
        
        // $ASSURANCE_ID = 1;
        // echo $ASSURANCE_ID;
        // echo "<br>";
        // echo "<pre>";

        if (is_numeric($ASSURANCE_ID)) {
        $caract= $this->Model->getRequete("SELECT assurance_carateristique.DESCRIPTION, assurance_carateristique_assurance_value.VALEUR_TEXT FROM `assurance_carateristique_assurance_value` JOIN assurance_carateristique ON assurance_carateristique.ID_CARACTERISTIQUE = assurance_carateristique_assurance_value.ID_CARACTERISTIQUE WHERE assurance_carateristique_assurance_value.ASSURANCE_ID = ".$ASSURANCE_ID." ");
        $capital= $this->Model->getRequete("SELECT assurance_capital.DESCRIPTION, assurance_capital_assurance_value.CAPITAL_ASSURE, assurance_capital_assurance_value.POURCENTAGE_VALUE, assurance_capital_assurance_value.PRIME_POURCENTAGE_TOT, assurance_capital_assurance_value.PRIME_TOTALE, assurance_capital_assurance_value.PRIME_FIXE, assurance_capital_assurance_value.ID_ASSURANCE_CAPITAL FROM assurance_capital JOIN assurance_capital_assurance_value ON assurance_capital_assurance_value.ID_ASSURANCE_CAPITAL = assurance_capital.ID_ASSURANCE_CAPITAL WHERE assurance_capital_assurance_value.ASSURANCE_ID = ".$ASSURANCE_ID." ");
        $projet= $this->Model->getRequeteOne("SELECT assurance.PROJET FROM assurance WHERE assurance.ASSURANCE_ID = ".$ASSURANCE_ID." ");
        if ($projet['PROJET'] == 1) {
          $previsualisation = '';
        }
        else{
          $previsualisation = '-';  
        }
        
        } else {
        $caract= $this->Model->getRequete("SELECT assurance_carateristique.DESCRIPTION, assurance_carateristique_assurance_value.VALEUR_TEXT FROM `assurance_carateristique_assurance_value` JOIN assurance_carateristique ON assurance_carateristique.ID_CARACTERISTIQUE = assurance_carateristique_assurance_value.ID_CARACTERISTIQUE WHERE assurance_carateristique_assurance_value.TEMPOS LIKE '".$ASSURANCE_ID."' ");
        $capital= $this->Model->getRequete("SELECT assurance_capital.DESCRIPTION, assurance_capital_assurance_value.CAPITAL_ASSURE, assurance_capital_assurance_value.POURCENTAGE_VALUE, assurance_capital_assurance_value.PRIME_POURCENTAGE_TOT, assurance_capital_assurance_value.PRIME_TOTALE, assurance_capital_assurance_value.PRIME_FIXE, assurance_capital_assurance_value.ID_ASSURANCE_CAPITAL FROM assurance_capital JOIN assurance_capital_assurance_value ON assurance_capital_assurance_value.ID_ASSURANCE_CAPITAL = assurance_capital.ID_ASSURANCE_CAPITAL WHERE assurance_capital_assurance_value.TEMPOS LIKE '".$ASSURANCE_ID."' ");
        $previsualisation = '-';
        }
// SELECT assurance_capital.DESCRIPTION, assurance_capital_assurance_value.CAPITAL_ASSURE, assurance_capital_assurance_value.POURCENTAGE, assurance_capital_assurance_value.VALEUR_PRIME FROM `assurance_carateristique_assurance_value` JOIN assurance_capital ON assurance_capital.ID_ASSURANCE_CAPITAL = assurance_capital_assurance_value.ID_ASSURANCE_CAPITAL WHERE assurance_capital_assurance_value.TEMPOS LIKE 'Z3PGL5EY' 
        // print_r($caract);
        // exit();
        

        
        // $PRIME_TOT = $this->uri->segment(11);
        // $PRIME_TR = $this->uri->segment(12);
        // $PRIME_FAP = $this->uri->segment(13);
        $UTILISATEUR_ID = $this->uri->segment(11);
        $users= $this->Model->getRequeteOne("Select * from admin_utilisateurs WHERE UTILISATEUR_ID =".$UTILISATEUR_ID." ");

        $DESCR_ASS = $this->uri->segment(12);
        $DUREE_MOIS = $this->uri->segment(13);

      $pdf = new PDF_CONFIG('P','mm','A4');
      $pdf->addPage();
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(1,-20,utf8_decode('Société Anonyme au Capital de 1 698 450 000 FBU'),0,0,'L');
      // $pdf->Ln(-5);
      $pdf->Cell(55,-12,utf8_decode('Entreprise régie par le Code des Assurances Burundais'),0,0,'L');
       $pdf->Ln(1);
      $pdf->Cell(125,-10,utf8_decode('------------------------------------------------------------------------------'),0,0,'R');
      $pdf->Ln(7);
      $pdf->Cell(210,-17,utf8_decode('COMPTES ( BANCOBU : 9413-01-29 | CRDB: 0150800449800 | IBB : 0915801-17 |'),0,0,'C');
      $pdf->Ln(7);
      $pdf->Cell(166,-25,utf8_decode('FLB :02000731101-72 | KCB: 6600009888 | BGF:15002009111 | BBCI:500-01411101-18)'),0,0,'R');

      if (is_numeric($ASSURANCE_ID)) {
        $projet= $this->Model->getRequeteOne("SELECT assurance.PROJET FROM assurance WHERE assurance.ASSURANCE_ID = ".$ASSURANCE_ID." ");
        if ($projet['PROJET'] == 0) {
      $pdf->Ln(1);
      $pdf->SetFont('Arial','B',32);
      $pdf->SetTextColor(255,192,203);
      $pdf->Cell(-57,1,'PREVISUALISATION DU CONTRAT',0,0,'L');
      $pdf->SetTextColor(0,0,0);
        }
      }
      else{
      $pdf->Ln(1);
      $pdf->SetFont('Arial','B',32);
      $pdf->SetTextColor(255,192,203);
      $pdf->Cell(-57,1,'PREVISUALISATION DU CONTRAT',0,0,'L');
      $pdf->SetTextColor(0,0,0);
      }
      

      $pdf->SetX(5);
      $pdf->SetFont('Arial','B',15);
      $pdf->SetTextColor(0,0,0);
      $pdf->Cell(190,5,utf8_decode(strtoupper($typeass['DESCRIPTION'])),0,1,'C');
      $pdf->SetX(10);
      $pdf->setFillColor(194,229,229); 
      $pdf->SetTextColor(1,0,128);
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(190,5,utf8_decode('AVENANT D\'ORDRE D\'ASSURANCE N° : '.$previsualisation.''.$NUM_ASSURANCE.' '),0,1,'C',1);
      $pdf->SetX(10);
      $pdf->Ln(1);
      $pdf->setFillColor(194,229,229); 
      $pdf->SetTextColor(0,0,0);
      $pdf->Cell(190,5,utf8_decode('Police'),0,1,'C',1);
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(35,5,utf8_decode('Bureau Direct'),0,0,'L');
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($banques['DESCRIPTION']),0,0,'L',1);   
      $pdf->Cell(95,5,utf8_decode(''),0,1,'L');   
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(35,5,utf8_decode('Adresse'),0,0,'L');   
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($banques['ADRESSE']),0,0,'L',1);      
      $pdf->Cell(35,5,'',0,0,'L');
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode(''),0,1,'L',1);
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(35,5,utf8_decode('Téléphone'),0,0,'L');   
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($banques['TEL']),0,0,'L',1);      
      $pdf->Cell(35,5,utf8_decode('Fax'),0,0,'L');
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,'',0,1,'L',1);
      $pdf->SetFont('Arial','B',8);

      $pdf->Cell(35,5,utf8_decode('Produit'),0,0,'L');   
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($typeass['ASSURANCE_TYPE_ID'].' '.$typeass['DESCRIPTION']),0,0,'L',1);      
      $pdf->Cell(35,5,utf8_decode('Durée'),0,0,'L');
      $pdf->setFillColor(221, 221, 217); 

      if ($DUREE_MOIS == 3) {
        $nb_jours = '90 Jours';
      }
      else if ($DUREE_MOIS == 6) {
        $nb_jours = '180 Jours';
      }
      else{
        $nb_jours = '365 Jours';
      }
      
      $pdf->Cell(60,5,utf8_decode($nb_jours),0,1,'L',1);
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(35,5,utf8_decode('Date d\'effet '),0,0,'L');   
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(194,229,229); 
      $pdf->SetTextColor(1,0,128);
      $pdf->Cell(60,5,utf8_decode($EFFEDU.' 00:00'),0,0,'L',1);  
      $pdf->SetTextColor(0,0,0);    
      $pdf->Cell(35,5,utf8_decode('Date d\'échéance '),0,0,'L');
      $pdf->setFillColor(194,229,229); 
      $pdf->SetTextColor(1,0,128);
      $pdf->Cell(60,5,utf8_decode($ECHEANCE.' 23h59'),0,1,'L',1);

      $pdf->SetX(10);
      // $pdf->Ln(5);
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(20,5,'',0,0,'C');
      $pdf->setFillColor(194,229,229); 
      $pdf->SetTextColor(0,0,0);
      $pdf->Cell(150,5,utf8_decode('ASSURE'),0,0,'C',1);
      $pdf->Cell(20,5,utf8_decode($preneur['SOUSCRIPTEUR_ID']),0,1,'R');
      
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(35,5,utf8_decode('Raison Sociale'),0,0,'L');   
      
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($preneur['NOM'].' '.$preneur['PRENOM']),0,0,'L',1);      
      $pdf->Cell(35,5,utf8_decode('Tél.'),0,0,'L');
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($preneur['TELEPHONE']),0,1,'L',1);
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(35,5,utf8_decode('Adresse'),0,0,'L');   
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($preneur['ADRESSE']),0,0,'L',1);      
      $pdf->Cell(35,5,utf8_decode('GSM.'),0,0,'L');
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode(''),0,1,'L',1);

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(35,5,utf8_decode('Activité'),0,0,'L');   
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($preneur['SECTEUR_ACTIVITE']),0,0,'L',1);      
      $pdf->Cell(35,5,utf8_decode('E-mail'),0,0,'L');
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(60,5,utf8_decode($preneur['EMAIL']),0,1,'L',1);


      $pdf->SetX(10);
      $pdf->SetFont('Arial','B',12);
      $pdf->setFillColor(194,229,229); 
      // $pdf->SetTextColor(1,0,128);
      $pdf->SetTextColor(0,0,0);
      $pdf->Cell(190,5,utf8_decode('PERIODE DE GARANTIE'),0,1,'C',1);
      $pdf->SetFont('Arial','',8);
      $pdf->SetTextColor(0,0,0);
      $pdf->Cell(15,5,utf8_decode('Du'),0,0,'L');   
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(30,5,utf8_decode($EFFEDU),0,0,'L',1);      
      $pdf->Cell(15,5,utf8_decode('Au'),0,0,'L');
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(30,5,utf8_decode($ECHEANCE),0,0,'L',1);
      $pdf->Cell(30,5,utf8_decode('Durée :'),0,0,'L');
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(30,5,utf8_decode('365 Jours'),0,0,'L',1);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(40,5,utf8_decode('Sans tacite reconduction'),0,1,'L',1);

      $pdf->SetX(10);
      $pdf->SetFont('Arial','B',12);
      $pdf->setFillColor(194,229,229); 
      $pdf->Cell(190,5,utf8_decode('FACULTÉS'),0,1,'C',1);
      $pdf->SetFont('Arial','B',8);
      $pdf->setFillColor(221, 221, 217); 
      $DESCR_ASS = str_replace("%20"," ",$DESCR_ASS);
      $pdf->Cell(190,5,utf8_decode('* '.$DESCR_ASS.''),0,1,'L',1);   
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(70,5,utf8_decode('Adresse '),0,0,'L',1);   
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(120,5,utf8_decode($preneur['ADRESSE']),0,1,'L',1);      
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(70,5,utf8_decode('Ville'),0,0,'L',1);   
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(120,5,utf8_decode($preneur['ADRESSE']),0,1,'L',1);      

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(190,5,utf8_decode('Caractéristiques'),0,1,'L',1);   


      foreach ($caract as $value) {
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(60,5,utf8_decode('+ '.$value['DESCRIPTION'].''),0,0,'L');   
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(130,5,utf8_decode($value['VALEUR_TEXT']),0,1,'L',1);     
      }
          
 

      $pdf->SetX(10);
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(0,0,0);
      $pdf->Ln(5);
      $pdf->setFillColor(194,229,229); 
      $pdf->Cell(75,5,'',0,0,'C',1);
      $pdf->Cell(80,5,utf8_decode('Franchises'),0,0,'C',1);
      $pdf->Cell(35,5,'',0,1,'C',1);
      $pdf->Cell(55,5,utf8_decode('Garanties souscrites'),0,0,'C',1);

      $pdf->Cell(35,5,utf8_decode('Limitation Garanties'),0,0,'C',1);
      $pdf->Cell(15,5,utf8_decode('Taux'),0,0,'C',1);
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(25,5,utf8_decode('Minimum(FBU)'),0,0,'L',1);
      // $pdf->SetFont('Arial','',8);
      $pdf->Cell(25,5,utf8_decode('Maximum(FBU)'),0,0,'L',1); 
      $pdf->Cell(35,5,utf8_decode('Primes Nettes(FBU)'),0,1,'L',1);  
      $primes = 0;
      foreach ($capital as $value) {
      $pdf->SetFont('Arial','B',9);
      $pdf->SetTextColor(0,0,0);
      $pdf->Cell(55,5,utf8_decode("* ".$value['DESCRIPTION']),0,0,'L');
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(35,5,utf8_decode(number_format($value['CAPITAL_ASSURE'], 0, ',',' ')),0,0,'R');
      $pdf->Cell(15,5,utf8_decode(number_format($value['POURCENTAGE_VALUE'], 1, ',',' ')),0,0,'R');
      $pdf->Cell(25,5,'',0,0,'L');
      // $pdf->SetFont('Arial','',8);
      $pdf->Cell(25,5,utf8_decode(''),0,0,'L'); 
      $pdf->Cell(35,5,utf8_decode(number_format($value['PRIME_TOTALE'], 0, ',',' ')),0,1,'R');    
      $primes += $value['PRIME_TOTALE']; 


      $composant_capital= $this->Model->getRequete("SELECT assurance_capital_composant.DESCRIPTION, assurance_capital_composant.PRIME_FIXE, assurance_capital_composant.POURCENTAGE FROM assurance_capital_composant WHERE assurance_capital_composant.ID_ASSURANCE_CAPITAL = ".$value['ID_ASSURANCE_CAPITAL']." ");
      foreach ($composant_capital as $key => $composant_value) {
      
      $pdf->SetFont('Arial','',8);
      $pdf->SetTextColor(0,0,0);
      $pdf->Cell(12,5,utf8_decode(' -'),0,0,'R');
      $pdf->Cell(43,5,utf8_decode($composant_value['DESCRIPTION']),0,0,'L');
      $pdf->Cell(35,5,utf8_decode(number_format($value['CAPITAL_ASSURE'], 0, ',',' ')),0,0,'R');
      $primes_compose = ($composant_value['POURCENTAGE'] * $value['CAPITAL_ASSURE'] / 100) + $composant_value['PRIME_FIXE'];
      $pdf->Cell(15,5,utf8_decode(number_format($composant_value['POURCENTAGE'], 1, ',',' ')),0,0,'R');
      $pdf->Cell(25,5,'',0,0,'L');
      $pdf->Cell(25,5,utf8_decode(''),0,0,'L'); 
      $pdf->Cell(35,5,utf8_decode(number_format($primes_compose, 0, ',',' ')),0,1,'R');  
      
      }
        


      }

      $pdf->SetX(10);
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(0,0,0);
      // $pdf->Ln(5);

      
      $pdf->SetFont('Arial','B',8);
      $pdf->setFillColor(194,229,229); 
      $pdf->Cell(30,5,'',0,0,'C',1);
      $pdf->Cell(130,5,utf8_decode('DECOMPTE DE PRIME'),0,0,'C',1);
      $pdf->Cell(30,5,utf8_decode('Emission'),0,1,'R');
      
      $pdf->SetFont('Arial','',8);
      $pdf->setFillColor(221, 221, 217); 
      $pdf->Cell(20,5,utf8_decode('Prime Nette'),0,0,'C',1);
      $pdf->Cell(30,5,utf8_decode('Accessoires'),0,0,'C',1);
      $pdf->Cell(20,5,'',0,0,'C',1);
      $pdf->Cell(20,5,utf8_decode('TVA'),0,0,'L',1);
      $pdf->Cell(30,5,'',0,0,'L',1);   
      $pdf->Cell(35,5,'',0,0,'L',1);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(35,5,utf8_decode('Prime Totale'),0,1,'L',1);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(20,5,utf8_decode(number_format($primes, 0, ',',' ')),0,0,'C');
      $data_prix_sevices= $this->Model->getRequeteOne("SELECT * FROM assurance_prix_services WHERE IS_ACTIVE = 1 ");
      $prix_sevices =$primes * $data_prix_sevices['POURCENTAGE_PRIME']/100;
      $pdf->Cell(30,5,utf8_decode(number_format($prix_sevices, 0, ',',' ')),0,0,'C');
      $pdf->Cell(20,5,'',0,0,'C');
      $pdf->Cell(20,5,'',0,0,'L');
      $pdf->Cell(30,5,'',0,0,'L');   
      $pdf->Cell(35,5,'',0,0,'L');
      $pdf->SetFont('Arial','',12);
      $PRIME_TOT = $prix_sevices + $primes;
      $pdf->Cell(35,5,utf8_decode(''.number_format($PRIME_TOT, 0, ',',' ').' FBU'),0,1,'L',1);
      $pdf->SetFont('Arial','',8);
      

      $pdf->MultiCell(190,5,utf8_decode('Il n\'est rien dérogé aux autres clauses et conditions de la police à laquelle le présent avenant demeure annexé. Sont nulles toutes adjonctions ou
modifications matérielles non revêtues du visa de la compagnie.'),0,'J',0);

      $pdf->Cell(190,5,utf8_decode('Avenant Crée par : '.$users['UTILISATEUR_NOM'].' '.$users['UTILISATEUR_PRENOM'].' '),0,1,'L'); 
      $pdf->Cell(190,5,utf8_decode('Fait en 3 exemplaires à Bujumbura, le '.date('d/m/Y').' '),0,1,'C'); 
      $pdf->Cell(190,5,utf8_decode('« Sous réserve » et « Validité de '.$DUREE_MOIS.' mois » '),0,1,'C'); 
      $pdf->Cell(95,5,utf8_decode('Pour le souscripteur'),0,0,'C'); 
      $pdf->Cell(95,5,utf8_decode('Pour l\'Assureur'),0,1,'C'); 




  


      $pdf->Output('PREV_NOM_BANQUE_Assurance_DATEDAY_mois.pdf','I');

    }



    
}
