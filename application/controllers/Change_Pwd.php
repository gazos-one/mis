<?php

 class Change_Pwd extends CI_Controller {

    public function __construct() {
        parent::__construct();

    }



     function index() 
     {
   
        $data['msg']="";
        $data['title']="Changer pwd";
        $this->load->view('Change_Pwd_View',$data);

     }

    function changer()
        {

    $this->form_validation->set_rules('ACTUEL_PASSWORD','','trim|required',array('required'=>'Le mot de passe actuel est obligatoire'));
    $this->form_validation->set_rules('NEW_PASSWORD','','trim|required',array('required'=>'Le nouveau mot de passe est obligatoire'));
    $this->form_validation->set_rules('PASSWORDCONFIRM','','trim|required|matches[NEW_PASSWORD]',array('required'=>'La confirmation du nouveau mot de passe est obligatoire','matches'=>'Les deux mot de passe doivent etre identique'));
       if($this->form_validation->run()==TRUE)
           {
            // $email=$this->session->userdata('VOE_USERNAME');
            // $tel=$this->session->userdata('VOE_TELEPHONE');
            // if (empty($tel))
            //  {
            //   $criteres=$this->session->userdata('VOE_USERNAME');
            //  }
            //  if(empty($email))
            //   {
            //   $criteres=$this->session->userdata('VOE_TELEPHONE');
            //  }
            //  if (!empty($email) && !empty($tel))
            //   {
            //   $criteres=$this->session->userdata('VOE_USERNAME');
            //  }

            $oldpas=$this->Model->getOne('admin_user',array('USERNAME'=>$this->session->userdata('MIS_USERNAME')));


            if($oldpas['PASSWORD']==md5($this->input->post('ACTUEL_PASSWORD')))
               {
              // $password=md5($this->input->post('NEW_PASSWORD'));
              // $confirmpasswd=md5($this->input->post('PASSWORDCONFIRM'));
              $data=array(
               'PASSWORD'=>md5($this->input->post('NEW_PASSWORD')),
              );

              // print_r($data);
              // exit();

              $this->Model->update('admin_user',array('USERNAME'=>$this->session->userdata('MIS_USERNAME')),$data);

              $data['message']='<div class="alert alert-success text-center">Changement de mot de passe fait avec succès! vous pouvez vous connecter</div>';
              $this->session->set_flashdata($data);
              redirect(base_url('Login/do_logout'));
              }
              else{
                $data['title']="Changer pwd";
                $data['msg']="L'ancien mot de passe n'est pas correct";
                $this->load->view('Change_Pwd_View',$data);
              }
            }

        else{
        $data['msg']="";
        $data['title']="Changer pwd";
        $this->load->view('Change_Pwd_View',$data);
            }
        }
 }