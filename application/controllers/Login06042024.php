<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

    }

    public function index($params = NULL) {

       if (!empty($this->session->userdata('MIS_ID_USER'))) {

        $datas['message']='<div class="alert alert-success text-center" id="message">Connexion bien etablie!<br> Les menus sont à gauche</div>';
        $this->session->set_flashdata($datas);         
        redirect(base_url('Acceuil'));
        } else {

            $datas['message'] = $params;
            $datas['title'] = 'Login';
            $this->load->view('Login_View', $datas);

         }
    }

    public function do_login() {
        $login = $this->input->post('USERNAME');
        $password = $this->input->post('PASSWORD');
        // $email = filter_input(INPUT_POST, 'USERNAME', FILTER_VALIDATE_EMAIL);
        //   if(($email == null)||($email == false))
        //  {
        //   $criteresmail['TELEPHONE']=$login;
        //     // ADRESE mail non valide 
          
        //  }
        //  else { //ADRESSE  VALIDE ;

          // $users=$this->Model->getOne('admin_user',array('USERNAME'=>$login,'STATUS'=>1));
          // $criteresmail['TELEPHONE']=$users['TELEPHONE'];
         // }
        
        
        // $criteresmail['PASSWORD']=md5($password);
        // $criteresmail['STATUS']=1;
        // $criteresmail['USERNAME']=$login;

        $user= $this->Model->getOne('admin_user',array('USERNAME'=>$login,'STATUS'=>1));

        // print_r($user);
        // exit();

        // $criteresprofil['PROFIL_ID']=$user['PROFIL_ID'];
        // $profile = $this->Model->getOne('admin_profils',$criteresprofil);
        if (!empty($user)) {

            if ($user['PASSWORD'] == md5($password))

             {
   
              // $datadroit=$this->Model->getOne('admin_profils',$criteresprofil);

                  $session = array(
                              'MIS_ID_USER' => $user['ID_USER'],
                              'MIS_NOM' => $user['NOM'],
                              'MIS_PRENOM' => $user['PRENOM'],
                              'MIS_USERNAME' => $user['USERNAME'],
                              'MIS_ID_AGENCE' => $user['ID_AGENCE'],
                               );
                 $message = "<div class='alert alert-success' id='messages'> Le nom d'utilisateur ou/et mot de passe incorect(s) !</div>";
                 $this->session->set_userdata($session);
                 // redirect(base_url('Acceuil'));
            
            }

             else
                $message = "<div class='alert alert-danger' id='messages'> Le nom d'utilisateur ou/et mot de passe incorect(s) !</div>";
        }
         else
            $message = "<div class='alert alert-danger' id='messages'> L'utilisateur n'existe pas/plus dans notre système informatique !</div>";
              $this->index($message);

    }

    public function do_logout(){

                $session = array(
                              'MIS_ID_USER' => NULL,
                              'MIS_NOM' => NULL,
                              'MIS_PRENOM' => NULL,
                              'MIS_USERNAME' => NULL,
                              'MIS_ID_AGENCE' => NULL,
                            );                   
            $this->session->set_userdata($session);
            redirect(base_url('Login'));
        }


public function password_oublie($params=NULL,$id=0)
{
  $datas['message'] = $params;
  $datas['USER_ID'] = $id;
  $datas['title'] = 'Login';
  $this->load->view('Forgot_Password_View', $datas);  
}
public function test()
{
  $permission = $this->Model->get_permission('Employes');

  echo "<pre>";
  echo "Session : ".$this->session->userdata('VOE_PROFIL_ID');
  print_r($permission);
  echo "</pre>";
}

 public function demander($id=0) {
        $login = $this->input->post('USERNAME');
        $email = filter_input(INPUT_POST, 'USERNAME', FILTER_VALIDATE_EMAIL);
          if(($email == null)||($email == false))
         {
          $criteresmail['TELEPHONE']=$login;
            // ADRESE mail non valide 
         }
         else { //ADRESSE  VALIDE ;

          $users=$this->Model->getOne('admin_users',array('USERNAME'=>$login));
          $criteresmail['TELEPHONE']=$users['TELEPHONE'];
         }

          $user= $this->Model->getOne('admin_users',$criteresmail);
          if (!empty($user))
           {
            $USER_ID=$user['USER_ID'];
            $message = "";
            $this->password_recover($message,$user['USER_ID']);
           }

           else
           {
            $USER_ID=0;
            $message = "<div class='alert alert-danger' id='messages'> L'utilisateur n'existe pas/plus dans notre système informatique !</div>";
              $this->password_oublie($message);
           }
         }


  public function password_recover($params=NULL,$id=0)
      {
      $datas['USER_ID'] = $id;
      $datas['message'] = $params;
      $datas['title'] = 'Login';
      $this->load->view('Recover_Password_View', $datas);  
      }


  public function valider() 
        {

         $USER_ID=$this->input->post('USER_ID');
         $criteres['USER_ID']=$USER_ID;
         $user= $this->Model->getOne('admin_users',$criteres);
         $p1 = $this->input->post('PASSWORD');
         $this->form_validation->set_rules('PASSWORD', '', 'trim|required',array('required'=>'Le mot de passe est requis'));
         $this->form_validation->set_rules('PASSWORD_CONFIRM', '', 'trim|required|matches[PASSWORD]',array('matches'=>'Les deux mots de passe doivent etre identiques','required'=>'La confirmation du mot passe est requis'));
         if ($this->form_validation->run()==FALSE)
          {
          $datas['USER_ID'] = $USER_ID;
          $datas['message'] = '';
          $datas['title'] = 'Login';
         $this->load->view('Recover_Password_View', $datas);
          }

          else
           {
          $this->Model->update('admin_users',array('USER_ID'=>$USER_ID),array('PASSWORD'=>md5($p1)));
           $message = "<div class='alert alert-info' id='messages'> Récupperation du mot de passe fait avec succès !</div>"; 
           $this->index($message);
           }
         
         }






}