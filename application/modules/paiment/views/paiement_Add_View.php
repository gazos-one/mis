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
               <!-- <form id="FormData" action="#" method="POST"> -->
                 <form id="FormData" action="<?php echo base_url()?>paiment/Paiment_facture/add" method="POST" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-12">
                      <h4>Identification de l'Affilié</h4>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="DATE_ENREGISTREMENT">
                       Date
                       <i class="text-danger"> *</i>
                     </label>
                     <input type="date" name="DATE_ENREGISTREMENT" class="form-control" value="<?=set_value('DATE_ENREGISTREMENT')?>" id="DATE_ENREGISTREMENT">
                     <?php echo form_error('DATE_ENREGISTREMENT', '<div class="text-danger">', '</div>'); ?>
                   </div>
                   <div class="form-group col-md-4">
                    <label for="DESCRIPTION">
                      Libellés
                      <i class="text-danger"> *</i>
                    </label>
                    <input type="text" name="DESCRIPTION" class="form-control" value="<?=set_value('DESCRIPTION')?>" id="DESCRIPTION">
                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="NUMERO_FACTURE">
                     N° Facture
                     <i class="text-danger"> *</i>
                   </label>
                   <input type="text" name="NUMERO_FACTURE" class="form-control" value="<?=set_value('NUMERO_FACTURE')?>" id="NUMERO_FACTURE">
                   <?php echo form_error('NUMERO_FACTURE', '<div class="text-danger">', '</div>'); ?>
                 </div>

                
                  <div class="form-group col-md-4">
                    <label for="MOI_ANNEE">
                     Le mois
                     <i class="text-danger"> *</i>
                   </label>
                   <input type="month" name="MOI_ANNEE" class="form-control" value="<?=set_value('MOI_ANNEE')?>" id="MOI_ANNEE">
                   <?php echo form_error('MOI_ANNEE', '<div class="text-danger">', '</div>'); ?>
                 </div>

                 
                 <div class="form-group col-md-4">
                  <label for="ID_TYPE">
                   Type structure
                   <i class="text-danger"> *</i>
                 </label>
                 <select class="form-control"   name="ID_TYPE" id="ID_TYPE" onchange="toggleStructureFields()">
                  <option value="">-- Sélectionner --</option>
                  <option value="1">Hopital</option>
                  <option value="2">Pharmacie</option>
                </select>
                <?php echo form_error('ID_TYPE', '<div class="text-danger">', '</div>'); ?>
              </div>
              <div class="form-group col-md-4" id="hopital_div">
               <label for="ID_STRUCTURE">
                 Hopitaux
                 <i class="text-danger"> *</i>
               </label>
               <select class="form-control select2"  name="ID_STRUCTURE" id="ID_STRUCTURE">
                <option value="">-- Sélectionner --</option>
                <?php
                foreach ($hopitaux as $key => $value) { 
                  ?>
                  <option value="<?=$value['ID_STRUCTURE']?>"><?=$value['DESCRIPTION']?></option>
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
                <option value="<?=$value['ID_PHARMACIE']?>"><?=$value['DESCRIPTION']?></option>
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
            <input type="text" name="NUMERO_COMPTE" class="form-control" value="<?=set_value('NUMERO_COMPTE')?>" id="NUMERO_COMPTE">
            <?php echo form_error('NUMERO_COMPTE', '<div class="text-danger">', '</div>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label for="BANQUE">
              Banque
              <i class="text-danger"> *</i>
            </label>
            <input type="text" name="BANQUE" class="form-control" value="<?=set_value('BANQUE')?>" id="BANQUE">
            <?php echo form_error('BANQUE', '<div class="text-danger">', '</div>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label for="MONTANT">
             Montant
             <i class="text-danger"> *</i>
           </label>
           <input type="text" name="MONTANT" class="form-control" value="<?=set_value('MONTANT')?>" id="MONTANT">
           <?php echo form_error('MONTANT', '<div class="text-danger">', '</div>'); ?>
         </div>

<div class="form-group col-md-4">
        <label for="OBSERVATION">
         Observation
         <i class="text-danger"> </i>
       </label>
        <textarea id="OBSERVATION" class="form-control" name="OBSERVATION" rows="4" cols="50" placeholder="...." value="<?=set_value('OBSERVATION')?>" ></textarea>
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
  } 
}
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>