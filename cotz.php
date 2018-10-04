<?php
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
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/select2.min.css">
        <link rel="stylesheet" href="css/main.css?v=1.0.0">
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
                <h4 class="modal-title" id="myModalLabel">Consultar Inventario. [updating]</h4>
              </div>
              <div class="modal-body">
                <table id="table" data-pagination="true"
                        data-search="true" data-search-on-enter-key="true"  data-smart-display="true"
                        data-page-size="6" data-page-list="[10,25,50,100]">
                    <thead>
                    <tr>
                      <th data-radio="true"></th>
                      <!--<th data-field="Apellidos" data-sortable="true">Apellidos</th>-->
                      <th data-field="Bodega" data-sortable="true">Bodega</th>
                      <th data-field="Codigo" data-sortable="true">Código</th>
                      <th data-field="NombreDelArticulo" data-sortable="true">Artículo</th>
                      <th data-field="NoDeParte" data-sortable="true">N/P</th>
                      <th data-field="Unidad">U.M.</th>
                      <th data-field="CantidadDisponible" >Cant.</th>
                      <th data-field="Precio" data-formatter="formatPrice">Precio Unit.</th>
                      <th data-field="Provedor" >Provedor</th>
                      <th data-field="DetallesDelArticulo" > Especificación</th>
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
                <input type="text" placeholder="Buscar" class="pull-right custom-tablesearch" data-fields="username">
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
            <button type="button" class="btn btn-default btn-print"  data-toggle="tooltip" data-placement="bottom" title="Imprimir">
              <i class="fa fa-print" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      <!-- <button class="btn btn-primary" onclick="gotoList()">Regresar al listado</button> -->
    <form class="container-fluid form-container">
      <div class="row">
        <div class="col-sm-6 info-cotizacion float--active">

          <h4 class="f-section-title">Cotización</h4>
          <div class="row">
            <div class="col-sm-6 form-group">
              <label for="vendedor">Vendedor:</label>
              <input type="text" name="vendedor" class="form-control" id="vendedor" 
                        value="<?php echo $userdata[0]['firstname'].' '.$userdata[0]['lastname']; ?>" />

              <input type="hidden" name="userid" id="userid" value="<?php echo $userdata[0]['userID']; ?>" />          

            </div>
            <div class="col-sm-3 form-group">
              <label for="fechaCotizacion">Fecha de cotización:</label>
              <input type="text" placeholder="yy-mm-dd" disabled class="form-control datepicker" id="fechaCotizacion" >
              <input type="hidden" name="fechaCotizacion" value="" id="altFechaCotizacion">
            </div>
            <div class="col-sm-3 form-group">
              <label for="fechaVencimiento">Fecha de vencimiento:</label>
              <input type="text" name="fechaVencimiento" placeholder="yy-mm-dd" class="form-control datepicker" id="fechaVencimiento">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 form-group">
              <label for="tasaImpuestos">Tasa de impuestos:</label>
              <input type="number" name="tasaImpuestos" min="1" max="99" maxlength="7" class="form-control" id="tasaImpuestos" value="13">
            </div>
            <div class="col-sm-3 form-group">
              <label for="moneda">Moneda:</label>
              <select name="moneda" class="form-control" id="moneda">
                <option value="colones">¢</option>
                <option value="dolares">$</option>
                <option value="euro">€</option>
              </select>
            </div>
            <div class="col-sm-3 form-group">
              <label for="tasaCambio">Tasa de cambio:</label>
              <input type="number" name="tasaCambio" class="form-control" id="tasaCambio">
            </div>
            <div class="col-sm-3 form-group">
              <label for="redondeo">Factor de redondeo:</label>
              <select name="redondeo" class="form-control" id="redondeo">
                <option value="factor_3" selected>0,01</option>
                <option value="factor_1">0,05</option>
                <option value="factor_2">1,00</option>                
              </select>
            </div>
          </div>
        </div>
        <!--info cotizacion-->
        <div class="col-sm-6 info-cliente float--active">
          <h4 class="f-section-title">Datos del cliente</h4>
          <div class="row">
            <div class="col-sm-4 form-group">
              <label for="cuentaNombreAux">Compañía:</label>
              <input type="text" class="form-control" id="cuentaNombreAux" required>
              <input type="hidden" name="company_id" id="company_id">
            </div>
            <div class="col-sm-8 form-group">
              <label for="clienteNombreAux">Contacto:</label>
              <input type="text" class="form-control" id="clienteNombreAux">
              <input type="hidden" name="contact_id" id="contact_id">
            <!-- </div>
            <div class="col-sm-4">
              <a href="#" class="btn btn-default btn-block">Mostrar detalle</a> -->
            </div>
          </div>
          <h4 class="f-section-title">Condiciones</h4>
          <div class="row">
              <div class="col-sm-4 form-group">
                <label for="tiempoEntrega">Tiempo de entrega:</label>
                <select data-select-add-custom name="tiempoEntrega" class="form-control cl-select2" id="tiempoEntrega" >
                  <option value="Inmediata, salvo previa venta, a partir de recibida la OC.">Inmediata, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="1 día hábil, salvo previa venta, a partir de recibida la OC.">1 día hábil, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="2 días hábiles, salvo previa venta, a partir de recibida la OC.">2 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="3 días hábiles, salvo previa venta, a partir de recibida la OC.">3 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="4 días hábiles, salvo previa venta, a partir de recibida la OC.">4 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="5 días hábiles, salvo previa venta, a partir de recibida la OC.">5 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="8 días hábiles, salvo previa venta, a partir de recibida la OC.">8 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="10 días hábiles, salvo previa venta, a partir de recibida la OC.">10 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="12 días hábiles, salvo previa venta, a partir de recibida la OC.">12 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="15 días hábiles, salvo previa venta, a partir de recibida la OC.">15 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="20 días hábiles, salvo previa venta, a partir de recibida la OC.">20 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="25 días hábiles, salvo previa venta, a partir de recibida la OC.">25 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="30 días hábiles, salvo previa venta, a partir de recibida la OC.">30 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="35 días hábiles, salvo previa venta, a partir de recibida la OC.">35 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="40 días hábiles, salvo previa venta, a partir de recibida la OC.">40 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="45 días hábiles, salvo previa venta, a partir de recibida la OC.">45 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="50 días hábiles, salvo previa venta, a partir de recibida la OC.">50 días hábiles, salvo previa venta, a partir de recibida la OC.</option>
                  <option value="4 semanas, a partir de recibida la OC.">4 semanas, a partir de recibida la OC.</option>
                  <option value="5 semanas, a partir de recibida la OC.">5 semanas, a partir de recibida la OC.</option>
                  <option value="6 semanas, a partir de recibida la OC.">6 semanas, a partir de recibida la OC.</option>
                  <option value="7 semanas, a partir de recibida la OC.">7 semanas, a partir de recibida la OC.</option>
                  <option value="8 semanas, a partir de recibida la OC.">8 semanas, a partir de recibida la OC.</option>
                  <option value="10 semanas, a partir de recibida la OC.">10 semanas, a partir de recibida la OC.</option>
                  <option value="12 semanas, a partir de recibida la OC.">12 semanas, a partir de recibida la OC.</option>
                  <option value="4-6 semanas, a partir de recibida la OC.">4-6 semanas, a partir de recibida la OC.</option>
                  <option value="5-6 semanas, a partir de recibida la OC.">5-6 semanas, a partir de recibida la OC.</option>
                  <option value="6-7 semanas, a partir de recibida la OC.">6-7 semanas, a partir de recibida la OC.</option>
                  <option value="6-8 semanas, a partir de recibida la OC.">6-8 semanas, a partir de recibida la OC.</option>
                  <option value="8-9 semanas, a partir de recibida la OC.">8-9 semanas, a partir de recibida la OC.</option>
                  <option value="8-10 semanas, a partir de recibida la OC.">8-10 semanas, a partir de recibida la OC.</option>
                  <option value="10-12 semanas, a partir de recibida la OC.">10-12 semanas, a partir de recibida la OC.</option>
                  <option value="Inmediata, salvo previa venta, a partir de recibida la OC y el pago.">Inmediata, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="1 día hábil, salvo previa venta, a partir de recibida la OC y el pago.">1 día hábil, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="2 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">2 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="3 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">3 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="4 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">4 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="5 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">5 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="8 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">8 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="10 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">10 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="12 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">12 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="15 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">15 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="20 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">20 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="25 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">25 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="30 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">30 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="35 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">35 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="40 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">40 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="45 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">45 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="50 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.">50 días hábiles, salvo previa venta, a partir de recibida la OC y el pago.</option>
                  <option value="4 semanas, a partir de recibida la OC y el pago.">4 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="5 semanas, a partir de recibida la OC y el pago.">5 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="6 semanas, a partir de recibida la OC y el pago.">6 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="7 semanas, a partir de recibida la OC y el pago.">7 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="8 semanas, a partir de recibida la OC y el pago.">8 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="10 semanas, a partir de recibida la OC y el pago.">10 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="12 semanas, a partir de recibida la OC y el pago.">12 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="4-6 semanas, a partir de recibida la OC y el pago.">4-6 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="5-6 semanas, a partir de recibida la OC y el pago.">5-6 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="6-7 semanas, a partir de recibida la OC y el pago.">6-7 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="6-8 semanas, a partir de recibida la OC y el pago.">6-8 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="8-9 semanas, a partir de recibida la OC y el pago.">8-9 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="8-10 semanas, a partir de recibida la OC y el pago.">8-10 semanas, a partir de recibida la OC y el pago.</option>
                  <option value="10-12 semanas, a partir de recibida la OC y el pago.">10-12 semanas, a partir de recibida la OC y el pago.</option>
                  <option data-other>Otro</option>
                </select>
              </div>
              <div class="col-sm-4 form-group">
                <label for="lugarEntrega">Lugar de entrega:</label>
                <select data-select-add-custom class="form-control cl-select2" name="lugarEntrega" id="lugarEntrega">
                    <option value="Sus bodegas.">Sus bodegas.</option>
                    <option value="Sus instalaciones.">Sus instalaciones.</option>
                    <option value="Su oficina.">Su oficina.</option>
                    <option value="A convenir.">A convenir.</option>
                    <option value="Vía encomienda.">Vía encomienda.</option>
                    <option value="Nuestras bodegas">Nuestras bodegas</option>
                    <option value="Nuestras instalaciones">Nuestras instalaciones</option>
                    <option data-other>Otro</option>
                </select>
              </div>
              <div class="col-sm-4 form-group">
                <label for="formaPago">Forma de pago:</label>
                <select name="formaPago" class="form-control cl-select2" id="formaPago" data-select-add-custom>
                    <option value="Contado contra entrega.">Contado contra entrega.</option>
                    <option value="Contado contra orden de compra.">Contado contra orden de compra.</option>
                    <option value="Crédito a 30 días.">Crédito a 30 días.</option>
                    <option value="50% con la OC, 50% contra entrega de la mercadería.">50% con la OC, 50% contra entrega de la mercadería.</option>
                    <option value="50% con la OC, 50% restante a crédito 30 días.">50% con la OC, 50% restante a crédito 30 días.</option>
                    <option value="Usual de la Institución.">Usual de la Institución.</option>
                    <option data-other>Otro</option>
                </select>
              </div>
          </div>
        </div>
        <!--info cliente-->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-3 form-group">
              <label for="noSolicitud">No. de solicitud:</label>
              <input type="text" name="noSolicitud" class="form-control" id="noSolicitud">
            </div>
            <div class="col-sm-3 form-group">
              <label for="noCotizacion">No. de cotización:</label>
              <input type="text" name="noCotizacion" class="form-control" id="noCotizacion" required>
            </div>
            <div class="col-sm-3 form-group">
              <label for="marca">Marca:</label>
              <select type="text" name="marca" class="form-control cl-select2" id="marca" required>
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
            <div class="col-sm-3 form-group">
              <label for="fase">Fase:</label>
              <select name="fase" class="form-control cl-select2" id="fase" required>
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
      </div>
      <hr>
      <h4 class="f-section-title">Líneas de la transacción</h4>
      <ul class="transactions-list">
        <li class="row-head">
          <div class="row">
           <!--  <div class="col-sm-offset-6 col-sm-1 border-full">
              <b>Factor de redondeo</b>
            </div> -->
            <div class="col-sm-6">
              <b>Descripción</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>Cant.</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>U.M.</b>
            </div>
            <div class="col-sm-2 border--full">
              <b>Precio Unit.</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>% Descto.</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>Precio Total</b>
            </div>
          </div>
        </li>
        <li class="row-product">
          <div class="row">
            <div class="col-sm-6">
              <div class="row cols-middle">
                <div class="col-sm-2 form-group">
                  <label for="codigoArticulo1">Código:</label>
                  <input type="text" data-name="codigoArticulo" class="form-control codAutocomple" id="codigoArticulo1">
                </div>
                <div class="col-sm-6 form-group">
                  <label for="nombreArticulo1">Descripción:</label>
                  <input type="text" data-name="nombreArticulo" class="form-control" id="nombreArticulo1">
                </div>
                <div class="col-sm-4 form-group">
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
              </div>
              <!-- inner row -->
              <div class="wrapper-collapse">
                <div class="content-collapse">
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label for="descripcionArticulo1">Descripción:</label>
                      <textarea data-name="descripcionArticulo" rows="4" class="form-control" id="descripcionArticulo1"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="btns-wrapper">
                      <div class="btns-actions">
                        <a href="#" class="btn-action--delete visible-sm visible-md visible-lg">Eliminar</a>
                      </div>
                      <div class="btns-collapse">
                        <a href="#" class="show-collapse disp--hide">Mostar detalle</a>
                        <a href="#" class="hide-collapse">Ocultar detalle</a>
                      </div>
                    </div>
                    <!-- btns-wrapper -->
                  </div>
                </div>
                <!-- inner row -->
              </div>
              <!-- collapse  -->
            </div>      
            <!-- <div class="col-sm-1 form-group border--full">
              <select type="number" data-name="factorLinea" class="form-control" id="factorLinea1">
                <option value="factor_1">factor_1</option>
                <option value="factor_2">factor_2</option>
                <option value="factor_3">factor_3</option>
              </select>
            </div> -->
            <div class="col-sm-1 form-group border--full">
              <label for="cantidad1" class="hidden-sm">Cantidad</label>
              <input type="number" data-name="cantidad" class="form-control art-cantidad" id="cantidad1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <label for="unidadMedida1" class="hidden-sm">Unidad de medida</label>
              <input type="text" data-name="unidadMedida" class="form-control" id="unidadMedida1">
            </div>
            <div class="col-sm-2 form-group border--full">
              <label for="precioUnitario1" class="hidden-sm">Precio unitario</label>
              <input type="text" class="form-control art-precioUni format-currency" id="precioUnitario1">
              <input type="hidden" data-name="precioUnitario" class="form-control">
              <input type="hidden" data-name="precioUnitarioFormated" class="op-hidden-formated">
            </div>
            <div class="col-sm-1 form-group border--full">
              <label for="porcentajeDescuento1" class="hidden-sm">Descuento</label>
              <input type="number" data-name="porcentajeDescuento" class="form-control art-descuento" id="porcentajeDescuento1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <p class="op-total">
                <span class="hidden-sm">Monto:</span>
                <input type="hidden" data-name="monto" class="op-hidden-monto" id="monto1">
                <input type="hidden" data-name="montoFormated" class="op-hidden-formated">
                <b class="op-total-monto">0</b>
              </p>
              <span>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="btns-wrapper">
                <div class="btns-actions">
                  <a href="#" class="btn-action--delete visible-xs">Eliminar</a>
                </div>
              </div>
              <!-- btns-wrapper -->
            </div>
          </div>
          <!-- inner row -->
          
        </li>

        <li class="row-foot">
          <div class="row">
            <div class="col-sm-3 cell-collapse">
              <button class="btn btn-default">Agregar artículo</button>
              <br><br>
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
          <textarea name="notasCotizacion" rows="4" class="form-control" id="notasCotizacion"></textarea>
        </div>
        <div class="col-sm-6 form-group">
          <label for="notas2">Notas CRM:</label>
          <textarea name="notasCRM" rows="4" class="form-control" id="notasCRM"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-offset-8 col-md-offset-8 col-sm-2 col-md-2">
          <a href="#" class="btn btn-default btn-block btn-print">Imprimir</a>
        </div>
        <div class="col-sm-2 col-md-2">
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

        <!-- Modal Print Configuration -->
        <div class="modal fade" id="printConfig" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Opciones de impresión</h4>
            </div>
              <div class="modal-body">
                <form>
                <label>
                  <input type="checkbox" name="showObservations" value="1" checked> Mostrar observaciones
                </label>
                </form>
              </div>
              <div class="modal-footer">
                <a href="#" type="button" data-dismiss="modal" class="btn btn-primary" id="action-exc">Imprimir</a>
                <a href="#" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
              </div>
            </div>
          </div>
        </div>

        <!-- End printConfig -->

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
    <form id="downloadFile" method="post" action="/cotz/downloadPdf.php" target="_blank" class="hide">
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
    <script src="js/vendor/jquery-ui.min.js"></script>
    <script src="js/vendor/select2.full.min.js"></script>
    <script src="js/main.js?v=<?php echo rand(0,99) ?>"></script>

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
