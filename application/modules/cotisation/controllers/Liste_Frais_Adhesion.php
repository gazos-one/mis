<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Liste_Frais_Adhesion extends CI_Controller
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
        $data['title'] = " Frai adhesion";
        $data['stitle']=' Cotisation';
    
        $this->load->view('Liste_Frais_Adhesion_List_View',$data);
    }

     public function liste()
    {

   

      $critaire = '';
     

      $query_principal='SELECT membre_membre.NOM, membre_membre.PRENOM, cotisation_frais_adhesion.MONTANT, cotisation_frais_adhesion.DATE_PAIEMENT FROM `cotisation_frais_adhesion` JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_frais_adhesion.ID_MEMBRE WHERE 1 '.$critaire;


       $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $limit = 'LIMIT 0,10';
        if ($_POST['length'] != -1) {
        $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
 
        $order_column=array("membre_membre.NOM","membre_membre.PRENOM","cotisation_frais_adhesion.MONTANT"," cotisation_frais_adhesion.DATE_PAIEMENT");

         $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY cotisation_frais_adhesion.ID_COTISATION_FRAIS_ADHESION   ASC';
 
        $search = !empty($_POST['search']['value']) ? (' AND (membre_membre.NOM LIKE "%' . $var_search . '%" OR membre_membre.PRENOM LIKE "%' . $var_search . '%" OR cotisation_frais_adhesion.MONTANT LIKE "%' . $var_search . '%" OR cotisation_frais_adhesion.DATE_PAIEMENT LIKE "%' . $var_search . '%")') :'';
 
      $critaire = '';
    
       $groupby='';
 
       $query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
       $query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
       $resultat = $this->Model->datatable($query_secondaire);
     
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $chambr=array();

          $date=date_create($key->DATE_PAIEMENT);
          $DATE_CREATION = date_format($date,"d-m-Y"); 
          $chambr[]=$key->NOM.' '.$key->PRENOM; 
          $chambr[]=$key->MONTANT;
          // $chambr[]=$key['DESCIPTION_CATEGORIE'];
          // $chambr[]=$key['MOIS_COTISATION'];
          $chambr[]=$DATE_CREATION;
         
                          
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

    // public function delete()
    // {
    //   $table="coti_cotisation";
    //   $ID_COTISIATION=$this->uri->segment(4);
    //   // $data['rows']= $this->Model->getOne( $table,$criteres);

    //   $onerow = $this->Model->getOne('coti_cotisation',array('STATUS'=>1, 'ID_COTISATION'=> $ID_COTISIATION));


    //   $dataUpdate=array(

    //     'STATUS'=>0
    //   );
    //   $this->Model->update($table,array('ID_COTISATION' =>$ID_COTISIATION),$dataUpdate);

    //   $data['message']='<div class="alert alert-success text-center" id="message">'."Les informations du compte  <b> ".' '.$data['rows']['NUM_COMPTE'].' </b> '." sont supprimés avec succès".'</div>';

    //   $data['message']='<div class="alert alert-success text-center" id="message">'."Mr/Mme du Nom de <b> ".' '.$data['rows']['NOM'].' </b> '." a été desactiver avec succès".'</div>';

    //   $this->session->set_flashdata($data);
    //   redirect(base_url('cotisation/Coti_Cotisation/'));

    // }       
 }
?>