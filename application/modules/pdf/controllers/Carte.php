<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Carte extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

 

    
    public function index($id){


      if (empty($this->Model->getOne('membre_membre_qr',array('ID_MEMBRE'=>$id)))) {
      // echo "no qr code<br>";
      $this->get_qr_code($id);

      }




      include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';

      // $id=$id;
      $selected = $this->Model->getRequeteOne('SELECT membre_membre.NOM, membre_membre.PRENOM, membre_membre.URL_PHOTO, membre_membre.CODE_AFILIATION, membre_membre.IS_AFFILIE, membre_membre.CODE_PARENT, membre_groupe.NOM_GROUPE FROM membre_membre LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE membre_membre.ID_MEMBRE = '.$id.' '); 
      if ($selected['IS_AFFILIE'] == 0) {
        $CODE_AFFI = $selected['CODE_AFILIATION'];
        $NOM_AFFI = $selected['NOM'].' '.$selected['PRENOM'];
      }
      else{
        $selecteds = $this->Model->getRequeteOne('SELECT membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, membre_membre.CODE_AFILIATION FROM membre_membre WHERE membre_membre.ID_MEMBRE = '.$selected['CODE_PARENT'].' ');

        $listaff = $this->Model->getRequete('SELECT membre_membre.ID_MEMBRE, membre_membre.CODE_AFILIATION FROM membre_membre WHERE membre_membre.CODE_PARENT = '.$selecteds['ID_MEMBRE'].' AND IS_AFFILIE = 1 ORDER BY ID_MEMBRE ');
        $i = 1;
        foreach ($listaff as $value) {

          
          if ($value['ID_MEMBRE']==$id) {
            // echo "string ".$i ;
            $extention = $i;
            $this->Model->update('membre_membre',array('ID_MEMBRE'=>$id),array('CODE_AFILIATION' =>$selecteds['CODE_AFILIATION'].'-'.$extention));
          }
          $i++;
        }

        $CODE_AFFI = $selecteds['CODE_AFILIATION'].'-'.$extention;
        $NOM_AFFI = $selecteds['NOM'].' '.$selecteds['PRENOM'];
      }
      // exit();

      $cartes = $this->Model->getRequeteOne('SELECT membre_carte.DATE_FIN_VALIDITE, membre_carte.ID_CATEGORIE_ASSURANCE, syst_categorie_assurance.DESCRIPTION AS DESCRIPTION_CAT,membre_carte_membre.FIN_SUR_LA_CARTE FROM membre_carte_membre JOIN membre_carte ON membre_carte.ID_CARTE = membre_carte_membre.ID_CARTE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE membre_carte_membre.ID_MEMBRE = '.$id.' ');


      if (empty($cartes)) {
        // echo $selecteds['ID_MEMBRE'];

        $cartes = $this->Model->getRequeteOne('SELECT membre_carte.DATE_FIN_VALIDITE, membre_carte.ID_CATEGORIE_ASSURANCE, syst_categorie_assurance.DESCRIPTION AS DESCRIPTION_CAT,membre_carte_membre.FIN_SUR_LA_CARTE FROM membre_carte_membre JOIN membre_carte ON membre_carte.ID_CARTE = membre_carte_membre.ID_CARTE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE membre_carte_membre.ID_MEMBRE = '.$selecteds['ID_MEMBRE'].' ');
      }
     

      $pdf = new PDF_CONFIG('P','mm','A4');
      $pdf->addPage();
      // $pdf->SetX(1);
      $pdf->SetX(31);
      // $pdf->Cell(100.5,80,'',1,1,'C');
      $pdf->Cell(87.5,56,'',0,1,'C');
      $pdf->Image(''.base_url().'uploads/front_empy2.png',31,8.7,87.5);
      // $pdf->Image(''.base_url().'uploads/front_empy2.png',31,11.7,87.5);
      $pdf->SetY(50);
     

     $pdf->Cell(27.5);
$pdf->Cell(21.5,33.5,$pdf->Image(''.base_url().'uploads/image_membre/'.$selected['URL_PHOTO'],37.5,18.8,21.5,33.5),0,0,'C');
// ,$pdf->Image(''.base_url().'uploads/image_membre/'.$selected['URL_PHOTO'],10,10,0,90)
$pdf->SetY(24.5);
$pdf->Cell(50.6);
$pdf->AddFont('Myriadpro','','myriadpro.php');
$pdf->AddFont('MyriadproB','','myriadprob.php');
$pdf->SetFont('Myriadpro','',9);
$pdf->Cell(15,5,utf8_decode('Nom:'),0,0,'L');
$pdf->SetFont('MyriadproB','',9);
$pdf->Cell(40,5,utf8_decode($selected['NOM']),0,1,'L');

$pdf->SetY(29.5);
$pdf->Cell(50.6);
$pdf->SetFont('Myriadpro','',9);
$pdf->Cell(15,5,utf8_decode('Prénom:'),0,0,'L');
$pdf->SetFont('MyriadproB','',9);
$pdf->Cell(40,5,utf8_decode($selected['PRENOM']),0,1,'L');


$pdf->SetY(34.5);
$pdf->Cell(50.6);
$pdf->SetFont('Myriadpro','',9);
$pdf->Cell(15,5,utf8_decode('Matricule:'),0,0,'L');
$pdf->SetFont('MyriadproB','',9);
$pdf->Cell(40,5,utf8_decode($CODE_AFFI),0,1,'L');


$pdf->SetY(39);
$pdf->Cell(50.6);
$pdf->SetFont('Myriadpro','',9);
$pdf->Cell(15,5,utf8_decode('Société:'),0,0,'L');
$pdf->SetFont('MyriadproB','',9);
$pdf->Cell(40,5,utf8_decode($selected['NOM_GROUPE']),0,1,'L');


$pdf->SetY(43.5);
$pdf->Cell(50.6);
$pdf->SetFont('Myriadpro','',9);
$pdf->Cell(15,5,utf8_decode('Affilié:'),0,0,'L');
$pdf->SetFont('MyriadproB','',9);
$pdf->Cell(40,5,utf8_decode($NOM_AFFI),0,1,'L');



$pdf->SetY(48.5);
$pdf->Cell(50.6);
$pdf->SetTextColor(255,0,0);
$pdf->SetFont('Myriadpro','',9);
$pdf->Cell(15,5,utf8_decode('Validité:'),0,0,'L');
$pdf->SetFont('MyriadproB','',9);
// newDate;
      // print_r( $cartes['DATE_FIN_VALIDITE']);exit();

    $originalDate = $cartes['FIN_SUR_LA_CARTE'];
    $newDate = date("d-m-Y", strtotime($originalDate));
$pdf->Cell(40,5,utf8_decode($newDate),0,1,'L');
$pdf->SetTextColor(0,0,0);

  // $pdf->SetX(912);
      // $pdf = new PDF_CONFIG('P','mm','A4');
      $pdf->addPage();

      // $pdf->SetX(31);
      // // $pdf->SetY(87.5);
      $pdf->SetX(31);
      // $pdf->SetY(87.5);
      $pdf->Cell(87.5,56,'',0,1,'C');
      $pdf->Image(''.base_url().'uploads/back_empy.png',31,8.7,87.5);
      $pdf->SetY(35);
      $pdf->Cell(25);
      $pdf->SetFont('Myriadpro','',9);


    $soin1 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$cartes['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 1");
    $soin2 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$cartes['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 2");
    $soin3 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$cartes['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 3 ");
    $med1 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT, syst_categorie_assurance_medicament.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_medicament ON syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$cartes['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT = 1");
    $med2 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT, syst_categorie_assurance_medicament.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_medicament ON syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$cartes['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT = 2");

      $pdf->Cell(10,5.5,utf8_decode($soin1['POURCENTAGE'].'%'),0,0,'C');
      $pdf->Cell(9,5.5,utf8_decode($soin2['POURCENTAGE'].'%'),0,0,'C');
      $pdf->Cell(9,5.5,utf8_decode($soin3['POURCENTAGE'].'%'),0,0,'C');
      $pdf->Cell(13,5.5,utf8_decode($med1['POURCENTAGE'].'%'),0,0,'C');
      $pdf->Cell(12,5.5,utf8_decode($med2['POURCENTAGE'].'%'),0,1,'C');
      $pdf->Cell(50);
      $pdf->SetTextColor(255,0,0);
      $pdf->SetFont('MyriadproB','',12);
      $pdf->Cell(12,6.5,utf8_decode($cartes['DESCRIPTION_CAT']),0,1,'C');
      $pdf->SetTextColor(255,0,0);
      $pdf->SetY(18);
      $pdf->Cell(81);

      $qrcodes = $this->Model->getRequeteOne("SELECT membre_membre_qr.PATH_QR_CODE FROM membre_membre_qr  WHERE ID_MEMBRE = ".$id." ");

      $pdf->Cell(25,25,$pdf->Image(''.base_url().'uploads/QRCODE/'.$qrcodes['PATH_QR_CODE'],91,18,25,25),0,0,'C');
      // $pdf->Ln(20);
      // $pdf->SetFont('Arial','B',10);

      // $pdf->SetX(90);
      // $pdf->Cell(90,5,utf8_decode(strtoupper('Mis Sante')),1,1,'L');
      // $pdf->SetX(91);
      // $pdf->Cell(40,0,'',1,1,'L');
      // $pdf->SetX(90);
      // $pdf->Cell(90,5,utf8_decode(strtoupper('Mis Sante')),1,1,'L');
      // $pdf->SetX(90);
      // $pdf->Cell(90,5,utf8_decode('CONDITIONS PARTICULIERES'),0,1,'L');
      // $pdf->Line(84,48,128,48);
      // if ($info_assurance['STATUT']==0) {
      // $pdf->SetFont('Arial','B',50);
      // $pdf->SetTextColor(255,192,203);
      // $pdf->Cell(100,5,'Annulé Annulé Annulé',0,0,'L');
      // }

      // if ($info_assurance['PROJET']==0) {
      // $pdf->SetFont('Arial','B',50);
      // $pdf->SetTextColor(255,192,203);
      // $pdf->Cell(40,5,'Proposition Proposition Proposition',0,0,'L');
      // }
      
      // $pdf->SetTextColor(0,0,0);

      // $pdf->Ln(3);
      // $pdf->SetFont('Arial','',10);

      // $pdf->Rect(10,60,190,170);
      // // $pdf->Rect(10,60,80,50);
      // $pdf->Rect(90,60,55,50);
      // $pdf->Rect(145,60,55,50);
      // // $pdf->Rect(10,110,190,10);
      // // $pdf->Rect(10,193,190,17);
      // // $pdf->Rect(10,210,190,20);

      // $pdf->MultiCell(80,5,'Preneur d\'assurance (Nom ou raison sociales) '.strtoupper('Mis Sante'),0,'J',0);
      // $pdf->Cell(90,5,utf8_decode('P/C de : '.strtoupper('Mis Sante')),0,1,'L');
      // // $pdf->SetFont('Arial','B',10);
      // $pdf->Cell(90,5,utf8_decode('Date de naissance : '.strtoupper('Mis Sante').''),0,1,'L');
      // $pdf->Cell(90,5,utf8_decode('Adresse : '.strtoupper('Mis Sante')),0,1,'L');
      // $pdf->Cell(90,5,utf8_decode('Localité : '.strtoupper('Mis Sante')),0,1,'L');
      // $pdf->Cell(90,5,utf8_decode('Tél : '.strtoupper('Mis Sante')),0,1,'L');
      // $pdf->SetXY(90,60);
      // $pdf->SetFont('Arial','B',10);
      // $pdf->Cell(55,8,utf8_decode('PRISE D\'EFFET'),1,0,'C');
      // $pdf->Cell(55,8,utf8_decode('ECHEANCE'),1,1,'C');
      // $pdf->SetX(90);
      // $pdf->SetFont('Arial','',10);
      // $pdf->Cell(55,10,utf8_decode(strtoupper('Mis Sante')),1,0,'C');
      // $pdf->Cell(55,10,utf8_decode(strtoupper('Mis Sante')),1,1,'C');
      // $pdf->SetX(90);
      // $pdf->SetFont('Arial','B',10);
      // $pdf->Cell(55,10,utf8_decode('Mode de paiement'),1,0,'C');
      // $pdf->Cell(55,10,utf8_decode('Objet'),1,1,'C');
      // $pdf->SetX(90);
      // $pdf->SetFont('Arial','',8);
      // $pdf->MultiCell(40,4,utf8_decode(strtoupper('Mis Sante')),0,'C',0);
      
      // $pdf->Ln(-4);
      // $pdf->SetX(145);
      // $pdf->MultiCell(40,4,utf8_decode(strtoupper('Mis Sante')),0,'C',0);
      // $pdf->SetX(10);
      // $pdf->Ln(14);
      // // $pdf->Cell(135,10,utf8_decode('Prime totale (BIF) :')),1,0,'L');
      // $pdf->Cell(55,10,utf8_decode('Périodicité : Unique'),1,1,'L');
      // $pdf->Ln(4);
      // $pdf->SetFont('Arial','',10);
      // $pdf->MultiCell(190,6,utf8_decode('Le présent contrat a pour objet la couverture d\'un prêt et garantit au preneur d\'assurance le paiement du solde restant dû en capital du prêt qui a été consenti par la '.strtoupper('Mis Sante').' à '.strtoupper('Mis Sante').' dans les limites de la somme assurée, suivant les conditions ci-après :'),0,'J',0);
      // $pdf->SetX(20);
      // $pdf->SetFont('Arial','B',10);
      // $pdf->Cell(25,5,utf8_decode('1. ASSURE : '),0,0,'L');
      // $pdf->SetFont('Arial','',10);
      // // $pdf->Cell(120,5,utf8_decode(strtoupper($assure)),0,1,'L');
      // // if ($info_assurance['TYPE_ASSURANCE_ID'] == 206) {
      // //   // $pdf->Cell(120,5,utf8_decode(strtoupper('Membre groupe ( '.$assure.' )')),0,1,'L');
      // //   $pdf->Cell(120,5,utf8_decode(strtoupper('Liste en annexe')),0,1,'L');
      // // }
      // // else{
      // //   $pdf->Cell(120,5,utf8_decode(strtoupper($assure)),0,1,'L');
      // // }
      // $pdf->SetFont('Arial','B',10);
      // $pdf->SetX(20);
      // $pdf->Cell(40,5,utf8_decode('2. CAPITAL ASSURE :'),0,0,'L');
      // $pdf->SetFont('Arial','',10);
      // // $pdf->Cell(120,5,utf8_decode('...........'),1,1,'L');
      // $pdf->MultiCell(120,5,utf8_decode('Solde restant dû sur le capital de BIF à l\'exclusion de tout arriéré éventuel'),0,'J',0);
      // $pdf->SetX(20);
      // $pdf->SetFont('Arial','B',10);
      // $pdf->Cell(55,5,utf8_decode('2. GARANTIES ACCORDEES:'),0,1,'L');
      // $pdf->SetX(30);
      // $pdf->SetFont('Arial','',10);
      // $pdf->Cell(55,5,utf8_decode('A. Décès'),0,1,'L');
      // $pdf->SetX(30);
      // $pdf->Cell(55,5,utf8_decode('B. Incapacité permanente totale'),0,1,'L');
      // $pdf->Ln(8);
      // $pdf->MultiCell(190,6,utf8_decode('Le contrat est souscrit pour une période de 6 mois fermes prenant effet à la date de sa signature et après payement de la prime.'),0,'J',0);

      // $pdf->MultiCell(190,6,utf8_decode('Les conditions générales, la proposition d\'assurance et les présentes conditions particulières forment le contrat d\'assurance. Elles sont de rigueur, de stricte interpretation et ont été ainsi convenues entre parties pour être éxécutées de bonne foi..'),0,'J',0);
      // $pdf->SetFont('Arial','B',10);
      // $pdf->Cell(190,5,utf8_decode('Fait à Bujumbura, le '.date('d/m/Y')),0,1,'C');
      // $pdf->Cell(63,5,utf8_decode('LE SOUSCRIPTEUR'),0,0,'L');
      // $pdf->Cell(64,5,utf8_decode('LE CREANCIER'),0,0,'C');
      // $pdf->Cell(63,5,utf8_decode('L\'ASSUREUR'),0,1,'R');
      // $pdf->Cell(63,5,utf8_decode(strtoupper('Mis Sante')),0,0,'L');
      // $pdf->Cell(64,5,utf8_decode(strtoupper('Mis Sante')),0,0,'C');
      // $pdf->Cell(63,5,utf8_decode('SOCAR VIE'),0,1,'R');

        
      //  if ($info_assurance['TYPE_ASSURANCE_ID'] == 206) {    
      //   $listeass=$this->Model->getList('assure_206',array('CODE_ASSURANCE'=>$id));
      //   $numbreass=$this->Model->record_countsome('assure_206',array('CODE_ASSURANCE'=>$id));
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
      

      // $pdf->Output('Assurance.pdf','I');
      $pdf->Output('Carte_mois.pdf','I');

      // pdf/Pdf/type_assurance/21

    }


//     public function assurance_protection_avec_perte($id){

//       include 'pdfinclude/fpdf/mc_table.php';
//       include 'pdfinclude/fpdf/pdf_config.php';

//       $id=$id;
//       $info_assurance=$this->Model->getOne('assurance',array('ASSURANCE_ID'=>$id));
//       $date_prise_effet=new DateTime($info_assurance['PRISE_EFFET']);
//       $date_echeance=new DateTime($info_assurance['ECHEANCE']);

//       $info_souscripteur=$this->Model->getOne('souscripteur',array('SOUSCRIPTEUR_ID'=>$info_assurance['SOUSCRIPTEUR_ID']));
     
//       if($info_souscripteur['TYPE_SOUSCRIPTEUR_ID']==1){
//       	$nom_souscr=$info_souscripteur['NOM'];
//       	$date_naiss='-';
//       	$adresse=$info_souscripteur['ADRESSE'];
//       	$localite=$info_souscripteur['VILLE'];
//       	$tel=$info_souscripteur['TELEPHONE'];

//       }else{
//       	$nom_souscr=$info_souscripteur['NOM'].' '.$info_souscripteur['PRENOM'];
//       	$date_naiss=date("d/m/Y", strtotime($info_souscripteur['DATE_NAISSANCE']));
//       	$adresse=$info_souscripteur['ADRESSE'];
//       	$localite=$info_souscripteur['VILLE'];
//       	$tel=$info_souscripteur['TELEPHONE'];
//       }

//       $mode_paiement=$this->Model->getOne('mode_paiement',array('MODE_PAIEMENT_ID'=>$info_assurance['MODE_PAIEMENT']));
//       $asurance_type=$this->Model->getOne('asurance_type',array('ASSURANCE_TYPE_ID'=>$info_assurance['TYPE_ASSURANCE_ID']));
//       $objet=$this->Model->getOne('objet',array('OBJET_ID'=>$info_assurance['OBJET']));
//       // $assure=$this->Model->getOne('assure',array('ASSURE_ID'=>$info_assurance['BENEFICIAIRE_ID']));
//       if ($info_assurance['TYPE_ASSURANCE_ID'] == 206) {
//         $assure=$this->Model->getOne('souscripteur',array('SOUSCRIPTEUR_ID'=>$info_assurance['SOUSCRIPTEUR_ID']));
//       }
//       else{
//         $assure=$this->Model->getOne('assure',array('ASSURE_ID'=>$info_assurance['BENEFICIAIRE_ID']));
//       }

//       $periodicite=$this->Model->getOne('periodicite',array('PERIODICITE_ID'=>$info_assurance['PERIODICITE_ID']));

      
//       $user=$this->session->userdata('SOCAR_UTILISATEUR_EMAIL');
//       $code_soc=$this->Model->getOne('admin_utilisateurs',array('UTILISATEUR_EMAIL'=>$user));
//       // $info_banque=$this->Model->getOne('creancier',array('CODE_SOCIETE'=>$code_soc['CODE_SOCIETE']));
//       $info_banque=$this->Model->getOne('creancier',array('CODE_SOCIETE'=>$info_assurance['CODE_SOCIETE']));
//       if ($info_assurance['PROJET']==0) {
//         $projet ='(PREVISUALISATION CONTRAT) ';
//       }
//       else{
//         $projet ='';
//       }
//       $codeassu = $projet.'POLICE N° : '. $info_banque['POLICE_NUMERO'].' - '. $info_assurance['CODE_ASSURANCE'].'';

//             $urlpass = base_url();
//         $elementspas = explode("/", $urlpass);
//        $nouveau_urlpass = null ;
//         $indicepass = sizeof($elementspas);
//         for ($i = 0; $i < ($indicepass - 2); $i++) {
//             $nouveau_urlpass .=$elementspas[$i] . '/';
//         }

//       $logo_banque='uploads/logo_societe/'.$info_banque['LOGO'].'';
//       $abbreviation_banque=$info_banque['SIGLE_BANQUE'];
//       $nom_banque_1=$info_banque['DESCRIPTION'];
//       $nom_banque_2='';
//       $titreassurance=strtoupper($asurance_type['DESCRIPTION']).' AVEC PERTE D\'EMPLOI';
//       $nom_complet_banque_miniscule=ucfirst(strtolower($nom_banque_1)).' ('.$abbreviation_banque.') ';
// // 'ASSURANCE PROTECTION CREDIT 
//       $nom_souscripteur=$nom_souscr;
//       $date_naissance=$date_naiss;
//       $adresse=$adresse;
//       $localite=$localite;
//       $tel=$tel;

//       $prise_effet=$date_prise_effet->format('d/m/Y');
//       $echeance=$date_echeance->format('d/m/Y');

//       $mode_paiement=$mode_paiement['DESCRIPTION'];
//       $Objet=$objet['DESCRIPTION'];

//       $prime=$info_assurance['PRIME_TOTAL'];
//       $periodicite=$periodicite['DESCRIPTION'];

//       $assure=$assure['NOM'].' '.$assure['PRENOM'];
//       // $assure = 'Kimana';
// 	  $capital_assure=$info_assurance['CAPITAL_ASSURE'];

// 	  $nbre_mois=explode(" ", $periodicite);
     

//       $pdf = new PDF_CONFIG('P','mm','A4');
//       $pdf->addPage();
//       $pdf->Image(''.$logo_banque.'',145,5,30,10);
//       $pdf->Ln(-5);

//       $pdf->SetX(120);
//       $pdf->Cell(80,5,$nom_banque_1,0,1,'C');
//       $pdf->SetX(120);
//       $pdf->Cell(80,5,$nom_banque_2,0,0,'C');
//       $pdf->Ln(20);
//       $pdf->SetFont('Arial','B',10);

//       $pdf->SetX(90);
//       $pdf->Cell(90,5,utf8_decode($codeassu),0,1,'L');
//       $pdf->SetX(91);
//       $pdf->Cell(40,0,'',1,1,'L');
//       $pdf->SetX(90);
//       $pdf->Cell(90,5,utf8_decode($titreassurance),0,1,'L');
//       $pdf->SetX(90);
//       $pdf->Cell(90,5,utf8_decode('CONDITIONS PARTICULIERES'),0,1,'L');
//       // $pdf->Line(84,48,128,48);

//       if ($info_assurance['STATUT']==0) {
//       $pdf->SetFont('Arial','B',50);
//       $pdf->SetTextColor(255,192,203);
//       $pdf->Cell(100,5,utf8_decode('Annulé Annulé Annulé'),0,0,'L');
//       }

//       if ($info_assurance['PROJET']==0) {
//       $pdf->SetFont('Arial','B',50);
//       $pdf->SetTextColor(255,192,203);
//       $pdf->Cell(40,5,'Proposition Proposition Proposition',0,0,'L');
//       }
      
//       $pdf->SetTextColor(0,0,0);


//       $pdf->Ln(3);
//       $pdf->SetFont('Arial','',9);

//       $pdf->Rect(10,60,190,215);
//       // $pdf->Rect(10,60,80,50);
//       $pdf->Rect(90,60,55,50);
//       $pdf->Rect(145,60,55,50);
//       // $pdf->Rect(10,110,190,10);
//       // $pdf->Rect(10,193,190,17);
//       // $pdf->Rect(10,210,190,20);

//       $pdf->MultiCell(80,5,'Preneur d\'assurance (Nom ou raison sociales) '.strtoupper($nom_complet_banque_miniscule).' P/C DE '.strtoupper($nom_souscripteur),0,'J',0);
//       $pdf->Cell(90,5,utf8_decode('Date de naissance : '.strtoupper($date_naissance)),0,1,'L');
//       $pdf->Cell(90,5,utf8_decode('Adresse : '.strtoupper($adresse)),0,1,'L');
//       $pdf->Cell(90,5,utf8_decode('Localité : '.strtoupper($localite)),0,1,'L');
//       $pdf->Cell(90,5,utf8_decode('Tél : '.strtoupper($tel)),0,1,'L');
//       $pdf->SetXY(90,60);
//       $pdf->SetFont('Arial','B',9);
//       $pdf->Cell(55,8,utf8_decode('PRISE D\'EFFET'),1,0,'C');
//       $pdf->Cell(55,8,utf8_decode('ECHEANCE'),1,1,'C');
//       $pdf->SetX(90);
//       $pdf->SetFont('Arial','',9);
//       $pdf->Cell(55,10,utf8_decode(strtoupper($prise_effet)),1,0,'C');
//       $pdf->Cell(55,10,utf8_decode(strtoupper($echeance)),1,1,'C');
//       $pdf->SetX(90);
//       $pdf->SetFont('Arial','B',9);
//       $pdf->Cell(55,10,utf8_decode('Mode de paiement'),1,0,'C');
//       $pdf->Cell(55,10,utf8_decode('Objet'),1,1,'C');
//       $pdf->SetX(90);
//       $pdf->SetFont('Arial','',8);
//       $pdf->MultiCell(40,4,utf8_decode(strtoupper($mode_paiement)),0,'C',0);
      
//       $pdf->Ln(-4);
//       $pdf->SetX(145);
//       $pdf->MultiCell(40,4,utf8_decode(strtoupper($Objet)),0,'C',0);
//       $pdf->SetX(10);
//       $pdf->Ln(14);
//       $pdf->Cell(135,7,utf8_decode('Prime totale (BIF) :'.strtoupper(number_format($prime, 1, ',',' '))),1,0,'L');
//       $pdf->Cell(55,7,utf8_decode('Périodicité : Unique'),1,1,'L');
//       $pdf->Ln(2);
//       $pdf->SetFont('Arial','',8);
//       $pdf->MultiCell(190,4,utf8_decode('Le présent contrat a pour objet la couverture d\'un prêt et garantit au preneur d\'assurance le paiement du solde restant dû en capital du prêt qui a été consenti par la '.strtoupper($nom_complet_banque_miniscule).' à '.strtoupper($nom_souscripteur).' dans les limites de la somme assurée, suivant les conditions ci-après :'),0,'J',0);
//       $pdf->SetX(20);
//       $pdf->SetFont('Arial','B',8);
//       $pdf->Cell(25,4,utf8_decode('1. ASSURE : '),0,0,'L');
//       $pdf->SetFont('Arial','',8);
//       // $pdf->Cell(120,5,utf8_decode(strtoupper($assure)),0,1,'L');
//       if ($info_assurance['TYPE_ASSURANCE_ID'] == 206) {
//         // $pdf->Cell(120,5,utf8_decode(strtoupper('Membre groupe ( '.$assure.' )')),0,1,'L');
//         $pdf->Cell(120,5,utf8_decode(strtoupper('Liste en annexe')),0,1,'L');
//       }
//       else{
//         $pdf->Cell(120,5,utf8_decode(strtoupper($assure)),0,1,'L');
//       }
//       $pdf->SetFont('Arial','B',8);
//       $pdf->SetX(20);
//       $pdf->Cell(40,4,utf8_decode('2. CAPITAL ASSURE :'),0,0,'L');
//       $pdf->SetFont('Arial','',8);
//       // $pdf->Cell(120,5,utf8_decode('...........'),1,1,'L');
//       $pdf->MultiCell(120,5,utf8_decode('Solde restant dû sur le capital de '.number_format($capital_assure, 1, ',',' ').'BIF à l\'exclusion de tout arriéré éventuel'),0,'J',0);
//       $pdf->SetX(20);
//       $pdf->SetFont('Arial','B',8);
//       $pdf->Cell(55,5,utf8_decode('3. GARANTIES ACCORDEES:'),0,1,'L');
//       $pdf->SetX(30);
//       $pdf->SetFont('Arial','',8);
//       $pdf->Cell(55,5,utf8_decode('a) Décès'),0,1,'L');
//       $pdf->SetX(30);
//       $pdf->Cell(55,5,utf8_decode('b) Incapacité permanente totale'),0,1,'L');
//       $pdf->SetX(30);
//       $pdf->Cell(55,5,utf8_decode('c) Perte d\'emploi avec un maximum de dix millions de francs burundais'),0,1,'L');
//       $pdf->SetX(34);
//       $pdf->Cell(55,5,utf8_decode('Hormis les exclusions prévues par les conditions générales en annexe et particulièrement celles reprises ci-après'),0,1,'L');

//       // $pdf->Ln(4);
//       $pdf->SetX(15);
//       $pdf->SetFont('Arial','B',8);
//       $pdf->Cell(55,4,utf8_decode('Sont exclus de la garantie "PERTE D\'EMPLOI" '),0,1,'L');
//       $pdf->SetFont('Arial','',8);
//       $pdf->Cell(55,4,utf8_decode('- La démission, le départ volontaire de l\'assuré et la mise en disponibilité à sa demande '),0,1,'L');
//       $pdf->Cell(55,4,utf8_decode('- La mise en chômage technique '),0,1,'L');
//       $pdf->Cell(55,4,utf8_decode("- L'arrivée à terme d'un contrat à durée déterminée "),0,1,'L');
//       $pdf->Cell(55,4,utf8_decode("- La désertion de service "),0,1,'L');
//       $pdf->Cell(55,4,utf8_decode("- La mise en retraite et en général la simple suspension du contrat de travail "),0,1,'L');
//       $pdf->Cell(55,4,utf8_decode("- Le licenciement pour les raisons économiques et réorganisation au sein de l'institution qui emploie l'assuré "),0,1,'L');
//       $pdf->Cell(55,4,utf8_decode("- La fin (à l'echeancez ou precipitée) d'un mandat politique ou autre "),0,1,'L');
//       $pdf->SetFont('Arial','B',8);
//       $pdf->Cell(55,4,utf8_decode("N.B:"),0,1,'L');
//       $pdf->SetFont('Arial','',8);
//       $pdf->Cell(55,3,utf8_decode("- Le changement d'employeur n'est pas assimilé à une perte d'emploi"),0,1,'L');
//       $pdf->MultiCell(190,5,utf8_decode("- L'emploi dont il est question est celui occupé par une personne qui a été déclarée par Employeur au régime obligatoire de sécurité sociale. "),0,'J',0);

//       $pdf->MultiCell(190,5,utf8_decode("- L'assuré déclare et accepte de rester lié à ses engagements envers l'assureur pour le remboursement intégral du crédit par retenue d'office sur son salaire auprès du présent et/ou futur employeur ou par tout autre moyen "),0,'J',0);

//       $pdf->MultiCell(190,5,utf8_decode("- L'asssureur ne s'engage à rembourser le solde restant dû que si le dossier ,médical et administratif de l'assuré est déclaré satisfaisant au moment de la souscription du contrat d'assurance. "),0,'J',0);

//       $pdf->MultiCell(190,5,utf8_decode("- Conformement aux conditions générales de la police d'assurance Protection Crédit, l'Assureur est subrogé dans les droits de l'organisme prếteur à l'égard de l'employeur et de l'emprunteur. "),0,'J',0);

//       $pdf->Ln(3);
//       $pdf->MultiCell(190,5,utf8_decode('Le contrat est souscrit pour une période de '.$info_assurance['DURRETOT'].' mois fermes prenant effet à la date de sa signature et après payement de la prime à l\'exception de la garantie de perte d\'emploi qui commence trois mois après la signature du contrat'),0,'J',0);
//       $pdf->Ln(1);
//       $pdf->MultiCell(190,4,utf8_decode('Les conditions générales, la proposition d\'assurance et les présentes conditions particulières forment le contrat d\'assurance. Elles sont de rigueur, de stricte interpretation et ont été ainsi convenues entre parties pour être éxécutées de bonne foi..'),1,'J',0);

//       $pdf->SetFont('Arial','B',8);
//       $pdf->Cell(190,5,utf8_decode('Fait à Bujumbura, le '.date('d/m/Y')),0,1,'C');
//       $pdf->Cell(63,5,utf8_decode('LE SOUSCRIPTEUR'),0,0,'L');
//       $pdf->Cell(64,5,utf8_decode('LE CREANCIER'),0,0,'C');
//       $pdf->Cell(63,5,utf8_decode('L\'ASSUREUR'),0,1,'R');
//       $pdf->Cell(63,5,utf8_decode(strtoupper($nom_souscripteur)),0,0,'L');
//       $pdf->Cell(64,5,utf8_decode(strtoupper($abbreviation_banque)),0,0,'C');
//       $pdf->Cell(63,5,utf8_decode('SOCAR VIE'),0,1,'R');

//      // if ($info_assurance['TYPE_ASSURANCE_ID'] == 206) {    
//      //    $listeass=$this->Model->getList('assure_206',array('CODE_ASSURANCE'=>$id));
//      //    $numbreass=$this->Model->record_countsome('assure_206',array('CODE_ASSURANCE'=>$id));
//      //    $i =1;
//      //    $pdf->Ln(150);
//      //    $pdf->Ln(150);
//      //          $pdf->SetX(100);
//      //  $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
//      //  $pdf->SetX(101);
//      //  $pdf->Cell(50,0,'',0,0,'L');
//      //  $pdf->SetX(90);
//      //  $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
//      //  $pdf->SetX(100);
//      //  $pdf->Cell(100,5,utf8_decode('Liste des Membres (Au nombre de '.$numbreass.')'),0,1,'L');
//      //  $pdf->SetFont('Arial','B',10);

//      //    foreach ($listeass as $key) {

//      //    $pdf->SetX(20);
//      //  $pdf->SetFont('Arial','',10);
//      //  $pdf->Cell(70,5,utf8_decode(''.$i.'. '.$key['NOM_PRENOM'].' ('.$key['MATRICULE'].') - Capital: '.$key['CAPITAL_ASS'].' BIF - Prime: '.$key['PRIME'].' BIF - Durée: '.$key['DUREE_ID'].' Mois. Signature _____________________'),0,0,'L');
//      //  $pdf->SetFont('Arial','',10);
//      //    $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
//      //    $pdf->SetFont('Arial','',10);
//      //    $pdf->Cell(120,5,utf8_decode(' '),0,1,'L');
//      //  $pdf->Line(70,5,120, 5);
//      //    $i++;
//      //    }
//      //  }

      

//       if ($info_assurance['TYPE_ASSURANCE_ID'] == 206) {  
      

//         $pdf->Ln(150);
//         $pdf->Ln(150);
//               $pdf->SetX(100);
//               $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
//       $pdf->SetX(101);
//       $pdf->Cell(50,0,'',0,0,'L');
//       $pdf->SetX(90);
//       $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
//       $pdf->SetX(50);
//       $pdf->SetFont('Arial','B',10);
//       $pdf->Cell(50,5,utf8_decode('Liste des Membres du groupe'),0,1,'L');
//       $pdf->SetX(51);
//       $pdf->Cell(51,0,'',1,1,'L');
//       $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
//         $distinction=$this->Model->getListDistinct('assure_206',array('CODE_ASSURANCE'=>$id),'DUREE_ID');
//         $sommecapiall=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$id),'CAPITAL_ASS');
//         $sommepriall=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$id),'PRIME');
//         foreach ($distinction as $value) {
//           # code...
        
//         $listeass=$this->Model->getList('assure_206',array('CODE_ASSURANCE'=>$id,'DUREE_ID'=>$value['DUREE_ID']));
//         $numbreass=$this->Model->record_countsome('assure_206',array('CODE_ASSURANCE'=>$id,'DUREE_ID'=>$value['DUREE_ID']));
//         $sommecapi=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$id,'DUREE_ID'=>$value['DUREE_ID']),'CAPITAL_ASS');
//         $sommepri=$this->Model->getSommes('assure_206',array('CODE_ASSURANCE'=>$id,'DUREE_ID'=>$value['DUREE_ID']),'PRIME');
//         $i =1;
        
      

// // $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
// //       $pdf->SetX(101);
// //       $pdf->Cell(50,0,'',0,0,'L');
//       $pdf->SetX(90);
//       $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
//       // $pdf->SetX(50);


// $pdf->SetFont('Arial','B',10);

// $pdf->Cell(7,5,'',0,0,'C');
// $pdf->Cell(70,5,'Nom (Matricule)',1,0,'C');
// $pdf->Cell(30,5,'Capital',1,0,'C');
// $pdf->Cell(30,5,'Prime',1,0,'C');
// $pdf->Cell(13,5,utf8_decode('Durée'),1,0,'C');
// $pdf->Cell(40,5,'Signature',1,1,'C');


//         foreach ($listeass as $key) {
//       $pdf->SetFont('Arial','',8);
//       $pdf->Cell(7,5,$i,1,0,'C');
//         $pdf->Cell(70,5,utf8_decode(''.$key['NOM_PRENOM'].' ('.$key['MATRICULE'].')'),1,0,'L');
// $pdf->Cell(30,5,number_format($key['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
// $pdf->Cell(30,5,number_format($key['PRIME'], 1, ',',' ').' BIF',1,0,'R');
// $pdf->Cell(13,5,$key['DUREE_ID'],1,0,'R');
// $pdf->Cell(40,5,'',1,1,'L');

//         $i++;
        
//         }
//         $pdf->SetFont('Arial','B',8);
//         $pdf->Cell(7,5,'',0,0,'C');
//         $pdf->Cell(70,5,'',0,0,'C');
//         $pdf->Cell(30,5,number_format($sommecapi['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
//         $pdf->Cell(30,5,number_format($sommepri['PRIME'], 1, ',',' ').' BIF',1,0,'R');
//         $pdf->Cell(13,5,'',0,0,'C');
//         $pdf->Cell(40,5,'',0,1,'C');
        
//       }

// $pdf->Cell(100,5,utf8_decode(''),0,1,'L');
//       $pdf->SetX(101);
//       $pdf->Cell(50,0,'',0,0,'L');
//       $pdf->SetX(90);
//       $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');
//       $pdf->SetX(50);
//       $pdf->SetFont('Arial','B',10);
//       $pdf->Cell(50,5,utf8_decode('Totale général'),0,1,'C');
//       $pdf->Cell(90,5,utf8_decode(' '),0,1,'L');

//       $pdf->SetFont('Arial','B',10);
// $pdf->Cell(7,5,'',0,0,'C');
// $pdf->Cell(70,5,'',0,0,'C');
// $pdf->Cell(30,5,'Capital',1,0,'C');
// $pdf->Cell(30,5,'Prime',1,0,'C');
// $pdf->Cell(13,5,'',0,0,'C');
// $pdf->Cell(40,5,'',0,1,'C');

//       $pdf->SetFont('Arial','B',8);
//         $pdf->Cell(7,5,'',0,0,'C');
//         $pdf->Cell(70,5,'',0,0,'C');
//         $pdf->Cell(30,5,number_format($sommecapiall['CAPITAL_ASS'], 1, ',',' ').' BIF',1,0,'R');
//         $pdf->Cell(30,5,number_format($sommepriall['PRIME'], 1, ',',' ').' BIF',1,0,'R');
//         $pdf->Cell(13,5,'',0,0,'C');
//         $pdf->Cell(40,5,'',0,1,'C');
//       }


//       // $pdf->Output('Assurance.pdf','I');
//       $pdf->Output(''.$abbreviation_banque.'_Assurance_'.$info_assurance['DURRETOT'].'_mois.pdf','I');

//     }
  function get_qr_code($id)
    {
    
     $info=$this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
     $name=date('Ymdhis').$id;
     $lien=base_url('membre/Membres/details_one/'.$id);
     $this->notifications->generateQrcode($lien,$name);
     $this->Model->insert_last_id('membre_membre_qr',array('ID_MEMBRE'=>$id,'PATH_QR_CODE'=>$name.'.png'));

     

  }
  
    function test_qr_code()
    {
    
     $id = 102;
    
    //  $info=$this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
     $name='test'.date('Ymdhis').$id;
     $lien=base_url('membre/Membres/details_one/'.$id);
     $this->notifications->generateQrcode(11,12);
    //  $this->Model->insert_last_id('membre_membre_qr',array('ID_MEMBRE'=>$id,'PATH_QR_CODE'=>$name.'.png'));

     echo $name;

  }
  
  function test_qr_codes()
    {
    
     phpinfo();

  }

    
}
