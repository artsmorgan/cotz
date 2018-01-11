var SERVER_PROD = 'http://tecnosagot.united-crm.com';
var SERVER_DEV = 'http://crm.local/';

function gotoList(username){
    window.location.href = "index.php?u="+username;
    parent.iframeLoaded();
}

function formatPrice(value){
  return $('<span>'+ value + '</span>').formatCurrency({symbol: ''}).html();
}

(function ($){

  $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['es-CR']);
  $.formatCurrency.regions[''].decimalSymbol = ',';
  $.formatCurrency.regions[''].digitGroupSymbol = '.';

  var roundMethods = {
    factor_1: {
      total: 0.05,
      total_final: 0.05
    },
    factor_2: {
      total: 0.05,
      total_final: 1
    },
    factor_3: {
      total: 0.01,
      total_final: 0.01
    }
  };

  function updateConsecutiveAttr( consecutive, $item){
    $('.form-control, label, :checkbox, :radio', $item).each(function(){
      var $this = $(this),
          attrAux = '';

      if( $this.is( 'label' ) ){
        if( $this.attr( 'for' ) ){
          attrAux = $this.attr( 'for' ).replace( /\d+/, consecutive );
          $this.attr( 'for', attrAux );
        }
      }
      else{
        if( $this.attr( 'id' ) ){
          attrAux = $this.attr( 'id' ).replace( /\d+/, consecutive );
          $this.attr('id', attrAux);
        }
      }
    });
  }

  function containerScroll(to){
    var $container = parent.$('html, body');

    $container.animate({
      scrollTop: to
    }, 500);
  }

  function updateFormatCurrency(){
    $('.op-total b') .formatCurrency({
      symbol: $('#moneda option:selected').text() + ' '
    });

    $('.op-total b').each(function(){
      $(this).parent().find('.op-hidden-formated').val( $(this).text() );
    });

    $('[data-name=precioUnitario]').each(function(){
      $priceFormated = $(this).parent().find('.op-hidden-formated');

      $(this).formatCurrency( $priceFormated, {
        symbol: $('#moneda option:selected').text() + ' '
      });
    });
  }

  function updateMonto( $productRow ) {
    var cantidad = $productRow.find( '[data-name=cantidad]' ).val(),
        precioUnitario = $productRow.find( '[data-name=precioUnitario]' ).val();
        $dispMonto = $productRow.find( '.op-total-monto' ),
        method = $productRow.find('[data-name=factorLinea]').val(),
        exonerado = $productRow.find('[data-name=exonerado]').is(':checked');

        cantidad = cantidad ? cantidad : 0;
        precioUnitario = precioUnitario ? precioUnitario : 0;

        monto = cantidad * precioUnitario;

        monto = applyRoundFactor(monto, 'total', method);

        $productRow.find( '.op-hidden-monto' ).val( monto ).toggleClass( 'exonerado', exonerado );

        $dispMonto.text( monto );
  }

  function updateSubtotal(){
    var subtotal = 0,
        subtotalTaxes = 0;
    $('.row-product .op-hidden-monto').each(function(){
      subtotal += Number( $(this).val() );
      if( !$(this).hasClass('exonerado') ){
        subtotalTaxes += Number( $(this).val() );
      }
    });

    subtotal = applyRoundFactor(subtotal, 'total');

    $('.op-hidden-subtotal').val(subtotal);
    $('.op-total-subtotal').text(subtotal).data('withTaxes', subtotalTaxes);
  }

  function updateDescuento(){
    var descuento = 0,
        descuentoTaxes = 0,
        porcentaje = 0;

    $('.row-product').each(function(){
      porcentaje = $(this).find('.art-descuento').val() / 100;
      descuento += Number(  $(this).find('.op-hidden-monto').val() ) * porcentaje;
      if( !$(this).find('.op-total-monto').hasClass('exonerado') ){
        descuentoTaxes += Number(  $(this).find('.op-hidden-monto').val() ) * porcentaje;
      }
    });

    descuento = applyRoundFactor(descuento, 'total');

    $('.op-hidden-descuento').val(descuento);
    $('.op-total-descuento').text(descuento).data('withTaxes', descuentoTaxes);
  }

  function updateIVA(){
    var impuesto = Number( $('#tasaImpuestos').val() );
    impuesto = Object.is(impuesto, NaN) ? 0 : impuesto;
    var iva = impuesto / 100,
        subtotalTaxes = $('.op-total-subtotal').data('withTaxes'),
        descuentoTaxes = $('.op-total-descuento').data('withTaxes'),
        totalIva = ( subtotalTaxes - descuentoTaxes ) * iva;

    totalIva = applyRoundFactor(totalIva, 'total');

    $('.op-hidden-iva').val(totalIva);
    $('.op-total-iva').text(totalIva);
  }

  function updateTotal(){
    var iva = Number( $('.op-hidden-iva').val() ),
        subtotal = Number( $('.op-hidden-subtotal').val() ),
        descuento = Number( $('.op-hidden-descuento').val() ),
        total = subtotal - descuento + iva;

    total = applyRoundFactor(total, 'total_final');

    $('.op-hidden-total').val(total);
    $('.op-total-total').text(total);
  }

  function getProdcutDataJSON(){
    var data = [];

    $( '.row-product' ).each(function(){
      var product = {};
      
      $( 'input, textarea', this ).each(function(){
        var $input = $( this ),
            key = $input.data( 'name' );

        if( $input.is(':radio, :checkbox') ){
          product[key] = $input.is(':checked') ? $input.val(): null;
        }
        else{
          product[key] = $input.val();
        }
        

      });

     
      data.push(product);
    });

    return encodeURIComponent(JSON.stringify(data));
  }

  function parentIframeLoaded(scroll){
    if( scroll && typeof parent.iframeLoaded == 'function' ){
      parent.iframeLoaded(scroll);
    }
    else if( parent.$ ){
      parent.$('#if1').attr( 'height', (  parent.$('#if1').contents().find('body').outerHeight() ) );
    }
  }

  function applyRoundFactor( number, factor, method ){
    if ( factor !== 'total' && factor !== 'total_final' ){
      factor = 'total_final';
    }

    method = method || $('#redondeo').val();
    var round = roundMethods[method][factor];

    return roundTo(number, round).toFixed(2);
  }

  function roundTo(number, round ){
    return round * Math.round(number/round);
  }

  function setNewVendedor(username, id){
    $('#vendedor').val(username);
    $('#userid').val(id);
  }

  function updateAll(){
    $('.row-product').each(function(){
        updateMonto( $(this) );
      });

      updateSubtotal();
      updateDescuento();
      updateIVA();
      updateTotal();
      updateFormatCurrency();
  }

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

  $( document ).ready(function(){

    $('.format-currency').formatCurrency({symbol: ''});

    var deletingDecimalSymbol= false;
    
    $('.transactions-list').on('keydown', '.format-currency', function(e){
        var inputElem = $(this).get(0),
            caretPos = doGetCaretPosition( inputElem )
            decimalSymbol = ',',
            val = $(this).val();
      
          deletingDecimalSymbol = ( e.keyCode == 8 ) && val[caretPos - 1] == decimalSymbol;
    });

    $('.transactions-list').on('keypress', '.format-currency', function(e){
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

    $('.transactions-list').on('input', '.format-currency', function(e){
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

    var $productForm = $( '.row-product:first' ).clone().addClass( 'disp--hide' ),
        $productRow = {},
        productData = {};

    $productForm.find('input,textarea').val('');
    $productForm.find('.op-total-monto').text('');

    $( '.row-product.disp--hide' ).remove();

    updateFormatCurrency();
    parentIframeLoaded(true);
    //$( '.fixed-table-toolbar' ).prepend(createCotBtn);
    var randVer = Math.floor(Math.random() * 100);
    var inv = null;
    var url_inv = SERVER_PROD+'/cotz/api/inv.json?ver='+randVer;
    $.ajax({
        url: url_inv,
        dataType: 'json',
        success: function(response){
          console.log('here', url_inv)
           inv = response;
           initInvTable();
           initCodAutocomplete();
        }
    });

  function initInvTable(){
      var bootstrapTableOpt = {
        data: inv,
        onLoadSuccess: function(){
          parentIframeLoaded(true);
        },
        onAll: function(name, args){
          parentIframeLoaded(true);
        },
        exportDataType: 'all'
      };

      $( '#table' ).bootstrapTable(bootstrapTableOpt);

      // $('#toolbar').find('select').change(function () {
      //     console.log('change');
      //     bootstrapTableOpt['exportDataType'] =  $(this).val();

      //     $( '#table' ).bootstrapTable('destroy').bootstrapTable(bootstrapTableOpt);
      // });
  }

  function initCodAutocomplete(){
    var $codInput = $( ".codAutocomple:not(.auto)").addClass('auto');

    $codInput.autocomplete({
      minLength: 4,
      classes:{
          'ui-autocomplete': 'customAutocomplete'
      },
      source: function(request, response){
        var term = $.ui.autocomplete.escapeRegex(request.term),
            termRegExp = RegExp( '^' + term, 'i'),
            result = $.grep(inv, function(o){
              return termRegExp.test(o.Codigo);
            });

        response( $.map(result, function(o){
            return $.extend(o, {
              label: o.Codigo,
              value: o.Codigo
            });
          })
        );
      },
      select: function( event, ui ) {
          var $productRow = $(event.target).closest('.row-product');

          $( '[data-name=codigoArticulo]', $productRow ).val( ui.item.Codigo );
          $( '[data-name=nombreArticulo]', $productRow ).val( ui.item.NombreDelArticulo );
          $( '.art-precioUni', $productRow ).val( ui.item.Precio );
          $( '[data-name=descripcionArticulo]', $productRow ).val( ui.item.DetallesDelArticulo );
          $( '[data-name=unidadMedida]', $productRow ).val( ui.item.Unidad );
          $( '[data-name=cantidad]', $productRow ).val(1);

          $( '.art-precioUni', $productRow ).trigger( 'input' );
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div>" +item.Codigo + "<br>" + item.NombreDelArticulo + "</div>")
        .appendTo( ul );
    };

    $($codInput.autocomplete('instance').bindings[1]).off('mouseenter mouseout');
  }

  $('.cl-select2').select2();

  $('select[data-select-add-custom]').on('change', function(){
      if( $(this).find('option:selected').is('[data-other]') ){
          var $currentSelect = $(this),
              $modal = $('#confirmModal');

          $modal.find('.modal-body').html('<h4>Nueva opción</h4><input type="text" autofocus style="width: 100%;">');
          $modal.find('.btn-primary').text('Agregar').next().show();

          containerScroll(0);

          $modal.modal({ backdrop: 'static', keyboard: false })
          .one('click', '.modal-footer .btn', function (e) {
              var $options = $currentSelect.find('option');

              if( $(this).is('#action-exc') ){
                  var value = $.trim( $modal.find('input').val() );
                  if( value ){
                    var valueExists = $currentSelect.find('option[value="' + value + '"]').index();

                    if( valueExists == -1 ){
                        var $newOption = $('<option data-custom value="' + value + '">' + value + '</option>');

                        $currentSelect.find('[data-custom]').remove();
                        $newOption.insertBefore($options.last());

                        $currentSelect.val( $newOption.prop('selected', true).val());

                        if($currentSelect.hasClass('cl-select2')){
                          $currentSelect.select2();
                          $currentSelect.trigger('change.select2');      
                        }

                        return;
                    }
                }
                
              }

              $currentSelect.val( $options.eq(0).prop('selected', true).val() );

              if($currentSelect.hasClass('cl-select2')){
                $currentSelect.trigger('change.select2');
              }
          });
      }
  });



  $('#vendedor').on('click', function(e){
   // console.log('holap');
   $('#vendedoresModal').modal({ backdrop: 'static', keyboard: false });
  });

  $('#cuentaNombreAux').on('click', function(e){
   // console.log('holap');
   $('#companiasModal').modal({ backdrop: 'static', keyboard: false });

   addCompanyAutocomplete();
  });

  $('#clienteNombreAux').on('click', function(e){
     // console.log('holap');
     addContactAutocomplete();
     $('#clientesModal').modal({ backdrop: 'static', keyboard: false });
  });

  $('#clientesModal').on('shown.bs.modal', function(e){
    if( !!$('#contactCompanyIdInput').val() ){
      $("#contactInput").autocomplete( "search", "search" );
    }
  });

   $('#clientesModal').on('show.bs.modal', function (e) {
    $('#contactCompanyInput').val( $('#cuentaNombreAux').val() );
    $('#contactCompanyIdInput').val( $('#company_id').val() );
   });


   $('.add-vendedor').on('click', function(e){
      e.preventDefault();
      var name = $(this).data('username');
      var id =  $(this).data('id');
      setNewVendedor(name, id);
      // console.log('name: %d - id: %d', name, id)
      $('#vendedoresModal').modal('hide');
   });


    $( '#table' ).on( 'click-row.bs.table', function( e, item, $tr ){
      $( '[type=radio]', $tr ).prop( 'checked', true ).trigger('click');
    });

    $( '#table' ).on( 'check.bs.table', function(e, item){
      productData = item;
      $( '#inventarioModal button.btn-primary' ).prop( 'disabled', false );
    });

    $( '#inventarioModal' ).on( 'click', 'button.btn-primary', function(){
      $( '[data-name=codigoArticulo]', $productRow ).val( productData.Codigo );
      $( '[data-name=nombreArticulo]', $productRow ).val( productData.NombreDelArticulo );
      $( '.art-precioUni', $productRow ).val( productData.Precio );
      $( '[data-name=descripcionArticulo]', $productRow ).val( productData.DetallesDelArticulo );
      $( '[data-name=unidadMedida]', $productRow ).val( productData.Unidad );
      $( '[data-name=cantidad]', $productRow ).val(1);

      $( '.art-precioUni', $productRow ).trigger( 'input' );
    });

    $( '.transactions-list' ).on( 'click', '.row-product button[data-toggle=modal]', function(){
      $productRow = $(this).closest( '.row-product' );
    });

    $( '.row-foot .btn' ).click(function(e){ //add product
      e.preventDefault();
      var $product = $( '.row-product:last' ),
          $contentCollapse = $product.find( '.content-collapse' ),
          $newProduct = $productForm.clone(),
          consecutive = $product.index() < 1 ? 1 : $product.index() + 1;

      if($contentCollapse.is( ':visible' )){
        $contentCollapse.slideUp( 400 );
        $product.find( '.show-collapse' ).toggle();
        $product.find( '.hide-collapse' ).toggle();
      }

      updateConsecutiveAttr( consecutive, $newProduct );

      $(this).closest( '.row-foot' ).before($newProduct);
      $newProduct.slideDown( 400, function(){ parentIframeLoaded() });
      initCodAutocomplete();
    });

    $( '.transactions-list' ).on( 'click', '.btns-collapse a', function(e){
      e.preventDefault();
      var $product = $(this).closest('.row-product'),
          $contentCollapse = $product.find('.content-collapse');

      $contentCollapse.slideToggle( 400, function(){ parentIframeLoaded(false) } );
      $product.find('.show-collapse').toggle();
      $product.find('.hide-collapse').toggle();
    });

    $('.transactions-list').on('click', '.btn-action--delete', function(e){// delete product
      e.preventDefault();
      var $modal = $('#confirmModal'),
          $item = $(this).closest('.row-product');

      $modal.find('.modal-body').text('Seguro que desea eliminar este item?');
      $modal.find('.btn-primary').text('Eliminar').next().show();

      containerScroll(0);

      $modal.modal({ backdrop: 'static', keyboard: false })
        .one('click', '.modal-footer .btn', function (e) {
            if( $(this).is('#action-exc') ){
                $item.slideUp(400, function(){
                    $item.remove();
                    updateSubtotal();
                    updateDescuento();
                    updateIVA();
                    updateTotal();
                    updateFormatCurrency();
                    parentIframeLoaded(false);

                    if( !$item.is( '.row-product:last' ) ){
                      $('.row-product').each(function(index, $item){//update all items attributes
                        updateConsecutiveAttr(index + 1, $item);
                      });
                    }
                });
            }

            $('.modal-footer button').off('click');
        });
    });

    $('#moneda').on('change', updateFormatCurrency);

    $('.info-cliente .btn').on('click', function(e){
      e.preventDefault();
      $('#clienteModal').modal({ backdrop: 'static', keyboard: false });
    });

    $('[data-bind]').each(function(){
      var $this = $(this),
          $bind = $($this.data('bind'));

      $this.on('keyup', function(){
        $bind.val($this.val());
      });

      $bind.on('keyup', function(){
        $this.val($bind.val());
      });
    });

    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      startDate: new Date()
    });

    if (!$('.is-update').length){
      var today = new Date(),
          todayDateFormated = today.getUTCFullYear() + '-' + ('0' + (today.getUTCMonth() + 1)).slice(-2) + '-' + ('0' + today.getUTCDate()).slice(-2);
          todayTimeFormated = ('0' + today.getHours()).slice(-2) + ':' + ('0' + today.getMinutes()).slice(-2) + ':' + ('0' + today.getSeconds()).slice(-2);
          
          $('#altFechaCotizacion').val( todayDateFormated + ' ' + todayTimeFormated );
          $('#fechaCotizacion').datepicker('setDate', todayDateFormated);
    }
    else{
      $('#fechaCotizacion').datepicker('setDate', $('#fechaCotizacion').val() );
    }

    $('.datepicker').datepicker("option","minDate", $('#fechaCotizacion').val() );
    
    $('input[type=number]').on('input',function(){
      var $this = $(this),
          maxlength = $this.attr('maxlength'),
          value = $this.val();

      if (maxlength && $this.val().length > maxlength){
        $this.val( value.slice(0, maxlength) );
      }
    });

    $( '.transactions-list' ).on( 'input', '.art-cantidad, .art-precioUni', function(){
      updateMonto( $(this).closest( '.row-product' ) );
      updateSubtotal();
      updateDescuento();
      updateIVA();
      updateTotal();
      updateFormatCurrency();
    });

    $( '.transactions-list' ).on( 'input', '.art-descuento', function(){
      updateDescuento();
      updateIVA();
      updateTotal();
      updateFormatCurrency();
    });

    $('[required]').on('input blur change', function(){
      var $this = $(this);
      $this.closest('.form-group').toggleClass('hasErrors', !$this.val());
    });

    $('.btn-print').on('click', function(e){
        e.preventDefault();
        var allValid = validInputs();

        if(!allValid) return;

        $('#printConfig').modal({ backdrop: 'static', keyboard: false });
        containerScroll(0);
    });

    $('#printConfig .btn-primary').on('click', function(e){
      e.preventDefault();

      var data = $('.form-container').serialize() + '&lineas=' + getProdcutDataJSON();
      var printConfigData = $('#printConfig form').serialize();

      if ( printConfigData ){
        data += '&' + printConfigData;
      }

      $('#downloadFile').find('[name=data]').val(data);
      $('#downloadFile').submit();

    });

    function validInputs(){
      var allValid = true,
          elems = $('[required]');

      for(var i = 0; i < elems.length; i++){
          var $elem = $(elems[i]);
          if ( !$elem.val() ){
            $elem.closest('.form-group').addClass('hasErrors');
            if( allValid ){
              $elem.focus();
            }
            allValid = false;
          }
        }

        return allValid;

    }

    var processingAction = false;

    $('.btn-clone').on('click', function(e){
      e.preventDefault();

      var $modal = $('#confirmModal');

        $modal.find('.modal-body').text('Seguro que desea clonar esta cotización?');
        $modal.find('.btn-primary').text('Si').next().show();
        $modal.find('.btn-primary').attr('data-dismiss', '');

        containerScroll(0);

        $modal.modal({ backdrop: 'static', keyboard: false })
        .one('click', '.modal-footer .btn', function (e) {
            e.preventDefault();

            if( $(this).is('#action-exc') ){
              var allValid = validInputs(),
                  today = new Date(),
                  originalDate = $('#altFechaCotizacion').val(),
                  currentDate = $.datepicker.formatDate( "yy-mm-dd", today ) + " " + ( "0" + today.getHours() ).slice(-2) + ":" + ( "0" + today.getMinutes() ).slice(-2) + ":" + ( "0" + today.getSeconds() ).slice(-2);
                  action = 'save_cot',
                  data = null;

              $('#altFechaCotizacion').val(currentDate);

              data = $('.form-container').serialize() + '&lineas=' + getProdcutDataJSON();
              
              if(allValid){
                $.ajax({
                  url: "../cotz/services/cotz.php",
                  dataType: 'json',
                  data: { data: data, action: action },
                  type: "POST"
                })
                .done(function(data){
                    if(data.id){
                      $modal.find('.modal-body').html('Cotización clonada con éxito. <b>ID: ' + data.id + '</b>');
                      $modal.find('.btn-primary').hide();
                      $modal.find('.btn-primary').next().text('Ok');
                    }
                  })
                .fail(function(e){
                  $modal.find('.modal-body').text('Ocurrio un problema durante la clonación.');
                })
                .always(function(){
                  $('#altFechaCotizacion').val(originalDate);
                  $modal.find('.btn-primary').hide();
                });
              }
          }

        });

        $modal.one('hide.bs.modal', function(){
          $modal.find('.btn-primary').attr('data-dismiss', 'modal');
          $modal.find('.btn-primary').show().next().text('Cancelar');
        });
    });

    $('.btn-save').on('click', function(e){
            e.preventDefault();
            if(processingAction) return;
            processingAction = true;
            var data = $('.form-container').serialize() + '&lineas=' + getProdcutDataJSON(),
                allValid = validInputs(),
                isUpdate = $('.form-container').hasClass('is-update'),
                action = isUpdate ? 'update_cot':'save_cot';

            
            if(allValid){
              $.ajax({
                url: "../cotz/services/cotz.php",
                data: { data: data, action: action },
                type: "POST"
              })
              .done(function(data){
                  console.log('data',data);
                  if( action == 'save_cot' ){
                    $('.btn-backToList').trigger('click');
                  }
                  else{
                    var $modal = $('#confirmModal');

                    $modal.find('.modal-body').text('Cotización actualizada con éxito');
                    $modal.find('.btn-primary').text('Ok').next().hide();

                    containerScroll(0);

                    $modal.modal({ backdrop: 'static', keyboard: false });
                  }
                })
              .fail(function(e){
                console.log('fail',e);
              })
              .always(function(){
                processingAction = false;
              });
            }
            else{
              processingAction = false;
            }
    });

    $('#tasaImpuestos').on('input', function(){
        updateAll();
    });

    $('form').on('change', '#redondeo, [data-name=exonerado]', function(){
        updateAll();
    });

    $('.transactions-list').on('change', '[data-name=factorLinea]', function(){
      var i= $(this);
      $(this).closest('.row-product').find('[data-name=precioUnitario]').trigger( 'input' );
    });

    // $('#vendedor').autocomplete({
    //   minLength: 3,
    //   source: function(request, response) {
    //     var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
    //     response($.grep(salesPersons, function(value) {
    //         return matcher.test(value.name);
    //     }));
    //   },
    //   focus: function( event, ui ){
    //     $('#vendedor').val( ui.item.name );
    //     return false;
    //   },
    //   select: function( event, ui ){
    //     $('#vendedor').attr( 'data-id', ui.item.id );
    //     $('#vendedor').val( ui.item.name );
    //     return false;
    //   }
    // }).autocomplete('instance')._renderItem = function( ul, item ){
    //   return $( "<li>" )
    //     .append( '<div class="small">' + item.name + '</div>'  )
    //     .appendTo( ul );
    // };

    $('#codigoCliente, #codigoClienteAux, #nombreCliente').each(function(){
      $(this).autocomplete({
        minLength: 3,
        source: function(request, response) {
          var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
          response($.grep(clients, function(value) {
              return matcher.test(value.name + ' ' + value.id);
          }));
        },
        focus: function( event, ui ){
          $('#codigoClienteAux, #codigoCliente').val( ui.item.id );
          $('#nombreCliente').val( ui.item.name );
          return false;
        },
        select: function( event, ui ){
          $('#codigoClienteAux, #codigoCliente').val( ui.item.id );
          $('#nombreCliente').val( ui.item.name );
          return false;
        }
      }).autocomplete('instance')._renderItem = function( ul, item ){
        return $( "<li>")
          .append('<div class="small">' + item.id + '<br>' + item.name + '</div>')
          .appendTo( ul );
      };
    });

    $('.form-container.is-update .art-cantidad').trigger('input');


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

          vals = vals.join(' ').replace(/[ÀÁÂÃÄÅ]/gi,"A") .replace(/[ÈÉÊË]/gi,"E") .replace(/[Î]/gi,"I") .replace(/[Ô]/gi,"O") .replace(/[Ù]/gi,"U") ;
          
          return termRegex.test(vals);
        }).length;

      }).show();

    });

  });

