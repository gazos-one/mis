<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groupe extends CI_Controller {

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
  $data['title']=' Groupe d\'affilié ';
  $data['stitle']=' Groupe d\'affilié ';
      // $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
  $this->load->view('Groupe_Add_View',$data);
}


public function add()
{

  $NOM_GROUPE=$this->input->post('NOM_GROUPE');
  $DATE_ENREGISTREMENT=$this->input->post('DATE_ENREGISTREMENT');
  $NIF=$this->input->post('NIF');
  $RESIDENCE=$this->input->post('RESIDENCE');

  $this->form_validation->set_rules('NOM_GROUPE', 'Nom', 'required');
  $this->form_validation->set_rules('DATE_ENREGISTREMENT', 'Date de debut', 'required');
  if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
    Groupe non enregistr&eacute;
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $data['title']=' Groupe d\'affilié ';
    $data['stitle']=' Groupe d\'affilié ';
    $this->load->view('Groupe_Add_View',$data);
  }
  else{

    $datas=array('NOM_GROUPE'=>$NOM_GROUPE,
     'NIF'=>$NIF,
     'RESIDENCE'=>$RESIDENCE,
     'DATE_ENREGISTREMENT'=>$DATE_ENREGISTREMENT,
   );


    $this->Model->insert_last_id('membre_groupe',$datas);
    
    $message = "<div class='alert alert-success' id='message'>
    Groupe enregistr&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('membre/Groupe/listing'));    

  }
  

}

public function listing()
{

$data['stitle'] = " Groupe d'affilié";
$this->load->view('Groupe_List_View',$data);

}



