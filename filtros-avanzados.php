<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conspath.php';
include_once (AS_PATH.'/classes/dbAdmin.php');

// $path = "'".PATH."'";
$path = "'"."http://".$_SERVER['SERVER_NAME']."'";
$username = $_GET['u'];
$usernameToString = "'".$username."'";


$userlist = dbAdmin::getInstancia()->getAllFromUser(true);

$userdata = dbAdmin::getInstancia()->getAllFromUserByUsername($username);

// print_all($userlist);

// die();

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
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="css/select2.min.css">
        <style type="text/css">

          .body{
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
            width: 235px;
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
        </style>

    </head>
    <body>
      <div class="toolbar">
          <div class="toolbar">
            <div class="btn-group pull-right" role="group">
              <button type="button" class="btn btn-default btn-backToList" onclick="gotoList('<?php echo $username; ?>')" data-toggle="tooltip" data-placement="bottom" title="Regresar al listado">
                  <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar a cotizaciones
              </button>                            
            </div>
        </div>
    
    <div class="header">
      
      <div class="filter row">

        <div class="col-md-12">
          <form id="filters-form">
            <fieldset>
              <legend>Filtros Avanzados</legend>
              <div class="row">
                <div class="col-md-4">
                  <div class="input-prepend">
                    <span class="add-on">N. Cotización</span>
                    <input class="span2" id="no_cotizacion" name="no_cotizacion" type="text" placeholder="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-prepend">
                    <span class="add-on">Vendedor</span>
                    <select class="span2 cl-select2" id="vendedor" name="vendedor">
                      <option value="">Seleccione</option>
                      <?php

                        for($i = 0; $i < count($userlist); $i++){
                          echo '<option value="'.$userlist[$i]['username'].'">'.$userlist[$i]['firstname'].' '. $userlist[$i]['lastname'] .'</option>';
                        }

                      ?>
                    </select>
                  </div>
                </div> 
                <div class="col-md-4">
                  <div class="input-prepend">
                    <span class="add-on">Fase</span>
                    <select name="fase" class="span2 cl-select2" id="fase" required>
                      <option value="">Seleccione</option>
                      <option value="Comunicación inicial">Comunicación inicial</option>
                      <option value="Cotización">Cotización</option>
                      <option value="Negociación">Negociación</option>
                      <option value="Venta realizada">Venta realizada</option>
                      <option value="Cerrada perdida">Cerrada perdida</option>
                      <option value="Desierta">Desierta</option>
                    </select>
                  </div>
                </div> 
                                
              </div>

              <br>

              <div class="row">
                <div class="col-md-4">
                  <div class="input-prepend">
                    <span class="add-on">Marca</span>
                    <select class="span2 cl-select2" id="marcas" name="marcas">
                      <option value="">Seleccione</option>
                      <option value="Adhesives Technology">Adhesives Technology</option>
                      <option value="Allied">Allied</option>
                      <option value="Apollo Valves">Apollo Valves</option>
                      <option value="Asbury">Asbury</option>
                      <option value="Asco">Asco</option>
                      <option value="Ashcroft">Ashcroft</option>
                      <option value="Astm">Astm</option>
                      <option value="Atc">Atc</option>
                      <option value="Bray">Bray</option>
                      <option value="Bushnell">Bushnell</option>
                      <option value="Cedazo">Cedazo</option>
                      <option value="Clark Reliance">Clark Reliance</option>
                      <option value="Cole Parmer">Cole Parmer</option>
                      <option value="Compra Local">Compra Local</option>
                      <option value="Conarco">Conarco</option>
                      <option value="Crown">Crown</option>
                      <option value="Defelsko">Defelsko</option>
                      <option value="Dexsil">Dexsil</option>
                      <option value="Dualco">Dualco</option>
                      <option value="Eco-Shell">Eco-Shell</option>
                      <option value="Elcometer">Elcometer</option>
                      <option value="Empire">Empire</option>
                      <option value="Endress+Hauser">Endress+Hauser</option>
                      <option value="Ervin">Ervin</option>
                      <option value="Esab">Esab</option>
                      <option value="Five Star">Five Star</option>
                      <option value="Florida">Florida</option>
                      <option value="Flow-Tek">Flow-Tek</option>
                      <option value="Forestry Suppliers">Forestry Suppliers</option>
                      <option value="Gardco">Gardco</option>
                      <option value="Ge">Ge</option>
                      <option value="Ge-It">Ge-It</option>
                      <option value="Gilson">Gilson</option>
                      <option value="Gunt">Gunt</option>
                      <option value="Gurley">Gurley</option>
                      <option value="Itt">Itt</option>
                      <option value="JordanValve">JordanValve</option>
                      <option value="Kryton">Kryton</option>
                      <option value="La-Co">La-Co</option>
                      <option value="Laval">Laval</option>
                      <option value="Leser">Leser</option>
                      <option value="Logitech">Logitech</option>
                      <option value="Lovejoy">Lovejoy</option>
                      <option value="Magnaflux">Magnaflux</option>
                      <option value="Marswell">Marswell</option>
                      <option value="Mitutoyo">Mitutoyo</option>
                      <option value="Monti">Monti</option>
                      <option value="Numatics">Numatics</option>
                      <option value="Omega">Omega</option>
                      <option value="Opta Minerals">Opta Minerals</option>
                      <option value="Otros">Otros</option>
                      <option value="Phelps">Phelps</option>
                      <option value="Precision Brand">Precision Brand</option>
                      <option value="Quadrant">Quadrant</option>
                      <option value="Quimicos Construccion">Quimicos Construccion</option>
                      <option value="Rasstech">Rasstech</option>
                      <option value="Rimatec">Rimatec</option>
                      <option value="Ritepro">Ritepro</option>
                      <option value="Rubberart">Rubberart</option>
                      <option value="Rubberart">Rubberart</option>
                      <option value="Servicios">Servicios</option>
                      <option value="Sika">Sika</option>
                      <option value="Sinto">Sinto</option>
                      <option value="Tacc">Tacc</option>
                      <option value="Teadit">Teadit</option>
                      <option value="Tlv">TLV</option>
                      <option value="Utex">Utex</option>
                      <option value="Vaisala">Vaisala</option>
                      <option value="Vazel">Vazel</option>
                      <option value="Ve_Group">Ve Group</option>
                      <option value="Wall Colmonoy">Wall Colmonoy</option>
                      <option value="Ysi">Ysi</option>
                      <option value="Yxlon">Yxlon</option>
                      <option value="Zinga">Zinga</option>
                      <option value="Zwick">Zwick</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-prepend">
                    <span class="add-on">Moneda</span>                    
                    <select class="span2" id="moneda" name="moneda">
                      <option value="">Seleccione</option>
                      <option value="d">$ - Dolares</option>
                      <option value="c">¢ - Colones </option>
                      <option value="e">e - Euros </option>
                    </select>
                  </div>
                </div> 
                <div class="col-md-4">
                  <div class="input-prepend">
                    <span class="add-on">Monto</span>
                    <input type="text" class="span2 format-currency" id="precioUnitario1" name="precioUnitario1"/>
                    <input type="hidden" data-name="precioUnitarioFormated" name="monto" id="monto" class="op-hidden-formated">
                  </div>
                </div> 
                               
              </div>

              <br>

              <div class="row">
                <div class="col-md-4">                  
                  <div class="input-prepend">
                    <span class="add-on">Compañia</span>
                    <input class="span2" id="companiaInput" type="text" name="cliente" placeholder="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-prepend">
                    <span class="add-on">Desde</span>
                    <input class="span2" id="datepicker_from" name="desde" type="text" placeholder="">
                  </div>
                </div> 
                <div class="col-md-4">
                  <div class="input-prepend">
                    <span class="add-on">Hasta</span>
                    <input class="span2" id="datepicker_to" name="hasta" type="text" placeholder="">
                  </div>
                </div> 
                
              </div>
              <br>
              <div class="row">
                <div class="col-md-12" style="text-align: right;">
                  <button type="button" class="btn btn-primary" id="filter-now">Filtrar Cotizaciones</button>
                </div>                
              </div>

            </fieldset>            
          </form>
          <hr>

        </div>
        
      </div>          
    </div>  


    <br>
    <div class="wrapper">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
      <table id="table" data-pagination="true" 
                        data-show-export="true" data-export-types="['csv', 'txt', 'excel']"
                        data-search="true" data-search-on-enter-key="true"  data-smart-display="true"
                        data-page-size="50" data-page-list="[10,25,50,100]">
      <thead>
      <tr>  
        <th data-field="id" data-events="edit" data-formatter="editBtn"></th>
        <th data-field="id_sort" data-sortable="true">Cot #</th>
        <th data-field="no_cotizacion" data-sortable="true">No. cotización</th>
        <th data-field="name" data-sortable="true">Cliente</th>
        <th data-field="contact" data-sortable="true">Contacto</th>
        <th data-field="email" data-sortable="true">Email</th>
        <th data-field="phone" data-sortable="true">Teléfono</th>
        <th data-field="username" data-sortable="true">Vendedor</th>
        <th data-field="marca" data-sortable="true">Marca</th>
        <th data-field="fase" data-sortable="true">Fase</th>
        <!--<th data-field="tasa_cambio" data-sortable="true">T. cambio</th>-->
        <th data-field="moneda" data-sortable="true" title="Moneda">Moneda</th>
        <th data-field="total" data-sortable="true" data-formatter="formatPrice">Monto</th>
        <!-- <th data-field="description" data-sortable="true">Descripcion</th> -->
        <th data-field="fecha_cotizacion" data-sortable="true">Modificación</th>
        <th data-field="fecha_creacion" data-sortable="true">Creación</th>        
        <?php if( !empty($userdata[0]) && $userdata[0]['role_id'] == '1'  ): ?>
        <th data-field="id" data-events="edit" data-formatter="deletetBtn"></th>
        <?php endif; ?>
      </tr>
      </thead>
      </table>
    </div>  

     

      <!-- Modal user lists -->
        <div class="modal fade" id="clientesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Seleccionar contacto</h4>
              </div>
              <div class="modal-body company-modal-body">
                 <br>
                 <div class="auto-complete">
                   <div class="form-group">
                      <label for="exampleInputEmail1">Buscar contacto:</label>
                        <div class="row">
                          <div class="col-sm-4">
                            <input type="text" id="contactNameInput" placeholder="Nombre">
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="contactEmailInput" placeholder="Email">
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="contactCompanyInput" placeholder="Compañia">
                            <input type="hidden" id="contactCompanyIdInput" >
                          </div>
                        </div>

                      <input type="text" class="form-control" id="contactInput" style="height: 0; visibility: hidden;" value="buscar">
                      <div class="ui-widget" style="margin-top:2em; font-family:Arial">
                          Seleccionado:
                          <div id="log" class="ui-widget-content">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                   <td class="nombre_contacto"></td>
                                    <td class="email_contacto"></td>
                                    <td class="telefono_contacto"></td>
                                  </tr>
                                </tbody>
                              </table>

                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Compañia</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td class="company_name"></td>
                                  </tr>
                                </tbody>
                              </table>
                              
                          </div>
                        </div>
                        <br>
                        <p style="text-align: center;">
                                <a href="#" class="add_contacto btn btn-primary disabled">Agregar</a>
                          </p>
                    </div>
                 </div>
              </div>             
            </div>
          </div>
        </div>
        <!-- End clientesModal-->

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
                  <h3 id="message-load">Cargando Filtros Avanzados</h3>
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
      <!-- End clientesModal-->  

      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
      <script src="js/vendor/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
      <script src="js/vendor/select2.full.min.js"></script>
      <script src="bower_components/bootstrap-table/src/bootstrap-table.js"></script>
      <script src="bower_components/bootstrap-table/src/locale/bootstrap-table-es-CR.js"></script>
      <script src="js/export-table.js"></script>
      <script src="js/vendor/jquery.formatCurrency-1.4.0.min.js"></script>
      <script src="js/vendor/tableExport/tableExport.min.js"></script>
      <script type="text/javascript" src="js/vendor/tableExport/libs/FileSaver/FileSaver.min.js"></script>
      <script type="text/javascript" src="js/vendor/tableExport/libs/js-xlsx/xlsx.core.min.js"></script>
      <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
      <script type="text/javascript">

        $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['es-CR']);
        $.formatCurrency.regions[''].decimalSymbol = ',';
        $.formatCurrency.regions[''].digitGroupSymbol = '.';

        var _path = <?php echo $path; ?>;


        function setCaretPosition(elem, caretPos) {
        
            if(elem.createTextRange) {
                var range = elem.createTextRange();
                range.move('character', caretPos);
                range.select();
            }
            else {
                if(elem.selectionStart) {
                    elem.focus();
                    elem.setSelectionRange(caretPos, caretPos);
                }
                else
                    elem.focus();
            }
        }

        function doGetCaretPosition (oField) {

              // Initialize
              var iCaretPos = 0;

              // IE Support
              if (document.selection) {

                  // Set focus on the element
                  oField.focus();

                  // To get cursor position, get empty selection range
                  var oSel = document.selection.createRange();

                  // Move selection start to 0 position
                  oSel.moveStart('character', -oField.value.length);

                  // The caret position is selection length
                  iCaretPos = oSel.text.length;
              }

              // Firefox support
              else if (oField.selectionStart || oField.selectionStart == '0')
                  iCaretPos = oField.selectionStart;

              // Return results
              return iCaretPos;
          }
        
        var edit = { 
            'click .like': function (e, value, row, index) { 
                $('#table').tableExport({type:'csv'}); 
            }
        };

        function updateCot(value){
            var username = <?php echo json_encode($username) ?>;
            window.location.href = "cotz_update.php?u="+username+"&cotId="+value;
        }

        function addCheckbox(value){
          return '<label class="batch-processing">' + value + '<br> <input type="checkbox" value="' + value +  '"></label>';
        }

        var editBtn = function (value) {       
             return '<a href="#" class="edit edit-cot" onclick="updateCot('+value+')" data="$id"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
        };

        var deletetBtn = function (value) {
             return '<a href="#" class="edit delete-cot"  data-id="' + value + '"><i class="fa fa-times" aria-hidden="true"></i></a>';
        };

        var createCotBtn = function(){
          var username = <?php echo json_encode($username) ?>;
          // console.log(typeof username);
          return '<button class="btn btn-primary" onclick="gotoCotz(`'+username+'`)" type="button" aria-expanded="false"><i class="fa fa-plus-circle"></i> Crear Cotización</button>';
        }

        function gotoCotz(id){
          // console.log('id',id);
          // if(id===null || typeof id === 'undefined'){
          //   window.location.href = "cotz.php?u="+id;
          // }
           window.location.href = "cotz.php?u="+id;
          parent.iframeLoaded();
        }

        $.formatCurrency.regions[''].decimalSymbol = ',';
        $.formatCurrency.regions[''].digitGroupSymbol = '.';

        function formatPrice(value){
          return $('<span>'+ value + '</span>').formatCurrency({symbol: ''}).html();
        }
        var _username = <?php echo "'$username';"; ?>
            _username = JSON.stringify(_username);

        // console.log('_username', _username)

      $(function () {
        var username = <?php echo "'$username';"; ?>
        var _username = <?php echo $usernameToString; ?>


        $('.cl-select2').select2();

        $('.format-currency').formatCurrency({symbol: ''});

        $('body').on('keydown', '.format-currency', function(e){
            var inputElem = $(this).get(0),
                caretPos = doGetCaretPosition( inputElem )
                decimalSymbol = ',',
                val = $(this).val();
          
              deletingDecimalSymbol = ( e.keyCode == 8 ) && val[caretPos - 1] == decimalSymbol;
        });

        $('body').on('keypress', '.format-currency', function(e){
          var str = String.fromCharCode(e.which),
              val = $(this).val(),
              decimalSymbol = ',';
        
            if( !/\d/.test(str) || str == decimalSymbol ){
                if( str == ',' ){
                    var indexDot = val.indexOf(str);

                    if(indexDot == -1){
                      return true;
                    }

                    setCaretPosition($(this).get(0), indexDot + 1 );
                
                }
          
                return false;
            }
        });

        $('body').on('input', '.format-currency', function(e){
            var inputElem = $(this).get(0),
                caretPos = doGetCaretPosition( inputElem ),
                val = $.trim($(this).val()),
                indexDot = val.indexOf(','),
                valLength = val.length,
                lastDigit = val.substr(-1),
                decimalSymbol = ',';

            if( deletingDecimalSymbol ){
              deletingDecimalSymbol = false;
              val = val.substr(0, valLength - 2) + decimalSymbol + val.substr( valLength - 2 );
              $(this).val(val);
              caretPos += 1;
              valLength += 1;
            }

            if( indexDot !== -1 ){
              valLength = val.substr(0, indexDot).length + 3;
            }
            else{
              valLength += 3;
            }

            val = val.substr(0, valLength);
            $(this).val(val);
            $(this).val($(this).asNumber()).formatCurrency({symbol: ''});
            $(this).parent().find('[type=hidden]:not(.op-hidden-formated)').val( $(this).asNumber() );

            if( $(this).val().length > valLength ){
              caretPos++;
            }
            else if( $(this).val().length < valLength ){
              caretPos--;
            }

            setCaretPosition(inputElem, caretPos );

        });


        var dateFormat = 'yy-mm-dd',
        $from = $( "#datepicker_from" ).datepicker({dateFormat: dateFormat}).on( "change", function() {
          $to.datepicker( "option", "minDate", getDate( this.value ) );
        }),
        $to = $( "#datepicker_to" ).datepicker({dateFormat: dateFormat}).on( "change", function() {
          $from.datepicker( "option", "maxDate", getDate( this.value ) );
        });

        
        $("#companiaInput").autocomplete({
          minLength: 2,
          delay: 800,
          classes:{
            'ui-autocomplete': 'customAutocomplete'
          },
          source: function(request, response) {
              $.ajax({
                  url: "../cotz/services/cotz.php",
                  data: { term: request.term,action: 'term_company' },
                  dataType: "json",
                  type: "POST",
                  success: function(data){
                    //console.log(data);
                     var result = $.map(data, function(item){
                    // console.log(item);
                    return {
                              label: item.name,
                              value: item.name,
                              id: item.id,
                              desc: item.description,
                              phone: item.officephone,
                              website: item.website
                          }
                      });
                      response(result);
                  }
              });
          },
          // Inputs customer data into forms.
          select: function(event, ui){
            //do it here
            $( "#companiaInput" ).text( ui.label );
          }
      })
      .autocomplete( "instance" )._renderItem = function( ul, item ) {
      // console.log(item);
        var desc = (item.desc==null || item.desc == '') ? "-" : item.desc;
        return $( "<li>" )
          .append( "<div>" + item.label + "<br> <strong>Descripcion:</strong> " + desc + "<br> <strong>Telefono:</strong> " + item.phone + "</div>" )
          .appendTo( ul );
      };

      $($("#companiaInput").autocomplete('instance').bindings[1]).off('mouseenter mouseout');

        function getDate( value ) {
          var date;
          try {
            date = $.datepicker.parseDate( dateFormat, value );
          } catch( error ) {
            date = null;
          }

          return date;
        }



         parent.iframeLoaded();
         
         // var jsonData = null,
         //      bootstrapTableOpt = {
         //        url: <?php echo $path; ?>+'/cotz/services/cotz.php?action=get_cotizacionesAllMIN',
         //        onDblClickRow: function(row, $element, field){
         //          var cotID = row['id'];
         //        },
         //        onLoadSuccess: function(){
         //          $table.find('.batch-processing').closest('td').off('click dbclick');

         //          jsonData = $table.bootstrapTable('getData');

         //          console.log('jsonData',jsonData);

         //          bootstrapTableOpt['data'] = jsonData;
         //          delete bootstrapTableOpt.url;

         //          (typeof parent.iframeLoaded === 'function' ) && parent.iframeLoaded();
         //        },
         //        onAll: function(name, args){
         //            (typeof parent.iframeLoaded === 'function' ) && parent.iframeLoaded();
         //        }
         //      }, 
         //    $table = $('#table').bootstrapTable(bootstrapTableOpt);

         //    $('#toolbar input').on('change', function(){
         //      var value = $(this).is(':checked') ? $(this).val() : '';
         //      bootstrapTableOpt['exportDataType'] = value;

         //      $table.bootstrapTable('destroy').bootstrapTable(bootstrapTableOpt);
         //      applyFilters();
         //      $('.fixed-table-toolbar').prepend(createCotBtn);          
         //    });


         //  $('.fixed-table-toolbar').prepend(createCotBtn);

          
          function applyFilters(){
            var currentJsonData = jsonData,
                dateFilters = function(){
              var grepFunc,
              fromDate = getDate($from.val()),
              toDate = getDate($to.val()),
              itemDate = '';

              if( fromDate && toDate){
                grepFunc = function(item){
                  itemDate = getDate( item.fecha_cotizacion );
                  if( itemDate )
                    return fromDate.getTime() <= itemDate.getTime() && toDate.getTime() >= itemDate.getTime();
                  return false;
                }
              }
              else if(fromDate){
                grepFunc = function(item){
                  itemDate = getDate( item.fecha_cotizacion );
                  if( itemDate )
                    return fromDate.getTime() <= itemDate.getTime();
                  return false;
                }
              }
              else if(toDate){
                grepFunc = function(item){
                  itemDate = getDate( item.fecha_cotizacion );
                  if ( itemDate )
                    return toDate.getTime() >= itemDate.getTime();
                  return false;
                }
              }
              else{
                return currentJsonData;
              }

              return $.grep(currentJsonData, grepFunc);
            },
            searchFilter = function(){
                var grepFunc,
                    inputValue = $.trim($('.bootstrap-table .search input').val());

                if(inputValue){
                  grepFunc = function(item){
                  var found = false;

                    $.each(item, function(_, val){
                      if( RegExp(inputValue, 'i').test(val) ){
                        found = true;
                        return true;
                        }
                    });

                    return found;
                  };

                  return $.grep(currentJsonData, grepFunc);
                }
                else{
                  return currentJsonData;
                }
            };
            
            currentJsonData = dateFilters();
            currentJsonData = searchFilter();

             $table.bootstrapTable('load', currentJsonData);
        
      }


          $('.filter-by-data .btn').on('click', function(e){
            e.preventDefault();
            applyFilters();
          });

          $('.bootstrap-table .search input').on('input', function(){
            applyFilters(); 
          });


          var deletingCot = false;
          $('.bootstrap-table table').on('click', 'a.delete-cot', function(e){

              e.preventDefault();

              if(deletingCot) return;

              deletingCot = true;

              var cot_id = $(this).data('id'),
                  $modal = $('#deleteModal');

              $modal.find('.modal-body strong').text(cot_id);

              $modal.modal({ backdrop: 'static', keyboard: false })
              .off('click', '.modal-footer .btn')
              .one('click', '.modal-footer .btn', function (e) {
                if( $(this).is('#action-exc') ){
                    $.ajax({
                      url: "/cotz/services/cotz.php",
                      dataType: 'json',
                      data: {
                          data: {
                              id: cot_id,
                              username: username
                          }, 
                          action: 'delete_cot'
                      },
                      type: "POST"
                    })
                    .done(function(data){
                        console.log('data',data);
                        if(data.success == false){
                            return;
                        }

                        window.location.reload();
                    
                      })
                    .fail(function(e){
                      console.log('fail',e);
                    })
                    .always(function(){
                      $modal.modal('hide');
                      deletingCot = false;
                    });
                }
                else{
                  console.log('deleting false');
                  deletingCot = false;
                }
            });
          
        });

        $('#table').on('click', '.batch-processing', function(e){
          e.stopImmediatePropagation();

          var atLeastOne = $('.batch-processing input:checked').length;

          $('#batch-processing').prop('disabled', !atLeastOne);
          $('#batch-processing').val('');
        });

        $('#vendedor').on('click', function(e){
          $('#vendedoresModal').modal({ backdrop: 'static', keyboard: false });
        });

        $('#batch-processing').on('change', function(){
          var action = $(this).val(),
              $modal = $('#editBatchModal');

          switch(action){
            case 'edit':

                $modal.find('.editBatchForm [name="cotsId[]"]').remove();

                var cotzId = $.map($('#table .batch-processing input:checked'), function(item){
                      var value = $(item).val();
                      $modal.find('.editBatchForm').append( '<input type="hidden" name="cotsId[]" value="' + value  + '" >' );
                      return value
                  });

                $modal.find('h4 span').text(cotzId.join(' - '));
                $modal.find('.modal-footer.default').show();
                $modal.find('.modal-footer.ok').hide();
                $modal.find('.modal-body .msg').text('');
                $modal.modal({ backdrop: 'static', keyboard: false });
            break;
          }
        });

        $('#editBatchModal .btn-ok').on('click', function(){
            window.location.reload();
        });

        $('#editBatchModal .btn-primary').on('click', function(){

            var $modal = $('#editBatchModal'),
                data = $('.editBatchForm').serialize();

            $.ajax({
                url: "../cotz/services/cotz.php",
                dataType: 'json',
                data: { data: data, action: 'update_cot_batch' },
                type: "POST"
              })
              .done(function(data){
                  if(data.success){
                    $modal.find('.modal-body .msg').html('<b>Cotizaciones actualizadas con éxito</b>');
                    $modal.find('.modal-footer.default').hide();
                    $modal.find('.modal-footer.ok').show();
                  }
                })
              .fail(function(e){
                $modal.find('.modal-body .msg').text('Ocurrio un problema durante la actualización.');
              });
        });

        $('.custom-tablesearch').on('input', function(){
          var fields = $(this).data('fields').split(' ');
          var term = $.trim($(this).val() );
          var minLength = 2;

          if(!fields) return;

          var $table = $(this).closest('div').find('table:eq(0)');

          if(!term){
            $table.find('tbody tr').show();
            return;
          }

          if( term.length < minLength ){
            return;
          }

          var termRegex = RegExp(term, 'i');
          

          $table.find('tbody tr').hide().filter(function(){
            return !!$(this).find('a').filter(function(){
              var vals = [];
              var $this = $(this);

              fields.forEach(function(elem){
                vals.push(  $this.data(elem) );
              });

              vals = vals.join(' ');
              
              return termRegex.test(vals);
            }).length;

          }).show();

        });

        function setNewVendedor(username, id){
          $('#vendedor').val(username);
          $('#userid').val(id);
        }

        $('.add-vendedor').on('click', function(e){
          e.preventDefault();
          var name = $(this).data('username');
          var id =  $(this).data('id');
          setNewVendedor(name, id);
          // console.log('name: %d - id: %d', name, id)
          $('#vendedoresModal').modal('hide');
      });
          
      });

      function addContactAutocomplete(){
        $("#contactInput").autocomplete({
          minLength: 3,
          delay: 800,
          classes:{
            'ui-autocomplete': 'customAutocomplete'
          },
          source: function(request, response) {
              var termName = $.trim( $('#contactNameInput').val() ),
                  termEmail = $.trim( $('#contactEmailInput').val() ),
                  termCompany= $.trim( $('#contactCompanyInput').val() ),
                  termCompanyId = $.trim( $('#contactCompanyIdInput').val() );
        
              $.ajax({
                  url: "../cotz/services/cotz.php",
                  data: { termName: termName, termEmail: termEmail, termCompany: termCompany, termCompanyId: termCompanyId, action: 'term_contact' },
                  dataType: "json",
                  type: "POST",
                  success: function(data){
                    //console.log(data);
                     var result = $.map(data, function(item){
                    // console.log(item);
                    return {
                              label: item.name,
                              value: item.name,
                              id: item.id,
                              email: item.email,
                              phone: item.phones,
                              company: item.companyname,
                              companyid: item.companyid
                          }
                      });
                      response(result);
                  }
              });
          },
          // Inputs customer data into forms.
          select: function(event, ui){
            //do it here
            log_contacto(ui);
          }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          .append( "<div><b>" + item.label + "</b><br> Email: " + item.email +  ( item.phone ? "<br> Teléfono: " + item.phone : ""  )  + "<br> Compañia: " + item.company +"</div>" )
          .appendTo( ul );
        };
        
        $($("#contactInput").autocomplete('instance').bindings[1]).off('mouseenter mouseout');
      }

      </script>
      <script type="text/javascript" src="js/filtros-avanzados.js?v=<?php echo rand(1,10); ?>"></script>
  </body>
</html>
