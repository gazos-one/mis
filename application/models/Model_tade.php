<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class Model_tade extends CI_Model{
  
  public function getCollaorateur($USER_ID)
  {
    $this->db->select("cll.*");
    $this->db->from("admin_users usr"); 
    $this->db->join("admin_collaborateurs cll","cll.COLLABORATEUR_ID = usr.COLLABORATEUR_ID","LEFT");
    $this->db->where("usr.USER_ID",$USER_ID);

    $query = $this->db->get();
    if($query){
      return $query->row_array();
    }
  }
  public function unApprovisionnement($APPROVISIONNEMENT_ID)
  {
      $this->db->select("app.*,st.*,fn.*");
      $this->db->from("stock_approvisionnement app"); 
      $this->db->join("stock_statut st","st.STATUT_ID = app.STATUT_ID","LEFT");
      $this->db->join("stock_fournisseurs fn","fn.FOURNISSEUR_ID = app.FOURNISSEUR_ID","LEFT");
      $this->db->where("app.APPROVISIONNEMENT_ID",$APPROVISIONNEMENT_ID);

      $query = $this->db->get();
      if($query){
        return $query->row_array();
      } 
  }

  public function unApprovisionnement_interne($APPROVISIONNEMENT_ID)
  {
      $this->db->select("app.*,st.*,cll.*,pr.PROFIL_DESCR");
      $this->db->from("stock_approvisionnement app"); 
      $this->db->join("stock_statut st","st.STATUT_ID = app.STATUT_ID","LEFT");
      $this->db->join("admin_collaborateurs cll","cll.COLLABORATEUR_ID = app.FOURNISSEUR_ID","LEFT");
      $this->db->join("admin_profils pr","cll.HIERARCHIE_ID = pr.PROFIL_ID","LEFT");
      $this->db->where("app.APPROVISIONNEMENT_ID",$APPROVISIONNEMENT_ID);

      $query = $this->db->get();
      if($query){
        return $query->row_array();
      } 
  }
  public function getApprovionnement($STATUT_ID = 0){
      $this->db->select("cll.COLLABORATEUR_NOM,
      	                 cll.COLLABORATEUR_PRENOM,
      	                 app.*,
                         st.*,
                         fn.*,
                         COUNT(dtl.DETAIL_ID) as nbPiece,
      	                 SUM(dtl.PRIX_UNITAIRE*dtl.QUANTITE) as montant,
                         ");
      $this->db->from("stock_approvisionnement app");
      $this->db->join("admin_users usr","app.USER_ID = usr.USER_ID"); 
      $this->db->join("stock_statut st","st.STATUT_ID = app.STATUT_ID","LEFT");
      $this->db->join("stock_fournisseurs fn","fn.FOURNISSEUR_ID = app.FOURNISSEUR_ID","LEFT");
      $this->db->join("admin_collaborateurs cll","cll.COLLABORATEUR_ID = usr.COLLABORATEUR_ID","LEFT");
      $this->db->join("stock_approvisionnement_detail dtl","dtl.APPROVISIONNEMENT_ID=app.APPROVISIONNEMENT_ID","LEFT");
      if($STATUT_ID > 0){
        $this->db->where("app.STATUT_ID",$STATUT_ID);
      }
      $this->db->where("app.IS_INTERNE",0);

      $this->db->group_by("app.APPROVISIONNEMENT_ID");

      $query = $this->db->get();
      if($query){
        return $query->result_array();
      }      
  }
  public function getApprovionnementInterne()
  {
        $this->db->select("
                         clb.COLLABORATEUR_NOM as CLB_NOM,
                         clb.COLLABORATEUR_PRENOM as CLB_PRENOM,
                         clb.COLLABORATEUR_TEL,
                         cll.COLLABORATEUR_NOM,
                         cll.COLLABORATEUR_PRENOM,
                         app.*,
                         st.*,
                         fn.*,
                         COUNT(dtl.DETAIL_ID) as nbPiece,
                         SUM(dtl.PRIX_UNITAIRE*dtl.QUANTITE_LIVRE) as montant,
                         ");
      $this->db->from("stock_approvisionnement app");
      $this->db->join("admin_users usr","app.USER_ID = usr.USER_ID"); 
      $this->db->join("stock_statut st","st.STATUT_ID = app.STATUT_ID","LEFT");
      $this->db->join("stock_fournisseurs fn","fn.FOURNISSEUR_ID = app.FOURNISSEUR_ID","LEFT");
      $this->db->join("admin_collaborateurs clb","clb.COLLABORATEUR_ID = app.COLLABORATEUR_ID","LEFT");
      $this->db->join("admin_collaborateurs cll","cll.COLLABORATEUR_ID = usr.COLLABORATEUR_ID","LEFT");
      $this->db->join("stock_approvisionnement_detail dtl","dtl.APPROVISIONNEMENT_ID=app.APPROVISIONNEMENT_ID","LEFT");
      
      $this->db->where("app.IS_INTERNE",1);

      $this->db->group_by("app.APPROVISIONNEMENT_ID");

      $query = $this->db->get();
      if($query){
        return $query->result_array();
      }
  }

  public function getApprovionnementInterneDetail()
  {
      $this->db->select("dtl.*,app.*,fn.*,pc.PIECE_NOM");
      $this->db->from("stock_approvisionnement_detail dtl");
      $this->db->join("stock_approvisionnement app","dtl.APPROVISIONNEMENT_ID=app.APPROVISIONNEMENT_ID","LEFT");
      $this->db->join("masque_piece pc","pc.PIECE_ID=dtl.PIECE_ID","LEFT");
      $this->db->join("stock_fournisseurs fn","fn.FOURNISSEUR_ID = app.FOURNISSEUR_ID","LEFT");
      // $this->db->where("app.IS_INTERNE",1);


      $query = $this->db->get();
      if($query){
        return $query->result_array();
      }
  }

  public function approv_detail($APPROVISIONNEMENT_ID)
  { 
    $this->db->select("dtl.*,pc.PIECE_NOM,marq.PIECE_MARQUE_NOM");
    $this->db->from("stock_approvisionnement_detail dtl");
    $this->db->join("masque_piece pc","pc.PIECE_ID=dtl.PIECE_ID","LEFT");
    $this->db->join("masque_piece_marque marq","marq.PIECE_MARQUE_ID=pc.MARQUE_ID","LEFT");
    $this->db->where("dtl.APPROVISIONNEMENT_ID",$APPROVISIONNEMENT_ID);

    $query = $this->db->get();
    if($query){
      return $query->result_array();
    }
  }

  public function approv_detail_consomm_interne($APPROVISIONNEMENT_ID)
  {
    $this->db->select("apdt.*,pc.PIECE_NOM"); 
    $this->db->from("stock_approvisionnement_detail apdt");
    $this->db->join("masque_piece pc","pc.PIECE_ID=apdt.PIECE_ID","LEFT");
    $this->db->where("apdt.APPROVISIONNEMENT_ID",$APPROVISIONNEMENT_ID);

    $query = $this->db->get();
    if($query){
      return $query->result_array();
    }
  }

  public function getChargement()
  {
    $this->db->select("clb.*,pr.PROFIL_DESCR,cons.*,ppst.POSITION_DESCR,vh.PLAQUE_VEHICULE,pc.PIECE_NOM");
    $this->db->from("stock_consommation cons");
    $this->db->join("admin_collaborateurs clb","clb.COLLABORATEUR_ID = cons.COLLABORATEUR_ID","LEFT");
    $this->db->join("admin_profils pr","clb.HIERARCHIE_ID = pr.PROFIL_ID","LEFT");
    $this->db->join("masque_vehicules vh","vh.VEHICULE_ID = cons.VEHICULE_ID","LEFT");
    $this->db->join("masque_piece pc","pc.PIECE_ID = cons.PIECE_ID","LEFT");
    $this->db->join("masque_piece_position ppst","ppst.POSITION_ID = cons.POSITION_ID","LEFT");

    $query = $this->db->get();
    if($query){
      return $query->result_array();
    }
  }

  public function getChargement_rapport($PIECE_ID = NULL)
  {
    $this->db->select("cons.*,ppst.POSITION_DESCR,vh.PLAQUE_VEHICULE,pc.PIECE_NOM,marq.PIECE_MARQUE_NOM,col.COLLABORATEUR_NOM,col.COLLABORATEUR_PRENOM,col.COLLABORATEUR_TEL");
    $this->db->from("stock_consommation cons");
    $this->db->join("masque_vehicules vh","vh.VEHICULE_ID = cons.VEHICULE_ID","LEFT");
    $this->db->join("masque_piece pc","pc.PIECE_ID = cons.PIECE_ID","LEFT");
    $this->db->join("masque_piece_position ppst","ppst.POSITION_ID = cons.POSITION_ID","LEFT");
    $this->db->join("masque_piece_marque marq","marq.PIECE_MARQUE_ID=pc.MARQUE_ID","LEFT");
    $this->db->join("admin_collaborateurs col","col.COLLABORATEUR_ID = cons.COLLABORATEUR_ID","LEFT");
    
    if(empty($PIECE_ID)){
      $pieces = array(31,32);
      $this->db->where_not_in("pc.PIECE_ID",$pieces);
    }else{
     $this->db->where_in("pc.PIECE_ID",$PIECE_ID);
    }

    $query = $this->db->get();
    if($query){
      return $query->result_array();
    }
  }

  public function getConsommation($CONSOMMATION_ID)
  {
    $this->db->select("cons.*,ppst.POSITION_DESCR,vh.PLAQUE_VEHICULE,pc.PIECE_NOM");
    $this->db->from("stock_consommation cons");
    $this->db->join("masque_vehicules vh","vh.VEHICULE_ID = cons.VEHICULE_ID","LEFT");
    $this->db->join("masque_piece pc","pc.PIECE_ID = cons.PIECE_ID","LEFT");
    $this->db->join("masque_piece_position ppst","ppst.POSITION_ID = cons.POSITION_ID","LEFT");
    $this->db->where("cons.CONSOMMATION_ID",$CONSOMMATION_ID);

    $query = $this->db->get();
    if($query){
      return $query->row_array();
    }

  }

  public function getConsommationDetail($CONSOMMATION_ID)
  {
    $this->db->select("dtl.*,pc.PIECE_NOM,app.APPROVISIONNEMENT_CODE");
    $this->db->from("stock_consommation_detail dtl"); 
    $this->db->join("masque_piece pc","pc.PIECE_ID = dtl.PIECE_ID","LEFT");
    $this->db->join("stock_approvisionnement app","app.APPROVISIONNEMENT_ID = dtl.APPROVISIONNEMENT_ID","LEFT");

    $query = $this->db->get();
    if($query){
      return $query->result_array();
    }
  }
  
  public function getStockActuel()
  {
    $this->db->select("SUM(dtl.QUANTITE_DISPONIBLE) as QTY, SUM(dtl.QUANTITE_DISPONIBLE*PRIX_PIECE) as mnt ,pc.PIECE_NOM,marq.PIECE_MARQUE_NOM,pc.SEUIL");
    $this->db->from("stock_approvisionnement_detail dtl"); 
    $this->db->join("masque_piece pc","pc.PIECE_ID=dtl.PIECE_ID","LEFT");
    $this->db->join("masque_piece_marque marq","marq.PIECE_MARQUE_ID=pc.MARQUE_ID","LEFT");
    $this->db->group_by("dtl.PIECE_ID,pc.PIECE_ID,marq.PIECE_MARQUE_ID");
    $query = $this->db->get();

    if($query){
      return $query->result_array();
    }
  }
}