   <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';

  ?>

 

<style type="text/css">
  .highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 660px;
    margin: 1em auto;
}

.highcharts-data-table table { 
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tbody tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

.highcharts-description {
    margin: 0.3rem 10px;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid"> 
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Analyse des écarts</h3>
              </div>

             <form id="FormDatayanje" action="<?php echo base_url('dashboard/Tableau_Cotisation')?>" method="POST"  enctype="multipart/form-data">
          <div class="col-sm-12">
            <div class="row">
            <div class="form-group col-sm-4">
                          <label for="MOIS">
                          MOIS
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="month" id="MOIS" name="MOIS" class="form-control"  value="<?=set_value('MOIS');?>" id="MOIS"  onchange="subb()">
            </div>
<!-- 
            <div class="form-group col-md-4">
                <label for="ID_GROUPE">
                          Société
                          </label>
                          <select class="form-control"  onchange="liste()" name="ID_GROUPE" id="ID_GROUPE">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($groupe as $value) { 
                            if (set_value('ID_GROUPE') == $value['ID_GROUPE']) {
                            ?>
                            <option value="<?=$value['ID_GROUPE']?>" selected><?=$value['NOM_GROUPE']?></option>
                            <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_GROUPE']?>"><?=$value['NOM_GROUPE']?></option>
                              <?php
                              }
                           } 
                           ?>
                          </select><br>
              </div> -->

              <div class="col-md-4">
                <label for="ID_CATEGORIE_ASSURANCE">Cat&eacute;gorie </label>
                  <select class="form-control"  onchange="subb()" name="ID_CATEGORIE_ASSURANCE" id="ID_CATEGORIE_ASSURANCE" onchange="subb()">
                  <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($cotisation as $value) { 
                            if (set_value('ID_CATEGORIE_ASSURANCE') == $value['ID_CATEGORIE_ASSURANCE']) {
                            ?>
                            <option value="<?=$value['ID_CATEGORIE_ASSURANCE']?>" selected><?=$value['DESCRIPTION']?></option>
                            <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_CATEGORIE_ASSURANCE']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                              }
                           } 
                           ?>
                </select><br>
              </div>


              <div class="col-md-4">
                <label for="ID_GROUPE">Croupe </label>
                  <select class="form-control"  onchange="subb()" name="ID_GROUPE" id="ID_GROUPE"  onchange="subb()">
                  <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($groupe as $value) { 
                            if (set_value('ID_GROUPE') == $value['ID_GROUPE']) {
                            ?>
                            <option value="<?=$value['ID_GROUPE']?>" selected><?=$value['NOM_GROUPE']?></option>
                            <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_GROUPE']?>"><?=$value['NOM_GROUPE']?></option>
                              <?php
                              }
                           } 
                           ?>
                </select><br>
              </div>
            <!-- <div class="form-group col-md-2"><br>
                      <input type="submit" value="Chercher" class="btn btn-primary"/>
            </div> -->
            </div>

            
          </div>
          </form>
              <!-- /.card-header -->
              <!-- form start -->

 <div class="card-body table-responsive">
  

<div class="row"><div class="col-md-6"><div id="container"></div></div><div class="col-md-6"><div id="rapports"></div></div></div>



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
<script>

  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
    });
</script>

  <script type="text/javascript">
  // Destroy previous chart if it exists
  if (window.myChartRapports && typeof window.myChartRapports.destroy === 'function') {
      window.myChartRapports.destroy();
  }

  // Create and store the new chart
  window.myChartRapports = Highcharts.chart('rapports', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Consommation vs Cotisations'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
          point: {
              valueSuffix: '%'
          }
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: false
              },
              showInLegend: true
          }
      },
      series: [{
          name: 'Brands',
          colorByPoint: true,
          data: [{
              name: ' Consommations (<?= number_format($data3,0,","," ")?>)',
              y: <?=$data3?>,
              sliced: true,
              selected: true
          },  {
              name: ' Cotisations (<?= number_format($data4,0,","," ")?>)',
              y: <?=$data4?>
          }]
      }]
  });
</script>
</script>
<!-- <script type="text/javascript">
  // Keep a reference to the chart
  if (window.myChartRapports) {
      window.myChartRapports.destroy();
  }

  window.myChartRapports = Highcharts.chart('rapports', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Tableau des cotisations 2022'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
          point: {
              valueSuffix: '%'
          }
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: false
              },
              showInLegend: true
          }
      },
      series: [{
          name: 'Brands',
          colorByPoint: true,
          data: [{
              name: 'Musumba steel',
              y: 74.77,
              sliced: true,
              selected: true
          }, {
              name: 'RUSS',
              y: 12.82
          }, {
              name: 'SOPRAD RUYIGI ',
              y: 4.63
          }, {
              name: 'TUGWIZE UMWETE TWESE',
              y: 2.44
          }, {
              name: 'Internet Explorer',
              y: 2.02
          }, {
              name: 'Other',
              y: 3.28
          }]
      }]
  });
</script> -->

 <!-- <script type="text/javascript">
 Highcharts.chart('rapports',{
           chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Cotisations'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
        },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
  
    plotOptions: {
        pie: {
             allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
       cursor:'pointer',
             point:{
                events: {
            click: function()
                    {    
                       

                   }
               }
           },
         showInLegend: true
     }
 },

    credits: {
  enabled: true,
  href: "",
  text: "GAZS"
},      
    series: [{
        type: 'pie',
        name: 'date',
        data: [
          {name:'name1: 20 ',y:5,key4:1,color:'#ADD8E6'},
          {name:'name2: 30 ',y:5,key4:1,color:'#ADD8E6'},
          {name:'name3: 21 ',y:2,key4:1,color:'#ADD8E6'},

        ]
    }]
   
});
 </script>";
 -->
 <script type="text/javascript">
   Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Cotisations et Consommations par groupe'
    },
    subtitle: {
        text:
            ''
    },
    xAxis: {
        categories: [<?=$categorie?>],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Montant'
        }
    },
    tooltip: {
        valueSuffix: ' (FBU)'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Consommations',
            data: [<?=$data2?>]
        },
        {
            name: 'Cotisations',
            data: [<?=$data1?>]
        }
    ]
});

 </script>
 <script type="text/javascript">
function subb() {

var id=document.getElementById('FormDatayanje');

// console.log(id);

id.submit();


}
 </script>

</body>
</html>
