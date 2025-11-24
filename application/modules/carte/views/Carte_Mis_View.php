 <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>

  <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">

  <link href="https://api.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.css" rel="stylesheet">
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.js"></script>
  <script src="https://unpkg.com/@turf/turf/turf.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    #map {width: 102%;height: 600px;border-radius: 20px; margin-top: -14px; margin-bottom: -10px;margin-left:-10px;z-index: 1;}

    .mapbox-improve-map{
      display: none;
    }

    .leaflet-control-attribution{
      display: none !important;
    }
    .leaflet-control-attribution{
      display: none !important;
    }
    .search-ui {

    }

    .circle-green {
      background-color: #829b35;
      border-radius: 50%
    }

    .dash_card:hover {
      color: cadetblue;
      background-color: rgba(95, 158, 160,0.3);
    }


    .marker {
      background-image: url('<?= base_url() ?>/upload/vehicule_icon_marker.png');
      background-size: cover;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      cursor: pointer; }

      .map-legend {
  position: absolute;
  bottom: 20px;
  left: 20px;
  background: white;
  padding: 10px 15px;
  border-radius: 8px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.3);
  font-size: 14px;
  z-index: 2;
}

.map-legend h4 {
  margin: 0 0 8px;
  font-size: 16px;
}

.legend-color {
  display: inline-block;
  width: 16px;
  height: 16px;
  margin-right: 8px;
  vertical-align: middle;
  border-radius: 3px;
}
    }

  </style>
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
                <h3 class="card-title">CARTE MIS</h3> 
              </div>
              <!-- /.card-header -->
              <!-- form start -->

 <div class="card-body table-responsive">

<div class="row">

<div class="col-md-12">
<div id ="map">
  <div id="map-legend" class="map-legend">
  <h4>Légende</h4>
  <div><span class="legend-color" style="background:#FF0000;"></span> AGENCE</div>
  <div><span class="legend-color" style="background:#00FF00;"></span> AFFILIES</div>
  <div><span class="legend-color" style="background:#0000FF;"></span> HOPITAUX</div>
  <div><span class="legend-color" style="background:#000320;"></span> PHARMACIES</div>
</div>
</div>  



</div>
</div>


      


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
  $('#mytable').DataTable({
   dom: 'Bfrtlip',
   "paging":   true,
    "ordering": true,
    "info":     true,
    "lengthChange": true,
   buttons: [
      {
         extend: 'excel',
         text: 'Excel',
         className: 'btn btn-default',
         exportOptions: {
            columns: 'th:not(:last-child)'
         }
      },
      {
         extend: 'pdfHtml5',
         text: 'PDF',
         className: 'btn btn-default',
         exportOptions: {
            columns: 'th:not(:last-child)'
         }
      }
   ],
   language: {
                                "sProcessing":     "Traitement en cours...",
                                "sSearch":         "Rechercher&nbsp;:",
                                "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                                "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                                "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                "sInfoPostFix":    "",
                                "sLoadingRecords": "Chargement en cours...",
                                "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                                "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                                "oPaginate": {
                                    "sFirst":      "Premier",
                                    "sPrevious":   "Pr&eacute;c&eacute;dent",
                                    "sNext":       "Suivant",
                                    "sLast":       "Dernier"
                                },
                                "oAria": {
                                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                                }
                        }
});
</script>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoibWFydGlubWJ4IiwiYSI6ImNrMDc0dnBzNzA3c3gzZmx2bnpqb2NwNXgifQ.D6Fm6UO9bWViernvxZFW_A';

const coord = '29.3604533,-3.3804751'.split(",");
const zoom = 2;

const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v12',
    center: [parseFloat(coord[1]), parseFloat(coord[0])],
    zoom: zoom,
    projection: "globe"
});

map.addControl(new mapboxgl.NavigationControl());
map.addControl(new mapboxgl.FullscreenControl());