public function liste()
{

     $query_principal='SELECT DISTINCT(membre_groupe.ID_GROUPE) AS ID_GROUPE, membre_groupe.NOM_GROUPE, membre_groupe.DATE_ENREGISTREMENT, membre_groupe.STATUS FROM `membre_groupe` JOIN membre_groupe_membre ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE';

       $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $limit = 'LIMIT 0,10';
        if ($_POST['length'] != -1) {
        $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
 
        $order_column=array("membre_groupe.NOM_GROUPE","membre_groupe.DATE_ENREGISTREMENT","membre_groupe.STATUS");

         $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY membre_groupe.ID_GROUPE   ASC';
 
        $search = !empty($_POST['search']['value']) ? (' AND (membre_groupe.NOM_GROUPE LIKE "%' . $var_search . '%" OR membre_groupe.DATE_ENREGISTREMENT LIKE "%' . $var_search . '%" OR membre_groupe.STATUS LIKE "%' . $var_search . '%")') :'';
 
      $critaire = '';
    
       $groupby='';
 
       $query_secondaire = $query_principal . ' ' . $search . '  ' . $groupby . '  ' . $order_by . '   ' . $limit;


       $query_filter = $query_principal . '  ' . $search. ' ' . $groupby;
       $resultat = $this->Model->datatable($query_secondaire);
     
       // print_r($query_secondaire);die();
      

     

      $tabledata=array();
      
      foreach ($resultat as $key) 
  {


    $nombr = $this->Model->getRequeteOne('SELECT COUNT(ID_MEMBRE) as nb FROM membre_groupe_membre WHERE membre_groupe_membre.ID_GROUPE= '.$key->ID_GROUPE.' ');

    $autre_group = $this->Model->getRequete('SELECT ID_GROUPE, NOM_GROUPE FROM membre_groupe WHERE ID_GROUPE != '.$key->ID_GROUPE.' ');
    $selections = '<select class="form-control" name="ID_GROUPE_NEW" id="ID_GROUPE_NEW"><option value="" >-- Sélectionner --</option>';
    foreach ($autre_group as $autre_groups) {
      $selections .= '<option value="'.$autre_groups['ID_GROUPE'].'" >'.$autre_groups['NOM_GROUPE'].'</option>';
    }
    $selections .= '</select>';

    if ($key->STATUS == 1) {
     $stat = 'Actif';
     $fx = 'desactiver';
     $col = 'btn-danger';
     $titr = 'Désactiver';
     $stitr = 'voulez-vous désactiver le groupe ';
     $bigtitr = 'Désactivation du groupe';
   }
   else{
     $stat = 'Innactif';
     $fx = 'reactiver';
     $col = 'btn-success';
     $titr = 'Réactiver';
     $stitr = 'voulez-vous réactiver le groupe ';
     $bigtitr = 'Réactivation du groupe';
   }
          
          $chambr=array();
          $chambr[]=$key->NOM_GROUPE;
          $chambr[]=date("d-m-Y", strtotime($key->DATE_ENREGISTREMENT));
          $chambr[]=$nombr['nb'];
          $chambr[]=$stat;
          $chambr[]='<div class="modal fade" id="desactcat'.$key->ID_GROUPE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog modal-sm">
   <div class="modal-content">
   <div class="modal-header">
   <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
   <span aria-hidden="true">&times;</span>
   </button>
   </div>
   <div class="modal-body">
   <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key->NOM_GROUPE.')?</h6>
   </div>
   <div class="modal-footer">
   <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
   <a href="'.base_url('membre/Groupe/'.$fx.'/'.$key->ID_GROUPE).'" class="btn '.$col.'">'.$titr.'</a>
   </div>
   </div>
   </div>
   </div>
   <div class="modal fade" id="merging'.$key->ID_GROUPE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
   <div class="modal-content">
   <div class="modal-header">
   <h4 class="modal-title" id="myModalLabel">Associer un groupe a un autre</h4>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
   <span aria-hidden="true">&times;</span>
   </button>
   </div>
   <form id="FormData" action="'.base_url().'membre/Groupe/fusionner" method="POST" enctype="multipart/form-data">
   <div class="modal-body">
   Fusionner le groupe '.$key->NOM_GROUPE.' avec <br>
   '.$selections.'

   <input type="hidden" name="ID_GROUPE" class="form-control" value="'.$key->ID_GROUPE.'" id="ID_GROUPE"><br>

   En changeant le second groupe vas disparaitre et va etre rattacher au premier

   </div>
   <div class="modal-footer">
   <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
   <input type="submit" value="Enregistrer" class="btn btn-primary"/>
   </div>
   </form>
   </div>
   </div>
   </div>


 <div class="modal fade" id="date_fin'.$key->ID_GROUPE.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel">Changer la date fin pour tout les membres</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <form id="FormData" action="'.base_url().'membre/Groupe/changerdate" method="POST" enctype="multipart/form-data">
       <div class="modal-body">
       

         <input type="hidden" name="ID_GROUPE" class="form-control" value="'.$key->ID_GROUPE.'" id="ID_GROUPE"><br>
         <div class="row">
         <div class="col-md-12 form-group">
         <label>Date fin <font color="red">*</font></label>
         <input type="date" name="date_fin" min="'.date("Y-m-d").'" class="form-control" required>
         </div>
         </div>

       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
         <input type="submit" value="Enregistrer" class="btn btn-primary"/>
       </div>
       </form>
     </div>
   </div>
 </div>


   <div class="dropdown ">
   <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
   <span class="caret"></span></a>
   <ul class="dropdown-menu dropdown-menu-right">
   <li><a class="dropdown-item" href="'.base_url('membre/Groupe/index_update/'.$key->ID_GROUPE).'"> Modifier </a> </li>
   <li><a class="dropdown-item" href="'.base_url('membre/Groupe/details/'.$key->ID_GROUPE).'"> Details </a> </li>
   <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key->ID_GROUPE.'"> '.$titr.' </a> </li>
   <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#merging'.$key->ID_GROUPE.'"> Fusionner </a> </li>
      <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#date_fin'.$key->ID_GROUPE.'"> Changer la date fin des cartes</a> </li>
   </ul>
   </div>';

          
                          
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









//       // $resultat=$this->Model->getRequete('SELECT DISTINCT(membre_groupe.ID_GROUPE) AS ID_GROUPE, membre_groupe.NOM_GROUPE, membre_groupe.DATE_ENREGISTREMENT, membre_groupe.STATUS, COUNT(membre_groupe_membre.ID_MEMBRE) AS MEMBRE FROM `membre_groupe` JOIN membre_groupe_membre ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE GROUP BY membre_groupe.ID_GROUPE, membre_groupe.NOM_GROUPE, membre_groupe.DATE_ENREGISTREMENT, membre_groupe.STATUS');
//   $resultat=$this->Model->getRequete('SELECT * FROM membre_groupe');

  

//       //WHERE reservation_chambre.STATUT_RESERV_ID=1
//   $tabledata=array();
  
//   foreach ($resultat as $key) 
//   {
//    $nombre = $this->Model->getRequeteOne('SELECT COUNT(ID_GROUPE_MEMBRE) AS MEMBRE FROM membre_groupe_membre JOIN membre_membre ON membre_membre.ID_MEMBRE = membre_groupe_membre.ID_MEMBRE WHERE membre_groupe_membre.ID_GROUPE = '.$key['ID_GROUPE'].'  ');

//    $autre_group = $this->Model->getRequete('SELECT ID_GROUPE, NOM_GROUPE FROM membre_groupe WHERE ID_GROUPE != '.$key['ID_GROUPE'].' ');
//    $selections = '<select class="form-control" name="ID_GROUPE_NEW" id="ID_GROUPE_NEW"><option value="" >-- Sélectionner --</option>';
//    foreach ($autre_group as $autre_groups) {
//      $selections .= '<option value="'.$autre_groups['ID_GROUPE'].'" >'.$autre_groups['NOM_GROUPE'].'</option>';
//    }
//    $selections .= '</select>'; 

//    if ($key['STATUS'] == 1) {
//     $stat = 'Actif';
//     $fx = 'desactiver';
//     $col = 'btn-danger';
//     $titr = 'Désactiver';
//     $stitr = 'voulez-vous désactiver le groupe ';
//     $bigtitr = 'Désactivation du groupe';
//   }
//   else{
//     $stat = 'Innactif';
//     $fx = 'reactiver';
//     $col = 'btn-success';
//     $titr = 'Réactiver';
//     $stitr = 'voulez-vous réactiver le groupe ';
//     $bigtitr = 'Réactivation du groupe';
//   }
//   $chambr=array();
//   $chambr[]=$key['NOM_GROUPE'];
//   $chambr[]=$key['DATE_ENREGISTREMENT'];   
//           // $chambr[]=$key['MEMBRE'];
//   $chambr[]=$nombre['MEMBRE'];
//   $chambr[]=$stat;
//   $chambr[]='<div class="modal fade" id="desactcat'.$key['ID_GROUPE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
//   <div class="modal-dialog modal-sm">
//   <div class="modal-content">
//   <div class="modal-header">
//   <h4 class="modal-title" id="myModalLabel">'.$bigtitr.'</h4>
//   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
//   <span aria-hidden="true">&times;</span>
//   </button>
//   </div>
//   <div class="modal-body">
//   <h6><b>Mr/Mme , </b> '.$stitr.' ('.$key['NOM_GROUPE'].')?</h6>
//   </div>
//   <div class="modal-footer">
//   <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
//   <a href="'.base_url('membre/Groupe/'.$fx.'/'.$key['ID_GROUPE']).'" class="btn '.$col.'">'.$titr.'</a>
//   </div>
//   </div>
//   </div>
//   </div>
//   <div class="modal fade" id="merging'.$key['ID_GROUPE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
//   <div class="modal-dialog">
//   <div class="modal-content">
//   <div class="modal-header">
//   <h4 class="modal-title" id="myModalLabel">Associer un groupe a un autre</h4>
//   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
//   <span aria-hidden="true">&times;</span>
//   </button>
//   </div>
//   <form id="FormData" action="'.base_url().'membre/Groupe/fusionner" method="POST" enctype="multipart/form-data">
//   <div class="modal-body">
//   Fusionner le groupe '.$key['NOM_GROUPE'].' avec <br>
//   '.$selections.'

//   <input type="hidden" name="ID_GROUPE" class="form-control" value="'.$key['ID_GROUPE'].'" id="ID_GROUPE"><br>

//   En changeant le second groupe vas disparaitre et va etre rattacher au premier

//   </div>
//   <div class="modal-footer">
//   <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
//   <input type="submit" value="Enregistrer" class="btn btn-primary"/>
//   </div>
//   </form>
//   </div>
//   </div>
//   </div>


// <div class="modal fade" id="date_fin'.$key['ID_GROUPE'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
//   <div class="modal-dialog">
//     <div class="modal-content">
//       <div class="modal-header">
//         <h4 class="modal-title" id="myModalLabel">Changer la date fin pour tout les membres</h4>
//         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
//           <span aria-hidden="true">&times;</span>
//         </button>
//       </div>
//       <form id="FormData" action="'.base_url().'membre/Groupe/changerdate" method="POST" enctype="multipart/form-data">
//       <div class="modal-body">
       

//         <input type="hidden" name="ID_GROUPE" class="form-control" value="'.$key['ID_GROUPE'].'" id="ID_GROUPE"><br>
//         <div class="row">
//         <div class="col-md-12 form-group">
//         <label>Date fin <font color="red">*</font></label>
//         <input type="date" name="date_fin" min="'.date("Y-m-d").'" class="form-control" required>
//         </div>
//         </div>

//       </div>
//       <div class="modal-footer">
//         <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
//         <input type="submit" value="Enregistrer" class="btn btn-primary"/>
//       </div>
//       </form>
//     </div>
//   </div>
// </div>


//   <div class="dropdown ">
//   <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
//   <span class="caret"></span></a>
//   <ul class="dropdown-menu dropdown-menu-right">
//   <li><a class="dropdown-item" href="'.base_url('membre/Groupe/index_update/'.$key['ID_GROUPE']).'"> Modifier </a> </li>
//   <li><a class="dropdown-item" href="'.base_url('membre/Groupe/details/'.$key['ID_GROUPE']).'"> Details </a> </li>
//   <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#desactcat'.$key['ID_GROUPE'].'"> '.$titr.' </a> </li>
//   <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#merging'.$key['ID_GROUPE'].'"> Fusionner </a> </li>
//      <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#date_fin'.$key['ID_GROUPE'].'"> Changer la date fin des cartes</a> </li>
//   </ul>
//   </div>';
  
  
//   $tabledata[]=$chambr;
  
// }

// $template = array(
//   'table_open' => '<table id="mytable" class="table table-bordered table-striped">',
//   'table_close' => '</table>'
// );
// $this->table->set_template($template);
// $this->table->set_heading(array('Nom','Date Debut','Nb Membre','Status','Option'));
// $data['title'] = " Groupe d'affilié";
// $data['chamb']=$tabledata;
// $data['stitle']=' Groupe d\'affilié';
// $this->load->view('Groupe_List_View',$data);



public function fusionner()
{
  
  

  $ID_GROUPE_NEW=$this->input->post('ID_GROUPE_NEW');
  $ID_GROUPE=$this->input->post('ID_GROUPE');

  echo"a chancher";
  print_r(array('ID_GROUPE'=>$ID_GROUPE_NEW));
  echo"<br>nouvelle application";
  print_r(array('ID_GROUPE'=>$ID_GROUPE));
  $this->Model->update('membre_groupe_membre',array('ID_GROUPE'=>$ID_GROUPE_NEW),array('ID_GROUPE'=>$ID_GROUPE));
  $this->Model->delete('membre_groupe',array('ID_GROUPE'=>$ID_GROUPE_NEW));


  $message = "<div class='alert alert-success' id='message'>
  Groupe fusionnée avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('membre/Groupe/listing')); 


}

public function details($id)
{

  $data['title']=' Groupe';
  $data['stitle']=' Groupe';
      // $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
  $data['selected'] = $this->Model->getRequeteOne('SELECT DISTINCT(membre_groupe.ID_GROUPE) AS ID_GROUPE, membre_groupe.NOM_GROUPE, membre_groupe.DATE_ENREGISTREMENT, membre_groupe.STATUS, COUNT(membre_groupe_membre.ID_MEMBRE) AS MEMBRE FROM `membre_groupe` LEFT JOIN membre_groupe_membre ON membre_groupe.ID_GROUPE = membre_groupe_membre.ID_GROUPE WHERE membre_groupe.ID_GROUPE = '.$id.' GROUP BY membre_groupe.ID_GROUPE, membre_groupe.NOM_GROUPE, membre_groupe.DATE_ENREGISTREMENT, membre_groupe.STATUS  '); 
  $data['list'] = $this->Model->getRequete('SELECT membre_membre.ID_MEMBRE, CODE_AFILIATION, NOM, PRENOM, CNI, DATE_ADHESION, membre_membre.STATUS, IS_AFFILIE FROM membre_membre JOIN membre_groupe_membre ON membre_groupe_membre.ID_MEMBRE = membre_membre.ID_MEMBRE WHERE 1 AND membre_groupe_membre.ID_GROUPE = '.$id.' '); 
  $this->load->view('Groupe_Details_View',$data);
}

public function index_update($id)
{

  $data['title']=' Groupe';
  $data['stitle']=' Groupe';
      // $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
  $data['selected'] = $this->Model->getOne('membre_groupe',array('ID_GROUPE'=>$id)); 
  $this->load->view('Groupe_Update_View',$data);
}



public function update()
{

  $NOM_GROUPE=$this->input->post('NOM_GROUPE');
  $DATE_ENREGISTREMENT=$this->input->post('DATE_ENREGISTREMENT');
  $ID_GROUPE=$this->input->post('ID_GROUPE');
  $NIF=$this->input->post('NIF');
  $RESIDENCE=$this->input->post('RESIDENCE');

  $this->form_validation->set_rules('NOM_GROUPE', 'Nom du groupe', 'required');
  $this->form_validation->set_rules('DATE_ENREGISTREMENT', 'Date enregistrement', 'required');
  if ($this->form_validation->run() == FALSE){
    $message = "<div class='alert alert-danger' id='message'>
    Groupe d'affilié non modifi&eacute;
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    $data['title']=' Groupe d\'affilié ';
    $data['stitle']=' Groupe d\'affilié ';
    // $data['type_med'] = $this->Model->getList('syst_couverture_medicament'); 
    $data['selected'] = $this->Model->getOne('membre_groupe',array('ID_GROUPE'=>$ID_GROUPE)); 
    $this->load->view('Groupe_Update_View',$data);
  }
  else{

    $datas=array('NOM_GROUPE'=>$NOM_GROUPE,
     'DATE_ENREGISTREMENT'=>$DATE_ENREGISTREMENT,
     'NIF'=>$NIF,
     'RESIDENCE'=>$RESIDENCE,
   );


    $this->Model->update('membre_groupe',array('ID_GROUPE'=>$ID_GROUPE),$datas);
    
    $message = "<div class='alert alert-success' id='message'>
    Groupe modifi&eacute; avec succés
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
    $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('membre/Groupe/listing'));    

  }

}


public function desactiver($id)
{
  $this->Model->update('membre_groupe',array('ID_GROUPE'=>$id),array('STATUS'=>0));
  $message = "<div class='alert alert-success' id='message'>
  Groupe désactivé avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('membre/Groupe/listing')); 
}

