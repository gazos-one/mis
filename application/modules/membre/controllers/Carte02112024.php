<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Carte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->Is_Connected();
        $this->creationcarte();
        
    }

    public function Is_Connected()
       {

       if (empty($this->session->userdata('MIS_ID_USER')))
        {
         redirect(base_url('Login/'));
        }
       }



    public function creationcarte()
    {

      
      
      $membre_carte = $this->Model->getRequete('SELECT membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, membre_membre_qr.ID_MEMBRE_QR FROM `membre_membre`LEFT JOIN membre_membre_qr ON membre_membre_qr.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE membre_membre_qr.ID_MEMBRE_QR IS NULL ORDER BY membre_membre.ID_MEMBRE DESC LIMIT 10');
      foreach ($membre_carte as $cart) {
        $this->get_qr_code($cart['ID_MEMBRE']);
      }

      

    $listcarte = $this->Model->getRequete('SELECT * FROM membre_carte_membre RIGHT JOIN membre_membre ON membre_membre.ID_MEMBRE = membre_carte_membre.ID_MEMBRE WHERE membre_membre.CODE_AFILIATION NOT LIKE "" AND membre_membre.IS_AFFILIE = 0 AND membre_carte_membre.ID_CARTE IS NULL');
    $ysetting = $this->Model->getRequeteOne('SELECT * FROM syst_config WHERE ID_CONFIG = 1');
      foreach ($listcarte as $key) {

        if ($key['ID_CARTE'] == null) {         
        $listass = $this->Model->getRequete('SELECT * FROM membre_assurances WHERE ID_MEMBRE = '.$key['ID_MEMBRE'].' and STATUS =1 ');
        foreach ($listass as $ass) {

          $firstdate = strtotime($key['DATE_ADHESION']);
          $lastdate = strtotime('+ '.$ysetting['DUREE_CARTE'].' year', $firstdate);
          $lastdate = date('Y-m-d', $lastdate);
          $datacarte = array(
            'CODE_CARTE'=>$key['CODE_AFILIATION'],
            'NB_MEMBRE'=>0,
            'ID_CATEGORIE_ASSURANCE'=>$ass['ID_CATEGORIE_ASSURANCE'],
            'DATE_DABUT_VALIDITE'=>$key['DATE_ADHESION'],
            'DATE_FIN_VALIDITE'=>$lastdate,
          );
        $ID_CARTE = $this->Model->insert_last_id('membre_carte',$datacarte);
        $datacartemembre = array(
            'ID_CARTE'=>$ID_CARTE,
            'ID_MEMBRE'=>$key['ID_MEMBRE'],
            'DEBUT_SUR_LA_CARTE'=>$key['DATE_ADHESION'],
            'FIN_SUR_LA_CARTE'=>$lastdate
          );
        $this->Model->insert_last_id('membre_carte_membre',$datacartemembre);
        $listmembre = $this->Model->getRequete('SELECT * FROM membre_membre WHERE CODE_PARENT = '.$key['ID_MEMBRE'].' and STATUS =1');
        foreach ($listmembre as $membr) {
          $datacartemembres = array(
            'ID_CARTE'=>$ID_CARTE,
            'ID_MEMBRE'=>$membr['ID_MEMBRE'],
            'DEBUT_SUR_LA_CARTE'=>$membr['DATE_ADHESION'],
            'FIN_SUR_LA_CARTE'=>$lastdate
          );
        $this->Model->insert_last_id('membre_carte_membre',$datacartemembres);
        }



        $nbp = strlen($key['PROVINCE_ID']);
        $nbc = strlen($key['COMMUNE_ID']);
        if ($nbp == 1) {
        $prov = '0'.$key['PROVINCE_ID'];
        }
        else{
         $prov = $key['PROVINCE_ID']; 
        }

        if ($nbc == 1) {
        $comu = '00'.$key['COMMUNE_ID'];
        }
        elseif ($nbc == 2) {
        $comu = '0'.$key['COMMUNE_ID'];
        }
        else{
         $comu = $key['COMMUNE_ID']; 
        }

        $nbid = strlen($ID_CARTE);
        if ($nbid == 1) {
        $nid = '000000'.$ID_CARTE; 
        }
        elseif ($nbid == 2) {
        $nid = '00000'.$ID_CARTE; 
        }
        elseif ($nbid == 3) {
        $nid = '0000'.$ID_CARTE; 
        }
        elseif ($nbid == 4) {
        $nid = '000'.$ID_CARTE; 
        }
        elseif ($nbid == 5) {
        $nid = '00'.$ID_CARTE; 
        }
        elseif ($nbid == 6) {
        $nid = '0'.$ID_CARTE; 
        }
        else{
        $nid = $ID_CARTE; 
        }

        $CODE_CARTE =  'MIS'.$prov.''.$comu.'-'.$nid; 

        $nbmembre = $this->Model->record_countsome('membre_carte_membre',array('ID_CARTE'=>$ID_CARTE));
        $this->Model->update('membre_carte',array('ID_CARTE'=>$ID_CARTE),array('NB_MEMBRE'=>$nbmembre,'CODE_CARTE'=>$CODE_CARTE));

        }
        }
        else{

          
          $datedujour = date('Y-m-d');
          // echo $key['ID_CARTE'].' '.$key['FIN_SUR_LA_CARTE'];

          if($datedujour < $key['FIN_SUR_LA_CARTE']) { 

            
            $nbmembre = $this->Model->record_countsome('membre_carte_membre',array('ID_CARTE'=>$key['ID_CARTE'],'STATUS'=>1));
            $nbmembrereel = $this->Model->record_countsome('membre_membre',array('IS_AFFILIE'=>1,'CODE_PARENT'=>$key['ID_MEMBRE']));
            $nbmembrereels = $nbmembrereel +1;
            // echo ' '.$nbmembre . ' '.$nbmembrereels;

            if ($nbmembre != $nbmembrereels) {

              $this->Model->update('membre_carte',array('ID_CARTE'=>$key['ID_CARTE']),array('NB_MEMBRE'=>$nbmembrereels));
              $missingid = $this->Model->getRequete('SELECT DISTINCT membre_membre.ID_MEMBRE FROM membre_membre WHERE CODE_PARENT LIKE "'.$key['ID_MEMBRE'].'" AND ID_MEMBRE NOT IN (SELECT DISTINCT membre_carte_membre.ID_MEMBRE FROM membre_carte_membre WHERE ID_CARTE = '.$key['ID_CARTE'].' )');
              foreach ($missingid as $value) {

                    $datacartemembress = array(
            'ID_CARTE'=>$key['ID_CARTE'],
            'ID_MEMBRE'=>$value['ID_MEMBRE'],
            'DEBUT_SUR_LA_CARTE'=>$key['DEBUT_SUR_LA_CARTE'],
            'FIN_SUR_LA_CARTE'=>$key['FIN_SUR_LA_CARTE']
          );
             $this->Model->insert_last_id('membre_carte_membre',$datacartemembress);

              }
          
            
            }
            
            

          }
          else{

            // echo " Not good <br>";
            $this->Model->update('membre_carte',array('ID_CARTE'=>$key['ID_CARTE']),array('STATUS'=>0));
            $this->Model->update('membre_carte_membre',array('ID_CARTE'=>$key['ID_CARTE']),array('STATUS'=>0));

          $firstdaten = strtotime($key['FIN_SUR_LA_CARTE']);
          $lastdaten = strtotime('+ '.$ysetting['DUREE_CARTE'].' year', $firstdaten);
          $lastdaten = date('Y-m-d', $lastdaten);


          $listassn = $this->Model->getRequete('SELECT * FROM membre_assurances WHERE ID_MEMBRE = '.$key['ID_MEMBRE'].' and STATUS =1');
        foreach ($listassn as $assn) {
          $datacarten = array(
            'CODE_CARTE'=>$key['CODE_AFILIATION'],
            'NB_MEMBRE'=>0,
            'ID_CATEGORIE_ASSURANCE'=>$assn['ID_CATEGORIE_ASSURANCE'],
            'DATE_DABUT_VALIDITE'=>$key['FIN_SUR_LA_CARTE'],
            'DATE_FIN_VALIDITE'=>$lastdaten,
          );
          

          $ID_CARTEN = $this->Model->insert_last_id('membre_carte',$datacarten);
        $datacartemembren = array(
            'ID_CARTE'=>$ID_CARTEN,
            'ID_MEMBRE'=>$key['ID_MEMBRE'],
            'DEBUT_SUR_LA_CARTE'=>$key['FIN_SUR_LA_CARTE'],
            'FIN_SUR_LA_CARTE'=>$lastdaten
          );
        $this->Model->insert_last_id('membre_carte_membre',$datacartemembren);
        

        $listmembren = $this->Model->getRequete('SELECT * FROM membre_membre WHERE CODE_PARENT = '.$key['ID_MEMBRE'].' and STATUS =1');
        foreach ($listmembren as $membrn) {
          $datacartemembresn = array(
            'ID_CARTE'=>$ID_CARTEN,
            'ID_MEMBRE'=>$membrn['ID_MEMBRE'],
            'DEBUT_SUR_LA_CARTE'=>$key['FIN_SUR_LA_CARTE'],
            'FIN_SUR_LA_CARTE'=>$lastdaten
          );
         
        $this->Model->insert_last_id('membre_carte_membre',$datacartemembresn);
        }





        }



        $nbpn = strlen($key['PROVINCE_ID']);
        $nbcn = strlen($key['COMMUNE_ID']);
        if ($nbpn == 1) {
        $provn = '0'.$key['PROVINCE_ID'];
        }
        else{
         $provn = $key['PROVINCE_ID']; 
        }

        if ($nbcn == 1) {
        $comun = '00'.$key['COMMUNE_ID'];
        }
        elseif ($nbcn == 2) {
        $comun = '0'.$key['COMMUNE_ID'];
        }
        else{
         $comun = $key['COMMUNE_ID']; 
        }

        $nbidn = strlen($ID_CARTEN);
        if ($nbidn == 1) {
        $nidn = '000000'.$ID_CARTEN; 
        }
        elseif ($nbidn == 2) {
        $nidn = '00000'.$ID_CARTEN; 
        }
        elseif ($nbidn == 3) {
        $nidn = '0000'.$ID_CARTEN; 
        }
        elseif ($nbidn == 4) {
        $nidn = '000'.$ID_CARTEN; 
        }
        elseif ($nbidn == 5) {
        $nidn = '00'.$ID_CARTEN; 
        }
        elseif ($nbidn == 6) {
        $nidn = '0'.$ID_CARTEN; 
        }
        else{
        $nidn = $ID_CARTEN; 
        }

        $CODE_CARTEN =  'MIS'.$provn.''.$comun.'-'.$nidn; 

        $nbmembren = $this->Model->record_countsome('membre_carte_membre',array('ID_CARTE'=>$ID_CARTEN));
        $this->Model->update('membre_carte',array('ID_CARTE'=>$ID_CARTEN),array('NB_MEMBRE'=>$nbmembren,'CODE_CARTE'=>$CODE_CARTEN));

          }

        }
      }

   
    }

 
     public function listing()
    {

      $data['anne_aff']=$this->Model->getRequete("SELECT DISTINCT YEAR(membre_membre.DATE_ADHESION) AS DATE_ADHESION FROM `membre_membre`");
      $data['groupe'] = $this->Model->getList('membre_groupe'); 
      $DATE_ADHESION = $this->input->post('DATE_ADHESION');
      $IS_TAKEN = $this->input->post('IS_TAKEN');
      $STATUS = $this->input->post('STATUS');
      

      // echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$IS_TAKEN;
      // echo '<br>';
      // exit();
      
      if ($DATE_ADHESION != null) {
        $condi2 = ' AND membre_membre.DATE_ADHESION like "%'.$DATE_ADHESION.'%" ';
        $data['DATE_ADHESION'] = $this->input->post('DATE_ADHESION');
      }
      else{
        $condi2 = ' ';
        $data['DATE_ADHESION'] = '';
      }

      if ($IS_TAKEN != 3 && $IS_TAKEN != NULL) {
        $condi1 = ' AND membre_membre_qr.IS_TAKEN = '.$IS_TAKEN.' ';
        $data['IS_TAKEN'] = $this->input->post('IS_TAKEN');
      }
      else{
        $condi1 = '';
        $data['IS_TAKEN'] = 3;
      }

      if ($STATUS == NULL || $STATUS == 1) {
        $condi3 = ' AND membre_carte.STATUS = 1 ';
        $data['STATUS'] = 1;
      }
      else{
        $condi3 = 'AND membre_carte.STATUS = 0';
        $data['STATUS'] = 0;
      }
      

      $ID_GROUPE = $this->input->post('ID_GROUPE');
      if ($ID_GROUPE != null) {
        $condi5 = ' AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' ';
        $data['ID_GROUPE'] = $this->input->post('ID_GROUPE');
      }
      else{
        $groupe = $this->Model->getRequeteOne('SELECT ID_GROUPE FROM membre_groupe ORDER BY ID_GROUPE DESC');
        $condi5 = ' ';
        // $condi5 = ' AND membre_groupe_membre.ID_GROUPE = '.$groupe['ID_GROUPE'].' ';
        $data['ID_GROUPE'] = '';
      }

      // echo 'SELECT DISTINCT(membre_membre.ID_MEMBRE), membre_membre.NOM, membre_membre.PRENOM, membre_membre.CNI, membre_carte.STATUS FROM membre_membre LEFT JOIN membre_carte_membre ON membre_carte_membre.ID_MEMBRE = membre_membre.ID_MEMBRE JOIN membre_carte ON membre_carte.ID_CARTE = membre_carte_membre.ID_CARTE JOIN membre_membre_qr ON membre_membre_qr.ID_MEMBRE = membre_membre.ID_MEMBRE JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE 1 AND membre_membre.IS_AFFILIE = 0 '.$condi1.' '.$condi2.' '.$condi5.' '.$condi3.' GROUP BY membre_membre.ID_MEMBRE, membre_carte.STATUS ---'.$STATUS;
      // echo'<br>';
      // exit();
      // $resultat=$this->Model->getRequete('SELECT * FROM membre_carte');
      $resultat=$this->Model->getRequete('SELECT DISTINCT(membre_membre.ID_MEMBRE), membre_membre.NOM, membre_membre.PRENOM, membre_membre.CNI, membre_carte.STATUS FROM membre_membre LEFT JOIN membre_carte_membre ON membre_carte_membre.ID_MEMBRE = membre_membre.ID_MEMBRE JOIN membre_carte ON membre_carte.ID_CARTE = membre_carte_membre.ID_CARTE JOIN membre_membre_qr ON membre_membre_qr.ID_MEMBRE = membre_membre.ID_MEMBRE JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE 1 AND membre_membre.IS_AFFILIE = 0 '.$condi1.' '.$condi2.' '.$condi5.' '.$condi3.' GROUP BY membre_membre.ID_MEMBRE, membre_carte.STATUS');
      
      $tabledata=array();
      
      
      foreach ($resultat as $key) 
         {

          $carte=$this->Model->getRequeteOne('SELECT membre_carte.ID_CARTE, membre_carte.CODE_CARTE, membre_carte.DATE_DABUT_VALIDITE, membre_carte.DATE_FIN_VALIDITE FROM membre_carte JOIN membre_carte_membre ON membre_carte_membre.ID_CARTE = membre_carte.ID_CARTE WHERE membre_carte_membre.ID_MEMBRE = '.$key['ID_MEMBRE'].' ');

          if ($key['STATUS'] == 1) {
            $stat = 'Actif';
            $fx = 'desactiver';
            $col = 'btn-danger';
            $titr = 'Désactiver';
            $stitr = 'voulez-vous désactiver ce membre ';
            $bigtitr = 'Désactivation du membre';
          }
          else{
            $stat = 'Innactif';
            $fx = 'reactiver';
            $col = 'btn-success';
            $titr = 'Réactiver';
            $stitr = 'voulez-vous réactiver ce membre ';
            $bigtitr = 'Réactivation du membre';
          }


          $nban = $this->Model->getRequeteOne('SELECT count(*) AS NB_AYANT FROM `membre_carte_membre` WHERE ID_CARTE = '.$carte['ID_CARTE'].' ');
          $person = $this->Model->getRequeteOne('SELECT NOM, PRENOM FROM membre_carte_membre JOIN membre_membre on membre_carte_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE membre_membre.IS_AFFILIE = 0 AND membre_carte_membre.ID_CARTE  = '.$carte['ID_CARTE'].' ');
          
          $chambr=array();
          $chambr[]=$person['NOM'].' '.$person['PRENOM'];
          $chambr[]=$carte['CODE_CARTE'];
          $chambr[]=$key['CNI'];
          
          // newDate
          $newDatedebut = date("d-m-Y", strtotime($carte['DATE_DABUT_VALIDITE']));
          $newDatefin = date("d-m-Y", strtotime($carte['DATE_FIN_VALIDITE']));
          $chambr[]=$newDatedebut;  
          $chambr[]=$newDatefin;  
          $chambr[]=$nban['NB_AYANT'];  
          if ($key['STATUS']==1) {
            $chambr[]=$stat;
          }
          else{
            $chambr[]='<div style="background-color:red">'.$stat.'</div>';
          }
          

          $news = $this->Model->getRequete('SELECT membre_carte_membre.ID_CARTE, membre_carte_membre.ID_CARTE_MEMBRE, membre_carte_membre.DEBUT_SUR_LA_CARTE, membre_membre.CNI, membre_carte_membre.FIN_SUR_LA_CARTE, membre_carte_membre.STATUS, membre_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, syst_provinces.PROVINCE_NAME, syst_communes.COMMUNE_NAME, syst_groupe_sanguin.DESCRIPTION AS GroupeSanguin, masque_emploi.DESCRIPTION AS Emploi, membre_membre.DATE_NAISSANCE, syst_sexe.DESCRIPTION as SEXE FROM `membre_carte_membre` JOIN membre_membre ON membre_membre.ID_MEMBRE = membre_carte_membre.ID_MEMBRE JOIN syst_provinces ON syst_provinces.PROVINCE_ID = membre_membre.PROVINCE_ID JOIN syst_communes ON syst_communes.COMMUNE_ID = membre_membre.COMMUNE_ID JOIN syst_groupe_sanguin ON syst_groupe_sanguin.ID_GROUPE_SANGUIN = membre_membre.ID_GROUPE_SANGUIN JOIN masque_emploi ON masque_emploi.ID_EMPLOI = membre_membre.ID_EMPLOI JOIN syst_sexe ON syst_sexe.ID_SEXE = membre_membre.ID_SEXE WHERE ID_CARTE = '.$carte['ID_CARTE'].' ');

          $apercum = '<table class="table">
          <tr>
          <td>Nom & Prenom</td>
          <td>CNI</td>
          <td>Date Naissance</td>
          <td>Sexe</td>
          <td>Residence</td>
          <td>GS</td>
          <td>Validite carte</td>
          </tr>';     
          foreach ($news as $membre) {
            // Emploi
          $newDate = date("d-m-Y", strtotime($membre['DATE_NAISSANCE']));
          $newDatedebutn = date("d-m-Y", strtotime($membre['DEBUT_SUR_LA_CARTE']));
          $newDatefinn = date("d-m-Y", strtotime($membre['FIN_SUR_LA_CARTE']));
          $apercum .= '<tr>
          <td>'.$membre['NOM'].' '.$membre['PRENOM'].'</td>
          <td>'.$membre['CNI'].'</td>
          <td>'.$newDate.'</td>
          <td>'.$membre['SEXE'].'</td>
          <td>'.$membre['PROVINCE_NAME'].' '.$membre['COMMUNE_NAME'].'</td>
          <td>'.$membre['GroupeSanguin'].'</td>
          <td>Du '.$newDatedebutn.' au '.$newDatefinn.'</td>
          </tr>';
          }
          $apercum .= '</table>';

          // $chambr[]='';
          $chambr[]='<div class="modal fade" id="membres'.$carte['ID_CARTE'].'">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Membre de la carte '.$carte['CODE_CARTE'].'</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              '.$apercum.'
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="changedate'.$carte['ID_CARTE'].'">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Membre de la carte '.$carte['CODE_CARTE'].'</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="FormData" action="'.base_url().'membre/Carte/changedate" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
            
          <table class="table">
          <tr>
          <td colspan="2">Modification des dates des Validit&eacute;</td>
          </tr>
          <tr>
          <td>
          <input type="date" class="form-control" id="DEBUT_SUR_LA_CARTE" name="DEBUT_SUR_LA_CARTE" value="'.$carte['DATE_DABUT_VALIDITE'].'" />
          </td>
          <td>
          <input type="date" class="form-control" id="FIN_SUR_LA_CARTE" name="FIN_SUR_LA_CARTE" value="'.$carte['DATE_FIN_VALIDITE'].'" />
          <input type="hidden" class="form-control" id="ID_CARTE" name="ID_CARTE" value="'.$carte['ID_CARTE'].'" />
          </td>
          </tr>
          </table>
            
            </div>
            <div class="modal-footer justify-content-between">
              <input type="submit" value="Enregistrer" class="btn btn-primary"/>
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
            </form>
          </div>
        </div>
      </div>

          <div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#membres'.$carte['ID_CARTE'].'">Voir Membres</a> </li>
                    <li><a class="dropdown-item" href="'.base_url('membre/Carte/index_carte/'.$carte['ID_CARTE']).'"> Détail et Apercu</a> </li>
                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#changedate'.$carte['ID_CARTE'].'">Modifier la date de fin</a> </li>
                    </ul>
                  </div>';
         
                          
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Affili&eacute;','Numero','CNI','Debut','Fin','Nb membre','Etat','Option'));
       
        $data['chamb']=$tabledata;
        $data['title']=' Carte d\'assurance';
        $data['stitle']=' Carte d\'assurance';
        $this->load->view('Carte_List_View',$data);

    }

  


  public function index_carte($id)
    {
      // echo $id;
      // exit();
      $data['title']=' Carte d\'assurance';
      $data['stitle']=' Carte d\'assurance';
      $selected = $this->Model->getOne('membre_carte',array('ID_CARTE'=>$id));
      // $selected = $this->Model->getOne('membre_carte_membre',array('ID_MEMBRE'=>$id)); 
      $selectedm = $this->Model->getRequeteOne('Select * from membre_carte_membre WHERE ID_CARTE = '.$selected['ID_CARTE'].' limit 1'); 
      $data['categoriecarte']=$this->Model->getRequeteOne('SELECT * FROM membre_carte JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE ID_CARTE = '.$id.' '); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$selectedm['ID_MEMBRE']));  
      $data['nbayantdroit'] = $this->Model->getRequeteOne('SELECT COUNT(ID_MEMBRE) AS NBAYANTDROIT FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1');  
      $nbayantdroit = $this->Model->getRequeteOne('SELECT COUNT(ID_MEMBRE) AS NBAYANTDROIT FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1');  
      $data['firstayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 1');  
      $data['secondayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 1,1');  
      $data['thirdayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 2,1'); 
      $data['fourthayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 3,1');  
      $data['fivehayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 4,1');  
      $data['sixhayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 5,1'); 
      $data['septhayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 6,1');  
      $data['huitayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 7,1');  
      $data['neufayantdroit'] = $this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 8,1');  
      $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$selectedm['ID_MEMBRE'],'IS_AFFILIE'=>1));
      // echo "<pre>";
      // print_r($this->Model->getRequeteOne('SELECT * FROM `membre_membre` WHERE CODE_PARENT = '.$selectedm['ID_MEMBRE'].' AND STATUS = 1 ORDER BY membre_membre.IS_CONJOINT DESC limit 2,1'));
   // echo   $nbayantdroit['NBAYANTDROIT'];
