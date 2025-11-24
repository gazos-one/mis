<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Facture_pdf_cotisation_mensuellle extends CI_Controller {

  function __construct() {
    parent::__construct();
    include APPPATH.'third_party/fpdf/fpdf.php'; 

}



public function charge_pdf($id){


    $donne=$this->Model->getRequeteOne("SELECT cotisation_cotisation_new.ID_COTISATION,cotisation_cotisation_new.PRIX_UNITAIRE,cotisation_cotisation_new.`MOIS_COTISATION`,cotisation_cotisation_new.`ID_GROUPE`,membre_groupe.RESIDENCE,membre_groupe.NIF,cotisation_cotisation_new.`ID_CATEGORIE_ASSURANCE`,membre_groupe.NOM_GROUPE,syst_categorie_assurance.DESCRIPTION,cotisation_cotisation_new.MONTANT_COTISATION FROM `cotisation_cotisation_new` join membre_groupe on cotisation_cotisation_new.ID_GROUPE=membre_groupe.ID_GROUPE join syst_categorie_assurance on cotisation_cotisation_new.ID_CATEGORIE_ASSURANCE=syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE 1 AND cotisation_cotisation_new.ID_COTISATION=".$id);

    $donne_cotisation=$this->Model->getRequete("SELECT cotisation_cotisation_new.ID_COTISATION,cotisation_cotisation_new.PRIX_UNITAIRE,cotisation_cotisation_new.`MOIS_COTISATION`,cotisation_cotisation_new.`ID_GROUPE`,cotisation_cotisation_new.`ID_CATEGORIE_ASSURANCE`,membre_groupe.NOM_GROUPE,syst_categorie_assurance.DESCRIPTION,cotisation_cotisation_new.MONTANT_COTISATION,cotisation_cotisation_new.NOMBRE FROM `cotisation_cotisation_new` join membre_groupe on cotisation_cotisation_new.ID_GROUPE=membre_groupe.ID_GROUPE join syst_categorie_assurance on cotisation_cotisation_new.ID_CATEGORIE_ASSURANCE=syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE 1 AND cotisation_cotisation_new.ID_GROUPE=".$donne['ID_GROUPE']." AND cotisation_cotisation_new.MOIS_COTISATION='".$donne['MOIS_COTISATION']."'  AND cotisation_cotisation_new.AYANT_DROIT=2 ");


    $donne_cotisation_ayant_droit=$this->Model->getRequete("SELECT cotisation_cotisation_new.ID_COTISATION,cotisation_cotisation_new.PRIX_UNITAIRE,cotisation_cotisation_new.`MOIS_COTISATION`,cotisation_cotisation_new.`ID_GROUPE`,cotisation_cotisation_new.`ID_CATEGORIE_ASSURANCE`,membre_groupe.NOM_GROUPE,syst_categorie_assurance.DESCRIPTION,cotisation_cotisation_new.MONTANT_COTISATION,cotisation_cotisation_new.NOMBRE FROM `cotisation_cotisation_new` join membre_groupe on cotisation_cotisation_new.ID_GROUPE=membre_groupe.ID_GROUPE join syst_categorie_assurance on cotisation_cotisation_new.ID_CATEGORIE_ASSURANCE=syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE 1 AND cotisation_cotisation_new.ID_GROUPE=".$donne['ID_GROUPE']." AND cotisation_cotisation_new.MOIS_COTISATION='".$donne['MOIS_COTISATION']."'  AND cotisation_cotisation_new.AYANT_DROIT=1");

    $donne_frais_cartes=$this->Model->getRequete("SELECT cotisation_frais_cartes_new.ID_COTISATION_CARTES,cotisation_frais_cartes_new.PRIX_UNITAIRE,cotisation_frais_cartes_new.`MOIS_COTISATION`,cotisation_frais_cartes_new.`ID_GROUPE`,cotisation_frais_cartes_new.`ID_CATEGORIE_ASSURANCE`,membre_groupe.NOM_GROUPE,syst_categorie_assurance.DESCRIPTION,cotisation_frais_cartes_new.MONTANT_COTISATION,cotisation_frais_cartes_new.`NOMBRE` FROM `cotisation_frais_cartes_new` join membre_groupe on cotisation_frais_cartes_new.ID_GROUPE=membre_groupe.ID_GROUPE join syst_categorie_assurance on cotisation_frais_cartes_new.ID_CATEGORIE_ASSURANCE=syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE 1 AND cotisation_frais_cartes_new.`ID_GROUPE`=".$donne['ID_GROUPE']." AND cotisation_frais_cartes_new.MOIS_COTISATION='".$donne['MOIS_COTISATION']."'");


    $donne_frais_adhesion=$this->Model->getRequete("SELECT cotisation_frais_adhesion_new.ID_COTISATION_ADHESION,cotisation_frais_adhesion_new.PRIX_UNITAIRE,cotisation_frais_adhesion_new.`MOIS_COTISATION`,cotisation_frais_adhesion_new.`ID_GROUPE`,cotisation_frais_adhesion_new.`ID_CATEGORIE_ASSURANCE`,membre_groupe.NOM_GROUPE,syst_categorie_assurance.DESCRIPTION,cotisation_frais_adhesion_new.MONTANT_COTISATION,cotisation_frais_adhesion_new.NOMBRE FROM `cotisation_frais_adhesion_new` join membre_groupe on cotisation_frais_adhesion_new.ID_GROUPE=membre_groupe.ID_GROUPE join syst_categorie_assurance on cotisation_frais_adhesion_new.ID_CATEGORIE_ASSURANCE=syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE 1 AND cotisation_frais_adhesion_new.`ID_GROUPE`=".$donne['ID_GROUPE']." AND cotisation_frais_adhesion_new.MOIS_COTISATION='".$donne['MOIS_COTISATION']."'");

    $dateObj = new DateTime($donne['MOIS_COTISATION']);

    $formatter = new IntlDateFormatter(
    'fr_FR',                // Locale française
    IntlDateFormatter::NONE, // Pas de date complète prédéfinie
    IntlDateFormatter::NONE, // Pas d'heure
    null,                   // Fuseau horaire (null = par défaut)
    null,                   // Calendrier
    'LLLL yyyy'             // Format personnalisé : mois long + année
);

    $date= $formatter->format($dateObj);


//  Initialiser un tableau pour stocker les données combinées
    $data = [
      "Frais d'adhesion" => [],
      "Frais de cotisation mensuelle" => [],
      "Ayants droits supplementaires" => [],
      "Frais de confection  des cartes" => []
  ];

// Vérifier et ajouter les données de cotisation
  if (!empty($donne_cotisation)) {
      foreach ($donne_cotisation as $row) {
        $data["Frais de cotisation mensuelle"][] = $row; // Ajoute chaque ligne de cotisation
    }
}

// Vérifier et ajouter les données de cotisation
if (!empty($donne_cotisation_ayant_droit)) {
  foreach ($donne_cotisation_ayant_droit as $row) {
        $data["Ayants droits supplementaires"][] = $row; // Ajoute chaque ligne de cotisation
    }
}

// Vérifier et ajouter les données de frais d'adhésion
if (!empty($donne_frais_adhesion)) {
  foreach ($donne_frais_adhesion as $row) {
        $data["Frais d'adhesion"][] = $row; // Ajoute chaque ligne de frais d'adhésion
    }
}

// Vérifier et ajouter les données de frais de cartes
if (!empty($donne_frais_cartes)) {
  foreach ($donne_frais_cartes as $row) {
        $data["Frais de confection  des cartes"][] = $row; // Ajoute chaque ligne de frais de cartes
    }
}

    // print_r($data);exit();


$anne=date('Y');
$code = str_pad($id, 5, '0', STR_PAD_LEFT);
$code_valide =$code.' '.'DG/MIS/'.strtoupper($date).' DU '.date("d/m/Y");


$pdf = new FPDF(); 
$pdf->AddPage('P', 'A4');
$pdf->Image(FCPATH. 'assets/img/mis_logo/logo_mis.png',5,5,160,0);

$pdf->Ln(15);
$pdf->SetFont('Times','B',10);
$pdf->Cell(25,7,utf8_decode(""),0,'R');
$pdf->Cell(40,7,utf8_decode("FACTURE N° :".$code_valide),0,'R');
$textWidth = $pdf->GetStringWidth(utf8_decode("FACTURE N° :"));
// $pdf->Line(35, 25 + 7, 120 + $textWidth, 25 + 7);
$pdf->Ln(8);
$pdf->SetFont('Times','B',8);
$pdf->Cell(8,5,utf8_decode(""),0,'R');
$pdf->Cell(50,5,utf8_decode("A.IDENTIFICATION DU VENDEUR "),0,'L');
$pdf->SetFont('Times','',8);
$pdf->Cell(44,5,utf8_decode(""),0,'R');
$pdf->Cell(50,5,utf8_decode('CENTRE FISCAL :'),0,'R');
$pdf->SetFont('Times','B',8);
$pdf->Cell(30,5,utf8_decode('DMC'),0,'L');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,5,utf8_decode(""),0,'R');
$pdf->Cell(50,5,utf8_decode("RAISON SOCIALE :"),0,'L');
$pdf->SetFont('Times','b',8);
$pdf->Cell(40,5,utf8_decode("MIS Santé "),0,'R');
$pdf->Cell(50,5,utf8_decode('SECTEUR D\'ACTIVITE :'),0,'R');
$pdf->SetFont('Times','B',8);
$pdf->Cell(30,5,utf8_decode('ASSURANCE VIE'),0,'L');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,5,utf8_decode(""),0,'R');
$pdf->Cell(50,5,utf8_decode("NIF :"),0,'L');
$pdf->SetFont('Times','B',8);
$pdf->Cell(40,5,utf8_decode("4001687633"),0,'R');
$pdf->SetFont('Times','',8);
$pdf->Cell(50,5,utf8_decode('FORME JURDIQUE :'),0,'R');
$pdf->SetFont('Times','B',8);
$pdf->Cell(30,5,utf8_decode(''),0,'L');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,5,utf8_decode(""),0,'R');
$pdf->Cell(50,5,utf8_decode("RC :"),0,'L');
$pdf->SetFont('Times','B',8);
$pdf->Cell(40,5,utf8_decode("30531/21"),0,'R');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,5,utf8_decode(""),0,'R');
$pdf->Cell(30,5,utf8_decode("COMMUNE :"),0,'L');
$pdf->SetFont('Times','',8);
$pdf->Cell(20,5,utf8_decode("MUKAZA ,"),0,'R');
$pdf->SetFont('Times','',8);
$pdf->Cell(10,5,utf8_decode(""),0,'R');
$pdf->Cell(30,5,utf8_decode("QUARTIER :"),0,'L');
$pdf->SetFont('Times','',8);
$pdf->Cell(30,5,utf8_decode("ROHERO"),0,'R');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,5,utf8_decode(""),0,'R');
$pdf->Cell(50,5,utf8_decode("TEL :"),0,'L');
$pdf->SetFont('Times','',8);
$pdf->Cell(40,5,utf8_decode("22281029/77527805"),0,'R');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,5,utf8_decode(""),0,'R');
$pdf->Cell(50,5,utf8_decode("AVENUE :"),0,'L');
$pdf->SetFont('Times','',8);
$pdf->Cell(40,5,utf8_decode("Pierre NGENDANDUMWE"),0,'R');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,5,utf8_decode(""),0,'R');
$pdf->Cell(50,5,utf8_decode("assujeti a la TVA "),0,'L');
$pdf->SetFont('Times','',8);
$pdf->Cell(40,5,utf8_decode("oui"),0,'R');
$pdf->SetFont('Times','',8);
$pdf->Cell(40,5,utf8_decode("non"),0,'R');

