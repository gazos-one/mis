<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf_Preview extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    public function type_assurance(){
      $prevcodeass=$this->uri->segment(4);
      $prevtypassurance = $this->uri->segment(5);
      $prevcapital = $this->uri->segment(6);
      $prevdateprised = $this->uri->segment(7);
      $prevecheance = $this->uri->segment(8);
      $prevecheanceun = $this->uri->segment(9);
      $prevassure = $this->uri->segment(10);
      $prevsoub = $this->uri->segment(11);
      $CODE_SOCIETE = $this->uri->segment(12);
      $duree = $this->uri->segment(13);
      $TYPE_ASSURANCES = $this->uri->segment(14);
      $perte = $this->uri->segment(15);

    	$assur=$this->uri->segment(4);
    	if($perte==0){
    		$this->assurance_protection_sans_perte($assur);
    	}
      else
      {
    		$this->assurance_protection_avec_perte($assur);
    	}
    }

    
    public function assurance_protection_sans_perte($id){

      $prevcodeass=$this->uri->segment(4);
      $prevtypassurance = $this->uri->segment(5);
      $prevcapital = $this->uri->segment(6);
      $prevdateprised = $this->uri->segment(7);
      $prevecheance = $this->uri->segment(8);
      $prevecheanceun = $this->uri->segment(9);
      $prevassure = $this->uri->segment(10);
      $prevsoub = $this->uri->segment(11);
      $CODE_SOCIETE = $this->uri->segment(12);
      $duree = $this->uri->segment(13);
      $TYPE_ASSURANCES = $this->uri->segment(14);
      $perte = $this->uri->segment(15);
      $CODEUUID = $this->uri->segment(16);

      include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';

      $date_prise_effet=new DateTime($prevdateprised);
      $date_echeance=new DateTime($prevecheance);
      $info_souscripteur=$this->Model->getOne('souscripteur',array('SOUSCRIPTEUR_ID'=>$prevsoub));
     
      if($info_souscripteur['TYPE_SOUSCRIPTEUR_ID']==1){
      	$nom_souscr=$info_souscripteur['NOM'];
      	$date_naiss='-';
      	$adresse=$info_souscripteur['ADRESSE'];
      	$localite=$info_souscripteur['VILLE'];
      	$tel=$info_souscripteur['TELEPHONE'];

      }else{
      	$nom_souscr=$info_souscripteur['NOM'].' '.$info_souscripteur['PRENOM'];
      	$date_naiss=date("d/m/Y", strtotime($info_souscripteur['DATE_NAISSANCE']));

      	$adresse=$info_souscripteur['ADRESSE'];
      	$localite=$info_souscripteur['VILLE'];
      	$tel=$info_souscripteur['TELEPHONE'];
      }

      $mode_paiement=$this->Model->getOne('mode_paiement',array('MODE_PAIEMENT_ID'=>1));
      $asurance_type=$this->Model->getOne('asurance_type',array('ASSURANCE_TYPE_ID'=>$prevtypassurance));
      $objet=$this->Model->getOne('objet',array('OBJET_ID'=>1));

      if ($TYPE_ASSURANCES == 206) {
        $assure=$this->Model->getOne('souscripteur',array('SOUSCRIPTEUR_ID'=>$prevsoub));

        
        $bigduree=$this->Model->getOneOrder('assure_206',array('CODE_ASSURANCE'=>$CODEUUID),'DUREE_ID','DESC');
        $newdurre = $bigduree['DUREE_ID'];
      }
      else{
        $assure=$this->Model->getOne('assure',array('ASSURE_ID'=>$prevassure));
        $newdurre = $duree;
      }
      

      // $periodicite=$this->Model->getOne('periodicite',array('INTERVALLEUN <='=> $duree,'INTERVALLEDEUX >='=> $duree));
      $periodicite=$this->Model->getRequeteOne('SELECT * from prime JOIN periodicite pe ON pe.PERIODICITE_ID=prime.PERIODICITE_ID WHERE code_societe like "'.$CODE_SOCIETE.'" and pe.INTERVALLEUN <= '.$duree.' and pe.INTERVALLEDEUX >='.$duree.' and ASSURANCE_TYPE_ID = '.$prevtypassurance.' ORDER by pe.INTERVALLEDEUX ASC LIMIT 1');

      $user=$this->session->userdata('SOCAR_UTILISATEUR_EMAIL');
      $code_soc=$this->Model->getOne('admin_utilisateurs',array('UTILISATEUR_EMAIL'=>$user));
      $info_banque=$this->Model->getOne('creancier',array('CODE_SOCIETE'=>$CODE_SOCIETE));
      $codeassu = 'POLICE N° : '. $info_banque['POLICE_NUMERO'].' - '. $prevcodeass.'';

      $logo_banque='uploads/logo_societe/'.$info_banque['LOGO'].'';
      $abbreviation_banque=$info_banque['SIGLE_BANQUE'];
      $nom_banque_1=$info_banque['DESCRIPTION'];
      $nom_banque_2='';
      $titreassurance=strtoupper($asurance_type['DESCRIPTION']).' SANS PERTE D\'EMPLOI';
      $nom_complet_banque_miniscule=ucfirst(strtolower($nom_banque_1)).' ('.$abbreviation_banque.') ';
      $codeassu = 'POLICE N° : '. $info_banque['POLICE_NUMERO'].' - '. $prevcodeass.''; 

      $nom_souscripteur=$nom_souscr;
      $date_naissance=$date_naiss;
      $adresse=$adresse;
      $localite=$localite;
      $tel=$tel;

      $prise_effet=$date_prise_effet->format('d/m/Y');
      $echeance=$date_echeance->format('d/m/Y');

      $mode_paiement=$mode_paiement['DESCRIPTION'];
      $Objet=$objet['DESCRIPTION'];

      $calcprime=$this->Model->getOne('prime',array('PERIODICITE_ID'=>$periodicite['PERIODICITE_ID'],'ASSURANCE_TYPE_ID'=> $prevtypassurance,'CODE_SOCIETE'=>$CODE_SOCIETE));
      
      // $primeinit = ($this->input->post('prevcapital')*$calcprime['PRIME_PERTE'])/100;
      if ($TYPE_ASSURANCES != 206) {  
      if ($perte==1) {
        $primeinit = ($prevcapital*$calcprime['PRIME_PERTE'])/100;
        $primesup = 0;
        $prime = $primeinit + $primesup;
      }
      else{
        $primeinit = ($prevcapital*$calcprime['PRIME_TOTALE'])/100;
        $primesup = 0;
        $prime = $primeinit + $primesup;
      }
    }
    else{
      $sommes=$this->Model->getRequeteOne('SELECT SUM(CAPITAL_ASS) as CAPITAL_ASS, SUM(PRIME) as PRIME FROM assure_206 WHERE CODE_ASSURANCE like "'.$CODEUUID.'" ');
        $prime = $sommes['PRIME'];
    }

      $periodicite=$periodicite['DESCRIPTION'];

      $assure=$assure['NOM'].' '.$assure['PRENOM'];
	  $capital_assure=$prevcapital;

	  $nbre_mois=explode(" ", $periodicite);

      $pdf = new PDF_CONFIG('P','mm','A4');
      $pdf->addPage();
      $pdf->Image(''.$logo_banque.'',145,5,30,10);
      $pdf->Ln(-5);

      $pdf->SetX(120);
      $pdf->Cell(80,5,$nom_banque_1,0,1,'C');
      $pdf->SetX(120);
      $pdf->Cell(80,5,$nom_banque_2,0,0,'C');
      $pdf->Ln(20);
      $pdf->SetFont('Arial','B',10);

      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode($codeassu),0,1,'L');
      $pdf->SetX(91);
      $pdf->Cell(40,0,'',1,1,'L');
      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode($titreassurance),0,1,'L');
      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode('CONDITIONS PARTICULIERES'),0,1,'L');


      $pdf->SetFont('Arial','B',50);
      $pdf->SetTextColor(255,192,203);
      $pdf->Cell(40,5,'PREVISUALISATION CONTRAT',0,0,'L');
      $pdf->SetTextColor(0,0,0);

      $pdf->Ln(3);
      $pdf->SetFont('Arial','',10);

      $pdf->Rect(10,60,190,170);
      $pdf->Rect(90,60,55,50);
      $pdf->Rect(145,60,55,50);

      $pdf->MultiCell(80,5,'Preneur d\'assurance (Nom ou raison sociales) '.strtoupper($nom_complet_banque_miniscule).' P/C DE '.$nom_souscripteur,0,'J',0);
      $pdf->Cell(90,5,utf8_decode('Date de naissance : '.strtoupper($date_naissance)),0,1,'L');
      $pdf->Cell(90,5,utf8_decode('Adresse : '.strtoupper($adresse)),0,1,'L');
      $pdf->Cell(90,5,utf8_decode('Localité : '.strtoupper($localite)),0,1,'L');
      $pdf->Cell(90,5,utf8_decode('Tél : '.strtoupper($tel)),0,1,'L');
      $pdf->SetXY(90,60);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(55,8,utf8_decode('PRISE D\'EFFET'),1,0,'C');
      $pdf->Cell(55,8,utf8_decode('ECHEANCE'),1,1,'C');
      $pdf->SetX(90);
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(55,10,utf8_decode(strtoupper($prise_effet)),1,0,'C');
      $pdf->Cell(55,10,utf8_decode(strtoupper($echeance)),1,1,'C');
      $pdf->SetX(90);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(55,10,utf8_decode('Mode de paiement'),1,0,'C');
      $pdf->Cell(55,10,utf8_decode('Objet'),1,1,'C');
      $pdf->SetX(90);
      $pdf->SetFont('Arial','',8);
      $pdf->MultiCell(40,4,utf8_decode(strtoupper($mode_paiement)),0,'C',0);
      
      $pdf->Ln(-4);
      $pdf->SetX(145);
      $pdf->MultiCell(40,4,utf8_decode(strtoupper($Objet)),0,'C',0);
      $pdf->SetX(10);
      $pdf->Ln(14);
      $pdf->Cell(135,10,utf8_decode('Prime totale (BIF) :'.strtoupper(number_format($prime, 1, ',',' '))),1,0,'L');
      $pdf->Cell(55,10,utf8_decode('Périodicité : Unique'),1,1,'L');
      $pdf->Ln(4);
      $pdf->SetFont('Arial','',10);
      $pdf->MultiCell(190,6,utf8_decode('Le présent contrat a pour objet la couverture d\'un prêt et garantit au preneur d\'assurance le paiement du solde restant dû en capital du prêt qui a été consenti par la '.strtoupper($nom_complet_banque_miniscule).' à '.strtoupper($nom_souscripteur).' dans les limites de la somme assurée, suivant les conditions ci-après :'),0,'J',0);
      $pdf->SetX(20);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(25,5,utf8_decode('1. ASSURE : '),0,0,'L');
      $pdf->SetFont('Arial','',10);
      if ($TYPE_ASSURANCES == 206) {
        // $pdf->Cell(120,5,utf8_decode(strtoupper('Membre groupe ( '.$assure.' )')),0,1,'L');
        
        $pdf->Cell(120,5,utf8_decode(strtoupper('Liste en annexe')),0,1,'L');
      }
      else{
        $pdf->Cell(120,5,utf8_decode(strtoupper($assure)),0,1,'L');
      }
      
      $pdf->SetFont('Arial','B',10);
      $pdf->SetX(20);
      $pdf->Cell(40,5,utf8_decode('2. CAPITAL ASSURE :'),0,0,'L');
      $pdf->SetFont('Arial','',10);
      $pdf->MultiCell(120,5,utf8_decode('Solde restant dû sur le capital de '.strtoupper(number_format($capital_assure, 1, ',',' ')).'BIF à l\'exclusion de tout arriéré éventuel'),0,'J',0);
      $pdf->SetX(20);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(55,5,utf8_decode('3. GARANTIES ACCORDEES:'),0,1,'L');
      $pdf->SetX(30);
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(55,5,utf8_decode('A. Décès'),0,1,'L');
      $pdf->SetX(30);
      $pdf->Cell(55,5,utf8_decode('B. Incapacité permanente totale'),0,1,'L');
      $pdf->Ln(8);
      $pdf->MultiCell(190,6,utf8_decode('Le contrat est souscrit pour une période de '.$newdurre.' mois fermes prenant effet à la date de sa signature et après payement de la prime.'),0,'J',0);

      $pdf->MultiCell(190,6,utf8_decode('Les conditions générales, la proposition d\'assurance et les présentes conditions particulières forment le contrat d\'assurance. Elles sont de rigueur, de stricte interpretation et ont été ainsi convenues entre parties pour être éxécutées de bonne foi..'),0,'J',0);


      

      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(190,5,utf8_decode('Fait à Bujumbura, le '.date('d/m/Y')),0,1,'C');
      $pdf->Cell(63,5,utf8_decode('LE SOUSCRIPTEUR'),0,0,'L');
      $pdf->Cell(64,5,utf8_decode('LE CREANCIER'),0,0,'C');
      $pdf->Cell(63,5,utf8_decode('L\'ASSUREUR'),0,1,'R');
      $pdf->Cell(63,5,utf8_decode(strtoupper($nom_souscripteur)),0,0,'L');
      $pdf->Cell(64,5,utf8_decode(strtoupper($abbreviation_banque)),0,0,'C');
      $pdf->Cell(63,5,utf8_decode('SOCAR VIE'),0,1,'R');

      
      // if ($TYPE_ASSURANCES == 206) {    
      //   $listeass=$this->Model->getList('assure_206',array('CODE_ASSURANCE'=>$CODEUUID));
      //   $numbreass=$this->Model->record_countsome('assure_206',array('CODE_ASSURANCE'=>$CODEUUID));
      //   $i =1;
      //   $pdf->Ln(150);
      //   $pdf->Ln(150);
      //         $pdf->SetX(100);
      // $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
      // $pdf->SetX(101);
      // $pdf->Cell(50,0,'',0,0,'L');
      // $pdf->SetX(90);
      // $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
      // $pdf->SetX(100);
      // $pdf->Cell(100,5,utf8_decode('Liste des Membres (Au nombre de '.$numbreass.')'),0,1,'L');
      // $pdf->SetFont('Arial','B',10);

      //   foreach ($listeass as $key) {

      //   $pdf->SetX(20);
      // $pdf->SetFont('Arial','',10);
      // $pdf->Cell(70,5,utf8_decode(''.$i.'. '.$key['NOM_PRENOM'].' ('.$key['MATRICULE'].') - Capital: '.$key['CAPITAL_ASS'].' BIF - Prime: '.$key['PRIME'].' BIF - Durée: '.$key['DUREE_ID'].' Mois. Signature _____________________'),0,0,'L');
      // $pdf->SetFont('Arial','',10);
      //   $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
      //   $pdf->SetFont('Arial','',10);
      //   $pdf->Cell(120,5,utf8_decode(' '),0,1,'L');
      // $pdf->Line(70,5,120, 5);
      //   $i++;
      //   }
      // }
      if ($TYPE_ASSURANCES == 206) {    
        $pdf->Ln(150);
        $pdf->Ln(150);
              $pdf->SetX(100);
              $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
      $pdf->SetX(101);
      $pdf->Cell(50,0,'',0,0,'L');
      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
      $pdf->SetX(50);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(50,5,utf8_decode('Liste des Membres du groupe'),0,1,'L');
      $pdf->SetX(51);
      $pdf->Cell(51,0,'',1,1,'L');
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
        $distinction=$this->Model->getListDistinct('assure_206',array('CODE_ASSURANCE'=>$CODEUUID),'DUREE_ID');
        $sommecapiall=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$CODEUUID),'CAPITAL_ASS');
        $sommepriall=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$CODEUUID),'PRIME');
        foreach ($distinction as $value) {
          # code...
        
        $listeass=$this->Model->getList('assure_206',array('CODE_ASSURANCE'=>$CODEUUID,'DUREE_ID'=>$value['DUREE_ID']));
        $numbreass=$this->Model->record_countsome('assure_206',array('CODE_ASSURANCE'=>$CODEUUID,'DUREE_ID'=>$value['DUREE_ID']));
        $sommecapi=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$CODEUUID,'DUREE_ID'=>$value['DUREE_ID']),'CAPITAL_ASS');
        $sommepri=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$CODEUUID,'DUREE_ID'=>$value['DUREE_ID']),'PRIME');
        $i =1;
        
      // $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
      // $pdf->SetX(101);
      // $pdf->Cell(50,0,'',0,0,'L');
      // $pdf->SetX(90);
      // $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
      // $pdf->SetX(50);
      // $pdf->SetFont('Arial','B',10);
      // $pdf->Cell(50,5,utf8_decode('Liste des Membres pour une durée de '.$value['DUREE_ID'].' mois (Au nombre de '.$numbreass.')'),0,1,'L');
      // $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
$pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
     
$pdf->SetFont('Arial','B',10);

$pdf->Cell(7,5,'',0,0,'C');
$pdf->Cell(70,5,'Nom (Matricule)',1,0,'C');
$pdf->Cell(30,5,'Capital',1,0,'C');
$pdf->Cell(30,5,'Prime',1,0,'C');
$pdf->Cell(13,5,utf8_decode('Durée'),1,0,'C');
$pdf->Cell(40,5,'Signature',1,1,'C');


        foreach ($listeass as $key) {
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(7,5,$i,1,0,'C');
        $pdf->Cell(70,5,utf8_decode(''.$key['NOM_PRENOM'].' ('.$key['MATRICULE'].')'),1,0,'L');
$pdf->Cell(30,5,number_format($key['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
$pdf->Cell(30,5,number_format($key['PRIME'], 1, ',',' ').' BIF',1,0,'R');
$pdf->Cell(13,5,$key['DUREE_ID'],1,0,'R');
$pdf->Cell(40,5,'',1,1,'L');

        $i++;
        
        }
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7,5,'',0,0,'C');
        $pdf->Cell(70,5,'',0,0,'C');
        $pdf->Cell(30,5,number_format($sommecapi['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
        $pdf->Cell(30,5,number_format($sommepri['PRIME'], 1, ',',' ').' BIF',1,0,'R');
        $pdf->Cell(13,5,'',0,0,'C');
        $pdf->Cell(40,5,'',0,1,'C');
        
      }

$pdf->Cell(100,5,utf8_decode(''),0,1,'L');
      $pdf->SetX(101);
      $pdf->Cell(50,0,'',0,0,'L');
      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
      $pdf->SetX(50);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(50,5,utf8_decode('Totale général'),0,1,'C');
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');

      $pdf->SetFont('Arial','B',10);
$pdf->Cell(7,5,'',0,0,'C');
$pdf->Cell(70,5,'',0,0,'C');
$pdf->Cell(30,5,'Capital',1,0,'C');
$pdf->Cell(30,5,'Prime',1,0,'C');
$pdf->Cell(13,5,'',0,0,'C');
$pdf->Cell(40,5,'',0,1,'C');

      $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7,5,'',0,0,'C');
        $pdf->Cell(70,5,'',0,0,'C');
        $pdf->Cell(30,5,number_format($sommecapiall['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
        $pdf->Cell(30,5,number_format($sommepriall['PRIME'], 1, ',',' ').' BIF',1,0,'R');
        $pdf->Cell(13,5,'',0,0,'C');
        $pdf->Cell(40,5,'',0,1,'C');
      }

      $pdf->Output('Assurance.pdf','I');

    }


    public function assurance_protection_avec_perte($id){
      $prevcodeass=$this->uri->segment(4);
      $prevtypassurance = $this->uri->segment(5);
      $prevcapital = $this->uri->segment(6);
      $prevdateprised = $this->uri->segment(7);
      $prevecheance = $this->uri->segment(8);
      $prevecheanceun = $this->uri->segment(9);
      $prevassure = $this->uri->segment(10);
      $prevsoub = $this->uri->segment(11);
      $CODE_SOCIETE = $this->uri->segment(12);
      $duree = $this->uri->segment(13);
      $TYPE_ASSURANCES = $this->uri->segment(14);
      $perte = $this->uri->segment(15);
      $CODEUUID = $this->uri->segment(16);
// echo'prevcodeass '. $prevcodeass. "<br>";
//       echo'prevtypassurance '. $prevtypassurance. "<br>";
//       echo'prevcapital '. $prevcapital. "<br>";
//       echo'prevdateprised '. $prevdateprised. "<br>";
//       echo'prevecheance '. $prevecheance. "<br>";
//       echo'prevecheanceun '. $prevecheanceun. "<br>";
//       echo'prevassure '. $prevassure. "<br>";
//       echo'prevsoub '. $prevsoub. "<br>";
//       echo'CODE_SOCIETE '. $CODE_SOCIETE. "<br>";
//       echo'duree '. $duree. "<br>";
//       echo'TYPE_ASSURANCES '. $TYPE_ASSURANCES. "<br>";
//       echo'perte '. $perte. "<br>";

      include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';

//       $id=$id;
      // $info_assurance=$this->Model->getOne('assurance',array('ASSURANCE_ID'=>$id));
      $date_prise_effet=new DateTime($prevdateprised);
      $date_echeance=new DateTime($prevecheance);

      $info_souscripteur=$this->Model->getOne('souscripteur',array('SOUSCRIPTEUR_ID'=>$prevsoub));
     
      if($info_souscripteur['TYPE_SOUSCRIPTEUR_ID']==1){
      	$nom_souscr=$info_souscripteur['NOM'];
      	$date_naiss='-';
      	$adresse=$info_souscripteur['ADRESSE'];
      	$localite=$info_souscripteur['VILLE'];
      	$tel=$info_souscripteur['TELEPHONE'];

      }else{
      	$nom_souscr=$info_souscripteur['NOM'].' '.$info_souscripteur['PRENOM'];
      	$date_naiss=date("d/m/Y", strtotime($info_souscripteur['DATE_NAISSANCE']));
      	$adresse=$info_souscripteur['ADRESSE'];
      	$localite=$info_souscripteur['VILLE'];
      	$tel=$info_souscripteur['TELEPHONE'];
      }

      $mode_paiement=$this->Model->getOne('mode_paiement',array('MODE_PAIEMENT_ID'=>1));
      $asurance_type=$this->Model->getOne('asurance_type',array('ASSURANCE_TYPE_ID'=>$TYPE_ASSURANCES));
      $objet=$this->Model->getOne('objet',array('OBJET_ID'=>1));
      // $assure=$this->Model->getOne('assure',array('ASSURE_ID'=>$prevassure));
      if ($TYPE_ASSURANCES == 206) {
        $assure=$this->Model->getOne('souscripteur',array('SOUSCRIPTEUR_ID'=>$prevsoub));
        $bigduree=$this->Model->getOneOrder('assure_206',array('CODE_ASSURANCE'=>$CODEUUID),'DUREE_ID','DESC');
        $newdurre = $bigduree['DUREE_ID'];
      }
      else{
        $assure=$this->Model->getOne('assure',array('ASSURE_ID'=>$prevassure));
        $newdurre = $duree;
      }

      // $periodicite=$this->Model->getOne('periodicite',array('INTERVALLEUN <='=> $duree,'INTERVALLEDEUX >='=> $duree));
      $periodicite=$this->Model->getRequeteOne('SELECT * from prime JOIN periodicite pe ON pe.PERIODICITE_ID=prime.PERIODICITE_ID WHERE code_societe like "'.$CODE_SOCIETE.'" and pe.INTERVALLEUN <= '.$duree.' and pe.INTERVALLEDEUX >='.$duree.' and ASSURANCE_TYPE_ID = '.$prevtypassurance.' ORDER by pe.INTERVALLEDEUX ASC LIMIT 1');
      
      $user=$this->session->userdata('SOCAR_UTILISATEUR_EMAIL');
      $code_soc=$this->Model->getOne('admin_utilisateurs',array('UTILISATEUR_EMAIL'=>$user));
      // $info_banque=$this->Model->getOne('creancier',array('CODE_SOCIETE'=>$code_soc['CODE_SOCIETE']));
      $info_banque=$this->Model->getOne('creancier',array('CODE_SOCIETE'=>$CODE_SOCIETE));
      $codeassu = '(PREVISUALISATION CONTRANT) POLICE N° : '. $info_banque['POLICE_NUMERO'].' - '. $prevcodeass.'';

       //      $urlpass = base_url();
       //  $elementspas = explode("/", $urlpass);
       // $nouveau_urlpass = null ;
       //  $indicepass = sizeof($elementspas);
       //  for ($i = 0; $i < ($indicepass - 2); $i++) {
       //      $nouveau_urlpass .=$elementspas[$i] . '/';
       //  }

      $logo_banque='uploads/logo_societe/'.$info_banque['LOGO'].'';
      $abbreviation_banque=$info_banque['SIGLE_BANQUE'];
      $nom_banque_1=$info_banque['DESCRIPTION'];
      $nom_banque_2='';
      $titreassurance=strtoupper($asurance_type['DESCRIPTION']).' AVEC PERTE D\'EMPLOI';
      $nom_complet_banque_miniscule=ucfirst(strtolower($nom_banque_1)).' ('.$abbreviation_banque.') ';
// 'ASSURANCE PROTECTION CREDIT 
      $nom_souscripteur=$nom_souscr;
      $date_naissance=$date_naiss;
      $adresse=$adresse;
      $localite=$localite;
      $tel=$tel;

      $prise_effet=$date_prise_effet->format('d/m/Y');
      $echeance=$date_echeance->format('d/m/Y');

      $mode_paiement=$mode_paiement['DESCRIPTION'];
      $Objet=$objet['DESCRIPTION'];

      $calcprime=$this->Model->getOne('prime',array('PERIODICITE_ID'=>$periodicite['PERIODICITE_ID'],'ASSURANCE_TYPE_ID'=> $prevtypassurance,'CODE_SOCIETE'=>$CODE_SOCIETE));

      if ($TYPE_ASSURANCES != 206) {  
      if ($perte==1) {
        $primeinit = ($prevcapital*$calcprime['PRIME_PERTE'])/100;
        $primesup = 0;
        $prime = $primeinit + $primesup;
      }
      else{
        $primeinit = ($prevcapital*$calcprime['PRIME_TOTALE'])/100;
        $primesup = 0;
        $prime = $primeinit + $primesup;
      }
    }
      else{
      $sommes=$this->Model->getRequeteOne('SELECT SUM(CAPITAL_ASS) as CAPITAL_ASS, SUM(PRIME) as PRIME FROM assure_206 WHERE CODE_ASSURANCE like "'.$CODEUUID.'" ');
        $prime = $sommes['PRIME'];
    }

      // $prime=$info_assurance['PRIME_TOTAL'];
      $periodicite=$periodicite['DESCRIPTION'];

      $assure=$assure['NOM'].' '.$assure['PRENOM'];
	  $capital_assure=$prevcapital;

	  $nbre_mois=explode(" ", $periodicite);
     

      $pdf = new PDF_CONFIG('P','mm','A4');
      $pdf->addPage();
      $pdf->Image(''.$logo_banque.'',145,5,30,10);
      $pdf->Ln(-5);

      $pdf->SetX(120);
      $pdf->Cell(80,5,$nom_banque_1,0,1,'C');
      $pdf->SetX(120);
      $pdf->Cell(80,5,$nom_banque_2,0,0,'C');
      $pdf->Ln(20);
      $pdf->SetFont('Arial','B',10);

      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode($codeassu),0,1,'L');
      $pdf->SetX(91);
      $pdf->Cell(40,0,'',1,1,'L');
      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode($titreassurance),0,1,'L');
      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode('CONDITIONS PARTICULIERES'),0,1,'L');
      // $pdf->Line(84,48,128,48);
      $pdf->SetFont('Arial','B',50);
      $pdf->SetTextColor(255,192,203);
      $pdf->Cell(40,5,'PREVISUALISATION CONTRAT',0,0,'L');
      $pdf->SetTextColor(0,0,0);
      
      $pdf->Ln(3);
      $pdf->SetFont('Arial','',9);

      $pdf->Rect(10,60,190,215);
      // $pdf->Rect(10,60,80,50);
      $pdf->Rect(90,60,55,50);
      $pdf->Rect(145,60,55,50);
      // $pdf->Rect(10,110,190,10);
      // $pdf->Rect(10,193,190,17);
      // $pdf->Rect(10,210,190,20);

      $pdf->MultiCell(80,5,'Preneur d\'assurance (Nom ou raison sociales) '.strtoupper($nom_complet_banque_miniscule).' P/C DE '.$nom_souscripteur,0,'J',0);
      $pdf->Cell(90,5,utf8_decode('Date de naissance : '.strtoupper($date_naissance)),0,1,'L');
      $pdf->Cell(90,5,utf8_decode('Adresse : '.strtoupper($adresse)),0,1,'L');
      $pdf->Cell(90,5,utf8_decode('Localité : '.strtoupper($localite)),0,1,'L');
      $pdf->Cell(90,5,utf8_decode('Tél : '.$tel),0,1,'L');
      $pdf->SetXY(90,60);
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(55,8,utf8_decode('PRISE D\'EFFET'),1,0,'C');
      $pdf->Cell(55,8,utf8_decode('ECHEANCE'),1,1,'C');
      $pdf->SetX(90);
      $pdf->SetFont('Arial','',9);
      $pdf->Cell(55,10,utf8_decode(strtoupper($prise_effet)),1,0,'C');
      $pdf->Cell(55,10,utf8_decode(strtoupper($echeance)),1,1,'C');
      $pdf->SetX(90);
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(55,10,utf8_decode('Mode de paiement'),1,0,'C');
      $pdf->Cell(55,10,utf8_decode('Objet'),1,1,'C');
      $pdf->SetX(90);
      $pdf->SetFont('Arial','',8);
      $pdf->MultiCell(40,4,utf8_decode(strtoupper($mode_paiement)),0,'C',0);
      // MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
      $pdf->Ln(-4);
      $pdf->SetX(145);
      $pdf->MultiCell(40,4,utf8_decode(strtoupper($Objet)),0,'C',0);
      $pdf->SetX(10);
      $pdf->Ln(14);
      $pdf->Cell(135,7,utf8_decode('Prime totale (BIF) :'.strtoupper(number_format($prime, 1, ',',' '))),1,0,'L');
      $pdf->Cell(55,7,utf8_decode('Périodicité : Unique'),1,1,'L');
      $pdf->Ln(2);
      $pdf->SetFont('Arial','',8);
      $pdf->MultiCell(190,4,utf8_decode('Le présent contrat a pour objet la couverture d\'un prêt et garantit au preneur d\'assurance le paiement du solde restant dû en capital du prêt qui a été consenti par la '.strtoupper($nom_complet_banque_miniscule).' à '.strtoupper($nom_souscripteur).' dans les limites de la somme assurée, suivant les conditions ci-après :'),0,'J',0);
      $pdf->SetX(20);
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(25,4,utf8_decode('1. ASSURE : '),0,0,'L');
      $pdf->SetFont('Arial','',8);
      if ($TYPE_ASSURANCES == 206) {
        // $pdf->Cell(120,5,utf8_decode(strtoupper('Membre groupe ( '.$assure.' )')),0,1,'L');
        $pdf->Cell(120,5,utf8_decode(strtoupper('Liste en annexe')),0,1,'L');
      }
      else{
        $pdf->Cell(120,5,utf8_decode(strtoupper($assure)),0,1,'L');
      }
      // $pdf->Cell(120,4,utf8_decode(strtoupper($assure)),0,1,'L');
      $pdf->SetFont('Arial','B',8);
      $pdf->SetX(20);
      $pdf->Cell(40,4,utf8_decode('2. CAPITAL ASSURE :'),0,0,'L');
      $pdf->SetFont('Arial','',8);
      // $pdf->Cell(120,5,utf8_decode('...........'),1,1,'L');
      $pdf->MultiCell(120,5,utf8_decode('Solde restant dû sur le capital de '.number_format($capital_assure, 1, ',',' ').'BIF à l\'exclusion de tout arriéré éventuel'),0,'J',0);
      $pdf->SetX(20);
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(55,5,utf8_decode('3. GARANTIES ACCORDEES:'),0,1,'L');
      $pdf->SetX(30);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(55,5,utf8_decode('a) Décès'),0,1,'L');
      $pdf->SetX(30);
      $pdf->Cell(55,5,utf8_decode('b) Incapacité permanente totale'),0,1,'L');
      $pdf->SetX(30);
      $pdf->Cell(55,5,utf8_decode('c) Perte d\'emploi avec un maximum de dix millions de francs burundais'),0,1,'L');
      $pdf->SetX(34);
      $pdf->Cell(55,5,utf8_decode('Hormis les exclusions prévues par les conditions générales en annexe et particulièrement celles reprises ci-après'),0,1,'L');

      // $pdf->Ln(1);
      $pdf->SetX(15);
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(55,4,utf8_decode('Sont exclus de la garantie "PERTE D\'EMPLOI" '),0,1,'L');
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(55,4,utf8_decode('- La démission, le départ volontaire de l\'assuré et la mise en disponibilité à sa demande '),0,1,'L');
      $pdf->Cell(55,4,utf8_decode('- La mise en chômage technique '),0,1,'L');
      $pdf->Cell(55,4,utf8_decode("- L'arrivée à terme d'un contrat à durée déterminée "),0,1,'L');
      $pdf->Cell(55,4,utf8_decode("- La désertion de service "),0,1,'L');
      $pdf->Cell(55,4,utf8_decode("- La mise en retraite et en général la simple suspension du contrat de travail "),0,1,'L');
      $pdf->Cell(55,4,utf8_decode("- Le licenciement pour les raisons économiques et réorganisation au sein de l'institution qui emploie l'assuré "),0,1,'L');
      $pdf->Cell(55,4,utf8_decode("- La fin (à l'echeancez ou precipitée) d'un mandat politique ou autre "),0,1,'L');
      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(55,4,utf8_decode("N.B:"),0,1,'L');
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(55,3,utf8_decode("- Le changement d'employeur n'est pas assimilé à une perte d'emploi"),0,1,'L');
      $pdf->MultiCell(190,5,utf8_decode("- L'emploi dont il est question est celui occupé par une personne qui a été déclarée par Employeur au régime obligatoire de sécurité sociale. "),0,'J',0);

      $pdf->MultiCell(190,5,utf8_decode("- L'assuré déclare et accepte de rester lié à ses engagements envers l'assureur pour le remboursement intégral du crédit par retenue d'office sur son salaire auprès du présent et/ou futur employeur ou par tout autre moyen "),0,'J',0);

      $pdf->MultiCell(190,5,utf8_decode("- L'asssureur ne s'engage à rembourser le solde restant dû que si le dossier ,médical et administratif de l'assuré est déclaré satisfaisant au moment de la souscription du contrat d'assurance. "),0,'J',0);

      $pdf->MultiCell(190,5,utf8_decode("- Conformement aux conditions générales de la police d'assurance Protection Crédit, l'Assureur est subrogé dans les droits de l'organisme prếteur à l'égard de l'employeur et de l'emprunteur. "),0,'J',0);

      $pdf->Ln(3);
      $pdf->MultiCell(190,5,utf8_decode('Le contrat est souscrit pour une période de '.$newdurre.' mois fermes prenant effet à la date de sa signature et après payement de la prime à l\'exception de la garantie de perte d\'emploi qui commence trois mois après la signature du contrat'),0,'J',0);
      $pdf->Ln(1);
      $pdf->MultiCell(190,4,utf8_decode('Les conditions générales, la proposition d\'assurance et les présentes conditions particulières forment le contrat d\'assurance. Elles sont de rigueur, de stricte interpretation et ont été ainsi convenues entre parties pour être éxécutées de bonne foi..'),1,'J',0);

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(190,5,utf8_decode('Fait à Bujumbura, le '.date('d/m/Y')),0,1,'C');
      $pdf->Cell(63,5,utf8_decode('LE SOUSCRIPTEUR'),0,0,'L');
      $pdf->Cell(64,5,utf8_decode('LE CREANCIER'),0,0,'C');
      $pdf->Cell(63,5,utf8_decode('L\'ASSUREUR'),0,1,'R');
      $pdf->Cell(63,5,utf8_decode(strtoupper($nom_souscripteur)),0,0,'L');
      $pdf->Cell(64,5,utf8_decode(strtoupper($abbreviation_banque)),0,0,'C');
      $pdf->Cell(63,5,utf8_decode('SOCAR VIE'),0,1,'R');

     
      if ($TYPE_ASSURANCES == 206) {    
        $pdf->Ln(150);
        $pdf->Ln(150);
              $pdf->SetX(100);
              $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
      $pdf->SetX(101);
      $pdf->Cell(50,0,'',0,0,'L');
      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
      $pdf->SetX(50);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(50,5,utf8_decode('Liste des Membres'),0,1,'L');
      $pdf->SetX(51);
      $pdf->Cell(51,0,'',1,1,'L');
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
        $distinction=$this->Model->getListDistinct('assure_206',array('CODE_ASSURANCE'=>$CODEUUID),'DUREE_ID');
        $sommecapiall=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$CODEUUID),'CAPITAL_ASS');
        $sommepriall=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$CODEUUID),'PRIME');
        foreach ($distinction as $value) {
          # code...
        
        $listeass=$this->Model->getList('assure_206',array('CODE_ASSURANCE'=>$CODEUUID,'DUREE_ID'=>$value['DUREE_ID']));
        $numbreass=$this->Model->record_countsome('assure_206',array('CODE_ASSURANCE'=>$CODEUUID,'DUREE_ID'=>$value['DUREE_ID']));
        $sommecapi=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$CODEUUID,'DUREE_ID'=>$value['DUREE_ID']),'CAPITAL_ASS');
        $sommepri=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$CODEUUID,'DUREE_ID'=>$value['DUREE_ID']),'PRIME');
        $i =1;
        
      // $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
      // $pdf->SetX(101);
      // $pdf->Cell(50,0,'',0,0,'L');
      // $pdf->SetX(90);
      // $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
      // $pdf->SetX(50);
      // $pdf->SetFont('Arial','B',10);
      // $pdf->Cell(50,5,utf8_decode('Liste des Membres pour une durée de '.$value['DUREE_ID'].' mois (Au nombre de '.$numbreass.')'),0,1,'L');
      // $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');

     $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');

