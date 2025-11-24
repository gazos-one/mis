<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Liste_Consultation extends CI_Controller
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


    public function index()
    {
    $data['title'] = " Consultation";
    $data['stitle']=' Consultation';
    $data['is_archive']=2;
    
    $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation');

    // print_r($data['annee']);die();

    $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
 
   
    $this->load->view('Liste_Consultation_View',$data);

    }

    public function liste_non_archive()
    {
    $ANNEE=$this->input->post('ANNEE');
    $ID_CONSULTATION_TYPE=$this->input->post('ID_CONSULTATION_TYPE');
    $IS_ARCHIVE=$this->input->post('IS_ARCHIVE');
    
    $table='consultation_consultation';
    if ($IS_ARCHIVE==1) {
    $table='consultation_consultation_archive';
      # code...
    }
 
       if (!empty($ANNEE)) {
        $critaire= ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
      }   
      else{
        $ANNEE = date('Y');
        $data['ANNEE']=date('Y');
        $critaire = ' AND DATE_FORMAT(DATE_CONSULTATION,"%Y") Like "%'.$ANNEE.'%"';
      }

      if (!empty($ID_CONSULTATION_TYPE)) {
        $critaire2= ' AND '.$table.'.ID_CONSULTATION_TYPE  = '.$ID_CONSULTATION_TYPE.' ';
      }   
      else{
        $ID_CONSULTATION_TYPE = 0;
        $critaire2 = ' ';
      }

      $query_principal='SELECT '.$table.'.ID_CONSULTATION,'.$table.'.ID_STRUCTURE,  membre_membre.NOM, membre_membre.PRENOM,  membre_membre.CNI,  '.$table.'.DATE_CONSULTATION, '.$table.'.NUM_BORDERAUX, '.$table.'.MONTANT_CONSULTATION, '.$table.'.EXAMEN, '.$table.'.MEDECIN, '.$table.'.STATUS_PAIEMENT, '.$table.'.MONTANT_A_PAYER, '.$table.'.POURCENTAGE_A, consultation_type.DESCRIPTION AS TYPE, CASE  WHEN consultation_type.ID_CONSULTATION_TYPE IN (3, 7) THEN consultation_centre_optique.DESCRIPTION ELSE masque_stucture_sanitaire.DESCRIPTION END AS STRUCTURE FROM '.$table.' JOIN membre_membre ON membre_membre.ID_MEMBRE = '.$table.'.ID_MEMBRE JOIN consultation_type ON consultation_type.ID_CONSULTATION_TYPE = '.$table.'.ID_CONSULTATION_TYPE LEFT JOIN consultation_centre_optique ON consultation_centre_optique.ID_CENTRE_OPTIQUE = '.$table.'.ID_STRUCTURE LEFT JOIN  masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = '.$table.'.ID_STRUCTURE WHERE '.$table.'.STATUS_PAIEMENT = 0 '.$critaire.' '.$critaire2.'';

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $limit = 'LIMIT 0,10';
        if ($_POST['length'] != -1) {
        $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
 
    //     $order_by = '';
    //     if (!empty($order_by)) {
    //      $order_by .= isset($_POST['order']) ? ' ORDER BY ' . $_POST['order']['0']['column'] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY consultation_consultation.ID_CONSULTATION ASC';
    //       $order_column=array("trait_demande.ID_TRAITEMENT_DEMANDE","trait_demande.CODE_DEMANDE","(SELECT st.DESCRIPTION_STAGE FROM pms_stage st WHERE st.STAGE_ID=trait_demande.STAGE_ID)","DATE_FORMAT(trait_demande.DATE_DECLARATION,'%D %M %Y')","");

    // $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY trait_demande.ID_TRAITEMENT_DEMANDE  ASC';
         
    //      }

        $order_column=array("membre_membre.NOM","membre_membre.PRENOM","membre_membre.CNI","DATE_FORMAT(trait_demande.DATE_DECLARATION,'%D %M %Y')","'.$table.'.NUM_BORDERAUX","'.$table.'.MONTANT_CONSULTATION","'.$table.'.MONTANT_A_PAYER");

         $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY '.$table.'.ID_CONSULTATION  ASC';
 
        $search = !empty($_POST['search']['value']) ? (' AND (membre_membre.NOM LIKE "%' . $var_search . '%" OR membre_membre.PRENOM LIKE "%' . $var_search . '%" OR  membre_membre.CNI LIKE "%' . $var_search . '%" OR  '.$table.'.NUM_BORDERAUX LIKE "%' . $var_search . '%" OR  '.$table.'.MONTANT_CONSULTATION LIKE "%' . $var_search . '%" OR  '.$table.'.MONTANT_A_PAYER LIKE "%' . $var_search . '%" OR consultation_centre_optique.DESCRIPTION LIKE "%' . $var_search . '%" OR masque_stucture_sanitaire.DESCRIPTION LIKE "%' . $var_search . '%")') :'';
 
        $critaire = '';
    
       $groupby='';
 
       $query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;
       $query_filter = $query_principal . ' ' . $search. ' ' . $groupby;
       $fetch_client = $this->Model->datatable($query_secondaire);
     

      $tabledata=array();

      // $result = array_merge($resultat, $resultatcentre);
      
      foreach ($fetch_client as $key) 
         {

          $chambr=array();
          
          

          $chambr[]=$key->NOM.' '.$key->PRENOM.' ('.$key->CNI.')'; 
          $chambr[]=$key->DATE_CONSULTATION;
          $chambr[]=$key->NUM_BORDERAUX;
          $chambr[]=$key->MONTANT_CONSULTATION;          
          $chambr[]=$key->MONTANT_A_PAYER;
          $chambr[]=$key->POURCENTAGE_A.'%';
          $chambr[]=$key->TYPE;
          $chambr[]=$key->STRUCTURE;

          if ($IS_ARCHIVE==2) {
           
         
          $chambr[]='<div class="modal fade" id="desactcat'.$key->ID_CONSULTATION.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel">Liste des consultations</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              Voulez vous effacer cette consultation?

              <form id="FormData" action="'.base_url().'consultation/Liste_Consultation/archive" method="POST" enctype="multipart/form-data">
                     


                  <div class="form-group col-md-12">
                    <label for="MOTIF"> Motif d\'annulation </label>
                    <textarea class="form-control" id="MOTIF" name="MOTIF" rows="3"></textarea>

                  </div>
                  <input type="hidden"  max=""  class="form-control" id="ID_CONSULTATION" name="ID_CONSULTATION" value="'.$key->ID_CONSULTATION.'">

                    
                    
                              <div class="row"><br>
                                  <div class="col-12 text-center" id="divdata" style="margin-top: 10px">
                                        <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                                  </div>
                              </div>
                                    </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
        
                  <div class="dropdown ">
                            <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                            <li><a class="dropdown-item btn-danger" href="'.base_url('consultation/Liste_Consultation/index_update/'.$key->ID_CONSULTATION.'').'"> Modifier </a> </li> 
                            <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key->ID_CONSULTATION.'"> Effacer </a> </li>  
                                                     
                            
                            </ul>
                          </div>';

                           }
                          
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


    public function archive()
    {
     
      $resultat=$this->Model->getRequeteOne('SELECT * FROM consultation_consultation WHERE ID_CONSULTATION = '.$this->input->post('ID_CONSULTATION').' ');


      $this->Model->insert_last_id('consultation_consultation_archive',
      array(
        'ID_CONSULTATION'=>$resultat['ID_CONSULTATION'],
        'ID_TYPE_STRUCTURE'=>$resultat['ID_TYPE_STRUCTURE'],
        'ID_STRUCTURE'=>$resultat['ID_STRUCTURE'],
        'TYPE_AFFILIE'=>$resultat['TYPE_AFFILIE'],
        'ID_MEMBRE'=>$resultat['ID_MEMBRE'],
        'DATE_CONSULTATION'=>$resultat['DATE_CONSULTATION'],
        'NUM_BORDERAUX'=>$resultat['NUM_BORDERAUX'],
        'MONTANT_CONSULTATION'=>$resultat['MONTANT_CONSULTATION'],
        'POURCENTAGE_C'=>$resultat['POURCENTAGE_C'],
        'POURCENTAGE_A'=>$resultat['POURCENTAGE_A'],
        'MONTANT_A_PAYER'=>$resultat['MONTANT_A_PAYER'],
        'MEDECIN'=>$resultat['MEDECIN'],
        'EXAMEN'=>$resultat['EXAMEN'],        
        'ID_CONSULTATION_TYPE'=>$resultat['ID_CONSULTATION_TYPE'],        
        'MOTIF'=>$this->input->post('MOTIF'),        
        'USER_ARCHIVE'=>$this->session->userdata('MIS_ID_USER'),        
        )
        );
        $this->Model->delete('consultation_consultation',array('ID_CONSULTATION'=>$resultat['ID_CONSULTATION'],));
    
    
  
    $message = "<div class='alert alert-success' id='message'>
                              Consultation archiv&eacute; avec succés
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        </div>";
      $this->session->set_flashdata(array('message'=>$message));
        redirect(base_url('consultation/Liste_Consultation'));  
    }

    public function listing()
    {
     
    $data['title'] = " Consultation";
    $data['stitle']=' Consultation';
    $data['is_archive']=1;
 
    $data['annee']=$this->Model->getRequete('SELECT DISTINCT YEAR(DATE_CONSULTATION) AS ANNEE FROM consultation_consultation_archive');
    $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
 
   
    $this->load->view('Liste_Consultation_View',$data);

    }

    
    public function index_update($id)
    {
      $data['title']='Modification Consultation';
      $data['stitle']='Modification Consultation';
      $data['periode'] = $this->Model->getListOrdertwo('syst_couverture_structure',array(),'DESCRIPTION'); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['affilie']= $this->Model->getList("membre_membre",array('IS_AFFILIE'=>0));
      $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
      $data['coptique'] = $this->Model->getListOrdertwo('consultation_centre_optique',array(),'DESCRIPTION'); 
      $selected=$this->Model->getRequeteOne('SELECT * FROM consultation_consultation WHERE ID_CONSULTATION = '.$id.' ');
      $data['selected']=$selected;
      $data['struct']=$this->Model->getRequete('SELECT * FROM masque_stucture_sanitaire WHERE ID_TYPE_STRUCTURE = '.$selected['ID_TYPE_STRUCTURE'].' ');
      // $data['affil']=$this->Model->getRequete('SELECT * FROM masque_stucture_sanitaire WHERE ID_TYPE_STRUCTURE = '.$selected['ID_TYPE_STRUCTURE'].' ');
      $commune= $this->Model->getList("membre_membre",array('CODE_PARENT'=>$selected['TYPE_AFFILIE']));
      $affi= $this->Model->getOne("membre_membre",array('ID_MEMBRE'=>$selected['TYPE_AFFILIE']));
      // $datas= '<option value="">-- Sélectionner --</option>';
      if ($selected['TYPE_AFFILIE'] ==$selected['ID_MEMBRE']) {
        $firstselect = 'selected';
      }
      else{
        $firstselect = '';
      }
      $datas= '<option value="'.$selected['TYPE_AFFILIE'].'" '.$firstselect.'>Lui meme ('.$affi["NOM"].' '.$affi["PRENOM"].')</option>';
    foreach($commune as $commun){
      if ($commun["ID_MEMBRE"] == $selected["ID_MEMBRE"]) {
        $datas.= '<option value="'.$commun["ID_MEMBRE"].'" selected>'.$commun["NOM"].' '.$commun["PRENOM"].'</option>';
      }
      else{
        $datas.= '<option value="'.$commun["ID_MEMBRE"].'">'.$commun["NOM"].' '.$commun["PRENOM"].'</option>';
      }
    
    }
    // $datas.= '';
    $data['affilies']=$datas;


      $this->load->view('Update_Consultation_Add_View',$data);
    }

    public function update()
    {
      $ID_CONSULTATION = $this->input->post('ID_CONSULTATION');
  
    // $this->form_validation->set_rules('ID_TYPE_STRUCTURE', 'Type de Structure', 'required');
    // $this->form_validation->set_rules('ID_STRUCTURE', 'Structure', 'required');
    $this->form_validation->set_rules('TYPE_AFFILIE', 'Type Affilie', 'required');
    $this->form_validation->set_rules('ID_MEMBRE', 'Membre', 'required');
    $this->form_validation->set_rules('DATE_CONSULTATION', 'Date', 'required');
    $this->form_validation->set_rules('NUM_BORDERAUX', 'Borderaux', 'required');
    $this->form_validation->set_rules('MONTANT_CONSULTATION', 'Montant Consultation', 'required');
    $this->form_validation->set_rules('POURCENTAGE_C', 'Pourcentage ', 'required');
    $this->form_validation->set_rules('POURCENTAGE_A', 'Pourcentage', 'required');
    $this->form_validation->set_rules('MONTANT_A_PAYER', 'Montant A payer', 'required');
    $this->form_validation->set_rules('MEDECIN', 'Medecin', 'required');
  
    if ($this->form_validation->run() == FALSE){
      $message = "<div class='alert alert-danger'>
                              Consultation Assurance non enregistr&eacute; de cong&eacute; non enregistr&eacute;
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        </div>";
      $this->session->set_flashdata(array('message'=>$message));
      $data['title']='Modification Consultation';
      $data['stitle']='Modification Consultation';
      $data['periode'] = $this->Model->getListOrdertwo('syst_couverture_structure',array(),'DESCRIPTION'); 
      $data['province'] = $this->Model->getListOrdertwo('syst_provinces',array(),'PROVINCE_NAME'); 
      $data['affilie']= $this->Model->getList("membre_membre",array('IS_AFFILIE'=>0));
      $data['tconsultation'] = $this->Model->getListOrdertwo('consultation_type',array(),'DESCRIPTION'); 
      $data['coptique'] = $this->Model->getListOrdertwo('consultation_centre_optique',array(),'DESCRIPTION'); 
      $selected=$this->Model->getRequeteOne('SELECT * FROM consultation_consultation WHERE ID_CONSULTATION = '.$ID_CONSULTATION.' ');
      $data['selected']=$selected;
      $data['struct']=$this->Model->getRequete('SELECT * FROM masque_stucture_sanitaire WHERE ID_TYPE_STRUCTURE = '.$selected['ID_TYPE_STRUCTURE'].' ');
      // $data['affil']=$this->Model->getRequete('SELECT * FROM masque_stucture_sanitaire WHERE ID_TYPE_STRUCTURE = '.$selected['ID_TYPE_STRUCTURE'].' ');
      $commune= $this->Model->getList("membre_membre",array('CODE_PARENT'=>$selected['TYPE_AFFILIE']));
      $affi= $this->Model->getOne("membre_membre",array('ID_MEMBRE'=>$selected['TYPE_AFFILIE']));
      // $datas= '<option value="">-- Sélectionner --</option>';
      if ($selected['TYPE_AFFILIE'] ==$selected['ID_MEMBRE']) {
        $firstselect = 'selected';
      }
      else{
        $firstselect = '';
      }
      $datas= '<option value="'.$selected['TYPE_AFFILIE'].'" '.$firstselect.'>Lui meme ('.$affi["NOM"].' '.$affi["PRENOM"].')</option>';
    foreach($commune as $commun){
      if ($commun["ID_MEMBRE"] == $selected["ID_MEMBRE"]) {
        $datas.= '<option value="'.$commun["ID_MEMBRE"].'" selected>'.$commun["NOM"].' '.$commun["PRENOM"].'</option>';
      }
      else{
        $datas.= '<option value="'.$commun["ID_MEMBRE"].'">'.$commun["NOM"].' '.$commun["PRENOM"].'</option>';
      }
    
    }
    // $datas.= '';
    $data['affilies']=$datas;


      $this->load->view('Update_Consultation_Add_View',$data);
     }
     else{
      if ($this->input->post('ID_CONSULTATION_TYPE') == 3) {
        $STRUC = $this->input->post('ID_CENTRE_OPTIQUE');
      }
      else{
        $STRUC = $this->input->post('ID_STRUCTURE');
      }
      $this->Model->update('consultation_consultation',array('ID_CONSULTATION'=>$ID_CONSULTATION),
    array('ID_TYPE_STRUCTURE'=>$this->input->post('ID_TYPE_STRUCTURE'),
          'ID_STRUCTURE'=>$STRUC,
          'TYPE_AFFILIE'=>$this->input->post('TYPE_AFFILIE'),
          'ID_MEMBRE'=>$this->input->post('ID_MEMBRE'),
          'DATE_CONSULTATION'=>$this->input->post('DATE_CONSULTATION'),
          'NUM_BORDERAUX'=>$this->input->post('NUM_BORDERAUX'),
          'MONTANT_CONSULTATION'=>$this->input->post('MONTANT_CONSULTATION'),
          'POURCENTAGE_C'=>$this->input->post('POURCENTAGE_C'),
          'POURCENTAGE_A'=>$this->input->post('POURCENTAGE_A'),
          'MONTANT_A_PAYER'=>$this->input->post('MONTANT_A_PAYER'),
          'MEDECIN'=>$this->input->post('MEDECIN'),
          'EXAMEN'=>$this->input->post('EXAMEN'),        
          'ID_CONSULTATION_TYPE'=>$this->input->post('ID_CONSULTATION_TYPE'),        
          )
        );
  
    
    
  
    $message = "<div class='alert alert-success' id='message'>
                              Consultation enregistr&eacute; avec succés
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        </div>";
      $this->session->set_flashdata(array('message'=>$message));
        redirect(base_url('consultation/Liste_Consultation'));  
  
     }
      
  
    }
    
  
       
 }
?>