$pdf->Ln(8);
$pdf->SetFont('Times','B',8);
$pdf->Cell(8,6,utf8_decode(""),0,'R');
$pdf->Cell(50,6,utf8_decode("B. IDENTIFICATION DU CLIENT "),0,'L');
$pdf->SetFont('Times','',8);
$pdf->Cell(40,6,utf8_decode(""),0,'R');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,4,utf8_decode(""),0,'R');
$pdf->Cell(50,4,utf8_decode("RAISON SOCIALE :"),0,'L');
$pdf->SetFont('Times','B',8);
$pdf->Cell(40,4,utf8_decode($donne['NOM_GROUPE']),0,'R');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,4,utf8_decode(""),0,'R');
$pdf->Cell(50,4,utf8_decode("NIF :"),0,'L');
$pdf->SetFont('Times','B',8);
$pdf->Cell(40,4,utf8_decode($donne['NIF']? $donne['NIF']:""),0,'R');
$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,4,utf8_decode(""),0,'R');
$pdf->Cell(50,4,utf8_decode('RESIDENT A :'),0,'R');
$pdf->SetFont('Times','B',8);
$pdf->Cell(40,4,utf8_decode($donne['RESIDENCE']? $donne['RESIDENCE']:""),0,'R');

$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,4,utf8_decode(""),0,'R');
$pdf->Cell(50,4,utf8_decode("assujeti a la TVA "),0,'L');
$pdf->SetFont('Times','',8);
$pdf->Cell(40,4,utf8_decode("oui"),0,'R');
$pdf->SetFont('Times','',8);
$pdf->Cell(40,4,utf8_decode("non"),0,'R');

