<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Liste_Cotisation extends CI_Controller
{
	
	function __construct()
	{
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

///il faudra ajouter le statut dans la table coti_membre pour savoir 
//si une personne est actif ou non



    public function index()
    {
    $MOIS=$this->input->post('MOIS');
 
    $data['MOIS']=$MOIS;
      
      if (!empty($MOIS)) {
        $critaire= ' AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%"';
      }   
      else{
        $critaire = '';
      }

      $resultat=$this->Model->getRequete('SELECT cotisation_cotisation.ID_COTISATION, cotisation_cotisation.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, cotisation_cotisation.ID_CATEGORIE_COTISATION, cotisation_categorie.DESCRIPTION AS DESCIPTION_CATEGORIE, cotisation_cotisation.MONTANT_COTISATION, cotisation_cotisation.MOIS_COTISATION, cotisation_cotisation.DATE_INSERTION FROM cotisation_cotisation JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_cotisation.ID_MEMBRE JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_cotisation.ID_CATEGORIE_COTISATION WHERE 1 '.$critaire );

      $totals=$this->Model->getRequeteOne('SELECT SUM(cotisation_cotisation.MONTANT_COTISATION) AS TOTALS FROM cotisation_cotisation WHERE 1 '.$critaire );

      $data['TOTAL'] = 'TOTAL: '.$totals['TOTALS'];
  
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $chambr=array();

          $date=date_create($key['DATE_INSERTION']);
          $DATE_CREATION = date_format($date,"d-m-Y"); 
          $chambr[]=$key['NOM'].' '.$key['PRENOM']; 
          $chambr[]=$key['MONTANT_COTISATION'];
          $chambr[]=$key['DESCIPTION_CATEGORIE'];
          $chambr[]=$key['MOIS_COTISATION'];
          $chambr[]=$DATE_CREATION;
                          
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Membre','Montant','Cat&eacute;gorie','Mois','Enregistr&eacute; le'));
        $data['title'] = " Cotisation";
        $data['stitle']=' Cotisation';
        $data['chamb']=$tabledata;
        $this->load->view('Liste_Cotisation_List_View',$data);

    }


    public function listing()
    {
    $MOIS=$this->input->post('MOIS');
 
    // SELECT cotisation_cotisation.ID_MEMBRE FROM cotisation_cotisation WHERE 1 AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%2022-03%"

    // cotisation_categorie_membre.ID_MEMBRE NOT IN (SELECT cotisation_cotisation.ID_MEMBRE FROM cotisation_cotisation WHERE 1 AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%2022-03%")

    
      
      if (!empty($MOIS)) {
       $data['MOIS']=$MOIS;
       $critaire = ' AND cotisation_categorie_membre.ID_MEMBRE NOT IN (SELECT cotisation_cotisation.ID_MEMBRE FROM cotisation_cotisation WHERE 1 AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%")';
      }   
      else{
        // $critaire = 'AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.date('Y-m').'%"';

      //  $critaire = ' AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%"';
       
       $MOIS = date('Y-m');
       $data['MOIS']=date('Y-m');
       $critaire = ' AND cotisation_categorie_membre.ID_MEMBRE NOT IN (SELECT cotisation_cotisation.ID_MEMBRE FROM cotisation_cotisation WHERE 1 AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%")';

      }

      // $resultat=$this->Model->getRequete('SELECT cotisation_cotisation.ID_COTISATION, cotisation_cotisation.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, cotisation_cotisation.ID_CATEGORIE_COTISATION, cotisation_categorie.DESCRIPTION AS DESCIPTION_CATEGORIE, cotisation_cotisation.MONTANT_COTISATION, cotisation_cotisation.MOIS_COTISATION, cotisation_cotisation.DATE_INSERTION FROM cotisation_cotisation JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_cotisation.ID_MEMBRE JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_cotisation.ID_CATEGORIE_COTISATION WHERE 1 '.$critaire );

      
      $resultat=$this->Model->getRequete('SELECT cotisation_categorie_membre.ID_MEMBRE, membre_membre.NOM, membre_membre.PRENOM, cotisation_montant_cotisation.MONTANT_COTISATION, cotisation_categorie.DESCRIPTION AS DESCIPTION_CATEGORIE FROM cotisation_categorie_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_categorie_membre.ID_MEMBRE JOIN cotisation_montant_cotisation ON cotisation_montant_cotisation.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION JOIN cotisation_categorie ON cotisation_categorie.ID_CATEGORIE_COTISATION = cotisation_categorie_membre.ID_CATEGORIE_COTISATION WHERE  1 '.$critaire );

      // $totals=$this->Model->getRequeteOne('SELECT SUM(cotisation_cotisation.MONTANT_COTISATION) AS TOTALS FROM cotisation_cotisation JOIN cotisation_categorie_membre ON cotisation_categorie_membre.ID_CATEGORIE_COTISATION = cotisation_cotisation.ID_CATEGORIE_COTISATION WHERE 1 '.$critaire );

      
      $TOTAL = 0;
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $chambr=array();

          $date=date_create($MOIS);
          $DATE_CREATION = date_format($date,"d-m-Y"); 
          $chambr[]=$key['NOM'].' '.$key['PRENOM']; 
          $chambr[]=$key['MONTANT_COTISATION'];
          $chambr[]=$key['DESCIPTION_CATEGORIE'];
          $chambr[]=$MOIS;
          $chambr[]=$DATE_CREATION;
                          
       $tabledata[]=$chambr;
       $TOTAL += $key['MONTANT_COTISATION'] ;
     
     }

     $data['TOTAL'] = 'TOTAL: '.$TOTAL;

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Membre','Montant','Cat&eacute;gorie','Mois','Enregistr&eacute; le'));
        $data['title'] = " Cotisation";
        $data['stitle']=' Cotisation';
        $data['chamb']=$tabledata;
        $this->load->view('Liste_Cotisation_List_View',$data);

    }
       
 }
?>