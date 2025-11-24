<?php
class Categorie_Assurance  extends CI_Controller{
    function __construct() {
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

      $resultat=$this->Model->getRequete('SELECT ID_CATEGORIE_ASSURANCE, syst_categorie_assurance.DESCRIPTION AS ADESC, DROIT_AFFILIATION, COTISATION_MENSUELLE, PLAFOND_COUVERTURE_HOSP_JOURS, syst_regime_assurance.DESCRIPTION AS RASSU FROM syst_categorie_assurance JOIN syst_regime_assurance ON syst_regime_assurance.ID_REGIME_ASSURANCE = syst_categorie_assurance.ID_REGIME_ASSURANCE');
      $tabledata=array();
      
      foreach ($resultat as $key) 
         {


          $tablemedic=$this->Model->getRequete('SELECT syst_couverture_medicament.DESCRIPTION, syst_categorie_assurance_medicament.POURCENTAGE FROM `syst_categorie_assurance_medicament` JOIN syst_couverture_medicament ON syst_couverture_medicament.ID_COUVERTURE_MEDICAMENT = syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT WHERE syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE = '.$key['ID_CATEGORIE_ASSURANCE'].'');
          $tablestruc=$this->Model->getRequete('SELECT * FROM syst_categorie_assurance_type_structure JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE WHERE syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = '.$key['ID_CATEGORIE_ASSURANCE'].'');
          $nbmembre=$this->Model->getRequeteOne('SELECT COUNT(*) AS nb FROM membre_assurances WHERE membre_assurances.ID_CATEGORIE_ASSURANCE = '.$key['ID_CATEGORIE_ASSURANCE'].' AND membre_assurances.STATUS = 1');

          $tabmed = '<table class="table">';
          foreach ($tablemedic as $keymed) {
            $tabmed .= '<tr><td>'.$keymed['DESCRIPTION'].'</td><td>'.$keymed['POURCENTAGE'].'%</td></tr>';
          }
          $tabmed .= '</table>';

          $tabstru = '<table class="table">';
          foreach ($tablestruc as $tablest) {
            $tabstru .= '<tr><td>'.$tablest['DESCRIPTION'].'</td><td>'.$tablest['POURCENTAGE'].'%</td></tr>';
          }
          $tabstru .= '</table>';


          $colabo=array();
          $colabo[]=$key['RASSU'];
          $colabo[]=$key['ADESC'];
          $colabo[]='<div class="text-right">'.number_format($key['DROIT_AFFILIATION'],0,","," ").'</div>';
          $colabo[]='<div class="text-right">'.number_format($key['COTISATION_MENSUELLE'],0,","," ").'</div>';
          $colabo[]='<div class="text-right">'.number_format($key['PLAFOND_COUVERTURE_HOSP_JOURS'],0,","," ").'/Jours</div>';
          $colabo[]='<div class="text-right">'.number_format($nbmembre['nb'],0,","," ").'</div>';
          $colabo[]='<div class="modal fade" id="desactcat'.$key['ID_CATEGORIE_ASSURANCE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">D&eacute;tails pour '.$key['ADESC'].'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
      <div class="col-md-6">
      <h5 class="text-center">T. de couverture dans les Structures de soins</h5>
      '.$tabstru.'
      </div>
      <div class="col-md-6">
      <h5 class="text-center">T. de couverture des médicaments</h5>
      '.$tabmed.'
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>
<a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_CATEGORIE_ASSURANCE'].'"> D&eacute;tails </a>';

       $tabledata[]=$colabo;
     }

        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading(array('Regime Assurance','Intitulé','Droit d\'affiliation','Cotisation mensuelle','Plafond hosp.','Nb Membres','D&eacute;tails'));
        $data['title'] = " Categorie d'assurance";
        $data['stitle'] = " Categorie d'assurance";
        $data['employe']=$tabledata;

        // print_r($data);
        // exit();
        $this->load->view('Categorie_Assurance_List_View',$data);

    }
    


}