$pdf->Ln(5);
$pdf->SetFont('Times','',8);
$pdf->Cell(12,4,utf8_decode(""),0,'R');
$pdf->Cell(50,4,utf8_decode("doit pour ce qui suit :"),0,'L');

$pdf->Ln(10);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(8,4,utf8_decode(""),0,'R');
$widths = [10, 70, 30, 15, 15, 25];
$header = ['N°', 'Nature de Service', 'Catégorie', 'Nombre', 'P.U', 'PT HTVA'];

// En-tête du tableau
foreach ($header as $key => $col) {
    $pdf->Cell($widths[$key], 10, utf8_decode($col), 1, 0, 'C');
}
$pdf->Ln();

$rowNumber = 1;
$totalGeneral = 0;

foreach ($data as $service => $items) {
    $service = utf8_decode($service);
    $itemCount = count($items); 

    if (empty($items)) {
        continue; // Passe à l'itération suivante sans traiter cette catégorie
    }
    
    // Pré-calcul des hauteurs des items
    $itemHeights = [];
    $totalItemsHeight = 0;
    
    foreach ($items as $item) {
        // Calcul hauteur basée sur le contenu réel
        $itemHeight = 5 * max(
            $pdf->NbLines($widths[2], $item['DESCRIPTION']),
            $pdf->NbLines($widths[3], $item['NOMBRE']),
            $pdf->NbLines($widths[4], $item['PRIX_UNITAIRE']),
            $pdf->NbLines($widths[5], $item['MONTANT_COTISATION'])
        );
        
        // Limite à 15 (3 lignes) et hauteur minimale de 5
        $itemHeight = max(5, min($itemHeight, 15));
        $itemHeights[] = $itemHeight;
        $totalItemsHeight += $itemHeight;
    }
    
    // Calcul hauteur du service
    $serviceLines = $pdf->NbLines($widths[1], $service);
    $serviceHeight = min($serviceLines, 3) * 5; // Max 3 lignes (15)
    
    // Hauteur finale = max entre hauteur service et hauteur du PREMIER item
    $firstItemHeight = !empty($itemHeights) ? $itemHeights[0] : 10;
    $categoryHeight = max($serviceHeight, $firstItemHeight, $totalItemsHeight);
    
    $xStart = $pdf->GetX()+8;
    $yStart = $pdf->GetY();
    
    // Cellule numéro - s'adapte à la hauteur du premier item
    
    $pdf->Rect($xStart, $yStart, $widths[0], $categoryHeight, 'D');
    $pdf->SetXY($xStart, $yStart + ($categoryHeight - 5) / 2);
    $pdf->Cell($widths[0], 5, $rowNumber, 0, 0, 'C');
    $rowNumber++;
    
    // Cellule service - centrée verticalement par rapport au premier item
    $pdf->SetXY($xStart + $widths[0] + 1, $yStart + ($categoryHeight - $serviceHeight) / 2);
    $pdf->MultiCell($widths[1] - 2, 5, $service, 0, 'L');
    $pdf->Rect($xStart + $widths[0], $yStart, $widths[1], $categoryHeight, 'D');
    
    // Position Y pour les items
    $yPos = $yStart;
    
    // Dessiner les items
    foreach ($items as $index => $item) {
        $currentItemHeight = $itemHeights[$index];
        $verticalOffset = ($currentItemHeight - 5) / 2;
        
        // Catégorie
        $pdf->Rect($xStart + $widths[0] + $widths[1], $yPos, $widths[2], $currentItemHeight, 'D');
        $pdf->SetXY($xStart + $widths[0] + $widths[1], $yPos + $verticalOffset);
        $pdf->Cell($widths[2], 5, utf8_decode($item['DESCRIPTION']), 0, 0, 'C');
        
        // Nombre
        $pdf->Rect($xStart + $widths[0] + $widths[1] + $widths[2], $yPos, $widths[3], $currentItemHeight, 'D');
        $pdf->SetXY($xStart + $widths[0] + $widths[1] + $widths[2], $yPos + $verticalOffset);
        $pdf->Cell($widths[3], 5, utf8_decode($item['NOMBRE']), 0, 0, 'C');
        
        // P.U
        $pdf->Rect($xStart + $widths[0] + $widths[1] + $widths[2] + $widths[3], $yPos, $widths[4], $currentItemHeight, 'D');
        $pdf->SetXY($xStart + $widths[0] + $widths[1] + $widths[2] + $widths[3], $yPos + $verticalOffset);
        $pdf->Cell($widths[4], 5, utf8_decode(number_format($item['PRIX_UNITAIRE'], 0, ',', ' ')), 0, 0, 'R');
        
        // PT HTVA
        $pdf->Rect($xStart + $widths[0] + $widths[1] + $widths[2] + $widths[3] + $widths[4], $yPos, $widths[5], $currentItemHeight, 'D');
        $pdf->SetXY($xStart + $widths[0] + $widths[1] + $widths[2] + $widths[3] + $widths[4], $yPos + $verticalOffset);
        $pdf->Cell($widths[5], 5, utf8_decode(number_format($item['MONTANT_COTISATION'], 0, ',', ' ')), 0, 0, 'R');
        
        $totalGeneral += $item['MONTANT_COTISATION'];
        $yPos += $currentItemHeight;
    }
    
    // Déplacer au bas de la section
    $pdf->SetY($yStart + $categoryHeight);
}

