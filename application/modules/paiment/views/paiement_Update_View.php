  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_paiment.php';
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid"> 
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <?php 
            if(!empty($this->session->flashdata('message')))
             echo $this->session->flashdata('message');
           ?>
           <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">Ajout d'un affili&eacute;</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">

               <form id="FormData" action="<?php echo base_url()?>paiment/Paiment_facture/update" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-12">
                    <h4>Identification de l'Affilié</h4>
                  </div>
                  <input type="hidden" name="ID_FACTURE" class="form-control"  id="ID_FACTURE" value="<?= $facturations['ID_FACTURE']?>" >

                 <div class="form-group col-md-4">
                      <label for="DATE_ENREGISTREMENT">
                       Date
                       <i class="text-danger"> *</i>
                     </label>
                     <input type="date" name="DATE_ENREGISTREMENT" class="form-control" value="<?=set_value('DATE_ENREGISTREMENT',$facturations['DATE_ENREGISTREMENT'])?>" id="DATE_ENREGISTREMENT">
                     <?php echo form_error('DATE_ENREGISTREMENT', '<div class="text-danger">', '</div>'); ?>
                   </div>
                   <div class="form-group col-md-4">
                    <label for="DESCRIPTION">
                      Libellés
                      <i class="text-danger"> *</i>
                    </label>
                    <input type="text" name="DESCRIPTION" class="form-control" value="<?=set_value('DESCRIPTION',$facturations['DESCRIPTION'])?>" id="DESCRIPTION">
                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="NUMERO_FACTURE">
                     N° Facture
                     <i class="text-danger"> *</i>
                   </label>
                   <input type="text" name="NUMERO_FACTURE" class="form-control" value="<?=set_value('NUMERO_FACTURE',$facturations['NUMERO_FACTURE'])?>" id="NUMERO_FACTURE" readonly>
                   <?php echo form_error('NUMERO_FACTURE', '<div class="text-danger">', '</div>'); ?>
                 </div>


                 <div class="form-group col-md-4">
                    <label for="MOI_ANNEE">
                     Le mois
                     <i class="text-danger"> *</i>
                   </label>
                   <input type="month" name="MOI_ANNEE" class="form-control" value="<?=set_value('MOI_ANNEE',$facturations['MOI_ANNEE'])?>" id="MOI_ANNEE">
                   <?php echo form_error('MOI_ANNEE', '<div class="text-danger">', '</div>'); ?>
                 </div>

                <div class="form-group col-md-4">
                  <label for="ID_TYPE">
                   Type structure
                   <i class="text-danger"> *</i>
                 </label>
                 <select class="form-control"   name="ID_TYPE" id="ID_TYPE" onchange="toggleStructureFields()">
                  <option value="">-- Sélectionner --</option>
                  <?php if($facturations['ID_TYPE'] ==1){?>
                    <option value="1" selected>Hopital</option>
                    <option value="2">Pharmacie</option>
                    <?php
                  }elseif($facturations['ID_TYPE'] ==2){ ?>
                    <option value="1">Hopital</option>
                    <option value="2" selected>Pharmacie</option>
                    <?php
                  }elseif($facturations['ID_TYPE'] ==2){ ?>

                    <option value="1">Hopital</option>
                    <option value="2">Pharmacie</option>
                    <?php
                  } ?>
                </select>
                <?php echo form_error('ID_TYPE', '<div class="text-danger">', '</div>'); ?>
              </div>
              <div class="form-group col-md-4" id="hopital_div">
               <label for="ID_STRUCTURE">
                 Struccture sanitaire
                 <i class="text-danger"> *</i>
               </label>
               <select class="form-control select2"  name="ID_STRUCTURE" id="ID_STRUCTURE">
                <option value="">-- Sélectionner --</option>
                <?php
                foreach ($hopitaux as $key => $value) { 
                  ?>
                  <?php if($facturations['ID_STRUCTURE'] ==$value['ID_STRUCTURE']){?>
                    <option value="<?=$value['ID_STRUCTURE']?>" selected><?=$value['DESCRIPTION']?></option>
                    <?php
                  }else{ ?>
                   <option value="<?=$value['ID_STRUCTURE']?>"><?=$value['DESCRIPTION']?></option>
                   <?php
                 } ?>

                 <?php
               } 
               ?>

             </select>
             <?php echo form_error('ID_STRUCTURE', '<div class="text-danger">', '</div>'); ?>
           </div>
           <div class="form-group col-md-4" id="pharmacie_div">
            <label for="ID_PHARMACIE">
             Pharmacie
             <i class="text-danger"> *</i>
           </label>
           <select class="form-control select2" name="ID_PHARMACIE" id="ID_PHARMACIE">
            <option value="">-- Sélectionner --</option>
            <?php
            foreach ($pharmacies as $key => $value) { 
              ?>
              <?php if($facturations['ID_PHARMACIE'] ==$value['ID_PHARMACIE']){?>
                <option value="<?=$value['ID_PHARMACIE']?>" selected><?=$value['DESCRIPTION']?></option>
                <?php
              }else{ ?>
               <option value="<?=$value['ID_PHARMACIE']?>"><?=$value['DESCRIPTION']?></option>
               <?php
             } ?>
             <?php
           } 
           ?>
         </select>
         <?php echo form_error('ID_PHARMACIE', '<div class="text-danger">', '</div>'); ?>
       </div>

      <div class="form-group col-md-4">
        <label for="NUMERO_COMPTE">
          Numero Compte
          <i class="text-danger"> *</i>
        </label>
        <input type="text" name="NUMERO_COMPTE" class="form-control" value="<?=set_value('NUMERO_COMPTE',$facturations['NUMERO_COMPTE'])?>" id="NUMERO_COMPTE">
        <?php echo form_error('NUMERO_COMPTE', '<div class="text-danger">', '</div>'); ?>
      </div>

      <div class="form-group col-md-4">
            <label for="BANQUE">
              Banque
              <i class="text-danger"> *</i>
            </label>
            <input type="text" name="BANQUE" class="form-control" value="<?=set_value('BANQUE',$facturations['BANQUE'])?>" id="BANQUE">
            <?php echo form_error('BANQUE', '<div class="text-danger">', '</div>'); ?>
          </div>

      <div class="form-group col-md-4">
        <label for="MONTANT">
         Montant
         <i class="text-danger"> *</i>
       </label>
       <input type="text" name="MONTANT" class="form-control" value="<?=set_value('MONTANT',$facturations['MONTANT'])?>" id="MONTANT">
       <?php echo form_error('MONTANT', '<div class="text-danger">', '</div>'); ?>
     </div>


    <div class="form-group col-md-4">
        <label for="OBSERVATION">
         Observation
         <i class="text-danger"> </i>
       </label>
        <textarea id="OBSERVATION" class="form-control" name="OBSERVATION" rows="4" cols="50" placeholder="...." value="<?=set_value('OBSERVATION',$facturations['OBSERVATION'])?>" ></textarea>
       <?php echo form_error('OBSERVATION', '<div class="text-danger">', '</div>'); ?>
     </div>

   </div>

   <div class="row"><br>
    <div class="col-12 text-center" id="divdata" style="margin-top: 10px">
      <input type="submit" value="Enregistrer" class="btn btn-primary"/>
    </div>
  </div>
