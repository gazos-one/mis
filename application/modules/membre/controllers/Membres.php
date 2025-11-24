<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Membres extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }
 

  public function details_one($id)
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
      $this->load->view('Membre_Details_One_View',$data);
    }


}
?>