public function reactiver($id)
{
  $this->Model->update('membre_groupe',array('ID_GROUPE'=>$id),array('STATUS'=>1));
  $message = "<div class='alert alert-success' id='message'>
  Groupe Réactivé avec succés
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>";
  $this->session->set_flashdata(array('message'=>$message));
  redirect(base_url('membre/Groupe/listing')); 
}

    public function changerdate()
{
    $ID_GROUPE = $this->input->post('ID_GROUPE');
    $date_fin = $this->input->post('date_fin');
    $user_id = $this->session->userdata('MIS_ID_USER');

    // 1. Fetch only needed data
    $query = "
        SELECT ID_CARTE, FIN_SUR_LA_CARTE
        FROM membre_carte_membre 
        JOIN membre_groupe_membre 
            ON membre_carte_membre.ID_MEMBRE = membre_groupe_membre.ID_MEMBRE 
        WHERE membre_groupe_membre.ID_GROUPE = ?
        GROUP BY ID_CARTE
    ";

    $donnees = $this->db->query($query, [$ID_GROUPE])->result_array();

    if (empty($donnees)) {
        $this->session->set_flashdata([
            'message' => "<div class='alert alert-warning' id='message'>
                            Aucun membre trouvé.
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          </div>"
        ]);
        redirect(base_url('membre/Groupe/listing'));
        return;
    }

    // Prepare data for batch insert/update
    $data_histo_batch = [];
    $ids = [];

    foreach ($donnees as $row) {
        $ids[] = (int)$row['ID_CARTE'];

        $data_histo_batch[] = [
            'ID_CARTE'         => $row['ID_CARTE'],
            'ANCIEN_DATE_FIN' => $row['FIN_SUR_LA_CARTE'],
            'NOUVEL_DATE_FIN' => $date_fin,
            'USER_ID'         => $user_id
        ];
    }

    // 2. Insert history in batch
    $this->db->insert_batch('historique_carte', $data_histo_batch);

    // 3. Update membre_carte
    $this->db->where_in('ID_CARTE', $ids)
             ->update('membre_carte', ['DATE_FIN_VALIDITE' => $date_fin]);

    // 4. Update membre_carte_membre
    $this->db->where_in('ID_CARTE', $ids)
             ->update('membre_carte_membre', ['FIN_SUR_LA_CARTE' => $date_fin]);

    // 5. Set success message
    $this->session->set_flashdata([
        'message' => "<div class='alert alert-success' id='message'>
                        Date modifiée avec succès.
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>"
    ]);

    redirect(base_url('membre/Groupe/listing'));
}


}
?>