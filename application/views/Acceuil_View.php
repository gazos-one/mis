  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include VIEWPATH.'includes/new_smenu.php';
    ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="col-12">
        <?php 
             if(!empty($this->session->flashdata('message')))
               echo $this->session->flashdata('message');
               // echo $this->table->generate($employe);
            ?>
      </div>
      <div class="container-fluid row">
        
            <!-- <div class="col-8 text-center">
              <img src="<?php echo base_url() ?>dist/img/mislogo.png" alt=""></div> -->
    
            <div class="col-7">
              <h3 class="text-center">
                <br><br><br><br><br><br>
                Logiciel d'enregistrement des Membres de la Mutualité Interprofessionnelle de Santé et la Génération de leurs Cartes Mutuelles des Membres!
                     </h3>
            </div><br>
            <div class="col-5 text-center"><img src="<?php echo base_url() ?>dist/img/mis2.JPG" alt="" style="max-width: 80%" ></div>
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
    });
</script>