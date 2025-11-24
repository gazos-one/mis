<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration_Cotisation extends CI_Controller {

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
      $data['title']='Configuration Cotisation';
      $data['stitle']='Configuration Cotisation';
      $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 
      $data['categorie'] = $this->Model->getListOrdertwo('cotisation_categorie',array(),'DESCRIPTION'); 

      
      
      // $todaydate = strtotime(date('Y-m-d'));
      // $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      // $realdate = date('d/m/Y', $realdate);
      // $data['datemin'] = $realdate;
      $this->load->view('Configuration_Cotisation_Add_View',$data);
    }

public function addCategorie()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $datas=array('DESCRIPTION'=>$DESCRIPTION);
  $ID_EMPLOI = $this->Model->insert_last_id('cotisation_categorie',$datas);

  echo '<option value="'.$ID_EMPLOI.'">'.$this->input->post('DESCRIPTION').'</option>';

  }



public function addPeriode()
  {

  $DESCRIPTION=$this->input->post('DESCRIPTION');
  $NB_JOURS=$this->input->post('NB_JOURS');
  $datas=array('DESCRIPTION'=>$DESCRIPTION,'NB_JOURS'=>$NB_JOURS);
  $ID_PERIODE_COTISATION = $this->Model->insert_last_id('cotisation_periode',$datas);

  echo '<option value="'.$ID_PERIODE_COTISATION.'">'.$this->input->post('DESCRIPTION').'</option>';

  }


  public function add()
  {
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $ID_PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');

  $this->Model->insert_last_id('cotisation_montant_cotisation',array('MONTANT_COTISATION'=>$MONTANT_COTISATION, 'ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_PERIODE_COTISATION'=>$ID_PERIODE_COTISATION));

  $message = "<div class='alert alert-success' id='message'>
                            Cotisation enregistr&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Configuration_Cotisation/listing'));    

  }

  public function listing()
  {
    

      $resultat=$this->Model->getRequete('SELECT cotisation_montant_cotisation.ID_MONTANT_COTISATION, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_categorie.DESCRIPTION AS DESC_CATEGORIE, cotisation_periode.DESCRIPTION AS DESC_PERIODE, cotisation_periode.NB_JOURS, cotisation_montant_cotisation.IS_ACTIF, IF(cotisation_montant_cotisation.IS_ACTIF=1, "Actif", "Innactif") AS STATUS_COTISATION FROM cotisation_montant_cotisation JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_montant_cotisation.ID_CATEGORIE_COTISATION JOIN cotisation_periode ON cotisation_periode.ID_PERIODE_COTISATION = cotisation_montant_cotisation.ID_PERIODE_COTISATION WHERE 1');
      // $resultatlast=$this->Model->getRequeteOne('SELECT ID_MEMBRE FROM `membre_membre` WHERE IS_AFFILIE = 0 order by ID_MEMBRE DESC limit 1');
      //WHERE reservation_chambre.STATUT_RESERV_ID=1
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          if ($key['IS_ACTIF'] == 1) {
            // $stat = 'Actif';
            $fx = 'desactiver';
            $col = 'btn-danger';
            $titr = 'Désactiver';
            $stitr = 'voulez-vous désactiver la cotisation ';
            $bigtitr = 'Désactivation de la cotisation';
          }
          else{
            // $stat = 'Innactif';
            $fx = 'reactiver';
            $col = 'btn-success';
            $titr = 'Réactiver';
            $stitr = 'voulez-vous réactiver la cotisation ';
            $bigtitr = 'Réactivation de la cotisation';
          }

         

          $chambr=array();
          $chambr[]=$key['DESC_CATEGORIE'];
          $chambr[]=$key['DESC_PERIODE'].'('.$key['NB_JOURS'].')';
          $chambr[]=$key['MONTANT_COTISATION'];  
          // $chambr[]=$newDate;  
          // $chambr[]=$nban['NB_AYANT'];  
          $chambr[]=$key['STATUS_COTISATION'];
          // if ($resultatlast['ID_MEMBRE'] == $key['ID_MEMBRE']) {
            // $todel = '<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#supprimermembre'.$key['ID_MEMBRE'].'"> Supprimer la personne </a> </li>';
          // }
          // else{
          //   $todel = '';
          // }
          $chambr[]='
 <div class="modal fade" id="desactcat'.$key['ID_MONTANT_COTISATION'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key['DESC_CATEGORIE'].' - '.$key['DESC_PERIODE'].' - '.$key['NB_JOURS'].' - '.$key['MONTANT_COTISATION'].')?</h6>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
         <a href="'.base_url('cotisation/Configuration_Cotisation/'.$fx.'/'.$key['ID_MONTANT_COTISATION']).'" class="btn '.$col.'">'.$titr.'</a>
       </div>
     </div>
   </div>
 </div>

           <div class="dropdown ">
                     <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                     <span class="caret"></span></a>
                     <ul class="dropdown-menu dropdown-menu-right">
                     <li><a class="dropdown-item" href="'.base_url('cotisation/Configuration_Cotisation/details/'.$key['ID_MONTANT_COTISATION']).'"> Détail </a> </li>
                     <li><a class="dropdown-item" href="'.base_url('cotisation/Configuration_Cotisation/index_update/'.$key['ID_MONTANT_COTISATION']).'"> Modifier</a> </li>
                     <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_MONTANT_COTISATION'].'"> '.$titr.' </a> </li>
                     </ul>
                   </div>';
         
                          // <li><a class="dropdown-item" href="'.base_url('membre/Membre/index_update/'.$key['ID_MEMBRE']).'"> Ajouter/Enlever Groupe </a> </li>
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Nom','Periode (Nb Jours)','Montant','Status','Option'));
       
        $data['chamb']=$tabledata;
        $data['title']=' Configuration';
        $data['stitle']=' Configuration';
        $this->load->view('Configuration_Cotisation_List_View',$data);
  }

  public function details()
  {
    echo "In dev";
  }

  public function index_update($id)
  {
      // echo "In dev";
      $data['title']='Configuration Cotisation';
      $data['stitle']='Configuration Cotisation';
      $data['cotisation'] = $this->Model->getRequeteOne('SELECT * FROM `cotisation_montant_cotisation` WHERE ID_MONTANT_COTISATION = '.$id.''); 
      $data['periode'] = $this->Model->getListOrdertwo('cotisation_periode',array(),'DESCRIPTION'); 
      $data['categorie'] = $this->Model->getListOrdertwo('cotisation_categorie',array(),'DESCRIPTION'); 

      
      
      // $todaydate = strtotime(date('Y-m-d'));
      // $realdate = strtotime('-'.$conf['AGE_MINIMALE_AFFILIE'].' year', $todaydate);
      // $realdate = date('d/m/Y', $realdate);
      // $data['datemin'] = $realdate;
      $this->load->view('Configuration_Cotisation_Update_View',$data);
  }

  
  public function update()
  {
  $MONTANT_COTISATION=$this->input->post('MONTANT_COTISATION');
  $ID_CATEGORIE_COTISATION=$this->input->post('ID_CATEGORIE_COTISATION');
  $ID_PERIODE_COTISATION=$this->input->post('ID_PERIODE_COTISATION');
  $ID_MONTANT_COTISATION=$this->input->post('ID_MONTANT_COTISATION');

  $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$ID_MONTANT_COTISATION), array('MONTANT_COTISATION'=>$MONTANT_COTISATION, 'ID_CATEGORIE_COTISATION'=>$ID_CATEGORIE_COTISATION, 'ID_PERIODE_COTISATION'=>$ID_PERIODE_COTISATION));

  $message = "<div class='alert alert-success' id='message'>
                            Cotisation modifi&eacute; avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
    $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Configuration_Cotisation/listing'));    

  }


   public function desactiver($id)
    {
      $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$id),array('IS_ACTIF'=>0));
      $message = "<div class='alert alert-success' id='message'>
                            Cotisation désactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Configuration_Cotisation/listing'));
    }

  public function reactiver($id)
    {
      $this->Model->update('cotisation_montant_cotisation',array('ID_MONTANT_COTISATION'=>$id),array('IS_ACTIF'=>1));
      $message = "<div class='alert alert-success' id='message'>
                            Cotisation Réactivé avec succés
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
      $this->session->set_flashdata(array('message'=>$message));
      redirect(base_url('cotisation/Configuration_Cotisation/listing')); 
    }
  

}
?>