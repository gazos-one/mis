<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Carte_Prise extends CI_Controller {

    public function __construct() {
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

    $data['title']=' Carte prise';
    $data['stitle']=' Carte prise';
    $this->load->view('Carte_Prise_List_View',$data);

    }

     public function liste()
    {

      $query_principal='SELECT membre_membre.NOM, membre_membre.PRENOM, membre_groupe.NOM_GROUPE, IF(membre_membre.IS_AFFILIE = 0, "Oui", "Non") AS AFFILIE, membre_membre_qr.DATE_DE_PRISE, membre_membre.CODE_AFILIATION FROM `membre_membre_qr` JOIN membre_membre ON membre_membre_qr.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE LEFT JOIN membre_groupe ON membre_groupe_membre.ID_GROUPE = membre_groupe.ID_GROUPE WHERE 1 AND membre_membre_qr.IS_TAKEN = 1';

       $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $limit = 'LIMIT 0,10';
        if ($_POST['length'] != -1) {
        $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
 
        $order_column=array("membre_membre.NOM","membre_membre.PRENOM","membre_membre_qr.DATE_DE_PRISE","membre_membre.CODE_AFILIATION","membre_groupe.NOM_GROUPE");

         $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY membre_membre_qr.ID_MEMBRE_QR   ASC';
 
        $search = !empty($_POST['search']['value']) ? (' AND (membre_membre.NOM LIKE "%' . $var_search . '%" OR membre_membre.PRENOM LIKE "%' . $var_search . '%" OR membre_membre_qr.DATE_DE_PRISE LIKE "%' . $var_search . '%" OR membre_membre.CODE_AFILIATION LIKE "%' . $var_search . '%" OR membre_groupe.NOM_GROUPE LIKE "%' . $var_search . '%")') :'';
 
      $critaire = '';
    
       $groupby='';
 
       $query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
       $query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
       $resultat = $this->Model->datatable($query_secondaire);
     
      

     

      $tabledata=array();
      
      foreach ($resultat as $key) 
         {
          
          $chambr=array();
          $chambr[]=$key->NOM.' '.$key->PRENOM;
          $chambr[]=$key->CODE_AFILIATION;
          $chambr[]=$key->AFFILIE;
          $chambr[]=$key->NOM_GROUPE;
          $newDatedebut = date("d-m-Y", strtotime($key->DATE_DE_PRISE));
          $chambr[]=$newDatedebut;  
          
                          
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


  }



?>