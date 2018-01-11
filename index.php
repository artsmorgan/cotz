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
    <div id="toolbar" class="row" >
      <div class="col-sm-6">
        <select id="batch-processing" disabled>
            <option value="">Acciones en lote</option>
            <option value="edit">Editar</option>
        </select>
      </div>

      <div class="col-sm-6" style="text-align: right;">
        <label for="export_all">Exportar todas</label>
        <input type="checkbox" value="all" id="export_all">
      </div>
      
    </div>
    <br>

        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
      <table id="table" data-pagination="true" 
                        data-show-export="true" data-export-types="['csv', 'txt', 'excel']"
                        data-search="true" data-search-on-enter-key="true"  data-smart-display="true"
                        data-page-size="50" data-page-list="[10,25,50,100]">
      <thead>
      <tr>  
        <th data-field="id" data-sortable="true" data-formatter="addCheckbox">Cot #</th>
        <th data-field="no_cotizacion" data-sortable="true">No. cotización</th>
        <th data-field="name" data-sortable="true">Cliente</th>
        <th data-field="username" data-sortable="true">Vendedor</th>
        <th data-field="marca" data-sortable="true">Marca</th>
        <th data-field="fase" data-sortable="true">Fase</th>
        <!--<th data-field="tasa_cambio" data-sortable="true">T. cambio</th>-->
        <th data-field="moneda" data-sortable="true" title="Moneda">Moneda</th>
        <th data-field="total" data-sortable="true" data-formatter="formatPrice">Monto</th>
        <!-- <th data-field="description" data-sortable="true">Descripcion</th> -->
        <th data-field="fecha_cotizacion" data-sortable="true">Fecha de<br> Cotizacón</th>
        <th data-field="id" data-events="edit" data-formatter="editBtn"></th>
        <?php if( !empty($userdata[0]) && $userdata[0]['role_id'] == '1'  ): ?>
        <th data-field="id" data-events="edit" data-formatter="deletetBtn"></th>
        <?php endif; ?>
      </tr>
      </thead>
      </table>

      <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
              <p>Seguro que desea eliminar esta cotización Cot# <strong></strong>?</p>
            </div>
            <div class="modal-footer">
              <a href="#" type="button" data-dismiss="modal" class="btn btn-primary" id="action-exc">Eliminar</a>
              <a href="#" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="vendedoresModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 1000;">
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

        <div class="modal fade" id="editBatchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 900;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar cotizaciones: <span></span></h4>
              </div>
              <div class="modal-body company-modal-body">
                 <br>
                 <form class="editBatchForm">
                    <div class="form-group">
                      <label for="vendedor">Vendedor:</label>
                      <input type="text"  class="form-control" id="vendedor" />
                      <input type="hidden" name="userid" id="userid" value="" />
                    </div>
                  </form>
                  <div class="msg">
                  </div>
              </div>
              <div class="modal-footer default">
                <a href="#" type="button" class="btn btn-primary">Guardar</a>
                <a href="#" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
              </div>
              <div class="modal-footer ok">
                <a href="#" type="button" class="btn btn-primary btn-ok" data-dismiss="modal">Ok</a>
              </div>      
            </div>
          </div>
        </div>

      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
      <script src="js/vendor/bootstrap.min.js"></script>

      <script src="bower_components/bootstrap-table/src/bootstrap-table.js"></script>
      <script src="bower_components/bootstrap-table/src/locale/bootstrap-table-es-CR.js"></script>
      <script src="js/export-table.js"></script>
      <script src="js/vendor/jquery.formatCurrency-1.4.0.min.js"></script>
      <script src="js/vendor/tableExport/tableExport.min.js"></script>
      <script type="text/javascript" src="js/vendor/tableExport/libs/FileSaver/FileSaver.min.js"></script>
      <script type="text/javascript" src="js/vendor/tableExport/libs/js-xlsx/xlsx.core.min.js"></script>
      <script type="text/javascript">

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

      $(function () {
        var username = <?php echo "'$username';"; ?>

        var dateFormat = 'yy-mm-dd',
        $from = $( "#datepicker_from" ).datepicker({dateFormat: dateFormat}).on( "change", function() {
          $to.datepicker( "option", "minDate", getDate( this.value ) );
        }),
        $to = $( "#datepicker_to" ).datepicker({dateFormat: dateFormat}).on( "change", function() {
          $from.datepicker( "option", "maxDate", getDate( this.value ) );
        });

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
         var jsonData = null,
              bootstrapTableOpt = {
                url: <?php echo $path; ?>+'/cotz/services/cotz.php?action=get_cotizacionesAllMIN',
                onDblClickRow: function(row, $element, field){
                  var cotID = row['id'];
                },
                onLoadSuccess: function(){
                  $table.find('.batch-processing').closest('td').off('click dbclick');

                  jsonData = $table.bootstrapTable('getData');
                  bootstrapTableOpt['data'] = jsonData;
                  delete bootstrapTableOpt.url;

                  (typeof parent.iframeLoaded === 'function' ) && parent.iframeLoaded();
                },
                onAll: function(name, args){
                    (typeof parent.iframeLoaded === 'function' ) && parent.iframeLoaded();
                }
              }, 
            $table = $('#table').bootstrapTable(bootstrapTableOpt);

            $('#toolbar input').on('change', function(){
              var value = $(this).is(':checked') ? $(this).val() : '';
              bootstrapTableOpt['exportDataType'] = value;

              $table.bootstrapTable('destroy').bootstrapTable(bootstrapTableOpt);
              applyFilters();
              $('.fixed-table-toolbar').prepend(createCotBtn);          
            });


          $('.fixed-table-toolbar').prepend(createCotBtn);

          
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

      </script>

  </body>
</html>
