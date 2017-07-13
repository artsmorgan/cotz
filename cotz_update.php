<?php
include 'conspath.php';
include_once (AS_PATH.'/classes/dbAdmin.php');
// $path = "'".PATH."'";
$path = "'"."http://".$_SERVER['SERVER_NAME']."'";
$username = $_GET['u'];
$cotid = $_GET['cotId'];
$userlist = dbAdmin::getInstancia()->getAllFromUser();
$userdata = dbAdmin::getInstancia()->getAllFromUserByUsername($username);
$cot = dbAdmin::getInstancia()->getCotizacionById($cotid);

// print_all($cot);

// print_all($userlist);
// echo '---------------------------';
// print_all($userdata);
// echo $username;
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" langpo  =""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
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
        <link rel="stylesheet" href="css/jquery-ui.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="https://use.fontawesome.com/5b1d115124.js"></script>
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body class="form-page">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Modal -->
        <div class="modal fade" id="inventarioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Consultar Inventario</h4>
              </div>
              <div class="modal-body">
                <table id="table" data-pagination="true"
                        data-search="true" data-search-on-enter-key="true"  data-smart-display="true"
                        data-page-size="6" data-page-list="[10,25,50,100]">
                    <thead>
                    <tr>
                      <th data-radio="true"></th>
                      <th data-field="Apellidos" data-sortable="true">Apellidos</th>
                      <th data-field="Bodega" data-sortable="true">Bodega</th>
                      <th data-field="Codigo" data-sortable="true">Codigo</th>
                      <th data-field="NombreDelArticulo" data-sortable="true">Nombre Del Articulo</th>
                      <th data-field="NoDeParte" data-sortable="true">No De Parte</th>
                      <th data-field="Unidad">Unidad</th>
                      <th data-field="CantidadDisponible" >Cantidad Disponible</th>
                      <th data-field="Precio" >Precio</th>
                      <th data-field="Provedor" >Provedor</th>
                      <th data-field="DetallesDelArticulo" > Detalles Del Articulo</th>
                    </tr>
                    </thead>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" disabled>Agregar</button>
              </div>
            </div>
          </div>
        </div>


         <!-- Modal user lists -->
        <div class="modal fade" id="vendedoresModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Seleccionar Vendedor</h4>
              </div>
              <div class="modal-body">
                <table id="user-table" class="table table-striped">
                    <thead>
                    <tr>
                      <th>Nombre</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php for($i = 0; $i < count($userlist);$i++ ){?>                      
                      <tr>
                        <td><?php  echo $userlist[$i]['firstname'].' '. $userlist[$i]['lastname'];  ?></td>
                        <td>
                          <a href="#" class="add-vendedor btn btn-primary" 
                                          data-id="<?php  echo $userlist[$i]['userID']; ?>" 
                                          data-username="<?php  echo $userlist[$i]['firstname'].' '. $userlist[$i]['lastname'];  ?>">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar
                          </a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                </table>
              </div>             
            </div>
          </div>
        </div>


        <!-- End clientesModal modals-->


         <!-- Modal user lists -->
        <div class="modal fade" id="clientesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Seleccionar Vendedor</h4>
              </div>
              <div class="modal-body">
                <div class="alert alert-danger select_client_alert" role="alert"><strong>Precaucion</strong> Debe seleccionar una compania primero</div>
                <table id="user-table" class="table table-striped">
                    <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>email</th>
                      <th>Telefono</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody class="account_list_by_company"> </tbody>
                </table>
              </div>             
            </div>
          </div>
        </div>


        <!-- End clientesModal-->


          <!-- Modal companiasModal lists -->
        <div class="modal fade" id="companiasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Seleccionar Compania</h4>
              </div>
              <div class="modal-body company-modal-body">
                 <br>
                 <div class="auto-complete">
                   <div class="form-group">
                      <label for="exampleInputEmail1">Ingrese el nombre de la compania</label>
                      <input type="text" class="form-control" id="companiaInput" placeholder="Compania...">
                      <div class="ui-widget" style="margin-top:2em; font-family:Arial">
                          Seleccionado:
                          <div id="log" class="ui-widget-content">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Sitio Web</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                   <td class="id_compania"></td>
                                    <td class="nombre_compania"></td>
                                    <td class="telefono_compania"></td>
                                    <td class="website_compania"></td>
                                  </tr>
                                </tbody>
                              </table>

                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Descripcion</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td class="description_company"></td>
                                  </tr>
                                </tbody>
                              </table>
                              
                          </div>
                        </div>
                        <br>
                        <p style="text-align: center;">
                                <a href="#" class="add_compania btn btn-primary disabled">Agregar</a>
                          </p>
                    </div>
                 </div>
              </div>             
            </div>
          </div>
        </div>


        <!-- End companiasModal modals-->



        <div class="toolbar">
          <div class="btn-group pull-right" role="group">
            <button type="button" class="btn btn-default btn-backToList" onclick="gotoList('<?php echo $username; ?>')" data-toggle="tooltip" data-placement="bottom" title="Regresar al listado">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Configurar Cotizacion">
              <i class="fa fa-cogs" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-default"  data-toggle="tooltip" data-placement="bottom" title="Datos del Cliente">
              <i class="fa fa-user-plus" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-default"  data-toggle="tooltip" data-placement="bottom" title="Imprimir">
              <i class="fa fa-print" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      <!-- <button class="btn btn-primary" onclick="gotoList()">Regresar al listado</button> -->
    <form class="container-fluid form-container is-update">
      <input type="hidden" value="<?php echo $cotid; ?>" name="cotId">
      <div class="row">
        <div class="col-sm-6 info-cotizacion float--active">

          <h4 class="f-section-title">Cotización</h4>
          <div class="row">
            <div class="col-sm-6 form-group">
              <label for="vendedor">Vendedor:</label>
              <input type="text" name="vendedor" class="form-control" id="vendedor" 
                        value="<?php echo $cot[0]['vendedor_nombre']; ?>" />
              <input type="hidden" name="userid" id="userid" value="<?php echo htmlentities( $cot[0]['vendedor_id'] ); ?>" />          

            </div>
            <div class="col-sm-3 form-group">
              <label for="fechaCotizacion">Fecha de cotización:</label>
              <input type="text" placeholder="yy-mm-dd" disabled class="form-control datepicker" id="fechaCotizacion" value="<?php echo $cot[0]['fecha_cotizacion']; ?>">
              <input type="hidden" name="fechaCotizacion"  id="altFechaCotizacion" value="<?php echo $cot[0]['fecha_cotizacion']; ?>">
            </div>
            <div class="col-sm-3 form-group">
              <label for="fechaVencimiento">Fecha de vencimiento:</label>
              <input type="text" name="fechaVencimiento" placeholder="yy-mm-dd"  class="form-control datepicker" id="fechaVencimiento" value="<?php echo $cot[0]['fecha_vencimiento']; ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 form-group">
              <label for="tasaImpuestos">Tasa de impuestos:</label>
              <input type="number" name="tasaImpuestos" min="1" max="99" maxlength="7" class="form-control" id="tasaImpuestos" value="<?php echo $cot[0]['tasa_impuestos']; ?>">
            </div>
            <div class="col-sm-3 form-group">
              <label for="moneda">Moneda:</label>
              <select name="moneda" class="form-control" id="moneda">
                <?php $selectop = array( 'dolares' => '$', 'colones' => '¢', 'euro' => '€' ); ?>
                <?php foreach( $selectop as $opvalue => $optxt ): ?>
                  <option value="<?php echo $opvalue; ?>" <?php echo ( $cot[0]['moneda'] == $opvalue ? 'selected' : '' ); ?> ><?php echo $optxt; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm-3 form-group">
              <label for="tasaCambio">Tasa de cambio:</label>
              <input type="number" name="tasaCambio" class="form-control" id="tasaCambio" value="<?php echo $cot[0]['tasa_cambio']; ?>">
            </div>
            <div class="col-sm-3 form-group">
              <label for="redondeo">Factor de redondeo:</label>
              <select name="redondeo" class="form-control" id="redondeo">
                <?php $selectop = array( 'factor_1' => '0,05', 'factor_2' => '1,00', 'factor_3' => '0,01' ); ?>
                <?php foreach( $selectop as $opvalue => $optxt ): ?>
                  <option value="<?php echo $opvalue; ?>" <?php echo ( $cot[0]['factor_redondeo'] == $opvalue ? 'selected' : '' ); ?> ><?php echo $optxt; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <!--info cotizacion-->
        <div class="col-sm-6 info-cliente float--active">
          <h4 class="f-section-title">Datos del cliente</h4>
          <div class="row">
            <div class="col-sm-4 form-group">
              <label for="cuentaNombreAux">Compañía :</label>
              <input type="text" class="form-control" id="cuentaNombreAux" required value="<?php echo htmlentities( $cot[0]['account_name'] ); ?>">
              <input type="hidden" name="company_id" id="company_id" value="<?php echo $cot[0]['account_id']; ?>">
            </div>
            <div class="col-sm-8 form-group">
              <label for="clienteNombreAux">Contacto :</label>
              <input type="text" class="form-control" id="clienteNombreAux" required value="<?php echo htmlentities( $cot[0]['contact_name'] ); ?>">
              <input type="hidden" name="contact_id" id="contact_id" value="<?php echo $cot[0]['contact_id']; ?>">
            <!-- </div>
            <div class="col-sm-4">
              <a href="#" class="btn btn-default btn-block">Mostrar detalle</a> -->
            </div>
          </div>
          <h4 class="f-section-title">Condiciones</h4>
          <div class="row">
              <div class="col-sm-3 form-group">
                <label for="tiempoEntrega">Tiempo de entrega:</label>
                <input type="text" name="tiempoEntrega" class="form-control" id="tiempoEntrega" value="<?php echo htmlentities( $cot[0]['tiempo_entrega'] ); ?>">
              </div>
              <div class="col-sm-6 form-group">
                <label for="lugarEntrega">Lugar de entrega:</label>
                <input type="text" name="lugarEntrega" class="form-control" id="lugarEntrega" value="<?php echo htmlentities( $cot[0]['lugar_entrega'] ); ?>">
              </div>
              <div class="col-sm-3 form-group">
                <label for="formaPago">Forma de pago:</label>
                <input type="text" name="formaPago" class="form-control" id="formaPago" value="<?php echo htmlentities( $cot[0]['forma_pago']); ?>">
              </div>
          </div>
        </div>
        <!--info cliente-->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-3 form-group">
              <label for="noSolicitud">No. de solicitud:</label>
              <input type="text" name="noSolicitud" class="form-control" id="noSolicitud" value="<?php echo htmlentities($cot[0]['no_solicitud']); ?>">
            </div>
            <div class="col-sm-3 form-group">
              <label for="noCotizacion">No. de cotización:</label>
              <input type="text" name="noCotizacion" class="form-control" id="noCotizacion" required value="<?php echo htmlentities($cot[0]['no_cotizacion']); ?>">
            </div>
            <div class="col-sm-3 form-group">
              <label for="marca">Marca:</label>
              <select type="text" name="marca" class="form-control" id="marca" required>
                <?php $selectop = array(
                  "" => "Seleccione",
                  'Adhesives Technology' =>  'Adhesives Technology',
                  'Allied' =>  'Allied',
                  'Apollo Valves' =>  'Apollo Valves',
                  'Asbury' =>  'Asbury',
                  'Asco' =>  'Asco',
                  'Ashcroft' =>  'Ashcroft',
                  'Astm' =>  'Astm',
                  'Atc' =>  'Atc',
                  'Bray' =>  'Bray',
                  'Bushnell' =>  'Bushnell',
                  'Cedazo' =>  'Cedazo',
                  'Clark Reliance' =>  'Clark Reliance',
                  'Cole Parmer' =>  'Cole Parmer',
                  'Compra Local' =>  'Compra Local',
                  'Conarco' =>  'Conarco',
                  'Crown' =>  'Crown',
                  'Defelsko' =>  'Defelsko',
                  'Dexsil' =>  'Dexsil',
                  'Dualco' =>  'Dualco',
                  'Eco-Shell' =>  'Eco-Shell',
                  'Elcometer' =>  'Elcometer',
                  'Empire' =>  'Empire',
                  'Endress+Hauser' =>  'Endress+Hauser',
                  'Ervin' =>  'Ervin',
                  'Esab' =>  'Esab',
                  'Five Star' =>  'Five Star',
                  'Florida' =>  'Florida',
                  'Flow-Tek' =>  'Flow-Tek',
                  'Forestry Suppliers' =>  'Forestry Suppliers',
                  'Gardco' =>  'Gardco',
                  'Ge' =>  'Ge',
                  'Ge-It' =>  'Ge-It',
                  'Gilson' =>  'Gilson',
                  'Gunt' =>  'Gunt',
                  'Gurley' =>  'Gurley',
                  'Itt' =>  'Itt',
                  'Kryton' =>  'Kryton',
                  'La-Co' =>  'La-Co',
                  'Laval' =>  'Laval',
                  'Logitech' =>  'Logitech',
                  'Lovejoy' =>  'Lovejoy',
                  'Magnaflux' =>  'Magnaflux',
                  'Marswell' =>  'Marswell',
                  'Mitutoyo' =>  'Mitutoyo',
                  'Monti' =>  'Monti',
                  'Omega' =>  'Omega',
                  'Opta Minerals' =>  'Opta Minerals',
                  'Otros' =>  'Otros',
                  'Phelps' =>  'Phelps',
                  'Precision Brand' =>  'Precision Brand',
                  'Quadrant' =>  'Quadrant',
                  'Quimicos Construccion' =>  'Quimicos Construccion',
                  'Rasstech' =>  'Rasstech',
                  'Rimatec' =>  'Rimatec',
                  'Ritepro' =>  'Ritepro',
                  'Rubberart' =>  'Rubberart',
                  'Rubberart' =>  'Rubberart',
                  'Servicios' =>  'Servicios',
                  'Sika' =>  'Sika',
                  'Sinto' =>  'Sinto',
                  'Tacc' =>  'Tacc',
                  'Teadit' =>  'Teadit',
                  'Tlv' =>  'TlV',
                  'Utex' =>  'Utex',
                  'Vaisala' =>  'Vaisala',
                  'Vazel' =>  'Vazel',
                  'Ve_Group' =>  'Ve Group',
                  'Wall Colmonoy' =>  'Wall Colmonoy',
                  'Ysi' =>  'Ysi',
                  'Yxlon' =>  'Yxlon',
                  'Zinga' =>  'Zinga',
                  'Zwick' =>  'Zwick', ); ?>
                <?php foreach( $selectop as $opvalue => $optxt ): ?>
                  <option value="<?php echo $opvalue; ?>" <?php echo ( strtolower($cot[0]['marca']) == strtolower($opvalue) ? 'selected' : '' ); ?> ><?php echo $optxt; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm-3 form-group">
              <label for="fase">Fase:</label>
              <select name="fase" class="form-control" id="fase" required>
                <?php $selectop = array(
                    "" => "Seleccione",
                    "Comunicación inicial" => "Comunicación inicial",
                    "Cotización" => "Cotización",
                    "Negociación" => "Negociación",
                    "Venta realizada" => "Venta realizada",
                    "Cerrada perdida" => "Cerrada perdida",
                    "Desierta" => "Desierta" ); ?>
                <?php foreach( $selectop as $opvalue => $optxt ): ?>
                  <option value="<?php echo $opvalue; ?>" <?php echo ( $cot[0]['fase'] == $opvalue ? 'selected' : '' ); ?> ><?php echo $optxt; ?></option>
                <?php endforeach; ?>
              </select>
              </select>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <h4 class="f-section-title">Líneas de la transacción</h4>
      <ul class="transactions-list">
        <li class="row-head">
          <div class="row">
           <!--  <div class="col-sm-offset-6 col-sm-1 border-full">
              <b>Factor de redondeo</b>
            </div> -->
            <div class="col-sm-offset-6 col-sm-1 border--full">
              <b>Cant</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>U/ medida</b>
            </div>
            <div class="col-sm-2 border--full">
              <b>Precio u.</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>% descuento</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>Monto</b>
            </div>
          </div>
        </li>

        <li class="row-product <?php echo (!empty( $cot['lines'] ) ? 'disp--hide' : '' ); ?> ">
          <div class="row">
            <div class="col-sm-1 form-group">
              <label for="codigoArticulo1">Código del artículo:</label>
              <input type="text" data-name="codigoArticulo" class="form-control" id="codigoArticulo1">
            </div>
            <div class="col-sm-3 form-group">
              <label for="nombreArticulo1">Nombre del artículo:</label>
              <input type="text" data-name="nombreArticulo" class="form-control" id="nombreArticulo1">
            </div>
             <div class="col-sm-2 form-group">
              <div class="row">
                  <div class="col-sm-12">
                    <label for="exonerado1">Exonerado</label>
                    <input type="checkbox" data-name="exonerado" id="exonerado1" value="true">
                  </div>
                  <div class="col-sm-12">
                    <button class="btn btn-caution" type="button" data-toggle="modal" data-target="#inventarioModal">Ver el inventario</button>
                  </div>
                </div>
            </div>
            <!-- <div class="col-sm-1 form-group border--full">
              <select type="number" data-name="factorLinea" class="form-control" id="factorLinea1">
                <option value="factor_1">factor_1</option>
                <option value="factor_2">factor_2</option>
                <option value="factor_3">factor_3</option>
              </select>
            </div> -->
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="cantidad" class="form-control art-cantidad" id="cantidad1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="text" data-name="unidadMedida" class="form-control" id="unidadMedida1">
            </div>
            <div class="col-sm-2 form-group border--full">
              <input type="number" data-name="precioUnitario" class="form-control art-precioUni" id="precioUnitario1">
              <input type="hidden" data-name="precioUnitarioFormated" class="op-hidden-formated">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="porcentajeDescuento" class="form-control art-descuento" id="porcentajeDescuento1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <p class="op-total">
                <input type="hidden" data-name="monto" class="op-hidden-monto" id="monto1">
                <input type="hidden" data-name="montoFormated" class="op-hidden-formated">
                <b class="op-total-monto">0</b>
              </p>
              <span>
            </div>
          </div>
          <div class="wrapper-collapse">
            <div class="content-collapse">
              <div class="row">
                <div class="col-sm-6 form-group">
                  <label for="descripcionArticulo1">Descripción:</label>
                  <textarea data-name="descripcionArticulo" rows="4" class="form-control" id="descripcionArticulo1"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="btns-wrapper">
                  <div class="btns-actions">
                    <a href="#" class="btn-action--delete">Eliminar</a>
                  </div>
                  <div class="btns-collapse">
                    <a href="#" class="show-collapse disp--hide">Mostar detalle</a>
                    <a href="#" class="hide-collapse">Ocultar detalle</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>

        <?php foreach ($cot['lines'] as $index => $linea) :?>
          <li class="row-product">
          <div class="row">
            <div class="col-sm-1 form-group">
              <label for="codigoArticulo<?php echo $index + 1; ?>">Código del artículo:</label>
              <input type="text" data-name="codigoArticulo" class="form-control" id="codigoArticulo<?php echo $index + 1; ?>" value="<?php echo htmlentities($linea['codigo_articulo']); ?>" >
            </div>
            <div class="col-sm-3 form-group">
              <label for="nombreArticulo<?php echo $index + 1; ?>">Nombre del artículo:</label>
              <input type="text" data-name="nombreArticulo" class="form-control" id="nombreArticulo<?php echo $index + 1; ?>" value="<?php echo htmlentities($linea['nombre_articulo']); ?>">
            </div>
             <div class="col-sm-2 form-group">
              <div class="row">
                  <div class="col-sm-12">
                    <label for="exonerado<?php echo $index + 1; ?>">Exonerado</label>
                    <input type="checkbox" data-name="exonerado" id="exonerado<?php echo $index + 1;?>" value="true" <?php echo ( $linea['exonerado'] ? 'checked' : '' ); ?>>
                  </div>
                  <div class="col-sm-12">
                    <button class="btn btn-caution" type="button" data-toggle="modal" data-target="#inventarioModal">Ver el inventario</button>
                  </div>
                </div>
            </div>
            <!-- <div class="col-sm-1 form-group border--full">
              <select type="number" data-name="factorLinea" class="form-control" id="factorLinea<?php echo $index + 1; ?>">
                <option value="factor_1">factor_1</option>
                <option value="factor_2">factor_2</option>
                <option value="factor_3">factor_3</option>
              </select>
            </div> -->
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="cantidad" class="form-control art-cantidad" id="cantidad<?php echo $index + 1; ?>" value="<?php echo $linea['cantidad']; ?>">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="text" data-name="unidadMedida" class="form-control" id="unidadMedida<?php echo $index + 1; ?>" value="<?php echo htmlentities( $linea['unidad_medida']); ?>">
            </div>
            <div class="col-sm-2 form-group border--full">
              <input type="number" data-name="precioUnitario" class="form-control art-precioUni" id="precioUnitario<?php echo $index + 1; ?>" value="<?php echo $linea['precio']; ?>">
              <input type="hidden" data-name="precioUnitarioFormated" class="op-hidden-formated">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="porcentajeDescuento" class="form-control art-descuento" id="porcentajeDescuento<?php echo $index + 1; ?>" value="<?php echo $linea['descuento_porcentaje']; ?>">
            </div>
            <div class="col-sm-1 form-group border--full">
              <p class="op-total">
                <input type="hidden" data-name="monto" class="op-hidden-monto" id="monto<?php echo $index + 1; ?>" value="<?php echo $linea['monto']; ?>">
                <input type="hidden" data-name="montoFormated" class="op-hidden-formated">
                <b class="op-total-monto">0</b>
              </p>
              <span>
            </div>
          </div>
          <div class="wrapper-collapse">
            <div class="content-collapse">
              <div class="row">
                <div class="col-sm-6 form-group">
                  <label for="descripcionArticulo<?php echo $index + 1; ?>">Descripción:</label>
                  <textarea data-name="descripcionArticulo" rows="4" class="form-control" id="descripcionArticulo<?php echo $index + 1; ?>"><?php echo htmlentities( $linea['descripcion'] ); ?></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="btns-wrapper">
                  <div class="btns-actions">
                    <a href="#" class="btn-action--delete">Eliminar</a>
                  </div>
                  <div class="btns-collapse">
                    <a href="#" class="show-collapse disp--hide">Mostar detalle</a>
                    <a href="#" class="hide-collapse">Ocultar detalle</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <?php endforeach; ?>
        <li class="row-foot">
          <div class="row">
            <div class="col-sm-3 cell-collapse">
              <a href="#" class="btn btn-default">Agregar artículo</a>
            </div>
            <div class="col-sm-offset-7 col-sm-1">
              <b>Subtotal</b>
            </div>
            <div class="col-sm-1 op-total">
              <input type="hidden" name="subtotal" class="op-hidden-subtotal">
              <input type="hidden" name="subtotalFormated" class="op-hidden-formated">
              <b class="op-total-subtotal">0</b>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
              <b>Descuento</b>
            </div>
            <div class="col-sm-1 op-total">
              <input type="hidden" name="totalDescuento" class="op-hidden-descuento">
              <input type="hidden" name="totalDescuentoFormated" class="op-hidden-formated">
              <b class="op-total-descuento">0</b>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
              <b>I.V.A</b>
            </div>
            <div class="col-sm-1 op-total">
              <input type="hidden" name="totalIva" class="op-hidden-iva">
              <input type="hidden" name="totalIvaFormated" class="op-hidden-formated">
              <b class="op-total-iva">0</b>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
              <b>Total</b>
            </div>
            <div class="col-sm-1 op-total">
              <input type="hidden" name="total" class="op-hidden-total">
              <input type="hidden" name="totalFormated" class="op-hidden-formated">
              <b class="op-total-total">0</b>
            </div>
          </div>
        </li>
      </ul>
      <h4 class="f-section-title">Notas</h4>
      <div class="row">
        <div class="col-sm-6 form-group">
          <label for="notas1">Notas Cotización:</label>
          <textarea name="notasCotizacion" rows="4" class="form-control" id="notasCotizacion"><?php  echo htmlentities( $cot[0]['notas'] ); ?></textarea>
        </div>
        <div class="col-sm-6 form-group">
          <label for="notas2">Notas CRM:</label>
          <textarea name="notasCRM" rows="4" class="form-control" id="notasCRM"><?php  echo htmlentities( $cot[0]['notas_crm'] ); ?></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-offset-5 col-md-offset-8 col-sm-3  col-md-2 txt-right">
          <label for="firma">Incluir firma</label>
          <input type="checkbox" name="incluirFirma" id="firma" value="yes">
        </div>
        <div class="col-sm-2 col-md-1">
          <a href="#" class="btn btn-default btn-block btn-print">Imprimir</a>
        </div>
        <div class="col-sm-2 col-md-1">
          <a href="#" class="btn btn-default btn-block btn-save">Guardar</a>
        </div>
      </div>

      <footer>
        <p>&copy; United Devs 2016</p>
      </footer>
      <div class="modal fade" id="confirmModal" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <a href="#" type="button" data-dismiss="modal" class="btn btn-primary" id="action-exc"></a>
                <a href="#" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="clienteModal" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label for="codigoCliente">Código del cliente:</label>
                      <input type="text" name="codigoCliente" class="form-control" id="codigoCliente">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label for="cedulaJuridica">No. Cédula jurídica:</label>
                      <input type="text" name="cedulaJuridica" class="form-control" id="cedulaJuridica">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label for="nombreCliente">Nombre del cliente:</label>
                      <input type="text" name="nombreCliente" class="form-control" id="nombreCliente">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label for="nombreDivision">Nombre de la división:</label>
                      <input type="text" name="nombreDivision" class="form-control" id="nombreDivision">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label for="nombreContacto">Nombre del contacto:</label>
                      <input type="text" name="nombreContacto" class="form-control" id="nombreContacto">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label for="email">Email:</label>
                      <input type="text" name="email" class="form-control" id="email">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 form-group">
                      <label for="provincia">Provincia:</label>
                      <select name="provincia" class="form-control" id="provincia">
                        <option>----</option>
                      </select>
                    </div>
                    <div class="col-sm-4 form-group">
                      <label for="canton">Cantón:</label>
                      <select name="canton" class="form-control" id="canton">
                        <option>----</option>
                      </select>
                    </div>
                    <div class="col-sm-4 form-group">
                      <label for="distrito">Distrito:</label>
                      <select name="distrito" class="form-control" id="distrito">
                        <option>----</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label for="direccion">Dirección:</label>
                      <input type="text" name="direccion" class="form-control" id="direccion">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 form-group">
                      <label for="telefono1">Teléfono 1:</label>
                      <input type="text" name="telefono1" class="form-control" id="telefono1">
                    </div>
                    <div class="col-sm-4 form-group">
                      <label for="telefono2">Teléfono 2:</label>
                      <input type="text" name="telefono2" class="form-control" id="telefono2">
                    </div>
                    <div class="col-sm-4 form-group">
                      <label for="telefono3">Teléfono 3:</label>
                      <input type="text" name="telefono3" class="form-control" id="telefono3">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 form-group">
                      <label for="Fax">Fax:</label>
                      <input type="text" name="Fax" class="form-control" id="Fax">
                    </div>
                    <div class="col-sm-4 form-group">
                      <label for="apartadoPostal">Apartado postal:</label>
                      <input type="text" name="apartadoPostal" class="form-control" id="apartadoPostal">
                    </div>
                    <div class="col-sm-4 form-group">
                      <label for="codigoPostal">Código postal:</label>
                      <input type="text" name="codigoPostal" class="form-control" id="codigoPostal">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <a href="#" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                </div>
              </div>
            </div>
          </div>

    </form> <!-- /container -->
    <form id="downloadFile" method="post" action="/cotz/downloadPdf.php" target="_black" class="hide">
      <input type="hidden" name="data">
    </form>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/vendor/jquery.formatCurrency-1.4.0.min.js"></script>
    <script src="bower_components/bootstrap-table/src/bootstrap-table.js"></script>
    <script src="bower_components/bootstrap-table/src/locale/bootstrap-table-es-CR.js"></script>
    <script src="js/vendor/tableExport/tableExport.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X','auto');ga('send','pageview');
    </script>
  </body>
</html>
