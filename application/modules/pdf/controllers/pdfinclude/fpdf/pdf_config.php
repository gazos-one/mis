<?php


class PDF_CONFIG extends MC_TABLE
{
function Header()
{

   //Put the watermark
  // include 'PDF_Rotate.php';
  // if (condition) {
  //   # code...
  // }
   

$this->SetFont('Arial','B',10);
   
    //$this->Image(''.base_url().'upload/banderole/socar.jpeg',35,5,30);
       //  $urlpass = base_url();
       //  $elementspas = explode("/", $urlpass);
       // $nouveau_urlpass = null ;
       //  $indicepass = sizeof($elementspas);
       //  for ($i = 0; $i < ($indicepass - 2); $i++) {
       //      $nouveau_urlpass .=$elementspas[$i] . '/';
       //  }
    // $this->Image(''.$nouveau_urlpass.'upload/logosoc.jpeg',12,5,40,15);
        // $this->Cell(80,5,'SOCIETE COMMERCIALE',0,1,'C');
    // $this->Ln(7); 
    // $this->Cell(80,5,'SOCIETE COMMERCIALE',0,1,'C');
    // $this->Cell(50,10,'',0,0,'C');
    // Saut de ligne
    // $this->Ln(20);
    // $this->SetY(45);
    
    // $this->Line(40,50,40, 280);
}
// Pied de page
// function Footer()
// {
//     // Positionnement à 1,5 cm du bas
//     $this->SetY(-20);
//     // Police Arial italique 8
//     $this->SetFont('Arial','I',8);
//     // Numéro de page
//     $this->Cell(0,10,$this->PageNo(),0,0,'C');
    
    
//  $this->Image(''.base_url().'upload/banderole/grandlogo.jpg',10,280,220);
// }

function Footer(){
  $this->SetY(-20);
  $this->SetFont('Arial','',5);
  $this->SetTextColor(0,0,203);
  // $this->Cell(190,5,utf8_decode('Joonction Blvd de l\'indépendance & Avenue de l\'Italie, Bujumbura-BURUNDI, Tél:(+257)22 21 07 31 / E-mail: info@socar.bi / B.P 2884,site web :www.socar.bi'),0,1,'C');
  // $this->Cell(190,0,'-----------------------------------------------------------------------------------------------------',1,1,'C');
  // $this->Cell(190,5,utf8_decode('CPTE BANCOBU : 9413-01-29 | CPTE CRDB: 0150800449800 | CPTE IBB : 0915801-17 | COMPTE FLB :02000731101 | CPTE KCB: 6600009888 | CPTE BGF:15002009111 | CPTE ECOBANK: 0010123600356301 '),0,1,'C');
  // $this->Cell(190,5,utf8_decode('CPTE BCB: 00100018369-50 | CPTE DTB: 120101011912019 | CPTE BBCI: 500-01411101-18 | CPTE KAZOZA:3001-01712701-68 | CPTE CCM:61622/1'),0,1,'C');
}

}

?>