<?php

class Profil_Droit  extends CI_Controller{

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



      $data['title']='Profil & Droit';

      $data['droits']=$this->Model->getRequete('SELECT * FROM `config_droits` order by DESCRIPTION');

      $this->load->view('Profil_Droit_Add_View',$data);



    }







    public function add()

    {



  $DESCRIPTION=$this->input->post('DESCRIPTION');

  $ID_DROIT=$this->input->post('ID_DROIT');



  // $this->form_validation->set_rules('ID_DROIT', 'Profil', 'required');

  // $this->form_validation->set_rules('DESCRIPTION', 'Description', 'required');

  // $this->form_validation->set_rules('user_name', 'User Name', 'required|trim|xss_clean'.$is_unique);

  $this->form_validation->set_rules('DESCRIPTION', 'Nom du Profil', 'required|is_unique[config_profil.DESCRIPTION]');





  // print_r($ID_DROIT);

  // exit();



   if ($this->form_validation->run() == FALSE){

    $message = "<div class='alert alert-danger'>

                            Profil est droit non enregistr&eacute; de cong&eacute; non enregistr&eacute;

                            <button type='button' class='close' data-dismiss='alert'>&times;</button>

                      </div>";

    $this->session->set_flashdata(array('message'=>$message));

    $data['title']='Profil & Droit';

    $data['droits']=$this->Model->getRequete('SELECT * FROM `config_droits` order by DESCRIPTION');

  $this->load->view('Profil_Droit_Add_View',$data);

   }

   else{



    

    

    $datasprofil=array('DESCRIPTION'=>$DESCRIPTION);

    // echo'<br>';

    // print_r($datasprofil);

    $PROFIL_ID = $this->Model->insert_last_id('config_profil',$datasprofil);

    foreach ($ID_DROIT as $ID_DROIT) {

      // echo $ID_DROIT.'<br>';

      $datadroitprofil = array(

                                'PROFIL_ID' => $PROFIL_ID,

                                'ID_DROIT' =>$ID_DROIT ,

                               );

      $this->Model->insert_last_id('config_profil_droit',$datadroitprofil);

    }

    



    $message = "<div class='alert alert-success' id='message'>

                            Profil & Droit enregistr&eacute; avec succés

                            <button type='button' class='close' data-dismiss='alert'>&times;</button>

                      </div>";

    $this->session->set_flashdata(array('message'=>$message));

      redirect(base_url('administration/Profil_Droit/listing'));  

   }



    }



    



    public function listing()

    {

      



      $data['resultat']=$this->Model->getRequete('SELECT config_profil.PROFIL_ID, config_profil.DESCRIPTION, COUNT(config_profil_droit.ID_DROIT) AS NUMBER FROM `config_profil` JOIN config_profil_droit ON config_profil_droit.PROFIL_ID = config_profil.PROFIL_ID GROUP BY config_profil.PROFIL_ID, config_profil.DESCRIPTION');

      $tabledata=array();

      

      



      $data['title']='Profil & Droit';

      $this->load->view('Profil_Droit_List_View',$data);



    }







    public function index_update($id)

    {



      $data['title']='Profil & Droit';

      $data['data']=$this->Model->getRequeteOne('SELECT * FROM `config_profil` WHERE PROFIL_ID = '.$id.'');

      $data['droits']=$this->Model->getRequete('SELECT * FROM `config_droits` order by DESCRIPTION');

      $this->load->view('Profil_Droit_Update_View',$data);



    }







    public function update()

    {



  

      $DESCRIPTION=$this->input->post('DESCRIPTION');

      $ID_DROIT=$this->input->post('ID_DROIT');

      $PROFIL_ID=$this->input->post('PROFIL_ID');

    

      // $this->form_validation->set_rules('ID_DROIT', 'Profil', 'required');

      $this->form_validation->set_rules('DESCRIPTION', 'Description', 'required');

    

       if ($this->form_validation->run() == FALSE){

        $message = "<div class='alert alert-danger'>

                                Profil est droit non modifi&eacute; de cong&eacute; non enregistr&eacute;

                                <button type='button' class='close' data-dismiss='alert'>&times;</button>

                          </div>";

        $this->session->set_flashdata(array('message'=>$message));

        $data['title']='Profil & Droit';

      $data['data']=$this->Model->getRequeteOne('SELECT * FROM `config_profil` WHERE PROFIL_ID = '.$PROFIL_ID.'');

      $data['droits']=$this->Model->getRequete('SELECT * FROM `config_droits` order by DESCRIPTION');

      $this->load->view('Profil_Droit_Update_View',$data);

       }

       else{

    

        

        

        $datasprofil=array('DESCRIPTION'=>$DESCRIPTION);

        // echo'<br>';

        // print_r($datasprofil);

        $this->Model->update('config_profil',array('PROFIL_ID'=>$PROFIL_ID),$datasprofil);

        $this->Model->delete('config_profil_droit',array('PROFIL_ID'=>$PROFIL_ID));



        foreach ($ID_DROIT as $ID_DROIT) {



          $datadroitprofil = array(

                                    'PROFIL_ID' => $PROFIL_ID,

                                    'ID_DROIT' =>$ID_DROIT ,

                                   );

          $this->Model->insert_last_id('config_profil_droit',$datadroitprofil);

        }

        

    

        $message = "<div class='alert alert-success' id='message'>

                                Profil & Droit Modifi&eacute; avec succés

                                <button type='button' class='close' data-dismiss='alert'>&times;</button>

                          </div>";

        $this->session->set_flashdata(array('message'=>$message));

          redirect(base_url('administration/Profil_Droit/listing'));  

       }



    }





    public function desactiver($id)

    {

      $this->Model->update('config_type_conge',array('ID_TYPE_CONGE'=>$id),array('STATUS'=>0));

      $message = "<div class='alert alert-success' id='message'>

                            Type de cong&eacute; désactivé avec succés

                            <button type='button' class='close' data-dismiss='alert'>&times;</button>

                      </div>";

      $this->session->set_flashdata(array('message'=>$message));

      redirect(base_url('administration/Type_Conge/listing'));  

    }



  public function reactiver($id)

    {

      $this->Model->update('config_type_conge',array('ID_TYPE_CONGE'=>$id),array('STATUS'=>1));

      $message = "<div class='alert alert-success' id='message'>

                            Type de cong&eacute; Réactivé avec succés

                            <button type='button' class='close' data-dismiss='alert'>&times;</button>

                      </div>";

      $this->session->set_flashdata(array('message'=>$message));

      redirect(base_url('administration/Type_Conge/listing'));  

    }



    

    





}