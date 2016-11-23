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
        <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="css/main.css">

         <script src="https://use.fontawesome.com/5b1d115124.js"></script>

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
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
                <button type="button" class="btn btn-primary">Agregar</button>
              </div>
            </div>
          </div>
        </div>

        <div class="toolbar">
          <div class="btn-group pull-right" role="group">
            <button type="button" class="btn btn-default" onclick="gotoList()" data-toggle="tooltip" data-placement="bottom" title="Regresar al listado">
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
    <form class="container-fluid form-container">
      <div class="row">
        <div class="col-sm-6 info-cliente float--active">
          <h4 class="f-section-title">Datos del cliente</h4>
          <div class="row">
            <div class="col-sm-4 form-group">
              <label for="codigoClienteAux">Código del cliente:</label>
              <input type="text" class="form-control" id="codigoClienteAux" data-bind="#codigoCliente">
            </div>
            <div class="col-sm-4 form-group">
              <label for="cedulaJuridicaAux">No. Cédula jurídica:</label>
              <input type="text" class="form-control" id="cedulaJuridicaAux" data-bind="#cedulaJuridica">
            </div>
            <div class="col-sm-4">
              <a href="#" class="btn btn-default btn-block">Mostrar detalle</a>
            </div>
          </div>
          <h4 class="f-section-title">Condiciones</h4>
          <div class="row">
              <div class="col-sm-3 form-group">
                <label for="tiempoEntrega">Tiempo de entrega:</label>
                <select name="tiempoEntrega" class="form-control" id="tiempoEntrega">
                  <option>----</option>
                </select>
              </div>
              <div class="col-sm-6 form-group">
                <label for="lugarEntrega">Lugar de entrega:</label>
                <input type="text" name="lugarEntrega" class="form-control" id="lugarEntrega">
              </div>
              <div class="col-sm-3 form-group">
                <label for="formaPago">Forma de pago:</label>
                <input type="text" name="formaPago" class="form-control" id="formaPago">
              </div>
          </div>
        </div>
        <!--info cliente-->
        <div class="col-sm-6 info-cotizacion float--active">
          
          <h4 class="f-section-title">Cotización</h4>
          <div class="row">
            <div class="col-sm-6 form-group">
              <label for="vendedor">Vendedor:</label>
              <input type="text" name="vendedor" class="form-control" id="vendedor">
            </div>
            <div class="col-sm-3 form-group">
              <label for="fechaCotizacion">Fecha de cotización:</label>
              <input type="text" name="fechaCotizacion" placeholder="dd/mm/aaaa" class="form-control datepicker" id="fechaCotizacion">
            </div>
            <div class="col-sm-3 form-group">
              <label for="fechaVencimiento">Fecha de vencimiento:</label>
              <input type="text" name="fechaVencimiento" placeholder="dd/mm/aaaa" class="form-control datepicker" id="fechaVencimiento">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 form-group">
              <label for="tasaImpuestos">Tasa de impuestos:</label>
              <input type="number" name="tasaImpuestos" min="1" max="99" maxlength="2" class="form-control" id="tasaImpuestos">
            </div>
            <div class="col-sm-3 form-group">
              <label for="moneda">Moneda:</label>
              <select name="moneda" class="form-control" id="moneda">
                <option value="dolares">$</option>
                <option value="colones">₡</option>
              </select>
            </div>
            <div class="col-sm-3 form-group">
              <label for="tasaCambio">Tasa de cambio:</label>
              <input type="number" name="tasaCambio" class="form-control" id="tasaCambio">
            </div>
            <div class="col-sm-3 form-group">
              <label for="redondeo">Factor de redondeo:</label>
              <select name="redondeo" class="form-control" id="redondeo">
                <option value="001">001</option>
                <option value="001">005</option>
                <option value="001">000</option>
                <option value="N/A">N/A</option>
              </select>

            </div>
          </div>
        </div>

        <!--info cotizacion-->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-4 form-group">
              <label for="marca">Marca:</label>
              <input type="text" name="marca" class="form-control" id="marca">
            </div>
            <div class="col-sm-4 form-group">
              <label for="fase">Fase:</label>
              <select name="fase" class="form-control" id="fase">
                <option value="Comunicación inicial">Comunicación inicial</option>
                <option value="Cotización">Cotización</option>
                <option value="Negociación">Negociación</option>
                <option value="Venta realizada">Venta realizada</option>
                <option value="Cerrada perdida">Cerrada perdida</option>
                <option value="Desierta">Desierta</option>
              </select>
            </div>
            <div class="col-sm-4 form-group">
              <label for="noSolicitud">No. de solicitud:</label>
              <input type="text" name="noSolicitud" class="form-control" id="noSolicitud">
            </div>
          </div>
        </div>
      </div>
      <hr>
      <h4 class="f-section-title">Líneas de la transacción</h4>
      <ul class="transactions-list">
        <li class="row-head">
          <div class="row">
            <div class="col-sm-offset-6 col-sm-1 border--full">
              <b>U/ medida</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>Cant x precio U.</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>% descuento</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>Precio u.</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>Cant</b>
            </div>
            <div class="col-sm-1 border--full">
              <b>Monto</b>
            </div>
          </div>
        </li>
        <li class="row-product">
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
              <button class="btn btn-caution" type="button" data-toggle="modal" data-target="#inventarioModal">ver de Inventario</button>
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="unidadMedida" class="form-control" id="unidadMedida1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="cantidadPrecioUnitario" class="form-control" id="cantidadPrecioUnitario1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="porcentajeDescuento" class="form-control art-descuento" id="porcentajeDescuento1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="precioUnitario" class="form-control art-precioUni" id="precioUnitario1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="number" data-name="cantidad" class="form-control art-cantidad" id="cantidad1">
            </div>
            <div class="col-sm-1 form-group border--full">
              <input type="hidden" data-name="monto" class="op-hidden-monto" id="monto1">
              <p class="op-total">
                <b class="op-total-monto">0</b>
              </p>
              <span>
            </div>
          </div>
          <div class="wrapper-collapse">
            <div class="content-collapse">
              <div class="row">
                <div class="col-sm-2 form-group">
                  <label for="codigoNombreLinea1">Código y nombre de línea</label>
                  <input type="text" data-name="name" class="form-control" id="codigoNombreLinea1">
                </div>
                <div class="col-sm-1 form-group">
                  <label for="noParte1">No. de parte</label>
                  <input type="text" data-name="noParte" class="form-control" id="noParte1">
                </div>
                <div class="col-sm-1 form-group">
                  <label for="marcaArticulo1">Marca</label>
                  <input type="text" data-name="marcaArticulo" class="form-control" id="marcaArticulo1">
                </div>
                <div class="col-sm-2 form-group">
                  <label for="proveedor1">Proveedor</label>
                  <input type="text" data-name="proveedor" class="form-control" id="proveedor1">
                </div>
              </div>
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
              <b class="op-total-subtotal">0</b>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
              <b>Descuento</b>
            </div>
            <div class="col-sm-1 op-total">
              <input type="hidden" name="totalDescuento" class="op-hidden-descuento">
              <b class="op-total-descuento">0</b>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
              <b>I.V.A</b>
            </div>
            <div class="col-sm-1 op-total">
              <input type="hidden" name="totalIva" class="op-hidden-iva">
              <b class="op-total-iva">0</b>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
              <b>Total</b>
            </div>
            <div class="col-sm-1 op-total">
              <input type="hidden" name="total" class="op-hidden-total">
              <b class="op-total-total">0</b>
            </div>
          </div>
        </li>
      </ul>
      <h4 class="f-section-title">Notas</h4>
      <div class="row">
        <div class="col-sm-6 form-group">
          <label for="notas1">Notas 1:</label>
          <textarea name="notas1" rows="4" class="form-control" id="notas1"></textarea>
        </div>
        <div class="col-sm-6 form-group">
          <label for="notas2">Notas 2:</label>
          <textarea name="notas2" rows="4" class="form-control" id="notas2"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-offset-11 col-sm-1">
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


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="js/vendor/bootstrap.min.js"></script>

    <script src="js/vendor/bootstrap-datepicker.min.js"></script>

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
