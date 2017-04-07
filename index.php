<?php
include 'conspath.php';
include_once (AS_PATH.'/classes/dbAdmin.php');

// $path = "'".PATH."'";
$path = "'"."http://".$_SERVER['SERVER_NAME']."'";
$username = $_GET['u'];
$usernameToString = "'".$username."'";


$userlist = dbAdmin::getInstancia()->getAllFromUser();

$userdata = dbAdmin::getInstancia()->getAllFromUserByUsername($username);

// print_all($userlist);

// print_all($userdata);


// echo $username;
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <!-- More info https://datatables.net/examples/index -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
        <!--<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>-->

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="bower_components/bootstrap-table/src/bootstrap-table.css">
        <link rel="stylesheet" href="css/cotz-index.css">
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      
        <script src="https://use.fontawesome.com/5b1d115124.js"></script>

    </head>
    <body>


    <div class="filter-by-data">
      <p><h3>Filtros </h3> Desde: <input type="text" id="datepicker_from"> Hasta: <input type="text" id="datepicker_to"> <a href="#" class="btn btn-default">Filtrar</a></p>
    </div>
    <br>

        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
      <table id="table" data-pagination="true" 
                        data-show-export="true" data-export-types="['csv', 'txt', 'excel']"
                        data-search="true" data-search-on-enter-key="true"  data-smart-display="true"
                        data-page-size="10" data-page-list="[10,25,50,100]">
      <thead>
      <tr>  
        <th data-field="id" data-sortable="true">Cot #</th>
        <th data-field="name" data-sortable="true">Cliente</th>
        <th data-field="username" data-sortable="true">Vendedor</th>
        <th data-field="marca" data-sortable="true">Marca</th>
        <th data-field="fase" data-sortable="true">Fase</th>
        <th data-field="total" data-sortable="true">Monto</th>
        <!-- <th data-field="description" data-sortable="true">Descripcion</th> -->
        <th data-field="fecha_cotizacion" data-sortable="true">Fecha de Cotizacion</th>
        <th data-field="id" data-events="edit" data-formatter="editBtn"></th>
        <th data-field="delete" data-events="edit" data-formatter="deletetBtn"></th>
      </tr>
      </thead>
      </table>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
      <script src="js/vendor/bootstrap.min.js"></script>

      <script src="bower_components/bootstrap-table/src/bootstrap-table.js"></script>
      <script src="bower_components/bootstrap-table/src/locale/bootstrap-table-es-CR.js"></script>
      <script src="js/export-table.js"></script>
      <script src="js/vendor/tableExport/tableExport.min.js"></script>
      <script type="text/javascript" src="js/vendor/tableExport/libs/FileSaver/FileSaver.min.js"></script>
      <script type="text/javascript" src="js/vendor/tableExport/libs/js-xlsx/xlsx.core.min.js"></script>
      <script type="text/javascript">
       
         $( function() {
          $( "#datepicker_from" ).datepicker();
          $( "#datepicker_to" ).datepicker();
        } );

        $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['es-CR']);
        
        var edit = { 
            'click .like': function (e, value, row, index) { 
                $('#table').tableExport({type:'csv'}); 
            }
        };

        function updateCot(value){
            var username = <?php echo json_encode($username) ?>;
            window.location.href = "cotz_update.php?u="+username+"&cotId="+value;
        }

        var editBtn = function (value) { 
            
           

             return '<a href="#" class="edit edit-cot" onclick="updateCot('+value+')" data="$id"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
        };

        var deletetBtn = function (value) { 
             return '<a href="#" class="edit" data="$id"><i class="fa fa-times" aria-hidden="true"></i></a>';
        };

        var createCotBtn = function(){
          var username = <?php echo json_encode($username) ?>;
          // console.log(typeof username);
          return '<button class="btn btn-primary" onclick="gotoCotz(`'+username+'`)" type="button" aria-expanded="false"><i class="fa fa-plus-circle"></i> Crear Cotizacion</button>';
        }

        function gotoCotz(id){
          // console.log('id',id);
          // if(id===null || typeof id === 'undefined'){
          //   window.location.href = "cotz.php?u="+id;
          // }
           window.location.href = "cotz.php?u="+id;
          parent.iframeLoaded();
        }

      $(function () {

        // $.get(<?php echo $path; ?>+'/cotz/services/cotz.php?action=get_cotizacionesAllMIN')
        //   .done(function( data ) {
        //     console.log('?');
        //     console.log(data);
        //   });

         parent.iframeLoaded();
          $('#table').bootstrapTable({
             url: <?php echo $path; ?>+'/cotz/services/cotz.php?action=get_cotizacionesAllMIN',
             onDblClickRow: function(row, $element, field){
              var cotID = row['id'];
             },
             onLoadSuccess: function(){
               parent.iframeLoaded(); 
             },
             onAll: function(name, args){
                parent.iframeLoaded();
             }
          });
          $('.fixed-table-toolbar').prepend(createCotBtn);
      });

      </script>

  </body>
</html>
