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

            <li class="nav-item has-treeview <?php if($this->router->class == 'Regime_Assurance' || $this->router->class == 'Categorie_Assurance' || $this->router->class == 'Couverture_Medicament' || $this->router->class == 'Couverture_Structure_Sanitaire' || $this->router->class == 'Groupe_Sanguin' || $this->router->class == 'Province' || $this->router->class == 'Commune'){ echo 'menu-open';} else{ echo '';}  ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-keyboard"></i>
              <p>
                Données du système
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=base_url()?>donne_systeme/Regime_Assurance" class="nav-link <?php if($this->router->class == 'Regime_Assurance' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Regime d'Assurance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>donne_systeme/Categorie_Assurance" class="nav-link <?php if($this->router->class == 'Categorie_Assurance' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categorie Assurance</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=base_url()?>donne_systeme/Couverture_Medicament" class="nav-link <?php if($this->router->class == 'Couverture_Medicament' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Couverture Medicament</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>donne_systeme/Couverture_Structure_Sanitaire" class="nav-link <?php if($this->router->class == 'Couverture_Structure_Sanitaire' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Type Structure</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>donne_systeme/Groupe_Sanguin" class="nav-link <?php if($this->router->class == 'Groupe_Sanguin' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Groupe sanguin</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?=base_url()?>donne_systeme/Province" class="nav-link <?php if($this->router->class == 'Province' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Code Province</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>donne_systeme/Commune" class="nav-link <?php if($this->router->class == 'Commune' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Code Commune</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Provinces</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Communes</p>
                </a>
              </li> -->
            </ul> 
          </li>
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
                <!-- <a href="#" class="nav-link active"> -->
                <a href="<?=base_url()?>saisie/Structure_Sanitaire/listing" class="nav-link <?php if($this->router->class == 'Structure_Sanitaire' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Structure Sanitaire</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>saisie/Centre_Optique/listing" class="nav-link <?php if($this->router->class == 'Centre_Optique' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Centre Optique</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>saisie/Medicament/listing" class="nav-link <?php if($this->router->class == 'Medicament' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Medicament</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>saisie/Agence/listing" class="nav-link <?php if($this->router->class == 'Agence' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agence MIS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>saisie/Emploi/listing" class="nav-link <?php if($this->router->class == 'Emploi' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Emploi de membres</p>
                </a>
              </li> 
              <!-- <li class="nav-item">
                <a href="<?php echo base_url('saisie/Produit/listing');?>" class="nav-link <?php if($this->router->class == 'Produit' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produit</p>
                </a>
              </li>   -->    
              <!-- <li class="nav-item">
                <a href="<?php echo base_url('saisie/Fournisseur/listing');?>" class="nav-link <?php if($this->router->class == 'Fournisseur' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fournisseur</p>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="<?php echo base_url('saisie/Type_Client/listing');?>" class="nav-link <?php if($this->router->class == 'Type_Client' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Type de Client</p>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="<?php echo base_url('saisie/Client/listing');?>" class="nav-link <?php if($this->router->class == 'Client' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Client</p>
                </a>
              </li> -->
              
              <!-- <li class="nav-item">
                <a href="<?php echo base_url('saisie/Taux/listing');?>" class="nav-link <?php if($this->router->class == 'Taux' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Taux de change</p>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="<?php echo base_url('saisie/TVA/listing');?>" class="nav-link <?php if($this->router->class == 'TVA' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TVA</p>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="<?php echo base_url('saisie/Tables/listing');?>" class="nav-link <?php if($this->router->class == 'Tables' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Table du restaurant</p>
                </a>
              </li>  -->
              <!-- <li class="nav-item">
                <a href="<?php echo base_url('saisie/Cause_Annulation/listing');?>" class="nav-link <?php if($this->router->class == 'Cause_Annulation' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cause d'annulation</p>
                </a>
              </li>  -->           
            </ul>
          </li>

          <li class="nav-item has-treeview <?php if($this->router->class == 'Membre' || $this->router->class == 'Groupe' || $this->router->class == 'Carte_New' || $this->router->class == 'Carte_Prise'){ echo 'menu-open';} else{ echo '';}  ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Affilié
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('membre/Groupe/listing');?>" class="nav-link <?php if($this->router->class == 'Groupe' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Groupe d'affili&eacute;</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('membre/Membre/listing');?>" class="nav-link <?php if($this->router->class == 'Membre' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Affilié & Ayant Droits</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ayant Droits</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="<?php echo base_url('membre/Carte_New');?>" class="nav-link <?php if($this->router->class == 'Carte_New' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cartes de membres</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url('membre/Carte_Prise');?>" class="nav-link <?php if($this->router->class == 'Carte_Prise' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cartes Prise</p>
                </a>
              </li>

              
            </ul>
          </li>

          <li class="nav-item">
                <a href="<?=base_url('recherche/Recherche')?>" class="nav-link <?php if($this->router->class == 'Recherche' ){ echo 'active';} else{ echo '';}  ?>">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <i class="fas fa-search nav-icon"></i>
                  <p> Recherche</p>
                </a>
              </li>

          <!-- <li class="nav-item has-treeview <?php if($this->router->class == 'Service_Restaurant' || $this->router->class == 'Facture_Restaurant' || $this->router->class == 'Extra_Sortie'){ echo 'menu-open';} else{ echo '';}  ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-utensils"></i>
              <p>
                Restaurant
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
      
              <li class="nav-item">
                <a href="<?=base_url('restaurant/Service_Restaurant')?>" class="nav-link <?php if($this->router->class == 'Service_Restaurant' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vente</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('restaurant/Facture_Restaurant/listinglivrenopaye')?>" class="nav-link <?php if($this->router->class == 'Facture_Restaurant' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Facture restaurant</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('restaurant/Extra_Sortie/listing')?>" class="nav-link <?php if($this->router->class == 'Extra_Sortie' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Extrat Sortie</p>
                </a>
              </li>
 
            </ul>
          </li> -->

          <!-- <li class="nav-item has-treeview <?php if($this->router->class == 'Categorie_Chambre' || $this->router->class == 'Equipement_Chambre' || $this->router->class == 'Chambre' || $this->router->class == 'Reservation' || $this->router->class == 'Prise_Chambre' || $this->router->class == 'Salle' || $this->router->class == 'Check_Out'){ echo 'menu-open';} else{ echo '';}  ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bed"></i>
              <p>
                Hébergement 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=base_url()?>chambre/Categorie_Chambre/listing" class="nav-link <?php if($this->router->class == 'Categorie_Chambre' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categorie de Chambres</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?=base_url()?>chambre/Equipement_Chambre/listing" class="nav-link <?php if($this->router->class == 'Equipement_Chambre' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Equipents Chambres</p>
                </a>
              </li>

              
              <li class="nav-item">
                    <a href="<?=base_url('chambre/Chambre/listing')?>" class="nav-link <?php if($this->router->class == 'Chambre' ){ echo 'active';} else{ echo '';}  ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Chambres</p>
                    </a>
                  </li>

              
              <li class="nav-item">
                <a href="<?=base_url('reservation/Reservation')?>" class="nav-link <?php if($this->router->class == 'Reservation' ){ echo 'active';} else{ echo '';}  ?>">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Réservations</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>reservation/Prise_Chambre" class="nav-link  <?php if($this->router->class == 'Prise_Chambre' ){ echo 'active';} else{ echo '';}  ?>">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Check In</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>reservation/Prise_Chambre/listing" class="nav-link <?php if($this->router->class == 'Check_Out'){ echo 'active';} else{ echo '';}  ?>">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Check Out</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Planning chambre</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Paiement Chambre</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nettoyage de chambre</p>
                </a>
              </li>
            </ul>
          </li> -->



   <!--         <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Salle 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
      
              <li class="nav-item">
                <a href="<?=base_url('salle/Equipement_Salle/listing')?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Salle equipements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('salle/Salle/listing/')?>" class="nav-link <?php if($this->router->class == 'Salle' ){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Salles</p>
                </a>
              </li>

            </ul>
          </li> -->





         <!--  <li class="nav-item has-treeview <?php if($this->router->class == 'Type_Service' || $this->router->class == 'Service' || $this->router->class == 'Consomation_Service' || $this->router->class == 'Facturation'){ echo 'menu-open';} else{ echo '';}  ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cookie"></i>
              <p>
                Services 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
      
              <li class="nav-item">
                <a href="<?=base_url('service/Type_Service/listing')?>" class="nav-link <?php if($this->router->class == 'Type_Service'){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Types de Service</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url('service/Service/listing')?>" class="nav-link <?php if($this->router->class == 'Service'){ echo 'active';} else{ echo '';}  ?>">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Services</p>
                </a>
              </li>
            <li class="nav-item">
                <a href="<?=base_url()?>service/Consomation_Service/" class="nav-link <?php if($this->router->class == 'Consomation_Service'){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consommation</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=base_url()?>service/Facturation" class="nav-link <?php if($this->router->class == 'Facturation'){ echo 'active';} else{ echo '';}  ?>">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Facturation</p>
                </a>
              </li>
             
            </ul>
          </li> -->


          <li class="nav-item has-treeview <?php if($this->router->class == 'Configuration_Cotisation' || $this->router->class == 'Membre_Categorie' || $this->router->class == 'Ajout_Cotisation' || $this->router->class == 'Liste_Cotisation' || $this->router->class == 'Liste_Frais_Adhesion'){ echo 'menu-open';} else{ echo '';}  ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Cotisation 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
      
              <li class="nav-item">
                <a href="<?=base_url()?>cotisation/Configuration_Cotisation/" class="nav-link <?php if($this->router->class == 'Configuration_Cotisation'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Configuration cotisation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>cotisation/Membre_Categorie/" class="nav-link <?php if($this->router->class == 'Membre_Categorie'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Membre par categorie</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>cotisation/Ajout_Cotisation" class="nav-link <?php if($this->router->class == 'Ajout_Cotisation'){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Enregistrement cotisation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>cotisation/Liste_Cotisation" class="nav-link <?php if($this->router->class == 'Liste_Cotisation'){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste des cotisation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>cotisation/Liste_Frais_Adhesion" class="nav-link <?php if($this->router->class == 'Liste_Frais_Adhesion'){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste des frais d'adhesion</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rapport des cotisation</p>
                </a>
              </li> -->
            </ul>
          </li>


          <li class="nav-item has-treeview <?php if($this->router->class == 'Enregistrer_Consultation' || $this->router->class == 'Liste_Consultation_Hopital' || $this->router->class == 'Enregistrer_Medicament' || $this->router->class == 'Liste_Medicament_Pharmacie' || $this->router->class == 'Liste_Consultation' || $this->router->class == 'Consomation_Affilier' || $this->router->class == 'Consomation_Famille'){ echo 'menu-open';} else{ echo '';}  ?>">
            <a href="#" class="nav-link">
              <!-- <i class="nav-icon fas fa-money-check-alt"></i> -->
              <i class="nav-icon fas fa-file-medical-alt"></i>
              <p>
                Consomation 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <!-- <li class="nav-item">
                <a href="<?=base_url()?>cotisation/Configuration_Cotisation/" class="nav-link <?php if($this->router->class == 'Configuration_Cotisation'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Structure sanitaire</p>
                </a>
              </li> -->
      
              <li class="nav-item">
                <a href="<?=base_url()?>consultation/Enregistrer_Consultation/" class="nav-link <?php if($this->router->class == 'Enregistrer_Consultation'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fiches de consultation</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?=base_url()?>consultation/Liste_Consultation_Hopital/indexs" class="nav-link <?php if($this->router->class == 'Liste_Consultation_Hopital'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste des consultations</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?=base_url()?>consultation/Liste_Consultation/" class="nav-link <?php if($this->router->class == 'Liste_Consultation'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Archivage consultations</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?=base_url()?>consultation/Enregistrer_Medicament/" class="nav-link <?php if($this->router->class == 'Enregistrer_Medicament'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bon de medicament</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>consultation/Liste_Medicament_Pharmacie/" class="nav-link <?php if($this->router->class == 'Liste_Medicament_Pharmacie'){ echo 'active';} else{ echo '';}  ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste Medicament prise</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>consultation/Consomation_Affilier" class="nav-link <?php if($this->router->class == 'Consomation_Affilier'){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consomations Affilié</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>consultation/Consomation_Famille" class="nav-link <?php if($this->router->class == 'Consomation_Famille'){ echo 'active';} else{ echo '';}  ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consomations Groupe</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rapports consomations</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rapport des cotisation</p>
                </a>
              </li> -->
            </ul>
          </li>






              <!-- <li class="nav-item">
                <a href="<?=base_url('reservation/Prise_Chambre')?>" class="nav-link">  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prise de chambre</p>
                </a>
              </li> -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>