function getContactsByAccount(acc_id, cb){
    $.ajax({
          url: "../cotz/services/cotz.php",
          data: { acc_id: acc_id, action: 'get_usersAccount' },
          dataType: "json",
          type: "POST",
          success: function(data){
            cb(data);
          }
      });
}

function log_compania( ui ) {
  var ui = ui.item;
      var desc = (ui.desc==null || ui.desc == '') ? "-" : ui.desc;
      var website = (ui.website==null || ui.website == '') ? "-" : ui.website;
      $( ".nombre_compania" ).text( ui.label );
      $( ".telefono_compania" ).text( ui.phone );
      $( ".website_compania" ).text( website );
      $( ".description_company" ).text( desc );
      $('.add_compania').removeClass('disabled');
      $('#contactCompanyInput').val(ui.label);
      $('#contactCompanyIdInput').val(ui.id);
      $('.id_compania').text(ui.id);
      
    }

function log_contacto( ui ){
    var ui = ui.item;
    
    $( ".nombre_contacto" ).text( disp( ui.label ) );
    $( ".email_contacto" ).text(  disp( ui.email ) );
    $( ".telefono_contacto" ).text( disp( ui.phone )  );
    $( ".company_name" ).text( disp( ui.company ) );
    $('.add_contacto').removeClass('disabled');

    $('#clientesModal').data('contactInfo', ui);
}