map.on('load', () => {
    const colorsByGroup = {
        group1: '<?= $mesdonnees ?>',   // "#FF0000"
        group2: '<?= $mesdonnees2 ?>',  // "#00FF00"
        group3: '<?= $mesdonnees3 ?>',  // "#0000FF"
        group4: '<?= $mesdonnees4 ?>'   // "#000320"
    };

    const allData = [
        { raw: '<?= $mesdonnees ?>', group: 'group1' },
        { raw: '<?= $mesdonnees2 ?>', group: 'group2' },
        { raw: '<?= $mesdonnees3 ?>', group: 'group3' },
        { raw: '<?= $mesdonnees4 ?>', group: 'group4' }
    ];

    const features = [];

    allData.forEach(({ raw, group }) => {
        if (!raw) return;
        const points = raw.split('@');
        for (let i = 0; i < points.length - 1; i++) {
            const index = points[i].split('<>');
            if (index.length < 4) continue;
            features.push({
                type: 'Feature',
                geometry: {
                    type: 'Point',
                    coordinates: [parseFloat(index[2]), parseFloat(index[1])]
                },
                properties: {
                    title: index[3],
                    description: (index[4] ?? '') + ' - ' + (index[5] ?? ''),
                    group: group
                }
            });
        }
    });

    map.addSource('points', {
        type: 'geojson',
        data: {
            type: 'FeatureCollection',
            features: features
        },
        cluster: true,
        clusterMaxZoom: 14,
        clusterRadius: 50
    });

    map.addLayer({
        id: 'clusters',
        type: 'circle',
        source: 'points',
        filter: ['has', 'point_count'],
        paint: {
            'circle-color': '#FF6600',
            'circle-radius': [
                'step',
                ['get', 'point_count'],
                20, 10, 30, 30, 40
            ]
        }
    });


    map.addLayer({
        id: 'cluster-count',
        type: 'symbol',
        source: 'points',
        filter: ['has', 'point_count'],
        layout: {
            'text-field': '{point_count_abbreviated}',
            'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
            'text-size': 12
        }
    });

    map.addLayer({
        id: 'unclustered-point',
        type: 'circle',
        source: 'points',
        filter: ['!', ['has', 'point_count']],
        paint: {
            'circle-color': [
                'match',
                ['get', 'group'],
                'group1', '#FF0000',
                'group2', '#00FF00',
                'group3', '#0000FF',
                'group4', '#000320',
                '#888' // fallback
            ],
            'circle-radius': 6,
            'circle-stroke-width': 1,
            'circle-stroke-color': '#fff'
        }
    });

    map.on('click', 'unclustered-point', (e) => {
        const coordinates = e.features[0].geometry.coordinates.slice();
        const { title, description } = e.features[0].properties;

        new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(`<div><h5>Détail</h5><p class="text-center">${title}</p><p class="text-muted small pt-2 ps-1">${description}</p></div>`)
            .addTo(map);
    });

    map.on('click', 'clusters', (e) => {
        const features = map.queryRenderedFeatures(e.point, {
            layers: ['clusters']
        });
        const clusterId = features[0].properties.cluster_id;
        map.getSource('points').getClusterExpansionZoom(clusterId, (err, zoom) => {
            if (err) return;

            map.easeTo({
                center: features[0].geometry.coordinates,
                zoom: zoom
            });
        });
    });

    map.on('mouseenter', 'clusters', () => {
        map.getCanvas().style.cursor = 'pointer';
    });
    map.on('mouseleave', 'clusters', () => {
        map.getCanvas().style.cursor = '';
    });
});
</script>

<!-- <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoibWFydGlubWJ4IiwiYSI6ImNrMDc0dnBzNzA3c3gzZmx2bnpqb2NwNXgifQ.D6Fm6UO9bWViernvxZFW_A';

    var coord = '29.3604533,-3.3804751'.split(",");
    var zoom = 7;

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [parseFloat(coord[1]), parseFloat(coord[0])],
        zoom: zoom,
        bounds: [
            [29.3604533, -3.3804751],
            [29.3604533, -3.3804751]
        ],
        projection: "globe"
    });

    map.addControl(new mapboxgl.NavigationControl());
    map.addControl(new mapboxgl.FullscreenControl());

    // Optional: Marker at center
    new mapboxgl.Marker()
        .setLngLat([parseFloat(coord[1]), parseFloat(coord[0])])
        .addTo(map);
     map.on('load', async () => {

        //// Fly the map to the location.
                // map.flyTo({
                //     center: [coord[1],coord[0]],
                //     speed: 0.5
                // });


    var donn = '<?= $mesdonnees?>';

    var donn = donn.split('@');

    for (var i = 0; i < (donn.length)-1; i++) {
     var index = donn[i].split('<>');


      // Créez le popup
const popup = new mapboxgl.Popup({ offset: 25 }).setHTML('<div><h5>Détail</h5><p class="text-center">'+ index[3] +'</p> <p class="text-muted small pt-2 ps-1">'+ index[4] +' - '+ index[5] +'</p></div>');


     var color = ' ';

 
         color = '#FF0000';
    


     const marker = new mapboxgl.Marker({ color:color, rotation: 360})
        .setLngLat([index[2],index[1]])
        .setPopup(popup)
        .addTo(map);
    }


    var donn2 = '<?= $mesdonnees2?>';

    var donn2 = donn2.split('@');

    for (var i = 0; i < (donn2.length)-1; i++) {
     var index = donn2[i].split('<>');


      // Créez le popup
const popup = new mapboxgl.Popup({ offset: 25 }).setHTML('<div><h5>Détail</h5><p class="text-center">'+ index[3] +'</p></div>');


     var color = ' ';

 
         color = '#FF0000';
    


     const marker = new mapboxgl.Marker({ color:color, rotation: 360})
        .setLngLat([index[2],index[1]])
        .setPopup(popup)
        .addTo(map);
    }


     var donn3 = '<?= $mesdonnees3?>';

    var donn3 = donn3.split('@');

    for (var i = 0; i < (donn3.length)-1; i++) {
     var index = donn3[i].split('<>');


      // Créez le popup
    const popup = new mapboxgl.Popup({ offset: 25 }).setHTML('<div><h5>Détail</h5><p class="text-center">'+ index[3] +'</p></div>');


     var color = ' ';

 
         color = '#FF0000';
    


     const marker = new mapboxgl.Marker({ color:color, rotation: 360})
        .setLngLat([index[2],index[1]])
        .setPopup(popup)
        .addTo(map);
    }



    var donn4 = '<?= $mesdonnees4?>';

    var donn4 = donn4.split('@');

    for (var i = 0; i < (donn4.length)-1; i++) {
     var index = donn4[i].split('<>');


      // Créez le popup
    const popup = new mapboxgl.Popup({ offset: 25 }).setHTML('<div><h5>Détail</h5><p class="text-center">'+ index[3] +'</p></div>');


     var color = ' ';

 
         color = '#FF0000';
    


     const marker = new mapboxgl.Marker({ color:color, rotation: 360})
        .setLngLat([index[2],index[1]])
        .setPopup(popup)
        .addTo(map);
    }






    });
</script> -->




</body>
</html>