</form>
</div> 
</div>


<div class="modal fade" id="modalsm">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ajout d'un emploi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="myformsassuree" method="POST" onsubmit="addmetier();return false" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="row">
           <div class="form-group col-md-12">
            <label for="NOMMETIER">
             Emploi
             <i class="text-danger"> *</i>
           </label>
           <input type="text" name="NOMMETIER" class="form-control" value="" id="NOMMETIER">
           <?php echo form_error('NOMMETIER', '<div class="text-danger">', '</div>'); ?>
         </div>



       </div>                                    
     </div>
     <div class="modal-footer justify-content-between">
      <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      <input type="submit" value="Enregistrer" class="btn btn-primary"/>
    </div>
  </div>
</form>





</div>
</div>


<!-- /.card -->
</div>
<!--/.col (left) -->
<!-- right column -->
<div class="col-md-6">
</div>
<!--/.col (right) -->
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<?php
include VIEWPATH.'includes/new_copy_footer.php';
?>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php
include VIEWPATH.'includes/new_script.php';
?>
<!-- jQuery -->

</body>
</html>
<script>
  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');

    $('#pharmacie_div').hide()
    $('#hopital_div').hide();
    toggleStructureFields()
  });
</script>

<script>
  function toggleStructureFields() {
    var idType = $('#ID_TYPE').val();

    if (idType == "1") { // Si l'utilisateur sélectionne "Hôpital"
     $('#pharmacie_div').hide()
   $('#hopital_div').show();
    } else if (idType == "2") { // Si l'utilisateur sélectionne "Pharmacie"
    $('#pharmacie_div').show()
    $('#hopital_div').hide();
  }else{

    $('#pharmacie_div').hide()
    $('#hopital_div').hide();
  }
}
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>