<?php
class Config  extends CI_Controller{
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

        


  
    public function listing()
    {

      $data['conf'] = $this->Model->getOne('syst_config',array('ID_CONFIG'=>1));
      $this->load->view('Config_View',$data);

    }

    public function update_Ageminaff()
    {
      $AGE_MINIMALE_AFFILIE=$this->input->post('AGE_MINIMALE_AFFILIE');

            $this->Model->update('syst_config',array('ID_CONFIG'=>1),array('AGE_MINIMALE_AFFILIE'=>$AGE_MINIMALE_AFFILIE));
            $message = "<div class='alert alert-success' id='message'>
                            Age minimale de l'affili&eacute; modifi&eacute; avec success
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
            $this->session->set_flashdata(array('message'=>$message));
            redirect(base_url('administration/Config/listing')); 

    }

    public function update_Dureecarte($value='')
    {
      $DUREE_CARTE=$this->input->post('DUREE_CARTE');

            $this->Model->update('syst_config',array('ID_CONFIG'=>1),array('DUREE_CARTE'=>$DUREE_CARTE));
            $message = "<div class='alert alert-success' id='message'>
                            Durre de la carte de l'affili&eacute; modifi&eacute; avec success
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
            $this->session->set_flashdata(array('message'=>$message));
            redirect(base_url('administration/Config/listing')); 
    }

    public function update_age_max()
    {
      $AGE_MAXIMALE_AFFILIE_NON_CONJOIN_SUR_CARTE=$this->input->post('AGE_MAXIMALE_AFFILIE_NON_CONJOIN_SUR_CARTE');
            $this->Model->update('syst_config',array('ID_CONFIG'=>1),array('AGE_MAXIMALE_AFFILIE_NON_CONJOIN_SUR_CARTE'=>$AGE_MAXIMALE_AFFILIE_NON_CONJOIN_SUR_CARTE));
            $message = "<div class='alert alert-success' id='message'>
                            Age maximale de l'ayant droit modifi&eacute; avec success
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      </div>";
            $this->session->set_flashdata(array('message'=>$message));
            redirect(base_url('administration/Config/listing')); 
    }

    
    


}