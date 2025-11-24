<?php

class Carte_Mis  extends CI_Controller{

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
 
      $dataagence=$this->Model->getRequete('SELECT * FROM `masque_agence_msi` order by DESCRIPTION');
      $mesdonnees="";
      foreach ($dataagence as $key => $value) {
        $CODE=trim($value['DESCRIPTION']);
              $CODE = str_replace("\n","",$CODE);
              $CODE = str_replace("\r","",$CODE);
              $CODE = str_replace("\t","",$CODE);
              $CODE = str_replace('"','',$CODE);
              $CODE = str_replace("'",'',$CODE);
       $mesdonnees .= $value['ID_AGENCE'].'<>'.$value['LATITUDE'].'<>'.$value['LONGITUDE'].'<>'.$CODE.'<>'.$value['PROVINCE_ID'].'<>'.$value['COMMUNE_ID'].'<>@';  
      }

      $data['mesdonnees']=$mesdonnees;


      /////////////////////Membres par localites/////////////

      $datamembreslocalite=$this->Model->getRequete('SELECT COUNT(membre_membre.ID_MEMBRE) as nbr,syst_communes.COMMUNE_LATITUDE,syst_communes.COMMUNE_LONGITUDE,syst_communes.COMMUNE_NAME,syst_communes.COMMUNE_ID FROM `membre_carte_membre` join membre_membre on membre_carte_membre.ID_MEMBRE=membre_membre.ID_MEMBRE join syst_communes on membre_membre.COMMUNE_ID=syst_communes.COMMUNE_ID  WHERE 1 group by syst_communes.COMMUNE_ID');
     $mesdonnees2="";

     foreach ($datamembreslocalite as $key => $value2) {
       $CODE=trim($value2['COMMUNE_NAME']." <br>('".$value2['nbr']."') membres");
              $CODE = str_replace("\n","",$CODE);
              $CODE = str_replace("\r","",$CODE);
              $CODE = str_replace("\t","",$CODE);
              $CODE = str_replace('"','',$CODE);
              $CODE = str_replace("'",'',$CODE);
     
      $mesdonnees2 .= $value2['COMMUNE_ID'].'<>'.$value2['COMMUNE_LATITUDE'].'<>'.$value2['COMMUNE_LONGITUDE'].'<>'.$CODE.'<>@';  
      }

      $data['mesdonnees2']=$mesdonnees2;


      /////////////////////STRUCTURES ET PHARMACIES///////////////

       $datastructureslocalite=$this->Model->getRequete(' SELECT masque_stucture_sanitaire.ID_STRUCTURE,masque_stucture_sanitaire.`DESCRIPTION`,syst_communes.COMMUNE_LATITUDE,syst_communes.COMMUNE_LONGITUDE FROM `masque_stucture_sanitaire` join syst_communes on masque_stucture_sanitaire.COMMUNE_ID=syst_communes.COMMUNE_ID WHERE 1');
       $mesdonnees3="";

     foreach ($datastructureslocalite as $key => $value3) {
       $CODE=trim($value3['DESCRIPTION']);
              $CODE = str_replace("\n","",$CODE);
              $CODE = str_replace("\r","",$CODE);
              $CODE = str_replace("\t","",$CODE);
              $CODE = str_replace('"','',$CODE);
              $CODE = str_replace("'",'',$CODE);
      $mesdonnees3 = $value3['ID_STRUCTURE'].'<>'.$value3['COMMUNE_LATITUDE'].'<>'.$value3['COMMUNE_LONGITUDE'].'<>'.$CODE.'<>@';  
      }

      $data['mesdonnees3']=$mesdonnees3;

        /////////////////////STRUCTURES ET PHARMACIES///////////////

       $datapharmacieslocalite=$this->Model->getRequete('SELECT consultation_pharmacie.`ID_PHARMACIE`,consultation_pharmacie.`DESCRIPTION`,syst_communes.COMMUNE_LATITUDE,syst_communes.COMMUNE_LONGITUDE FROM `consultation_pharmacie` join syst_communes on consultation_pharmacie.COMMUNE_ID=syst_communes.COMMUNE_ID WHERE 1');

      $mesdonnees4="";

     foreach ($datapharmacieslocalite as $key => $value4) {
       $CODE=trim($value4['DESCRIPTION']);
              $CODE = str_replace("\n","",$CODE);
              $CODE = str_replace("\r","",$CODE);
              $CODE = str_replace("\t","",$CODE);
              $CODE = str_replace('"','',$CODE);
              $CODE = str_replace("'",'',$CODE);
     
      $mesdonnees4 .= $value4['ID_PHARMACIE'].'<>'.$value4['COMMUNE_LATITUDE'].'<>'.$value4['COMMUNE_LONGITUDE'].'<>'.$CODE.'<>@';  
      }

      $data['mesdonnees4']=$mesdonnees4;


      

      

     