$pdf->SetFont('Arial','B',10);

$pdf->Cell(7,5,'',0,0,'C');
$pdf->Cell(70,5,'Nom (Matricule)',1,0,'C');
$pdf->Cell(30,5,'Capital',1,0,'C');
$pdf->Cell(30,5,'Prime',1,0,'C');
$pdf->Cell(13,5,utf8_decode('Durée'),1,0,'C');
$pdf->Cell(40,5,'Signature',1,1,'C');


        foreach ($listeass as $key) {
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(7,5,$i,1,0,'C');
        $pdf->Cell(70,5,utf8_decode(''.$key['NOM_PRENOM'].' ('.$key['MATRICULE'].')'),1,0,'L');
$pdf->Cell(30,5,number_format($key['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
$pdf->Cell(30,5,number_format($key['PRIME'], 1, ',',' ').' BIF',1,0,'R');
$pdf->Cell(13,5,$key['DUREE_ID'],1,0,'R');
$pdf->Cell(40,5,'',1,1,'L');

        $i++;
        
        }
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7,5,'',0,0,'C');
        $pdf->Cell(70,5,'',0,0,'C');
        $pdf->Cell(30,5,number_format($sommecapi['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
        $pdf->Cell(30,5,number_format($sommepri['PRIME'], 1, ',',' ').' BIF',1,0,'R');
        $pdf->Cell(13,5,'',0,0,'C');
        $pdf->Cell(40,5,'',0,1,'C');
        
      }

$pdf->Cell(100,5,utf8_decode(''),0,1,'L');
      $pdf->SetX(101);
      $pdf->Cell(50,0,'',0,0,'L');
      $pdf->SetX(90);
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
      $pdf->SetX(50);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(50,5,utf8_decode('Totale général'),0,1,'C');
      $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');

      $pdf->SetFont('Arial','B',10);
$pdf->Cell(7,5,'',0,0,'C');
$pdf->Cell(70,5,'',0,0,'C');
$pdf->Cell(30,5,'Capital',1,0,'C');
$pdf->Cell(30,5,'Prime',1,0,'C');
$pdf->Cell(13,5,'',0,0,'C');
$pdf->Cell(40,5,'',0,1,'C');

      $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7,5,'',0,0,'C');
        $pdf->Cell(70,5,'',0,0,'C');
        $pdf->Cell(30,5,number_format($sommecapiall['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
        $pdf->Cell(30,5,number_format($sommepriall['PRIME'], 1, ',',' ').' BIF',1,0,'R');
        $pdf->Cell(13,5,'',0,0,'C');
        $pdf->Cell(40,5,'',0,1,'C');
      }

      $pdf->Output('Assurance.pdf','I');

    }

    
}