// Ligne du total
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(8,4,utf8_decode(""),0,'R');
$totalWidth = array_sum(array_slice($widths, 0, 5));
$pdf->Cell($totalWidth, 5, 'TOTAL GENERAL', 1, 0, 'L');
$pdf->Cell($widths[5], 5, number_format($totalGeneral, 0, ',', ' '), 1, 1, 'R');

$pdf->SetFont('Times', 'B', 11); 
$pdf->Ln(6);
$montant=$this->nombreEnLettres($totalGeneral);

$pdf->SetFont('Times', '', 10);
$pdf->Cell(8,4,utf8_decode(""),0,'R');
$pdf->Cell(40, 10, utf8_decode("Nous disons une somme de"), 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(120, 10, utf8_decode("".$montant." francs burundais (".number_format($totalGeneral, 0, ',', ' ')." Fbu)"),  0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(8,4,utf8_decode(""),0,'R');
$pdf->Cell(30, 10, utf8_decode("équivalant aux frais "),  0, 'L');
$pdf->Cell(15, 10, utf8_decode("de cotisations du mois de ".$date." pour la couverture maladie."),  0, 'L');

$pdf->Ln(8); 
$pdf->SetFont('Times', '', 10);
$pdf->Cell(8,4,utf8_decode(""),0,'R');
$pdf->Cell(60, 10, utf8_decode("A verser sur le compte de MIS Santé N° :"), 0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(20, 10, utf8_decode("20533880000"),  0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(25, 10, utf8_decode("Ouvert à la BCB, "),  0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(25, 10, utf8_decode("10258820101-09"),  0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(35, 10, utf8_decode("ouvert à la BANCOBU, "),  0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(20, 10, utf8_decode("33392"),  0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(8,4,utf8_decode(""),0,'R');
$pdf->Cell(35, 10, utf8_decode(" ouvert à la COOPEC, "),  0, 'L');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(13, 10, utf8_decode("E00078"),  0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(40, 10, utf8_decode("ouvert à la Microfinance SOPEC. "),  0, 'L');

$pdf->SetY(230);
$pdf->SetFont('Times', 'B', 10);
// $pdf->Ln(12);

$pdf->Ln(1);
$pdf->Cell(113,7,utf8_decode(""),0,'R'); 
$pdf->Cell(30, 8, utf8_decode("Directeur Général de la MIS Santé"), 0, 1, 'L');

$pdf->Ln(1); 
$pdf->Cell(120,7,utf8_decode(""),0,'R'); 
$pdf->Cell(30, 10, utf8_decode("NIYONSABA Solange"), 0, 1, 'L');
  $pdf->Image(FCPATH. 'assets/img/mis_logo/cachet_mis.png',140,225,30,0);

$x1 = 10; 
$y1 = 268; 
$x2 = 200; 
$y2 = 268;

// Tracer la ligne
$pdf->Line($x1, $y1, $x2, $y2);

// Configuration du pied de page
$pdf->SetY($y1);
$pdf->SetFont('Times', 'B', 6);
// Numéro de page (Page X/Y)
$pdf->Cell(0, 5, utf8_decode('679/A ; Avenue Pierre NGENDANDUMWE, Central Building, 1er étage, Bureau 202 - Tél : (+257) 22 28 10 29 / 77 527 805 / 65 771 286 ') , 0, 0, 'C');
$pdf->Ln(2); // Espacement entre les lignes

// Copyright
$pdf->Cell(0,5 , utf8_decode('E-mail : missante2020@gmail.com '), 0, 0, 'C');

$pdf->Output('I');

}

// Fonction pour convertir un nombre en lettres
function nombreEnLettres($nombre) {
    // Gestion du zéro
    if ($nombre == 0) return 'zéro';
    
    $unités = [
        1 => 'un', 2 => 'deux', 3 => 'trois', 4 => 'quatre', 5 => 'cinq', 
        6 => 'six', 7 => 'sept', 8 => 'huit', 9 => 'neuf', 10 => 'dix',
        11 => 'onze', 12 => 'douze', 13 => 'treize', 14 => 'quatorze', 
        15 => 'quinze', 16 => 'seize', 17 => 'dix-sept', 18 => 'dix-huit', 
        19 => 'dix-neuf'
    ];

    $dizaines = [
        2 => 'vingt', 3 => 'trente', 4 => 'quarante', 5 => 'cinquante',
        6 => 'soixante', 8 => 'quatre-vingt'
    ];

    // Nombres < 20
    if ($nombre < 20) {
        return $unités[$nombre];
    }
    
    // Nombres 20-69, 80-89
    elseif ($nombre < 70 || ($nombre >= 80 && $nombre < 90)) {
        $d = floor($nombre / 10);
        $u = $nombre % 10;
        
        // Cas spéciaux
        if ($u == 0) {
            // Vingt prend un "s" quand seul
            return ($d == 8) ? $dizaines[$d] . 's' : $dizaines[$d];
        }
        if ($u == 1 && $d != 8) {
            return $dizaines[$d] . ' et un';
        }
        
        return $dizaines[$d] . '-' . $unités[$u];
    }
    
    // Nombres 70-79 : soixante-dix à soixante-dix-neuf
    elseif ($nombre < 80) {
        return 'soixante-' . $this->nombreEnLettres($nombre - 60);
    }
    
    // Nombres 90-99 : quatre-vingt-dix à quatre-vingt-dix-neuf
    elseif ($nombre < 100) {
        return 'quatre-vingt-' . $this->nombreEnLettres($nombre - 80);
    }
    
    // Centaines (100-999)
    elseif ($nombre < 1000) {
        $c = floor($nombre / 100);
        $reste = $nombre % 100;
        $s = ($c > 1 && $reste == 0) ? 's' : ''; // Pluriel pour "cents"
        
        return ($c > 1 ? $this->nombreEnLettres($c) . ' ' : '') 
        . 'cent' . $s 
        . ($reste > 0 ? ' ' . $this->nombreEnLettres($reste) : '');
    }
    
    // Milliers (1000-999999)
    elseif ($nombre < 1000000) {
        $m = floor($nombre / 1000);
        $reste = $nombre % 1000;
        
        // "mille" est invariable
        return ($m > 1 ? $this->nombreEnLettres($m) . ' ' : '') 
        . 'mille' 
        . ($reste > 0 ? ' ' . $this->nombreEnLettres($reste) : '');
    }
    
    // Millions (1000000+)
    else {
        $m = floor($nombre / 1000000);
        $reste = $nombre % 1000000;
        $s = ($m > 1) ? 's' : ''; // Pluriel pour "millions"
        
        return $this->nombreEnLettres($m) 
        . ' million' . $s 
        . ($reste > 0 ? ' ' . $this->nombreEnLettres($reste) : '');
    }
}



}