// exit();

      // if ($nbayantdroit['NBAYANTDROIT'] == 0) {
      //   // echo " 0";
      //   $this->load->view('Carte_Detail_View0',$data);
      // }
      // elseif ($nbayantdroit['NBAYANTDROIT'] == 1) {
      //   // echo "1";
      //   $this->load->view('Carte_Detail_View1',$data);
      // }
      // elseif ($nbayantdroit['NBAYANTDROIT'] == 2) {
      //   // echo "2";
      //   $this->load->view('Carte_Detail_View2',$data);
      // }
      // elseif ($nbayantdroit['NBAYANTDROIT'] == 3) {
      //   $this->load->view('Carte_Detail_View3',$data);
      // }
      // elseif ($nbayantdroit['NBAYANTDROIT'] == 4) {
      //   $this->load->view('Carte_Detail_View4',$data);
      // }
      // elseif ($nbayantdroit['NBAYANTDROIT'] == 5) {
      //   $this->load->view('Carte_Detail_View5',$data);
      // }
      // elseif ($nbayantdroit['NBAYANTDROIT'] == 6) {
      //   $this->load->view('Carte_Detail_View6',$data);
      // }

      // else {
        $this->load->view('Carte_Detail_View7',$data);
      // }
      // {
      //    $this->load->view('Carte_Detail_View',$data);
      // }
     
    }

    public function changedate()
    {
      $DEBUT_SUR_LA_CARTE=$this->input->post('DEBUT_SUR_LA_CARTE');
      $FIN_SUR_LA_CARTE=$this->input->post('FIN_SUR_LA_CARTE');
      $ID_CARTE=$this->input->post('ID_CARTE');



      // $carte = $this->Model->getOne('membre_carte_membre',array('ID_MEMBRE'=>$id));
      // echo 'Carte '.$carte['ID_CARTE'];
        

        $this->Model->update('membre_carte_membre',array('ID_CARTE'=>$ID_CARTE),array('DEBUT_SUR_LA_CARTE'=>$DEBUT_SUR_LA_CARTE,'FIN_SUR_LA_CARTE'=>$FIN_SUR_LA_CARTE));
        $this->Model->update('membre_carte',array('ID_CARTE'=>$ID_CARTE),array('DATE_DABUT_VALIDITE'=>$DEBUT_SUR_LA_CARTE,'DATE_FIN_VALIDITE'=>$FIN_SUR_LA_CARTE));

         $message = "<div class='alert alert-success' id='message'>
                            Validit&eacute; chang&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Carte/listing'));  
      // MIS02016-0000218  14-12-2021  14-12-2022


 
    }

    public function carte_taken($ID_MEMBRE,$ID_CARTE)
    {     
    
      $this->Model->update('membre_membre_qr',array('ID_MEMBRE'=>$ID_MEMBRE),array('IS_TAKEN'=>1,'DATE_DE_PRISE'=>date('Y-m-d H:i'),'USER_TAKEN'=>$this->session->userdata('MIS_ID_USER')));

      $message = "<div class='alert alert-success' id='message'>
                            Enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Carte/index_carte/'.$ID_CARTE));  
    }


    function get_qr_code($id)
  {
    
    //  $info=$this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
     $name=date('Ymdhis').$id;
     $lien=base_url('membre/Membres/details_one/'.$id);
     $this->notifications->generateQrcode($lien,$name);
     $this->Model->insert_last_id('membre_membre_qr',array('ID_MEMBRE'=>$id,'PATH_QR_CODE'=>$name.'.png'));

     

  }


  }



?>