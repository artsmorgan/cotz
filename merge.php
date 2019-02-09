<?php
error_reporting(E_ALL);
  ini_set('display_errors', 1);
include 'conspath.php';
include_once (AS_PATH.'/classes/dbAdmin.php');

// $path = "'".PATH."'";
$path = "'"."http://".$_SERVER['SERVER_NAME']."'";
$username = $_GET['u'];


// echo 'username ' .$username;

$userlist = dbAdmin::getInstancia()->getAllFromUser(true);

$userdata = dbAdmin::getInstancia()->getAllFromUserByUsername($username);

// print_all($userlist);
// echo '---------------------------';
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
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/select2.min.css">
        <link rel="stylesheet" href="css/main.css?v=1.0.0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="css/select2.min.css">
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <style type="text/css">

        body .muted{
          color: #ccc !important;
        }

          body{
            min-height: 550px;
          }

          .filter .btn{
            color: #fff !important;
          }
          tbody > tr > td{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
              font-size: 12px;
              color: #545454;
          }
          thead {
              background-color: #f4f4f4;
              background-repeat: repeat-x;
              background-image: -ms-linear-gradient(top,#f9f9f9,#f4f4f4);
              background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#f9f9f9),color-stop(100%,#f4f4f4));
              background-image: -webkit-linear-gradient(top,#f9f9f9,#f4f4f4);
              background-image: -o-linear-gradient(top,#f9f9f9,#f4f4f4);
              background-image: -moz-linear-gradient(top,#f9f9f9,#f4f4f4);
              background-image: linear-gradient(top,#f9f9f9,#f4f4f4);
          }
          .fa-edit:before, .fa-pencil-square-o:before {
              color: black;
              content: "\f044";
          }
          .header{
            padding: 0 50px;
          }
          .fixed-table-toolbar{
            padding: 0 0 0 30px;
          }
          #batch-processing{
            margin-left: 10px;
          }
          .input-append .add-on, .input-prepend .add-on {
              display: inline-block;
              width: 100px;
              padding: 2px 5px;
              min-width: 16px;
              padding: 4px 5px;
              font-size: 14px;
              font-weight: normal;
              line-height: 20px;
              text-align: center;
              text-shadow: 0 1px 0 #ffffff;
              background-color: #eeeeee;
              border-top: 1px solid #ccc;
              border-bottom: 1px solid #ccc;
              border-left: 1px solid #ccc;
              float: left;

          }
          .span2{
            float: left;
            padding: 3px 5px;
            width: 100%;
          }

          select.span2 {
            padding: 4px 20px !important;
            border-radius: 0 !important;
            border: 1px solid #ccc !important;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            background-position: right center;
            background-repeat: no-repeat;
            background-size: 1ex;
            background-origin: content-box;
            background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgdmVyc2lvbj0iMS4xIgogICBpZD0ic3ZnMiIKICAgdmlld0JveD0iMCAwIDM1Ljk3MDk4MyAyMy4wOTE1MTgiCiAgIGhlaWdodD0iNi41MTY5Mzk2bW0iCiAgIHdpZHRoPSIxMC4xNTE4MTFtbSI+CiAgPGRlZnMKICAgICBpZD0iZGVmczQiIC8+CiAgPG1ldGFkYXRhCiAgICAgaWQ9Im1ldGFkYXRhNyI+CiAgICA8cmRmOlJERj4KICAgICAgPGNjOldvcmsKICAgICAgICAgcmRmOmFib3V0PSIiPgogICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2Uvc3ZnK3htbDwvZGM6Zm9ybWF0PgogICAgICAgIDxkYzp0eXBlCiAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4KICAgICAgICA8ZGM6dGl0bGU+PC9kYzp0aXRsZT4KICAgICAgPC9jYzpXb3JrPgogICAgPC9yZGY6UkRGPgogIDwvbWV0YWRhdGE+CiAgPGcKICAgICB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMjAyLjAxNDUxLC00MDcuMTIyMjUpIgogICAgIGlkPSJsYXllcjEiPgogICAgPHRleHQKICAgICAgIGlkPSJ0ZXh0MzMzNiIKICAgICAgIHk9IjYyOS41MDUwNyIKICAgICAgIHg9IjI5MS40Mjg1NiIKICAgICAgIHN0eWxlPSJmb250LXN0eWxlOm5vcm1hbDtmb250LXdlaWdodDpub3JtYWw7Zm9udC1zaXplOjQwcHg7bGluZS1oZWlnaHQ6MTI1JTtmb250LWZhbWlseTpzYW5zLXNlcmlmO2xldHRlci1zcGFjaW5nOjBweDt3b3JkLXNwYWNpbmc6MHB4O2ZpbGw6IzAwMDAwMDtmaWxsLW9wYWNpdHk6MTtzdHJva2U6bm9uZTtzdHJva2Utd2lkdGg6MXB4O3N0cm9rZS1saW5lY2FwOmJ1dHQ7c3Ryb2tlLWxpbmVqb2luOm1pdGVyO3N0cm9rZS1vcGFjaXR5OjEiCiAgICAgICB4bWw6c3BhY2U9InByZXNlcnZlIj48dHNwYW4KICAgICAgICAgeT0iNjI5LjUwNTA3IgogICAgICAgICB4PSIyOTEuNDI4NTYiCiAgICAgICAgIGlkPSJ0c3BhbjMzMzgiPjwvdHNwYW4+PC90ZXh0PgogICAgPGcKICAgICAgIGlkPSJ0ZXh0MzM0MCIKICAgICAgIHN0eWxlPSJmb250LXN0eWxlOm5vcm1hbDtmb250LXZhcmlhbnQ6bm9ybWFsO2ZvbnQtd2VpZ2h0Om5vcm1hbDtmb250LXN0cmV0Y2g6bm9ybWFsO2ZvbnQtc2l6ZTo0MHB4O2xpbmUtaGVpZ2h0OjEyNSU7Zm9udC1mYW1pbHk6Rm9udEF3ZXNvbWU7LWlua3NjYXBlLWZvbnQtc3BlY2lmaWNhdGlvbjpGb250QXdlc29tZTtsZXR0ZXItc3BhY2luZzowcHg7d29yZC1zcGFjaW5nOjBweDtmaWxsOiMwMDAwMDA7ZmlsbC1vcGFjaXR5OjE7c3Ryb2tlOm5vbmU7c3Ryb2tlLXdpZHRoOjFweDtzdHJva2UtbGluZWNhcDpidXR0O3N0cm9rZS1saW5lam9pbjptaXRlcjtzdHJva2Utb3BhY2l0eToxIj4KICAgICAgPHBhdGgKICAgICAgICAgaWQ9InBhdGgzMzQ1IgogICAgICAgICBzdHlsZT0iZmlsbDojMzMzMzMzO2ZpbGwtb3BhY2l0eToxIgogICAgICAgICBkPSJtIDIzNy41NjY5Niw0MTMuMjU1MDcgYyAwLjU1ODA0LC0wLjU1ODA0IDAuNTU4MDQsLTEuNDczMjIgMCwtMi4wMzEyNSBsIC0zLjcwNTM1LC0zLjY4MzA0IGMgLTAuNTU4MDQsLTAuNTU4MDQgLTEuNDUwOSwtMC41NTgwNCAtMi4wMDg5MywwIEwgMjIwLDQxOS4zOTM0NiAyMDguMTQ3MzIsNDA3LjU0MDc4IGMgLTAuNTU4MDMsLTAuNTU4MDQgLTEuNDUwODksLTAuNTU4MDQgLTIuMDA4OTMsMCBsIC0zLjcwNTM1LDMuNjgzMDQgYyAtMC41NTgwNCwwLjU1ODAzIC0wLjU1ODA0LDEuNDczMjEgMCwyLjAzMTI1IGwgMTYuNTYyNSwxNi41NDAxNyBjIDAuNTU4MDMsMC41NTgwNCAxLjQ1MDg5LDAuNTU4MDQgMi4wMDg5MiwwIGwgMTYuNTYyNSwtMTYuNTQwMTcgeiIgLz4KICAgIDwvZz4KICA8L2c+Cjwvc3ZnPgo=");
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff !important;
            border: 1px solid #ccc !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single{
              height: 30px !important;
        }
        
        .btn-inverse {
            color: #ffffff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
            background-color: #363636;
            *background-color: #222222;
            background-image: -moz-linear-gradient(top, #444444, #222222);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#444444), to(#222222));
            background-image: -webkit-linear-gradient(top, #444444, #222222);
            background-image: -o-linear-gradient(top, #444444, #222222);
            background-image: linear-gradient(to bottom, #444444, #222222);
            background-repeat: repeat-x;
            border-color: #222222 #222222 #000000;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff444444', endColorstr='#ff222222', GradientType=0);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);        
        }

        .btn-inverse:hover{
          color: #ffffff;
        }

        .ui-menu .ui-menu-item{
            border-bottom: 1px solid #ccc;
            margin-bottom: 5px;
            padding-bottom: 5px;
        }

        table.dataTable tbody td {
          border-bottom: 1px solid #ccc !important;
        }

        #loadingModal .modal-dialog{
          text-align: center;
          margin-top: 100px;
        }
        .toolbar{
          margin-bottom: 2px;
        }

        .input-el{
          float: left;
          width: 100%;
          padding: 2px 0;
          margin-top: 10px;
        }  
        .input-el label{
          width: 100%;          
        }

        .selected-bg{
          background: #fff2a8 !important;
        }

        input::-webkit-input-placeholder {
          font-size: 12px;
        }
        .swal2-popup {
          font-size: 1.6rem !important;
        }
        </style>
    </head>
    <body>
  
      <div class="toolbar">
          <div class="toolbar">
            <div class="btn-group pull-right" role="group">
              <button type="button" class="btn btn-default btn-backToList" onclick="gotoList('<?php echo $username; ?>')" data-toggle="tooltip" data-placement="bottom" title="Regresar al listado">
                  <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
              </button>              
              <!-- <button class="btn btn-default btn-print" onclick="gotoMerge('<?php echo $username; ?>')"   data-toggle="tooltip" data-placement="bottom" title="Opciones Avanzadas">              
                <i class="fa fa-cogs" aria-hidden="true"></i> Unir Cotizaciones
              </button> -->
            </div>
        </div>
      </div>  
      <div class="container">
        <div class="row">
          <div class="col-md-2">
            <hr>
            <h5>Búsqueda de cotizaciones</h5>
            <hr>
            <form id="filters-form">
              <div class="input-el">
                <label>N. Cotización</label>
                <input class="span2" id="no_cotizacion" name="no_cotizacion" type="text" placeholder="">
              </div>

              <div class="input-el">
                <label>Vendedor</label>
                <select class="span2 cl-select2" id="vendedor" name="vendedor">
                  <option value="">Seleccione</option>
                  <?php

                    for($i = 0; $i < count($userlist); $i++){
                      echo '<option value="'.$userlist[$i]['username'].'">'.$userlist[$i]['firstname'].' '. $userlist[$i]['lastname'] .'</option>';
                    }

                  ?>
                </select>
              </div>

              <div class="input-el">
                <label>Compañia</label>
                <input class="span2 companiaInput" id="companiaInput" type="text" name="cliente" placeholder="">
              </div>
              </form>  
              <div class="input-el">
                <button class="btn btn-primary" id="filter-now" style="width: 100%">Buscar</button>
              </div>
              <div class="input-el">
                <button class="btn btn-default" id="noparent-btn" style="width: 100%; font-size: 12px">Buscar sin Compañia</button>
              </div>
            

          </div>
          <div class="col-md-8">
            <hr>

            <h5 style="float: left;">Listado de cotizaciones</h5> 
            <label  style="float: right;" class="muted" id="labelForSelectAll"> <input type="checkbox" id="selectAll" disabled /> Seleccionar todas</label>
            <hr style="float: left;width: 100%;">
            <table id="table">
                <thead>
                <tr>  
                  <th data-field="id" data-events="edit" data-formatter="editBtn"></th>
                  <th data-field="no_cotizacion" data-sortable="true">Cot</th>
                  <th data-field="name" data-sortable="true">Cliente</th>
                  <!-- <th data-field="username" data-sortable="true">Vendedor</th> -->
                  <th data-field="marca" data-sortable="true">Marca</th>
                  <th data-field="fase" data-sortable="true">Fase</th>
                  <th data-field="fecha_cotizacion" data-sortable="true">Modificación</th>
                  <!-- <th data-field="fecha_creacion" data-sortable="true">Creación</th>         -->
                </tr>
                </thead>              
            </table>
          </div>


          <div class="col-md-2">
            <hr>
            <h5>Actualizar Datos</h5>
            <hr>
            <div class="input-el">
              <label>Nueva Compañia</label>
              <input class="span2 companiaInput" id="newCompany" name="newCompany" type="text" placeholder="">
              <input type="hidden" name="companyHidden" id="companyHidden">
            </div>
            <div class="input-el">
                <label>Vendedor</label>
                <select class="span2 cl-select2" id="newVendedor" name="newVendedor">
                  <option value="">Seleccione</option>
                  <?php

                    for($i = 0; $i < count($userlist); $i++){
                      echo '<option value="'.$userlist[$i]['userID'].'">'.$userlist[$i]['firstname'].' '. $userlist[$i]['lastname'] .'</option>';
                    }

                  ?>
                </select>
              </div>
            <div class="input-el">
              <label>Nuevo Contacto</label>
              <select class="span2 cl-select2" id="newContact" name="newContact" disabled="true">
                  <option value="">-</option>
               </select> 
            </div>
            <div class="input-el">
              <button class="btn btn-danger" id="modify" disabled="true" style="width: 100%">Modificar</button>
            </div>
          </div>
        </div>
      </div>  

      <!-- loading-->
        <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Consultar Inventario. [updating]</h4> -->
              </div>
              <div class="modal-body">
                <div class="load-modal">
                  <h3 id="message-load">Cargando</h3>
                  <div class="loading-inner"><i style="font-size: 52px" class="fas fa-cog fa-spin"></i></div>
                </div>
              </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" disabled>Agregar</button> -->
              </div>
            </div>
          </div>
        </div>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/vendor/jquery.formatCurrency-1.4.0.min.js"></script>
    <script src="bower_components/bootstrap-table/src/bootstrap-table.js"></script>
    <script src="bower_components/bootstrap-table/src/locale/bootstrap-table-es-CR.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="js/vendor/tableExport/tableExport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="js/vendor/jquery-ui.min.js"></script>
    <script src="js/vendor/select2.full.min.js"></script>
    <script src="js/main.js?v=<?php echo rand(0,99) ?>"></script>
    <script src="js/merge.js?v=<?php echo rand(0,99) ?>"></script>

   
  </body>
</html>
