<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Membre extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Is_Connected();
        $this->codegenerator();
        
    }

    public function Is_Connected()
       {

       if (empty($this->session->userdata('MIS_ID_USER')))
        {
         redirect(base_url('Login/'));
        }
       }



    public function codegenerator()
    {
      // echo "MIS0100-000001<br>";
      $listmembre = $this->Model->getRequete('Select * from membre_membre WHERE CODE_AFILIATION like "" and IS_AFFILIE = 0 '); 
      foreach ($listmembre as $key) {
        $nbp = strlen($key['PROVINCE_ID']);
        $nbc = strlen($key['COMMUNE_ID']);
        // $nbid = strlen($key['ID_MEMBRE']);
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

        $nbdeja = $this->Model->getRequeteOne('Select count(*) AS NB_DEJA from membre_membre WHERE CODE_AFILIATION NOT like "" and IS_AFFILIE = 0 '); 
        $secance = $nbdeja['NB_DEJA']+1;
        $nbid = strlen($secance);
        if ($nbid == 1) {
        $nid = '000000'.$secance; 
        }
        elseif ($nbid == 2) {
        $nid = '00000'.$secance; 
        }
        elseif ($nbid == 3) {
        $nid = '0000'.$secance; 
        }
        elseif ($nbid == 4) {
        $nid = '000'.$secance; 
        }
        elseif ($nbid == 5) {
        $nid = '00'.$secance; 
        }
        elseif ($nbid == 6) {
        $nid = '0'.$secance; 
        }

        else{
        $nid = $secance; 
        }

        
        $CODE_AFILIATION =  'MIS'.$prov.''.$comu.'-'.$nid; 
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$key['ID_MEMBRE']),array('CODE_AFILIATION'=>$CODE_AFILIATION));
        

        
        // $comu = $key['COMMUNE_ID'];
        // MIS0100000001
        

      }
      // $this->load->view('Membre_Add_View',$data);
    }

    public function index()
    {
      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getList('syst_communes');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 

      
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance',array('ID_REGIME_ASSURANCE'=>2)); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      
      $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
      $todaydate = strtotime(date('Y-m-d'));
      $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      $realdate = date('d/m/Y', $realdate);
      $data['datemin'] = $realdate;
      $this->load->view('Membre_Add_View',$data);
    }


 public function get_commune()
  {
  $commune= $this->Model->getList("syst_communes",array('PROVINCE_ID'=>$this->input->post('provine_id')));
  $datas= '<option value="">-- Sélectionner --</option>';
  foreach($commune as $commun){
  $datas.= '<option value="'.$commun["COMMUNE_ID"].'">'.$commun["COMMUNE_NAME"].'</option>';
  }
  $datas.= '';
  echo $datas;
  }

