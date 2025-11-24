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

    $MOIS=$this->input->post('MOIS');
 
    // $an=$this->Model->getRequete("SELECT DISTINCT  date_format(MOIS_COTISATION,'%Y-%m') AS MOIS  FROM coti_cotisation  ORDER BY  MOIS ASC");
    $data['MOIS']=$MOIS;
    // $data['an']=$an;

      $critaire = '';
      // if (!empty($MOIS)) {
      //   $critaire= ' AND DATE_FORMAT(MOIS_COTISATION,"%Y-%m") Like "%'.$MOIS.'%"';
      // }   

      $resultat=$this->Model->getRequete('SELECT membre_membre.NOM, membre_membre.PRENOM, cotisation_frais_adhesion.MONTANT, cotisation_frais_adhesion.DATE_PAIEMENT FROM `cotisation_frais_adhesion` JOIN membre_membre ON membre_membre.ID_MEMBRE = cotisation_frais_adhesion.ID_MEMBRE WHERE 1 '.$critaire );
      // if ($this->input->post('MOIS_COTISATION') == null) {
      // $resultat=$this->Model->getRequete('SELECT coti_membre.NOM, coti_membre.PRENOM, coti_cotisation.MONTANT,coti_membre.STATUS, coti_cotisation.MOIS_COTISATION, coti_cotisation.ID_COTISATION, coti_cotisation.DATE_CREATION FROM coti_cotisation JOIN coti_membre ON coti_membre.ID_MEMBRE = coti_cotisation.ID_MEMBRE AND coti_cotisation.MOIS_COTISATION'.$critaire );

      // $data['resume']=$this->Model->getRequeteOne('SELECT COUNT(coti_cotisation.ID_COTISATION) AS NOMBRES, SUM(coti_cotisation.MONTANT) AS SOMMES FROM coti_cotisation WHERE 1');
      // $data['selecteds']='';
      // }
      // else{
      // $resultat=$this->Model->getRequete('SELECT coti_membre.NOM, coti_membre.PRENOM, coti_cotisation.MONTANT, coti_cotisation.MOIS_COTISATION, coti_cotisation.ID_COTISATION, coti_cotisation.DATE_CREATION FROM coti_cotisation JOIN coti_membre ON coti_membre.ID_MEMBRE = coti_cotisation.ID_MEMBRE WHERE 1 AND MOIS_COTISATION LIKE "'.$this->input->post('MOIS_COTISATION').'"');
      // $data['resume']=$this->Model->getRequeteOne('SELECT COUNT(coti_cotisation.ID_COTISATION) AS NOMBRES, SUM(coti_cotisation.MONTANT) AS SOMMES FROM coti_cotisation WHERE 1 AND MOIS_COTISATION LIKE "'.$this->input->post('MOIS_COTISATION').'"');
      // $data['selecteds']=$this->input->post('MOIS_COTISATION');
      // }
      
      // $data['liste']=$this->Model->getRequete('SELECT DISTINCT(MOIS_COTISATION) FROM `coti_cotisation`');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {

          $chambr=array();

          $date=date_create($key['DATE_PAIEMENT']);
          $DATE_CREATION = date_format($date,"d-m-Y"); 
          $chambr[]=$key['NOM'].' '.$key['PRENOM']; 
          $chambr[]=$key['MONTANT'];
          // $chambr[]=$key['DESCIPTION_CATEGORIE'];
          // $chambr[]=$key['MOIS_COTISATION'];
          $chambr[]=$DATE_CREATION;
          // $chambr[]='<a href="#" data-toggle="modal" data-target="#mydelete' . $key['ID_COTISATION'] . '" style="color:white;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Supprimer</a>';



          // $chambr[]= '<div class="modal fade" id="mydelete' .$key['ID_COTISATION']. '">
          // <div class="modal-dialog">
          // <div class="modal-content">

          // <div class="modal-body">
          // <h6><b>Mr/Mme , </b> voulez-vous desactiver le paiement de '.$key['NOM'].' '.$key['PRENOM'].' du mois de '.$key['MOIS_COTISATION'].' ?</h6>
          // </div>

          // <div class="modal-footer">
          // <a class="btn btn-danger btn-md" href="' .base_url('cotisation/Coti_Cotisation/delete/'.$key['ID_COTISATION']).'">Supprimer</a>
          // <button class="btn btn-primary" class="close" data-dismiss="modal">Quitter</button>
          // </div>

          // </div>
          // </div>
          // </div>';
                          
       $tabledata[]=$chambr;
     
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Membre','Montant','Enregistr&eacute; le'));
        $data['title'] = " Frai adhesion";
        // $data['stitle']=' Cotisation';
        $data['chamb']=$tabledata;
        $this->load->view('Liste_Frais_Adhesion_List_View',$data);

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