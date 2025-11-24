
<?php 

if (empty($this->session->userdata('MIS_ID_USER'))) {

  redirect(base_url());
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?=base_url()?>" class="brand-link  text-center">
    <!-- <i class=" fas fa-chess-queen"></i> -->
    <i class="nav-icon fas fa-star-of-life"></i>
    <span class="brand-text font-weight-light"> MIS Santé </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url() ?>upload/avatar.jfif" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
       <a href="#" class="d-block"><?=$this->session->userdata('MIS_PRENOM')?> <?=$this->session->userdata('MIS_NOM')?></a> 
     </div>
   </div>

   <!-- Sidebar Menu -->
   <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      <?php
      if (in_array('1',$this->session->userdata('MIS_DROIT')) || in_array('2',$this->session->userdata('MIS_DROIT')) || in_array('3',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item has-treeview <?php if($this->router->class == 'Config' || $this->router->class == 'Profil_Droit' || $this->router->class == 'User' || $this->router->class == 'Control_All'){ echo 'menu-open';} else{ echo '';}  ?>">
          <a href="#" class="nav-link">
            <i class=" nav-icon fas fa-user-cog"></i>
            <p>
              Administration
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php
            if (in_array('1',$this->session->userdata('MIS_DROIT'))){
              ?>
              <li class="nav-item">
                <a href="<?=base_url('administration/Config/listing')?>" class="nav-link <?php if($this->router->class == 'Config' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Configuration</p>
                </a>
              </li>
              <?php
            }
            ?>
            <?php
            if (in_array('2',$this->session->userdata('MIS_DROIT'))){
              ?>
              <li class="nav-item">
                <a href="<?=base_url('administration/Profil_Droit/listing')?>" class="nav-link <?php if($this->router->class == 'Profil_Droit' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Accès</p>
                </a>
              </li>
              <?php
            }
            ?>
            <?php
            if (in_array('3',$this->session->userdata('MIS_DROIT'))){
              ?>
              <li class="nav-item">
                <a href="<?=base_url('administration/User/listing')?>" class="nav-link <?php if($this->router->class == 'User' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Utilisateurs & Accès</p>
                </a>
              </li>
              <?php
            }
            ?>


          </ul>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('4',$this->session->userdata('MIS_DROIT')) || in_array('5',$this->session->userdata('MIS_DROIT')) || in_array('6',$this->session->userdata('MIS_DROIT')) || in_array('7',$this->session->userdata('MIS_DROIT')) || in_array('8',$this->session->userdata('MIS_DROIT')) || in_array('9',$this->session->userdata('MIS_DROIT')) || in_array('10',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item has-treeview <?php if($this->router->class == 'Regime_Assurance' || $this->router->class == 'Categorie_Assurance' || $this->router->class == 'Couverture_Medicament' || $this->router->class == 'Couverture_Structure_Sanitaire' || $this->router->class == 'Groupe_Sanguin' || $this->router->class == 'Province' || $this->router->class == 'Commune'){ echo 'menu-open';} else{ echo '';}  ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-keyboard"></i>
            <p>
              Données du système
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
           <?php
           if (in_array('4',$this->session->userdata('MIS_DROIT'))){
            ?>
            <li class="nav-item">
              <a href="<?=base_url()?>donne_systeme/Regime_Assurance" class="nav-link <?php if($this->router->class == 'Regime_Assurance' ){ echo 'active';} else{ echo '';}  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Regime d'Assurance</p>
              </a>
            </li>
            <?php
          }
          ?>


          <?php
          if (in_array('5',$this->session->userdata('MIS_DROIT'))){
            ?>
            <li class="nav-item">
              <a href="<?=base_url()?>donne_systeme/Categorie_Assurance" class="nav-link <?php if($this->router->class == 'Categorie_Assurance' ){ echo 'active';} else{ echo '';}  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Categorie Assurance</p>
              </a>
            </li>

            <?php
          }
          ?>


          <?php
          if (in_array('6',$this->session->userdata('MIS_DROIT'))){
            ?>

            <li class="nav-item">
              <a href="<?=base_url()?>donne_systeme/Couverture_Medicament" class="nav-link <?php if($this->router->class == 'Couverture_Medicament' ){ echo 'active';} else{ echo '';}  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Couverture Medicament</p>
              </a>
            </li>

            <?php
          }
          ?>


          <?php
          if (in_array('7',$this->session->userdata('MIS_DROIT'))){
            ?>
            <li class="nav-item">
              <a href="<?=base_url()?>donne_systeme/Couverture_Structure_Sanitaire" class="nav-link <?php if($this->router->class == 'Couverture_Structure_Sanitaire' ){ echo 'active';} else{ echo '';}  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Type Structure</p>
              </a>
            </li>
            <?php
          }
          ?>


          <?php
          if (in_array('8',$this->session->userdata('MIS_DROIT'))){
            ?>
            <li class="nav-item">
              <a href="<?=base_url()?>donne_systeme/Groupe_Sanguin" class="nav-link <?php if($this->router->class == 'Groupe_Sanguin' ){ echo 'active';} else{ echo '';}  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Groupe sanguin</p>
              </a>
            </li>
            <?php
          }
          ?>


          <?php
          if (in_array('9',$this->session->userdata('MIS_DROIT'))){
            ?>

            <li class="nav-item">
              <a href="<?=base_url()?>donne_systeme/Province" class="nav-link <?php if($this->router->class == 'Province' ){ echo 'active';} else{ echo '';}  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Code Province</p>
              </a>
            </li>
            <?php
          }
          ?>


          <?php
          if (in_array('10',$this->session->userdata('MIS_DROIT'))){
            ?>
            <li class="nav-item">
              <a href="<?=base_url()?>donne_systeme/Commune" class="nav-link <?php if($this->router->class == 'Commune' ){ echo 'active';} else{ echo '';}  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Code Commune</p>
              </a>
            </li>
            <?php
          }
          ?>

        </ul> 
      </li>
      <?php
    }
    ?>
    <?php
    if (in_array('11',$this->session->userdata('MIS_DROIT')) || in_array('12',$this->session->userdata('MIS_DROIT')) || in_array('13',$this->session->userdata('MIS_DROIT')) || in_array('14',$this->session->userdata('MIS_DROIT')) || in_array('15',$this->session->userdata('MIS_DROIT'))){
      ?>
      <li class="nav-item has-treeview <?php if($this->router->class == 'Structure_Sanitaire' || $this->router->class == 'Medicament' || $this->router->class == 'Agence' || $this->router->class == 'Emploi' || $this->router->class == 'Pharmacie' || $this->router->class == 'Centre_Optique'){ echo 'menu-open';} else{ echo '';}  ?>">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-edit"></i>
          <p>
            Saisie et donn&eacute;es
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
           <?php
           if (in_array('11',$this->session->userdata('MIS_DROIT'))){
            ?>
            <a href="<?=base_url()?>saisie/Structure_Sanitaire/listing" class="nav-link <?php if($this->router->class == 'Structure_Sanitaire' ){ echo 'active';} else{ echo '';}  ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Structure Sanitaire</p>
            </a>
          </li>
          <?php
        }
        ?>
        <?php
        if (in_array('12',$this->session->userdata('MIS_DROIT'))){
          ?>
          <li class="nav-item">
            <a href="<?=base_url()?>saisie/Centre_Optique/listing" class="nav-link <?php if($this->router->class == 'Centre_Optique' ){ echo 'active';} else{ echo '';}  ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Centre Optique</p>
            </a>
          </li>
          <?php
        }
        ?>
        <?php
        if (in_array('13',$this->session->userdata('MIS_DROIT'))){
          ?>

          <li class="nav-item">
            <a href="<?=base_url()?>saisie/Medicament/listing" class="nav-link <?php if($this->router->class == 'Medicament' ){ echo 'active';} else{ echo '';}  ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Medicament</p>
            </a>
          </li>
          <?php
        }
        ?>
        <?php
        if (in_array('14',$this->session->userdata('MIS_DROIT'))){
          ?>
          <li class="nav-item">
            <a href="<?=base_url()?>saisie/Agence/listing" class="nav-link <?php if($this->router->class == 'Agence' ){ echo 'active';} else{ echo '';}  ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Agence MIS</p>
            </a>
          </li>
          <?php
        }
        ?>
        <?php
        if (in_array('15',$this->session->userdata('MIS_DROIT'))){
          ?>
          <li class="nav-item">
            <a href="<?=base_url()?>saisie/Emploi/listing" class="nav-link <?php if($this->router->class == 'Emploi' ){ echo 'active';} else{ echo '';}  ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Emploi de membres</p>
            </a>
          </li> 
          <?php
        }
        ?>
      </ul>
    </li>
    <?php
  }
  ?>

  <?php
  if (in_array('16',$this->session->userdata('MIS_DROIT')) || in_array('17',$this->session->userdata('MIS_DROIT')) || in_array('18',$this->session->userdata('MIS_DROIT')) || in_array('19',$this->session->userdata('MIS_DROIT'))){
    ?>
    <li class="nav-item has-treeview <?php if($this->router->class == 'Membre' || $this->router->class == 'Groupe' || $this->router->class == 'Carte_New' || $this->router->class == 'Carte_Prise'){ echo 'menu-open';} else{ echo '';}  ?>">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
          Affilié
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
       <?php
       if (in_array('16',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?php echo base_url('membre/Groupe/listing');?>" class="nav-link <?php if($this->router->class == 'Groupe' ){ echo 'active';} else{ echo '';}  ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Groupe d'affili&eacute;</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('17',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?php echo base_url('membre/Membre/listing');?>" class="nav-link <?php if($this->router->class == 'Membre' ){ echo 'active';} else{ echo '';}  ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Affilié & Ayant Droits</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('18',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?php echo base_url('membre/Carte_New');?>" class="nav-link <?php if($this->router->class == 'Carte_New' ){ echo 'active';} else{ echo '';}  ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Cartes de membres</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('19',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?php echo base_url('membre/Carte_Prise');?>" class="nav-link <?php if($this->router->class == 'Carte_Prise' ){ echo 'active';} else{ echo '';}  ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Cartes Prise</p>
          </a>
        </li>

        <?php
      }
      ?>

    </ul>
  </li>
  <?php
}
?>
<?php
if (in_array('38',$this->session->userdata('MIS_DROIT'))){
  ?>

  <li class="nav-item">
    <a href="<?=base_url('recherche/Recherche')?>" class="nav-link <?php if($this->router->class == 'Recherche' ){ echo 'active';} else{ echo '';}  ?>">
      <i class="fas fa-search nav-icon"></i>
      <p> Recherche</p>
    </a>
  </li>
  <?php
}
?>
<?php
if (in_array('41',$this->session->userdata('MIS_DROIT'))){
  ?>

  <li class="nav-item">
    <a href="<?=base_url('membre/Rappel')?>" class="nav-link <?php if($this->router->class == 'Rappel' ){ echo 'active';} else{ echo '';}  ?>">
      <i class="fa fa-bell nav-icon" aria-hidden="true"></i>
      <p> Rappel</p>
    </a>
  </li>
  <?php
}
?>
<?php
if (in_array('44',$this->session->userdata('MIS_DROIT'))){
  ?>

  <li class="nav-item">
    <a href="<?=base_url('consomation/Depassement_plafond')?>" class="nav-link <?php if($this->router->class == 'Depassement_plafond' ){ echo 'active';} else{ echo '';}  ?>">
      <i class="fa fa-bell nav-icon" aria-hidden="true"></i>
      <p> Dépassement</p>
    </a>
  </li>
  <?php
}
?>

<?php
if (in_array('43',$this->session->userdata('MIS_DROIT'))){
  ?>

  <li class="nav-item">
    <a href="<?=base_url('consultation/Pdf_prise_en_charge')?>" class="nav-link <?php if($this->router->class == 'Pdf_prise_en_charge' ){ echo 'active';} else{ echo '';}  ?>">
      <i class="fas fa-bed nav-icon" aria-hidden="true"></i>
      <p> Prise en charrge</p>
    </a>
  </li>
  <?php
}
?>

<?php
if (in_array('30',$this->session->userdata('MIS_DROIT')) || in_array('31',$this->session->userdata('MIS_DROIT')) || in_array('34',$this->session->userdata('MIS_DROIT')) || in_array('35',$this->session->userdata('MIS_DROIT'))){
  ?>

  <li class="nav-item has-treeview <?php if($this->router->class == 'Configuration_Cotisation' || $this->router->class == 'Membre_Categorie' || $this->router->class == 'Ajout_Cotisation' || $this->router->class == 'Liste_Cotisation' || $this->router->class == 'Liste_Frais_Adhesion' || $this->router->class == 'Tableau_Cotisation'){ echo 'menu-open';} else{ echo '';}  ?>">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-money-check-alt"></i>
      <p>
        Cotisation 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <?php
      if (in_array('30',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?=base_url()?>cotisation/Configuration_Cotisation/" class="nav-link <?php if($this->router->class == 'Configuration_Cotisation'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Configuration cotisation</p>
          </a>
        </li>

        <?php
      }
      ?>
      <?php
      if (in_array('31',$this->session->userdata('MIS_DROIT'))){
        ?>
        <!-- <li class="nav-item">
          <a href="<?=base_url()?>cotisation/Membre_Categorie/" class="nav-link <?php if($this->router->class == 'Membre_Categorie'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Membre par categorie</p>
          </a>
        </li> -->
        <?php
      }
      ?>
      <?php
      if (in_array('34',$this->session->userdata('MIS_DROIT'))){
        ?>
     <!--    <li class="nav-item">
          <a href="<?=base_url()?>cotisation/Gestion_Adhesion" class="nav-link <?php if($this->router->class == 'Gestion_Adhesion'){ echo 'active';} else{ echo '';}  ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Gestion frais d'adhesion</p>
          </a>
        </li> -->
        <?php
      }
      ?>
      <?php
      if (in_array('35',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?=base_url()?>dashboard/Tableau_Cotisation" class="nav-link <?php if($this->router->class == 'Tableau_Cotisation'){ echo 'active';} else{ echo '';}  ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Ecarts cotisations et consommations</p>
          </a>
        </li>
        <?php
      }
      ?>

    </ul>
  </li>
  <?php
}
?>

<?php
if (in_array('20',$this->session->userdata('MIS_DROIT')) || in_array('21',$this->session->userdata('MIS_DROIT')) || in_array('22',$this->session->userdata('MIS_DROIT')) || in_array('23',$this->session->userdata('MIS_DROIT')) || in_array('24',$this->session->userdata('MIS_DROIT')) || in_array('26',$this->session->userdata('MIS_DROIT'))){
  ?>
  <li class="nav-item has-treeview <?php if($this->router->class == 'Enregistrer_Consultation' || $this->router->class == 'Liste_Consultation_Hopital' || $this->router->class == 'Enregistrer_Medicament' || $this->router->class == 'Liste_Medicament_Pharmacie' || $this->router->class == 'Liste_Consultation' || $this->router->class == 'Consomation_Affilier' || $this->router->class == 'Consomation_Famille'){ echo 'menu-open';} else{ echo '';}  ?>">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-file-medical-alt"></i>
      <p>
        Consomation 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <?php
      if (in_array('20',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?=base_url()?>consultation/Enregistrer_Consultation/" class="nav-link <?php if($this->router->class == 'Enregistrer_Consultation'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Fiches de consultation</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('21',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?=base_url()?>consultation/Liste_Consultation_Hopital/indexs" class="nav-link <?php if($this->router->class == 'Liste_Consultation_Hopital'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Liste des consultations</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('22',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?=base_url()?>consultation/Liste_Consultation/" class="nav-link <?php if($this->router->class == 'Liste_Consultation'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Archivage consultations</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('23',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?=base_url()?>consultation/Enregistrer_Medicament/" class="nav-link <?php if($this->router->class == 'Enregistrer_Medicament'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Bon de medicament</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('24',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?=base_url()?>consultation/Liste_Medicament_Pharmacie/" class="nav-link <?php if($this->router->class == 'Liste_Medicament_Pharmacie'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Liste Medicament prise</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('26',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?=base_url()?>consultation/Consomation_Affilier" class="nav-link <?php if($this->router->class == 'Consomation_Famille'){ echo 'active';} else{ echo '';}  ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Consomations Groupe</p>
          </a>
        </li> 
        <?php
      }
      ?>

    </ul>
  </li>
  <?php
}
?>

<?php
if (in_array('42',$this->session->userdata('MIS_DROIT'))){
  ?>

  <li class="nav-item has-treeview <?php if($this->router->class == 'Carte_Mis'){ echo 'menu-open';} else{ echo '';}  ?>">
    <a href="#" class="nav-link">
      <i class="fa fa-map nav-icon" aria-hidden="true"></i>
      <p>
        Cartographie
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
     <li class="nav-item">
      <a href="<?=base_url()?>carte/Carte_Mis" class="nav-link <?php if($this->router->class == 'Carte_Mis'){ echo 'active';} else{ echo '';}  ?>">
        <i class="fa fa-map-marker nav-icon" aria-hidden="true"></i>
        <p>Carte MIS</p>
      </a>
    </li>
  </li>

</ul>
</li>

<?php
}
?>

<?php
if (in_array('28',$this->session->userdata('MIS_DROIT')) || in_array('29',$this->session->userdata('MIS_DROIT'))){
  ?>
  <li class="nav-item has-treeview <?php if($this->router->method == 'liste' || $this->router->method == 'liste_phare' ){ echo 'menu-open'; } ?>">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-money-check-alt"></i>
      <p>
        Paiment 
        <i class="right fas fa-angle-left "></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <?php
      if (in_array('28',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?= base_url('paiment/Paiment_facture/liste') ?>" class="nav-link <?php if($this->router->method == 'liste'){ echo 'active'; } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Paiment des Hopitaux</p>
          </a>
        </li>
        <?php
      }
      ?>
      <?php
      if (in_array('29',$this->session->userdata('MIS_DROIT'))){
        ?>
        <li class="nav-item">
          <a href="<?= base_url('paiment/Paiment_facture/liste_phare') ?>" class="nav-link <?php if($this->router->method == 'liste_phare'){ echo 'active'; } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Paiment des Pharmacies</p>
          </a>
        </li>
        <?php
      }
      ?>
    </ul>
  </li>


  <?php
}
?>


</ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>