      $this->load->view('Carte_Mis_View',$data);



    }







    public function add()

    {



  $NOM=$this->input->post('NOM');

  $PRENOM=$this->input->post('PRENOM');

  $USERNAME=$this->input->post('USERNAME');

  $PASSWORD=$this->input->post('PASSWORD');

  $PROFIL_ID=$this->input->post('PROFIL_ID');

  $ID_AGENCE=$this->input->post('ID_AGENCE');

  



  $this->form_validation->set_rules('NOM', 'Noms', 'required');

  $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');

  $this->form_validation->set_rules('USERNAME', 'Username', 'required|is_unique[admin_user.USERNAME]');

  $this->form_validation->set_rules('PASSWORD', 'Mot de passe', 'required');

  $this->form_validation->set_rules('PROFIL_ID', 'Profil', 'required');

  $this->form_validation->set_rules('ID_AGENCE', 'Agence', 'required');



   if ($this->form_validation->run() == FALSE){

    $message = "<div class='alert alert-danger'>

                            Utilisateur non enregistr&eacute; de cong&eacute; non enregistr&eacute;

                            <button type='button' class='close' data-dismiss='alert'>&times;</button>

                      </div>";

    $this->session->set_flashdata(array('message'=>$message));

    $data['title']='Utilisateur';

    $data['profil']=$this->Model->getRequete('SELECT * FROM `config_profil` order by DESCRIPTION');

    $data['agence']=$this->Model->getRequete('SELECT * FROM `masque_agence_msi` order by DESCRIPTION');

    $this->load->view('User_Add_View',$data);

   }

   else{



    $datasuser=array(

                       'NOM'=>$NOM,

                       'PRENOM'=>$PRENOM,

                       'USERNAME'=>$USERNAME,

                       'PASSWORD'=>md5($PASSWORD),

                       'PROFIL_ID'=>$PROFIL_ID,

                       'ID_AGENCE'=>$ID_AGENCE,

                      );



                      

                      

    $this->Model->insert_last_id('admin_user',$datasuser);  



    $message = "<div class='alert alert-success' id='message'>

                            Utilisateur enregistr&eacute; avec succés

                            <button type='button' class='close' data-dismiss='alert'>&times;</button>

                      </div>";

    $this->session->set_flashdata(array('message'=>$message));

      redirect(base_url('administration/User/listing'));  

   }



    }



    



    public function listing()

    {

      



      $data['resultat']=$this->Model->getRequete('SELECT ID_USER, NOM, PRENOM, USERNAME, config_profil.DESCRIPTION as DESCRIPTION, masque_agence_msi.DESCRIPTION AS AGENCE, admin_user.STATUS AS STATUS FROM `admin_user` JOIN config_profil ON config_profil.PROFIL_ID = admin_user.PROFIL_ID JOIN masque_agence_msi ON masque_agence_msi.ID_AGENCE = admin_user.ID_AGENCE');

      $tabledata=array();

      



      $data['title']='Utilisateur';

      $this->load->view('User_List_View',$data);



    }







    public function index_update($id)

    {



      $data['title']='Utilisateur';

      $data['data']=$this->Model->getRequeteOne('SELECT * FROM `admin_user` WHERE ID_USER = '.$id.'');

      $data['profil']=$this->Model->getRequete('SELECT * FROM `config_profil` order by DESCRIPTION');

      $data['agence']=$this->Model->getRequete('SELECT * FROM `masque_agence_msi` order by DESCRIPTION');

      $this->load->view('User_Update_View',$data);



    }







    public function update()

    {



      $NOM=$this->input->post('NOM');

      $PRENOM=$this->input->post('PRENOM');

      $USERNAME=$this->input->post('USERNAME');

      $ID_USER=$this->input->post('ID_USER');

      $PROFIL_ID=$this->input->post('PROFIL_ID');

      $ID_AGENCE=$this->input->post('ID_AGENCE');

    

      $this->form_validation->set_rules('NOM', 'Nom', 'required');

      $this->form_validation->set_rules('PRENOM', 'Prenom', 'required');

      $this->form_validation->set_rules('USERNAME', 'Username', 'required');

      $this->form_validation->set_rules('PROFIL_ID', 'Profile', 'required');

      $this->form_validation->set_rules('ID_AGENCE', 'Agence', 'required');

    

       if ($this->form_validation->run() == FALSE){

        $message = "<div class='alert alert-danger'>

                                Utilisateur non modifi&eacute; de cong&eacute; non enregistr&eacute;

                                <button type='button' class='close' data-dismiss='alert'>&times;</button>

                          </div>";

        $this->session->set_flashdata(array('message'=>$message));

        $data['title']='Utilisateur';

        $data['data']=$this->Model->getRequeteOne('SELECT * FROM `admin_user` WHERE ID_USER = '.$ID_USER.'');

        $data['profil']=$this->Model->getRequete('SELECT * FROM `config_profil` order by DESCRIPTION');

        $this->load->view('User_Update_View',$data);

       }

       else{

    

        $datasuser=array(

                           'NOM'=>$NOM,

                           'PRENOM'=>$PRENOM,

                           'USERNAME'=>$USERNAME,

                           'PROFIL_ID'=>$PROFIL_ID,

                           'ID_AGENCE'=>$ID_AGENCE

                          );

                          

        $this->Model->update('admin_user',array('ID_USER'=>$ID_USER),$datasuser);  

    

        $message = "<div class='alert alert-success' id='message'>

                                Utilisateur modifi&eacute; avec succés

                                <button type='button' class='close' data-dismiss='alert'>&times;</button>

                          </div>";

        $this->session->set_flashdata(array('message'=>$message));

          redirect(base_url('administration/User/listing'));  

       }

    

  

    }





    public function desactiver($id)

    {

      $this->Model->update('admin_user',array('ID_USER'=>$id),array('STATUS'=>0));

      $message = "<div class='alert alert-success' id='message'>

                            Utilisateur désactivé avec succés

                            <button type='button' class='close' data-dismiss='alert'>&times;</button>

                      </div>";

      $this->session->set_flashdata(array('message'=>$message));

      redirect(base_url('administration/User/listing'));  

    }



  public function reactiver($id)

    {

      $this->Model->update('admin_user',array('ID_USER'=>$id),array('STATUS'=>1));

      $message = "<div class='alert alert-success' id='message'>

                            Utilisateur Réactivé avec succés

                            <button type='button' class='close' data-dismiss='alert'>&times;</button>

                      </div>";

      $this->session->set_flashdata(array('message'=>$message));

      redirect(base_url('administration/User/listing'));  

    }



    

    





}