$('#clientesModal').on('hidden.bs.modal', function (e) {
    $( ".nombre_contacto" ).text( '' );
    $( ".email_contacto" ).text(  '' );
    $( ".telefono_contacto" ).text( ''  );
    $( ".company_name" ).text( '' );
    $('.add_contacto').addClass('disabled');
    $( "#contactNameInput" ).val("");
    $( "#contactEmailInput" ).val("");
    $( "#contactCompanyInput" ).val("");

    $("#contactInput").autocomplete( "destroy" );
    $('#clientesModal').data('contactInfo', '');
});

$('.add_contacto').on('click', function(e){
  e.preventDefault();
  var contact = $('#clientesModal').data('contactInfo');
  $('#clienteNombreAux').val(contact.label);
  $('#contact_id').val(contact.id);
  $('#cuentaNombreAux').val(contact.company);
  $('#company_id').val(contact.companyid);
  $('#clientesModal').modal('hide');
});

function disp(val){
  return val || '';
}

$('#companiasModal').on('hidden.bs.modal', function (e) {
   $( ".nombre_compania" ).text( "" );
      $( ".telefono_compania" ).text( "" );
      $( ".website_compania" ).text( "" );
      $( ".description_company" ).text( "" );
      $('.add_compania').addClass('disabled');
      $( "#companiaInput" ).val("");
      $('.id_compania').text("");

      $("#companiaInput").autocomplete( "destroy" );
})