public function addEmploi()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $datas=array('DESCRIPTION'=>$DESCRIPTION);
  $ID_EMPLOI = $this->Model->insert_last_id('masque_emploi',$datas);

  echo '<option value="'.$ID_EMPLOI.'">'.$this->input->post('DESCRIPTION').'</option>';

  }

  public function countmembre()
  {
    $ID_GROUPE=$this->input->post('ID_GROUPE');
    $ETUDIANT=$this->input->post('ETUDIANT');

    $nbmembre = $this->Model->record_countsome('membre_groupe_membre',array('ID_GROUPE'=>$ID_GROUPE,'STATUS'=>1));
    $resultat = '<option value="" >-- Sélectionner --</option>';
    // if ($ETUDIANT == 1) {
      $resultat.= '<option value="1">A</option>';
      $resultat.= '<option value="11">A.</option>';
      $resultat.= '<option value="2">B</option>';
      $resultat.= '<option value="9">B+</option>';
      $resultat.= '<option value="14">B.</option>';
      $resultat.= '<option value="3">C</option>';
      $resultat.= '<option value="4">D</option>';
      $resultat.= '<option value="5">E</option>';



      $resultat.= '<option value="15">B+.</option>';
      $resultat.= '<option value="16">A_</option>';
      $resultat.= '<option value="17">H</option>';
      $resultat.= '<option value="18">C.</option>';
    // }
    // else{

    //   if ($nbmembre <= 50) {
    //     $resultat.= '<option value="2">B</option>';
    //     $resultat.= '<option value="9">B+</option>';
    //     $resultat.= '<option value="3">C</option>';
    //     $resultat.= '<option value="4">D</option>';
    //     $resultat.= '<option value="5">E</option>';
    //   // echo '<option value="'.$ID_EMPLOI.'">'.$this->input->post('DESCRIPTION').'</option>';
    // }
    // else{
      // echo '<option value="'.$ID_EMPLOI.'">'.$this->input->post('DESCRIPTION').'</option>';
      // echo "Plus de 50";
        // $resultat.= '<option value="1">A</option>';
        // $resultat.= '<option value="2">B</option>';
        // $resultat.= '<option value="9">B+</option>';
        // $resultat.= '<option value="3">C</option>';
        // $resultat.= '<option value="4">D</option>';
        // $resultat.= '<option value="5">E</option>';
    // }

    // }
        echo $resultat;
    // $acategorie = $this->Model->getList('syst_categorie_assurance',array('ID_REGIME_ASSURANCE'=>1)); 
    
    // foreach ($acategorie as $value) {
    //   echo '<option value="'.$value['ID_CATEGORIE_ASSURANCE'].'">'.$value['DESCRIPTION'].'</option>';
    // }

    
    // echo $nbmembre;

  }

    public function add()
  {

    
  $NOM=$this->input->post('NOM');
  $PRENOM=$this->input->post('PRENOM');
  $CNI=$this->input->post('CNI');
  $DATE_ADHESION=$this->input->post('DATE_ADHESION');
  $CODE_AFILIATION=$this->input->post('CODE_AFILIATION');
  $TELEPHONE=$this->input->post('TELEPHONE');
  $ID_SEXE=$this->input->post('ID_SEXE');
  $COMMUNE_ID=$this->input->post('COMMUNE_ID');
  $PROVINCE_ID=$this->input->post('PROVINCE_ID');
  $ID_GROUPE_SANGUIN=$this->input->post('ID_GROUPE_SANGUIN');
  $ID_EMPLOI=$this->input->post('ID_EMPLOI');
  $ID_AGENCE=$this->input->post('ID_AGENCE');
  $DATE_NAISSANCE=$this->input->post('DATE_NAISSANCE');
  $ADRESSE=$this->input->post('ADRESSE');
  $ID_CATEGORIE_ASSURANCE=$this->input->post('ID_CATEGORIE_ASSURANCE');
  $ID_REGIME_ASSURANCE=$this->input->post('ID_REGIME_ASSURANCE');
  $DATE_DEBUT=$this->input->post('DATE_ADHESION');
  $ID_GROUPE=$this->input->post('ID_GROUPE');

  // echo $PROVINCE_ID;exit();
   $this->form_validation->set_rules('NOM', 'Nom', 'required');
   $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');
   $this->form_validation->set_rules('CNI', 'CNI', 'required');
   $this->form_validation->set_rules('ID_SEXE', 'Sexe', 'required');
   $this->form_validation->set_rules('DATE_NAISSANCE', 'Date de naissance', 'required');
   $this->form_validation->set_rules('ID_GROUPE_SANGUIN', 'Groupe Sanguin', 'required');
   $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
   $this->form_validation->set_rules('COMMUNE_ID', 'Commune', 'required');
   $this->form_validation->set_rules('TELEPHONE', 'Telephone', 'required');
   $this->form_validation->set_rules('ID_EMPLOI', 'Emploi', 'required');
   $this->form_validation->set_rules('ADRESSE', 'Adresse', 'required');



   if ($this->form_validation->run() == FALSE){
      $message = "<div class='alert alert-danger' id='message'>
                            Affili&eacute; non enregistr&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getList('syst_communes');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 

      $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
      $todaydate = strtotime(date('Y-m-d'));
      $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      $realdate = date('d/m/Y', $realdate);
      $data['datemin'] = $realdate;  

      $this->load->view('Membre_Add_View',$data);
   }
   else{

    $newDate = date("Y-m-d", strtotime($DATE_NAISSANCE));
    $datas=array('NOM'=>$NOM,
                 'PRENOM'=>$PRENOM,
                 'CNI'=>$CNI,
                 'DATE_ADHESION'=>$DATE_ADHESION,
                 'CODE_AFILIATION'=>$CODE_AFILIATION,
                 'TELEPHONE'=>$TELEPHONE,
                 'ID_SEXE'=>$ID_SEXE,
                 'COMMUNE_ID'=>$COMMUNE_ID,
                 'PROVINCE_ID'=>$PROVINCE_ID,
                 'ID_GROUPE_SANGUIN'=>$ID_GROUPE_SANGUIN,
                 'ID_EMPLOI'=>$ID_EMPLOI,
                 'ID_AGENCE'=>$ID_AGENCE,
                 'DATE_NAISSANCE'=>$newDate,
                 'ADRESSE'=>$ADRESSE,
                );

    $ID_MEMBRE = $this->Model->insert_last_id('membre_membre',$datas);

    $datagroupe=array('ID_MEMBRE'=>$ID_MEMBRE,
                 'ID_GROUPE'=>$ID_GROUPE,
                 'DATE_DEBUT'=>$DATE_DEBUT
                );
    $this->Model->insert_last_id('membre_groupe_membre',$datagroupe);

    $dataass=array('ID_MEMBRE'=>$ID_MEMBRE,
                 'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
                 'ID_REGIME_ASSURANCE'=>$ID_REGIME_ASSURANCE,
                 'DATE_DEBUT'=>$DATE_DEBUT
                );
    $this->Model->insert_last_id('membre_assurances',$dataass);









        $repPhotoo =FCPATH.'/uploads/image_membre';
        $code=uniqid();
        $logo_societe = $_FILES['URL_PHOTO']['name'];
        $config['upload_path'] ='./uploads/image_membre/';
        $config['allowed_types'] = '*';
        $test = explode('.', $logo_societe);
        $ext = end($test);
        $name = $code.'_membre.' . $ext;
        $config['file_name'] =$name;
        if(!is_dir($repPhotoo)) //create the folder if it does not already exists   
        {
            mkdir($repPhotoo,0777,TRUE);
                                                                      
        }
        $this->upload->initialize($config);
        $this->upload->do_upload('URL_PHOTO');
        $image_name_main=$config['file_name'];
        $data_image=$this->upload->data();

        $data_pict=array('URL_PHOTO'=>$image_name_main);
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$data_pict);


    // print_r($dataass);

    // exit();
    $message = "<div class='alert alert-success' id='message'>
                            Affili&eacute; enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Membre/listing'));    

   }
   

  }

     public function listing()
    {

      $IS_AFFILIE = $this->input->post('IS_AFFILIE');
      if ($IS_AFFILIE == 1) {
        $condi1 = ' AND membre_membre.IS_AFFILIE = 1 ';
        $data['IS_AFFILIE'] = $this->input->post('IS_AFFILIE');
      }
      else if ($IS_AFFILIE == 0) {
        $condi1 = ' AND membre_membre.IS_AFFILIE = 0 ';
        $data['IS_AFFILIE'] = $this->input->post('IS_AFFILIE');
      }
      else{
        $condi1 = '';
        $data['IS_AFFILIE'] = 2;
      }


      
      $DATE_ADHESION = $this->input->post('DATE_ADHESION');
      if ($DATE_ADHESION != null) {
        $condi2 = ' AND membre_membre.DATE_ADHESION like "%'.$DATE_ADHESION.'%" ';
        $data['DATE_ADHESION'] = $this->input->post('DATE_ADHESION');
      }
      else{
        $condi2 = '';
        $data['DATE_ADHESION'] = NULL;
      }


      

      $ID_SEXE = $this->input->post('ID_SEXE');
      if ($ID_SEXE != null) {
        $condi3 = ' AND membre_membre.ID_SEXE = '.$ID_SEXE.' ';
        $data['ID_SEXE'] = $this->input->post('ID_SEXE');
      }
      else{
        $condi3 = '';
        $data['ID_SEXE'] = NULL;
      }


      
      $ID_CATEGORIE_ASSURANCE = $this->input->post('ID_CATEGORIE_ASSURANCE');
      if ($ID_CATEGORIE_ASSURANCE != null) {
        $condi4 = ' AND membre_membre.ID_CATEGORIE_ASSURANCE = '.$ID_CATEGORIE_ASSURANCE.' ';
        $data['ID_CATEGORIE_ASSURANCE'] = $this->input->post('ID_CATEGORIE_ASSURANCE');
      }
      else{
        $condi4 = '';
        $data['ID_CATEGORIE_ASSURANCE'] = NULL;
      }


      
      $ID_GROUPE = $this->input->post('ID_GROUPE');
      if ($ID_GROUPE != null) {
        $condi5 = ' AND membre_groupe_membre.ID_GROUPE = '.$ID_GROUPE.' ';
        $data['ID_GROUPE'] = $this->input->post('ID_GROUPE');
      }
      else{
        $condi5 = '';
        $data['ID_GROUPE'] = NULL;
      }


      $resultat=$this->Model->getRequete('SELECT membre_membre.ID_MEMBRE,CODE_AFILIATION, NOM, PRENOM, CNI, DATE_ADHESION, membre_membre.STATUS, IS_AFFILIE FROM `membre_membre` JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE 1 '.$condi1.' '.$condi2.' '.$condi3.' '.$condi4.' '.$condi5.' ');
      // $resultat=$this->Model->getRequete('SELECT ID_MEMBRE,CODE_AFILIATION, NOM, PRENOM, CNI, DATE_ADHESION, STATUS, IS_AFFILIE FROM `membre_membre` WHERE IS_AFFILIE = 0');
      //WHERE reservation_chambre.STATUT_RESERV_ID=1
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

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

          if ($key['IS_AFFILIE'] == 1) {
            $aff = 'Oui';
          }
          else{
            $aff = 'Non';
          }

          $nban = $this->Model->getRequeteOne('SELECT count(*) AS NB_AYANT FROM `membre_membre` WHERE CODE_PARENT = '.$key['ID_MEMBRE'].' ');
          $newDate = date("d-m-Y", strtotime($key['DATE_ADHESION']));
          $chambr=array();
          $chambr[]=$key['NOM'].' '.$key['PRENOM'];
          $chambr[]=$key['CODE_AFILIATION'];
          $chambr[]=$key['CNI'];  
          $chambr[]=$newDate;  
          $chambr[]=$nban['NB_AYANT'];  
          $chambr[]=$stat;
          // if ($resultatlast['ID_MEMBRE'] == $key['ID_MEMBRE']) {
            $todel = '<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#supprimermembre'.$key['ID_MEMBRE'].'"> Supprimer la personne </a> </li>';
          // }
          // else{
          //   $todel = '';
          // }
          $chambr[]='<div class="modal fade" id="supprimermembre'.$key['ID_MEMBRE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Suppression du membre</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><b>Mr/Mme ,  Voulez-vous vraiment supprimer de manière définitive ce membre ('.$key['NOM'].' '.$key['PRENOM'].')?</b><br>Cette action est irréversible</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="'.base_url('membre/Membre/supprimer/'.$key['ID_MEMBRE']).'" class="btn '.$col.'">Supprimer</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="desactcat'.$key['ID_MEMBRE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key['NOM'].' '.$key['PRENOM'].')?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="'.base_url('membre/Membre/'.$fx.'/'.$key['ID_MEMBRE']).'" class="btn '.$col.'">'.$titr.'</a>
      </div>
    </div>
  </div>
</div>

          <div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="'.base_url('membre/Membre/details/'.$key['ID_MEMBRE']).'"> Détail </a> </li>
                    
                    <li><a class="dropdown-item" href="'.base_url('membre/Membre/index_update/'.$key['ID_MEMBRE']).'"> Modifier</a> </li>
                    <li><a class="dropdown-item" href="'.base_url('membre/Membre/ayant_droits/'.$key['ID_MEMBRE']).'"> Ajouter/Enlever ayant droit </a> </li>
                    <li><a class="dropdown-item" href="'.base_url('membre/Membre/assurances_index/'.$key['ID_MEMBRE']).'"> Modifier la Categorie d\'assurance </a> </li>
                    
                    
                    '.$todel.'
                    </ul>
                  </div>';
         // <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_MEMBRE'].'"> '.$titr.' </a> </li>
                          // <li><a class="dropdown-item" href="'.base_url('membre/Membre/index_update/'.$key['ID_MEMBRE']).'"> Ajouter/Enlever Groupe </a> </li>
                  // <li><a class="dropdown-item" href="'.base_url('membre/Carte/index_carte/'.$key['ID_MEMBRE']).'"> Cartes PVC </a> </li>
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Nom','Code','CNI','Date adhesion','Ayant Droit','Status','Option'));
       
        $data['chamb']=$tabledata;
        $data['title']=' Affili&eacute;';
        $data['stitle']=' Affili&eacute;';
        $data['anne_aff']=$this->Model->getRequete("SELECT DISTINCT YEAR(membre_membre.DATE_ADHESION) AS DATE_ADHESION FROM `membre_membre`");
        $data['sexe_nom'] = $this->Model->getList('syst_sexe'); 
        $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
        $data['groupe'] = $this->Model->getList('membre_groupe'); 


        $this->load->view('Membre_List_View',$data);

    }

    

    public function index_update($id)
    {

      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
      

      $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
      $todaydate = strtotime(date('Y-m-d'));
      $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      $realdate = date('d/m/Y', $realdate);
      $data['datemin'] = $realdate;


      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
      $todaydates = strtotime(date($selected['DATE_NAISSANCE']));
      $realdates = date('d/m/Y', $todaydates);
      // echo $realdates;
      // exit();

      $data['selecteds'] = $realdates;

      $this->load->view('Membre_Update_View',$data);
    }


     public function update()
  {

  
  $NOM=$this->input->post('NOM');
  $PRENOM=$this->input->post('PRENOM');
  $CNI=$this->input->post('CNI');
  $DATE_ADHESION=$this->input->post('DATE_ADHESION');
  $CODE_AFILIATION=$this->input->post('CODE_AFILIATION');
  $TELEPHONE=$this->input->post('TELEPHONE');
  $ID_SEXE=$this->input->post('ID_SEXE');
  $COMMUNE_ID=$this->input->post('COMMUNE_ID');
  $PROVINCE_ID=$this->input->post('PROVINCE_ID');
  $ID_GROUPE_SANGUIN=$this->input->post('ID_GROUPE_SANGUIN');
  $ID_EMPLOI=$this->input->post('ID_EMPLOI');
  $ID_AGENCE=$this->input->post('ID_AGENCE');
  $DATE_NAISSANCE=$this->input->post('DATE_NAISSANCE');
  $ADRESSE=$this->input->post('ADRESSE');
  $DATE_DEBUT=$this->input->post('DATE_ADHESION');
  $ID_MEMBRE=$this->input->post('ID_MEMBRE');


   $this->form_validation->set_rules('NOM', 'Nom', 'required');
   $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');
   $this->form_validation->set_rules('TELEPHONE', 'Telephone', 'required');
   $this->form_validation->set_rules('ID_SEXE', 'Sexe', 'required');
   $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
   $this->form_validation->set_rules('COMMUNE_ID', 'Commune', 'required');
   $this->form_validation->set_rules('DATE_NAISSANCE', 'Date de naissance', 'required');

   if ($this->form_validation->run() == FALSE){
      $message = "<div class='alert alert-danger' id='message'>
                            Affili&eacute; non modifi&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  


      $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
      $todaydate = strtotime(date('Y-m-d'));
      $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      $realdate = date('d/m/Y', $realdate);
      $data['datemin'] = $realdate;

      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  
      $todaydates = strtotime(date($selected['DATE_NAISSANCE']));
      $realdates = date('d/m/Y', $todaydates);
      $data['selecteds'] = $realdates;

      $this->load->view('Membre_Update_View',$data);
   }
   else{

    $datas=array('NOM'=>$NOM,
                 'PRENOM'=>$PRENOM,
                 'CNI'=>$CNI,
                 'DATE_ADHESION'=>$DATE_ADHESION,
                 'CODE_AFILIATION'=>$CODE_AFILIATION,
                 'TELEPHONE'=>$TELEPHONE,
                 'ID_SEXE'=>$ID_SEXE,
                 'COMMUNE_ID'=>$COMMUNE_ID,
                 'PROVINCE_ID'=>$PROVINCE_ID,
                 'ID_GROUPE_SANGUIN'=>$ID_GROUPE_SANGUIN,
                 'ID_EMPLOI'=>$ID_EMPLOI,
                 'ID_AGENCE'=>$ID_AGENCE,
                 'DATE_NAISSANCE'=>$DATE_NAISSANCE,
                 'ADRESSE'=>$ADRESSE,
                );
    // echo "<pre>";
    // print_r($datas);
    $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$datas);

        $repPhotoo =FCPATH.'/uploads/image_membre';
        $code=uniqid();
        $logo_societe = $_FILES['URL_PHOTO']['name'];

        if ($logo_societe != null) {
        $config['upload_path'] ='./uploads/image_membre/';
        $config['allowed_types'] = '*';
        $test = explode('.', $logo_societe);
        $ext = end($test);
        $name = $code.'_membre.' . $ext;
        $config['file_name'] =$name;
        if(!is_dir($repPhotoo)) //create the folder if it does not already exists   
        {
            mkdir($repPhotoo,0777,TRUE);                                                  
        }
        $this->upload->initialize($config);
        $this->upload->do_upload('URL_PHOTO');
        $image_name_main=$config['file_name'];
        $data_image=$this->upload->data();
        $data_pict=array('URL_PHOTO'=>$image_name_main);
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$data_pict);
        }
        
        


    $message = "<div class='alert alert-success' id='message'>
                            Affili&eacute; modifi&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Membre/listing'));    

   }

  }


  public function details($id)
    {

      

      if (empty($this->Model->getOne('membre_membre_qr',array('ID_MEMBRE'=>$id)))) {
      $this->get_qr_code($id);

      }

      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
      $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$id,'IS_AFFILIE'=>1));

      $aff = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$id,'IS_AFFILIE'=>1));
      foreach ($aff as $affilies) {
        if (empty($this->Model->getOne('membre_membre_qr',array('ID_MEMBRE'=>$affilies['ID_MEMBRE'])))) {
      $this->get_qr_code($affilies['ID_MEMBRE']);    
        }
      }

      $this->load->view('Membre_Details_View',$data);
    }


  
  public function index_update_ayant($id)
    {

      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  



      $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
      $todaydate = strtotime(date('Y-m-d'));
      $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      $realdate = date('d/m/Y', $realdate);
      $data['datemin'] = $realdate;


      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
      $todaydates = strtotime(date($selected['DATE_NAISSANCE']));
      $realdates = date('d/m/Y', $todaydates);

      $data['selecteds'] = $realdates;
      $this->load->view('Membre_Update_Ayant_View',$data);
    }


       public function update_ayant_droit()
  {

  
  $NOM=$this->input->post('NOM');
  $PRENOM=$this->input->post('PRENOM');
  $CNI=$this->input->post('CNI');
  $DATE_ADHESION=$this->input->post('DATE_ADHESION');
  $CODE_AFILIATION=$this->input->post('CODE_AFILIATION');
  $TELEPHONE=$this->input->post('TELEPHONE');
  $ID_SEXE=$this->input->post('ID_SEXE');
  $COMMUNE_ID=$this->input->post('COMMUNE_ID');
  $PROVINCE_ID=$this->input->post('PROVINCE_ID');
  $ID_GROUPE_SANGUIN=$this->input->post('ID_GROUPE_SANGUIN');
  $ID_EMPLOI=$this->input->post('ID_EMPLOI');
  $ID_AGENCE=$this->input->post('ID_AGENCE');
  $DATE_NAISSANCE=$this->input->post('DATE_NAISSANCE');
  $ADRESSE=$this->input->post('ADRESSE');
  $DATE_DEBUT=$this->input->post('DATE_ADHESION');
  $ID_MEMBRE=$this->input->post('ID_MEMBRE');
  $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE)); 

   $this->form_validation->set_rules('NOM', 'Nom', 'required');
   $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');
   $this->form_validation->set_rules('ID_SEXE', 'Sexe', 'required');
   $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
   $this->form_validation->set_rules('COMMUNE_ID', 'Nom', 'required');
   $this->form_validation->set_rules('ID_GROUPE_SANGUIN', 'Nom', 'required');

   if ($this->form_validation->run() == FALSE){
      $message = "<div class='alert alert-danger' id='message'>
                            Affili&eacute; non modifi&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  


      $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
      $todaydate = strtotime(date('Y-m-d'));
      $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      $realdate = date('d/m/Y', $realdate);
      $data['datemin'] = $realdate;


      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  
      $todaydates = strtotime(date($selected['DATE_NAISSANCE']));
      $realdates = date('d/m/Y', $todaydates);
      $data['selecteds'] = $realdates;

      $this->load->view('Membre_Update_Ayant_View',$data);
   }
   else{

    $datas=array('NOM'=>$NOM,
                 'PRENOM'=>$PRENOM,
                 'CNI'=>$CNI,
                 'DATE_ADHESION'=>$DATE_ADHESION,
                 'CODE_AFILIATION'=>$CODE_AFILIATION,
                 'TELEPHONE'=>$TELEPHONE,
                 'ID_SEXE'=>$ID_SEXE,
                 'COMMUNE_ID'=>$COMMUNE_ID,
                 'PROVINCE_ID'=>$PROVINCE_ID,
                 'ID_GROUPE_SANGUIN'=>$ID_GROUPE_SANGUIN,
                 'ID_EMPLOI'=>$ID_EMPLOI,
                 'ID_AGENCE'=>$ID_AGENCE,
                 'DATE_NAISSANCE'=>$DATE_NAISSANCE,
                 'ADRESSE'=>$ADRESSE,
                );
    // echo "<pre>";
    // print_r($datas);
    $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$datas);

        $repPhotoo =FCPATH.'/uploads/image_membre';
        $code=uniqid();
        $logo_societe = $_FILES['URL_PHOTO']['name'];

        if ($logo_societe != null) {
        $config['upload_path'] ='./uploads/image_membre/';
        $config['allowed_types'] = '*';
        $test = explode('.', $logo_societe);
        $ext = end($test);
        $name = $code.'_membre.' . $ext;
        $config['file_name'] =$name;
        if(!is_dir($repPhotoo)) //create the folder if it does not already exists   
        {
            mkdir($repPhotoo,0777,TRUE);                                                  
        }
        $this->upload->initialize($config);
        $this->upload->do_upload('URL_PHOTO');
        $image_name_main=$config['file_name'];
        $data_image=$this->upload->data();
        $data_pict=array('URL_PHOTO'=>$image_name_main);
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE),$data_pict);
        }
        
        


    $message = "<div class='alert alert-success' id='message'>
                            Affili&eacute; modifi&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      // redirect(base_url('membre/Membre/listing'));    
    redirect(base_url('membre/Membre/ayant_droits/'.$selected['CODE_PARENT']));    

   }

  }


  public function ayant_droits($id)
    {

      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
      $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$id,'IS_AFFILIE'=>1));

      $conf = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $data['agemin'] = $conf['AGE_MINIMALE_AFFILIE'];
      $todaydate = strtotime(date('Y-m-d'));
      $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      $realdate = date('d/m/Y', $realdate);
      $data['datemin'] = $realdate;
      
      $this->load->view('Membre_Ayant_Droits_View',$data);
    }

    

    public function ayant_droits_add()
    {

     
  $NOM=$this->input->post('NOM');
  $PRENOM=$this->input->post('PRENOM');
  $CNI=$this->input->post('CNI');
  $DATE_ADHESION=$this->input->post('DATE_ADHESION');
  $CODE_AFILIATION=$this->input->post('CODE_AFILIATION');
  $TELEPHONE=$this->input->post('TELEPHONE');
  $ID_SEXE=$this->input->post('ID_SEXE');
  $ID_GROUPE_SANGUIN=$this->input->post('ID_GROUPE_SANGUIN');
  $DATE_NAISSANCE=$this->input->post('DATE_NAISSANCE');
  $ADRESSE=$this->input->post('ADRESSE');
  $DATE_DEBUT=$this->input->post('DATE_ADHESION');
  $ID_MEMBRE=$this->input->post('ID_MEMBRE');
  $IS_CONJOINT=$this->input->post('IS_CONJOINT');
  


   $this->form_validation->set_rules('NOM', 'Nom', 'required');
   $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');
   $this->form_validation->set_rules('ID_SEXE', 'Sexe', 'required');
   $this->form_validation->set_rules('ID_GROUPE_SANGUIN', 'Groupe Sanguin', 'required');
   $this->form_validation->set_rules('DATE_NAISSANCE', 'Date de naissance', 'required');
   $this->form_validation->set_rules('IS_CONJOINT', 'Conjoint', 'required');
   // $this->form_validation->set_rules('URL_PHOTO', 'Photo', 'required');


   if ($this->form_validation->run() == FALSE){
      $message = "<div class='alert alert-danger' id='message'>
                            Ayant droit non enregistr&eacute;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance'); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));  
      $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$ID_MEMBRE,'IS_AFFILIE'=>1));
      $this->load->view('Membre_Ayant_Droits_View',$data);
   }
   else{
  $parentmembre = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRE));
  $COMMUNE_ID=$parentmembre['COMMUNE_ID'];
  $PROVINCE_ID=$parentmembre['PROVINCE_ID'];
  $ID_EMPLOI=$parentmembre['ID_EMPLOI'];
  $ID_AGENCE=$parentmembre['ID_AGENCE'];
  
  
    $datas=array('NOM'=>$NOM,
                 'PRENOM'=>$PRENOM,
                 'CNI'=>$CNI,
                 'DATE_ADHESION'=>$DATE_ADHESION,
                 'CODE_AFILIATION'=>$CODE_AFILIATION,
                 'TELEPHONE'=>$TELEPHONE,
                 'ID_SEXE'=>$ID_SEXE,
                 'COMMUNE_ID'=>$COMMUNE_ID,
                 'PROVINCE_ID'=>$PROVINCE_ID,
                 'ID_GROUPE_SANGUIN'=>$ID_GROUPE_SANGUIN,
                 'ID_EMPLOI'=>$ID_EMPLOI,
                 'ID_AGENCE'=>$ID_AGENCE,
                 'DATE_NAISSANCE'=>$DATE_NAISSANCE,
                 'ADRESSE'=>$ADRESSE,
                 'IS_AFFILIE'=>1,
                 'CODE_PARENT'=>$ID_MEMBRE,
                 'IS_CONJOINT'=>$IS_CONJOINT
                );
    // echo "<pre>";
    // print_r($datas);
    $ID_MEMBRES = $this->Model->insert_last_id('membre_membre',$datas);

    


    $assumembre = $this->Model->getList('membre_assurances',array('ID_MEMBRE'=>$ID_MEMBRE,'STATUS'=>1));
    foreach ($assumembre as $keys) {
    $ID_CATEGORIE_ASSURANCE=$keys['ID_CATEGORIE_ASSURANCE'];
    $ID_REGIME_ASSURANCE=$keys['ID_REGIME_ASSURANCE'];

    $dataass=array('ID_MEMBRE'=>$ID_MEMBRES,
                 'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
                 'ID_REGIME_ASSURANCE'=>$ID_REGIME_ASSURANCE,
                 'DATE_DEBUT'=>$DATE_DEBUT
                );
    $this->Model->insert_last_id('membre_assurances',$dataass);
    // print_r($dataass);
    }

    $groupmembre = $this->Model->getList('membre_groupe_membre',array('ID_MEMBRE'=>$ID_MEMBRE,'STATUS'=>1));
    foreach ($groupmembre as $keys) {
    $ID_GROUPE=$keys['ID_GROUPE'];
    $datagroupe=array('ID_MEMBRE'=>$ID_MEMBRES,
                 'ID_GROUPE'=>$ID_GROUPE,
                 'DATE_DEBUT'=>$DATE_DEBUT
                );
    $this->Model->insert_last_id('membre_groupe_membre',$datagroupe);

    // print_r($datagroupe);
    }
    
    

        $repPhotoo =FCPATH.'/uploads/image_membre';
        $code=uniqid();
        $logo_societe = $_FILES['URL_PHOTO']['name'];
        $config['upload_path'] ='./uploads/image_membre/';
        $config['allowed_types'] = '*';
        $test = explode('.', $logo_societe);
        $ext = end($test);
        $name = $code.'_membre.' . $ext;
        $config['file_name'] =$name;
        if(!is_dir($repPhotoo)) //create the folder if it does not already exists   
        {
            mkdir($repPhotoo,0777,TRUE);                                                           
        }
        $this->upload->initialize($config);
        $this->upload->do_upload('URL_PHOTO');
        $image_name_main=$config['file_name'];
        $data_image=$this->upload->data();

        $data_pict=array('URL_PHOTO'=>$image_name_main);
        $this->Model->update('membre_membre',array('ID_MEMBRE'=>$ID_MEMBRES),$data_pict);
   
    // exit();
    $message = "<div class='alert alert-success' id='message'>
                            Ayant droit enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Membre/ayant_droits/'.$ID_MEMBRE));    

   }
    }


  // public function desactiver($id)
  //   {
  //     $this->Model->update('masque_stucture_sanitaire',array('ID_STRUCTURE'=>$id),array('STATUS'=>0));
  //     $message = "<div class='alert alert-success' id='message'>
  //                           Stucture sanitaire désactivé avec succés
  //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
  //                     </div>";
  //     $this->session->set_flashdata(array('message'=>$message));
  //     redirect(base_url('saisie/Structure_Sanitaire/listing')); 
  //   }

  // public function reactiver($id)
  //   {
  //     $this->Model->update('masque_stucture_sanitaire',array('ID_STRUCTURE'=>$id),array('STATUS'=>1));
  //     $message = "<div class='alert alert-success' id='message'>
  //                           Stucture sanitaire Réactivé avec succés
  //                           <button type='button' class='close' data-dismiss='alert'>&times;</button>
  //                     </div>";
  //     $this->session->set_flashdata(array('message'=>$message));
  //     redirect(base_url('saisie/Structure_Sanitaire/listing')); 
  //   }

    public function desactiver_ayant_droit($id)
    {
      $parentmembre = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
      $this->Model->update('membre_groupe_membre',array('ID_MEMBRE'=>$id),array('STATUS'=>0,'DATE_FIN'=>date('Y-m-d H:i')));
      $this->Model->update('membre_assurances',array('ID_MEMBRE'=>$id),array('STATUS'=>0,'DATE_FIN'=>date('Y-m-d H:i')));
      $this->Model->update('membre_membre',array('ID_MEMBRE'=>$id),array('STATUS'=>0));
      // membre_groupe_membre DATE_FIN
      // membre_assurances
      // membre_membre
      $message = "<div class='alert alert-success' id='message'>
                            Ayant droit désactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      // redirect(base_url('saisie/Structure_Sanitaire/listing')); 
      redirect(base_url('membre/Membre/ayant_droits/'.$parentmembre['CODE_PARENT']));    

    }

    public function supprimer($id)
    {

      // echo $id;

      $membre = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
      $groupe = $this->Model->getOne('membre_groupe_membre',array('ID_MEMBRE'=>$id));
      $affilie = $this->Model->getRequete('SELECT * FROM membre_membre WHERE CODE_PARENT = '.$membre['ID_MEMBRE'].'');

      // echo 'First '.$membre['ID_MEMBRE'].'<br>';
      foreach ($affilie as $keys) {
        $groupeaf = $this->Model->getOne('membre_groupe_membre',array('ID_MEMBRE'=>$keys['ID_MEMBRE']));
        // echo $keys['ID_MEMBRE'].' - '.$groupeaf['ID_GROUPE_MEMBRE'].'<br>';


        $this->Model->delete('membre_membre',array('ID_MEMBRE'=>$keys['ID_MEMBRE']));
        $this->Model->delete('membre_groupe_membre',array('ID_MEMBRE'=>$keys['ID_MEMBRE']));
      }

      $carte = $this->Model->getOne('membre_carte_membre',array('ID_MEMBRE'=>$id));
      // echo 'Carte '.$carte['ID_CARTE'];
        
        $this->Model->delete('membre_carte_membre',array('ID_CARTE'=>$carte['ID_CARTE']));
        $this->Model->delete('membre_carte',array('ID_CARTE'=>$carte['ID_CARTE']));
        $this->Model->delete('membre_membre',array('ID_MEMBRE'=>$id));
        $this->Model->delete('membre_groupe_membre',array('ID_MEMBRE'=>$id));

    

    $message = "<div class='alert alert-success' id='message'>
                            Affili&eacute; effac&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Membre/listing'));  

      
      

      
      


    }


    public function assurances_index($id)
    {

      $data['title']=' Affili&eacute;';
      $data['stitle']=' Affili&eacute;';
      $selected = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id)); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['commune'] = $this->Model->getListOrdertwo('syst_communes',array('PROVINCE_ID'=>$selected['PROVINCE_ID']),'COMMUNE_NAME');
      $data['type_str'] = $this->Model->getList('syst_couverture_structure'); 
      $data['groupesanguin'] = $this->Model->getList('syst_groupe_sanguin'); 
      $data['emploi'] = $this->Model->getList('masque_emploi'); 
      $data['agence'] = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$this->session->userdata('MIS_ID_AGENCE'))); 
      $data['aregime'] = $this->Model->getList('syst_regime_assurance'); 
      $data['acategorie'] = $this->Model->getList('syst_categorie_assurance',array('ID_REGIME_ASSURANCE'=>1)); 
      $data['agroupe'] = $this->Model->getList('membre_groupe'); 
      $data['selected'] = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));  
      $data['groupmembre'] = $this->Model->getList('membre_membre',array('CODE_PARENT'=>$id,'IS_AFFILIE'=>1));
      $data['aassurances'] = $this->Model->getRequete('SELECT * FROM membre_assurances LEFT JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_assurances.ID_CATEGORIE_ASSURANCE WHERE membre_assurances.ID_MEMBRE = '.$id.' ');
      $this->load->view('Membre_Assurance_Index_View',$data);
    }


    
    public function update_assurances()
    {
      
      $ID_MEMBRE_ASSURANCE=$this->input->post('ID_MEMBRE_ASSURANCE');
      $ID_CATEGORIE_ASSURANCE=$this->input->post('ID_CATEGORIE_ASSURANCE');
      $DATE_DEBUT=$this->input->post('DATE_DEBUT');
      // echo $ID_MEMBRE_ASSURANCE.'<br>';
      // echo $ID_CATEGORIE_ASSURANCE.'<br>';
      // echo $DATE_DEBUT.'<br>';

    // $datax=array('ID_MEMBRE'=>$ID_MEMBRE,
    //              'ID_CATEGORIE_ASSURANCE'=>$ID_CATEGORIE_ASSURANCE,
    //              'ID_REGIME_ASSURANCE'=>$ID_REGIME_ASSURANCE,
    //              'DATE_DEBUT'=>$DATE_DEBUT
    //             );
    $donneab = $this->Model->getOne('membre_assurances',array('ID_MEMBRE_ASSURANCE'=>$ID_MEMBRE_ASSURANCE));

    // print_r($donneab);


    $allmem=$this->Model->getList('membre_membre',array('IS_AFFILIE'=>1,'CODE_PARENT'=>$donneab['ID_MEMBRE']));
    // echo "<pre>";
    // print_r($allmem);

    foreach ($allmem as $key) {
      $this->Model->update('membre_assurances',array('ID_MEMBRE'=>$key['ID_MEMBRE'],'ID_CATEGORIE_ASSURANCE'=>$donneab['ID_CATEGORIE_ASSURANCE']),array('ID_CATEGORIE_ASSURANCE'=>$this->input->post('ID_CATEGORIE_ASSURANCE')));
    }

    $this->Model->update('membre_assurances',array('ID_MEMBRE'=>$donneab['ID_MEMBRE'],'ID_CATEGORIE_ASSURANCE'=>$donneab['ID_CATEGORIE_ASSURANCE']),array('ID_CATEGORIE_ASSURANCE'=>$this->input->post('ID_CATEGORIE_ASSURANCE')));


    $cart = $this->Model->getOne('membre_carte_membre',array('ID_MEMBRE'=>$donneab['ID_MEMBRE']));

    $this->Model->update('membre_carte',array('ID_CARTE'=>$cart['ID_CARTE']),array('ID_CATEGORIE_ASSURANCE'=>$this->input->post('ID_CATEGORIE_ASSURANCE')));



    $message = "<div class='alert alert-success' id='message'>
                            Categorie modifié avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('membre/Membre/listing'));  

    }


    function get_qr_code($id)
  {
    
     $info=$this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$id));
     $name=date('Ymdhis').$id;
     $lien=base_url('membre/Membres/details_one/'.$id);
     $this->notifications->generateQrcode($lien,$name);
     $this->Model->insert_last_id('membre_membre_qr',array('ID_MEMBRE'=>$id,'PATH_QR_CODE'=>$name.'.png'));

     

  }



}
?>