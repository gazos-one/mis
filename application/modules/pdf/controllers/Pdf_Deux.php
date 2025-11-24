<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf_Deux extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->model('ghislain_model');
        // $this->load->model('roles_model');
        // $this->load->library("MbxLibrary");
    }
    public function type_assurance(){
    	$assur=$this->uri->segment(4);
    	$info_assurance=$this->Model->getOne('assurance',array('ASSURANCE_ID'=>$assur));
    	// $typ=$info_assurance['PRIMESUP'];
    	// if($typ==0){
    		$this->assurance_protection_sans_perte($assur);
    	// }
      // else
      // {
    		// $this->assurance_protection_avec_perte($assur);
    	// }
    }

    
    public function assurance_protection_sans_perte($id){

      include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';

      $id=$id;
      $info_assurance=$this->Model->getOne('assurance',array('ASSURANCE_ID'=>$id));
      $date_prise_effet=new DateTime($info_assurance['PRISE_EFFET']);
      $date_echeance=new DateTime($info_assurance['ECHEANCE']);

      $info_souscripteur=$this->Model->getOne('souscripteur',array('SOUSCRIPTEUR_ID'=>$info_assurance['SOUSCRIPTEUR_ID']));
     
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

      $mode_paiement=$this->Model->getOne('mode_paiement',array('MODE_PAIEMENT_ID'=>$info_assurance['MODE_PAIEMENT']));
      $asurance_type=$this->Model->getOne('asurance_type',array('ASSURANCE_TYPE_ID'=>$info_assurance['TYPE_ASSURANCE_ID']));
      $objet=$this->Model->getOne('objet',array('OBJET_ID'=>$info_assurance['OBJET']));

      if ($info_assurance['TYPE_ASSURANCE_ID'] == 219) {
        $assure=$this->Model->getOne('souscripteur',array('SOUSCRIPTEUR_ID'=>$info_assurance['SOUSCRIPTEUR_ID']));
      }
      else{
        $assure=$this->Model->getOne('assure',array('ASSURE_ID'=>$info_assurance['BENEFICIAIRE_ID']));
      }
      // $assure=$this->Model->getOne('assure',array('ASSURE_ID'=>$info_assurance['BENEFICIAIRE_ID']));
      $periodicite=$this->Model->getOne('periodicite',array('PERIODICITE_ID'=>$info_assurance['PERIODICITE_ID']));
      // $periodicite=$this->Model->getOneOrder('periodicite',array('INTERVALLEUN <='=> $duree,'INTERVALLEDEUX >='=> $duree),'INTERVALLEDEUX','ASC');

      $user=$this->session->userdata('SOCAR_UTILISATEUR_EMAIL');
      $code_soc=$this->Model->getOne('admin_utilisateurs',array('UTILISATEUR_EMAIL'=>$user));
      $info_banque=$this->Model->getOne('creancier',array('CODE_SOCIETE'=>$info_assurance['CODE_SOCIETE']));

            $urlpass = base_url();
        $elementspas = explode("/", $urlpass);
       $nouveau_urlpass = null ;
        $indicepass = sizeof($elementspas);
        for ($i = 0; $i < ($indicepass - 2); $i++) {
            $nouveau_urlpass .=$elementspas[$i] . '/';
        }

      $logo_banque='uploads/logo_societe/'.$info_banque['LOGO'].'';
      $abbreviation_banque=$info_banque['SIGLE_BANQUE'];
      $nom_banque_1=$info_banque['DESCRIPTION'];
      $nom_banque_2='';
      $titreassurance=strtoupper($asurance_type['DESCRIPTION']);
      $nom_complet_banque_miniscule= $abbreviation_banque ;
      if ($info_assurance['PROJET']==0) {
        $projet ='(PREVISUALISATION CONTRAT) ';
      }
      else{
        $projet ='';
      }
      $codeassu = $projet.'POLICE N° : '. $info_banque['POLICE_NUMERO'].' - '. $info_assurance['CODE_ASSURANCE'].''; 

      $nom_souscripteur=$nom_souscr;
      $date_naissance=$date_naiss;
      $adresse=$adresse;
      $localite=$localite;
      $tel=$tel;

      $prise_effet=$date_prise_effet->format('d/m/Y');
      $echeance=$date_echeance->format('d/m/Y');

      $mode_paiement=$mode_paiement['DESCRIPTION'];
      $Objet=$objet['DESCRIPTION'];

      $prime=$info_assurance['PRIME_TOTAL'];
      $periodicite=$periodicite['DESCRIPTION'];

      $assure=$assure['NOM'].' '.$assure['PRENOM'];
	  $capital_assure=$info_assurance['CAPITAL_ASSURE'];

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

      $pdf->SetX(50);
      $pdf->Cell(90,5,utf8_decode($codeassu),0,1,'L');
      $pdf->SetX(50);
      $pdf->Cell(40,0,'',1,1,'L');
      $pdf->SetX(50);
      $pdf->Cell(90,5,utf8_decode($titreassurance),0,1,'L');
      $pdf->SetX(50);
      $pdf->Cell(90,5,utf8_decode('CONDITIONS PARTICULIERES'),0,1,'L');

      if ($info_assurance['STATUT']==0) {
      $pdf->SetFont('Arial','B',50);
      $pdf->SetTextColor(255,192,203);
      $pdf->Cell(40,5,'Annulé Annulé Annulé',0,0,'L');
      }
      if ($info_assurance['PROJET']==0) {
      $pdf->SetFont('Arial','B',50);
      $pdf->SetTextColor(255,192,203);
      $pdf->Cell(40,5,'Proposition Proposition Proposition',0,0,'L');
      }
      
      $pdf->SetTextColor(0,0,0);

      $pdf->Ln(3);
      $pdf->SetFont('Arial','',10);

      $pdf->Rect(10,60,190,170);
      $pdf->Rect(90,60,55,50);
      $pdf->Rect(145,60,55,50);

      $pdf->MultiCell(80,5,'Preneur d\'assurance (Nom ou raison sociales) ',0,'J',0);
      
      $pdf->Cell(90,5,utf8_decode('Banque/EMF : '.strtoupper($nom_complet_banque_miniscule)),0,1,'L');
      $pdf->Cell(90,5,utf8_decode('P/C de : '.strtoupper($nom_souscripteur)),0,1,'L');
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
      $pdf->Cell(80,10,utf8_decode('Capital assure (en BIF) :'.strtoupper(number_format($capital_assure, 1, ',',' '))),1,0,'L');
      $pdf->Cell(55,10,utf8_decode('Prime totale (BIF) :'.strtoupper(number_format($prime, 1, ',',' '))),1,0,'L');
      $pdf->Cell(55,10,utf8_decode('Périodicité : Unique'),1,1,'L');
      $pdf->Ln(4);
      $pdf->Ln(8);
      $pdf->MultiCell(190,6,utf8_decode('Le present contrat a pour objet la couverture d\'assurance du montant de la ligne de credit ou du decouvert, ci-dessus indlque, en cas de Deces ou d\'lnvalidite totale et permanente suite a une maladie ou un accident.'),0,'J',0);

      $pdf->MultiCell(190,6,utf8_decode('Le contrat est souscrit pour une periode de '.$info_assurance['DURRETOT'].' mois fermes prenant effet a la date de sa signature et apres payement de la prime.'),0,'J',0);
      $pdf->SetFont('Arial','',8);
      $pdf->Ln(14);
      $pdf->MultiCell(190,6,utf8_decode('Les conditions generales, la proposition d\'assurance et les presentes conditions particulieres forment le contrat d\'assurance. Elles sont de rigueur, de stricte interpretation et ont ete ainsi convenues entre parties pour etre executees de bonne foi. '),1,'J',0);
      $pdf->Ln(14);
      $pdf->Cell(190,6,utf8_decode('Fait à Bujumbura, le '.date('d/m/Y')),0,1,'C');
      $pdf->Cell(63,5,utf8_decode('LE SOUSCRIPTEUR'),0,0,'L');
      $pdf->Cell(64,5,utf8_decode('LE CREANCIER'),0,0,'C');
      $pdf->Cell(63,5,utf8_decode('L\'ASSUREUR'),0,1,'R');
      $pdf->Cell(63,5,utf8_decode(strtoupper($nom_souscripteur)),0,0,'L');
      $pdf->Cell(64,5,utf8_decode(strtoupper($abbreviation_banque)),0,0,'C');
      $pdf->Cell(63,5,utf8_decode('SOCAR VIE'),0,1,'R');

     
// if ($info_assurance['TYPE_ASSURANCE_ID'] == 219) {    
//         $listeass=$this->Model->getList('assure_206',array('CODE_ASSURANCE'=>$id));
//         $numbreass=$this->Model->record_countsome('assure_206',array('CODE_ASSURANCE'=>$id));
//         $i =1;
//         $pdf->Ln(150);
//         $pdf->Ln(150);
//               $pdf->SetX(100);
//       $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
//       $pdf->SetX(101);
//       $pdf->Cell(50,0,'',0,0,'L');
//       $pdf->SetX(90);
//       $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
//       $pdf->SetX(100);
//       $pdf->Cell(100,5,utf8_decode('Liste des Membres (Au nombre de '.$numbreass.')'),0,1,'L');
//       $pdf->SetFont('Arial','B',10);

//         foreach ($listeass as $key) {

//         $pdf->SetX(20);
//       $pdf->SetFont('Arial','',10);
//       $pdf->Cell(70,5,utf8_decode(''.$i.'. '.$key['NOM_PRENOM'].' ('.$key['MATRICULE'].') - Capital: '.$key['CAPITAL_ASS'].' BIF -  Prime: '.$key['PRIME'].' BIF - Durée: '.$key['DUREE_ID'].' Mois. Signature _____________________'),0,0,'L');
//       $pdf->SetFont('Arial','',10);
//         $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
//         $pdf->SetFont('Arial','',10);
//         $pdf->Cell(120,5,utf8_decode(' '),0,1,'L');
//       $pdf->Line(70,5,120, 5);
//         $i++;
//         }
//       }
      if ($info_assurance['TYPE_ASSURANCE_ID'] == 219) {    
        

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
        $distinction=$this->Model->getListDistinct('assure_206',array('CODE_ASSURANCE'=>$id),'DUREE_ID');
        $sommecapiall=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$id),'CAPITAL_ASS');
        $sommepriall=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$id),'PRIME');
        foreach ($distinction as $value) {
          # code...
        
        $listeass=$this->Model->getList('assure_206',array('CODE_ASSURANCE'=>$id,'DUREE_ID'=>$value['DUREE_ID']));
        $numbreass=$this->Model->record_countsome('assure_206',array('CODE_ASSURANCE'=>$id,'DUREE_ID'=>$value['DUREE_ID']));
        $sommecapi=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$id,'DUREE_ID'=>$value['DUREE_ID']),'CAPITAL_ASS');
        $sommepri=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$id,'DUREE_ID'=>$value['DUREE_ID']),'PRIME');
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

      $pdf->Output(''.$abbreviation_banque.'_Assurance_'.$info_assurance['DURRETOT'].'_mois.pdf','I');

    }


    

    
}