$('.add_compania').on('click', function(e){
  e.preventDefault();
  $('#company_id').val($('.id_compania').text());
  $('#cuentaNombreAux').val($('.nombre_compania').text());
  $('#cuentaNombreAux').trigger('input');
  $('#companiasModal').modal('hide');
});

var delaySearchContactId = null;

$('#contactNameInput,#contactEmailInput,#contactCompanyInput').on('input', function(){
  window.clearTimeout(delaySearchContactId);

  var doSearch = false,
      $this = $(this);

  $('#contactNameInput,#contactEmailInput,#contactCompanyInput').each(function(){
    doSearch = $.trim( $(this).val() ).length > 2;
    return !doSearch;
  });

  if ( doSearch ){
    delaySearchContactId = window.setTimeout(function(){
      if( $this.is('#contactCompanyInput') ){
        $('#contactCompanyIdInput').val('');
      }

      $("#contactInput").autocomplete( "search", "search" );
    }, 800);
  }

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


function addCompanyAutocomplete(){
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
      log_compania(ui);
    }
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
// console.log(item);
  var desc = (item.desc==null || item.desc == '') ? "-" : item.desc;
  return $( "<li>" )
    .append( "<div>" + item.label + "<br> Descripcion: " + desc + "<br> Telefono: " + item.phone + "</div>" )
    .appendTo( ul );
};

$($("#companiaInput").autocomplete('instance').bindings[1]).off('mouseenter mouseout');
}




    $(window).on('resize', function(e){
        parentIframeLoaded(false);
    });

})(jQuery);
