var SERVER_PROD = 'http://tecnosagot.united-crm.com';
var SERVER_DEV = 'http://crm.local/';

function gotoList(username){
    window.location.href = "index.php?u="+username;
    parent.iframeLoaded();
}

(function ($){

  $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['es-CR']);

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
    $('.form-control, label', $item).each(function(){
      var $this = $(this),
          attrAux = '';

      if( $this.is( '.form-control' ) ){
        if( $this.attr( 'id' ) ){
          attrAux = $this.attr( 'id' ).replace( /\d+/, consecutive );
          $this.attr('id', attrAux);
        }
      }
      else{
        if( $this.attr( 'for' ) ){
          attrAux = $this.attr( 'for' ).replace( /\d+/, consecutive );
          $this.attr( 'for', attrAux );
        }
      }
    });
  }

  function updateFormatCurrency(){
    $('.op-total b') .formatCurrency({
      symbol: $('#moneda option:selected').text() + ' '
    });

    $('.op-total b').each(function(){
      $(this).parent().find('.op-hidden-formated').val( $(this).text() );
    });

    $('.art-precioUni').each(function(){
      $priceFormated = $(this).parent().find('.op-hidden-formated');

      $(this).formatCurrency( $priceFormated, {
        symbol: $('#moneda option:selected').text() + ' '
      });
    });
  }

  function updateMonto( $productRow ) {
    var cantidad = $productRow.find( '.art-cantidad' ).val(),
        precioUnitario = $productRow.find( '.art-precioUni' ).val();
        $dispMonto = $productRow.find( '.op-total-monto' ),
        method = $productRow.find('[data-name=factorLinea]').val();

        cantidad = cantidad ? cantidad : 0;
        precioUnitario = precioUnitario ? precioUnitario : 0;

        monto = cantidad * precioUnitario;

        monto = applyRoundFactor(monto, 'total', method);

        $productRow.find( '.op-hidden-monto' ).val( monto );
        $dispMonto.text( monto );
  }

  function updateSubtotal(){
    var subtotal = 0;
    $('.row-product .op-total-monto').each(function(){
      subtotal += $(this).asNumber();
    });

    subtotal = applyRoundFactor(subtotal, 'total');

    $('.op-hidden-subtotal').val(subtotal);
    $('.op-total-subtotal').text(subtotal);
  }

  function updateDescuento(){
    var descuento = 0,
        porcentaje = 0;

    $('.row-product').each(function(){
      porcentaje = $(this).find('.art-descuento').val() / 100;
      descuento += $(this).find('.op-total-monto').asNumber() * porcentaje;
    });

    descuento = applyRoundFactor(descuento, 'total');

    $('.op-hidden-descuento').val(descuento);
    $('.op-total-descuento').text(descuento);
  }

  function updateIVA(){
    var iva = 13 / 100,
        subtotal = $('.op-total-subtotal').asNumber(),
        descuento = $('.op-total-descuento').asNumber()
        totalIva = ( subtotal - descuento ) * iva;

    totalIva = applyRoundFactor(totalIva, 'total');

    $('.op-hidden-iva').val(totalIva);
    $('.op-total-iva').text(totalIva);
  }

  function updateTotal(){
    var iva = $('.op-total-iva').asNumber(),
        subtotal = $('.op-total-subtotal').asNumber(),
        descuento = $('.op-total-descuento').asNumber(),
        total = subtotal - descuento + iva;

    total = applyRoundFactor(total, 'total_final');

    $('.op-hidden-total').val(total);
    $('.op-total-total').text(total);
  }

  function getProdcutDataJSON(){
    var data = [];

    $( '.row-product' ).each(function(){
      var product = {};
      $()
      $( 'input', this ).each(function(){
        var $input = $( this ),
            key = $input.data( 'name' );

        product[key] = $input.val();

      });

      $( 'textarea', this ).each(function(){
        var $input = $( this ),
            key = $input.data( 'name' );

        product[key] = $input.val();

      });

     
      data.push(product);
    });

    return encodeURIComponent(JSON.stringify(data));
  }

  function parentIframeLoaded(){
    if( typeof parent.iframeLoaded == 'function' ){
      parent.iframeLoaded();
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

  $( document ).ready(function(){

    var $productForm = $( '.row-product:first' ).clone().addClass( 'disp--hide' ),
        $productRow = {},
        productData = {};

    $( '.row-product.disp--hide' ).remove();

    updateFormatCurrency();
    parentIframeLoaded();
    //$( '.fixed-table-toolbar' ).prepend(createCotBtn);

   $( '#table' ).bootstrapTable({
      url: SERVER_PROD+'/cotz/api/inv.json',
      onLoadSuccess: function(){
        parentIframeLoaded();
      },
      onAll: function(name, args){
         parentIframeLoaded();
      }
    });



  $('#vendedor').on('click', function(e){
   // console.log('holap');
   $('#vendedoresModal').modal({ backdrop: 'static', keyboard: false });
  });

  $('#cuentaNombreAux').on('click', function(e){
   // console.log('holap');
   $('#companiasModal').modal({ backdrop: 'static', keyboard: false });
  });

  $('#clienteNombreAux').on('click', function(e){
     // console.log('holap');
     $('#clientesModal').modal({ backdrop: 'static', keyboard: false });
  
     if($('#cuentaNombreAux').val()=='' || $('#cuentaNombreAux').val() == null){      
        $('.select_client_alert').show();
     }else{
         var id = $('#company_id').val();
         console.log(id);
         getContactsByAccount(id, function(data){
            console.log(data);
            data = data.result;
            $('.account_list_by_company').empty();
            for(var i = 0; i < data.length; i++){
           
                $('.account_list_by_company').append('<tr><td class="c_acc_name">'+data[i].firstname+' '+data[i].lastname+'</td>'+
                                                    '<td>'+data[i].emailaddress+'</td>'+
                                                    '<td>'+data[i].officephone+'</td>'+
                                                    '<td><a href="#" class="add_contact_acc btn btn-default" data-c_acc="'+data[i].id+'">Agregar</a></td></tr>');
            }
            $('.add_contact_acc').on('click', function(e){

                e.preventDefault();
                var id = $(this).data('c_acc');
                var name = $(this).parent().parent().find('.c_acc_name').text();

                $('#clienteNombreAux').val(name);
                $('#clienteNombreAux').trigger('input');
                $("#contact_id").val(id);
                $('#clientesModal').modal('hide');
              })
         });
     }

  })






   $('#clientesModal').on('hidden.bs.modal', function (e) {
    $('.select_client_alert').hide();
   });

  




   $('.add-vendedor').on('click', function(e){
      e.preventDefault();
      var name = $(this).data('username');
      var id =  $(this).data('id');
      setNewVendedor(name, id);
      // console.log('name: %d - id: %d', name, id)
      $('#vendedoresModal').modal('hide');

   })


    $( '#table' ).on( 'click-row.bs.table', function( e, item, $tr ){
      productData = item;
      $( '[type=radio]', $tr ).prop( 'checked', true );
      $( '#inventarioModal button.btn-primary' ).prop( 'disabled', false );
    });

    $( '#inventarioModal' ).on( 'click', 'button.btn-primary', function(){
      $( '[data-name=codigoArticulo]', $productRow ).val( productData.Codigo );
      $( '[data-name=nombreArticulo]', $productRow ).val( productData.NombreDelArticulo );
      $( '[data-name=precioUnitario]', $productRow ).val( productData.Precio );
      $( '[data-name=descripcionArticulo]', $productRow ).val( productData.DetallesDelArticulo );
      $( '[data-name=cantidad]', $productRow ).val(1);

      $( '[data-name=precioUnitario]', $productRow ).trigger( 'input' );
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
      $newProduct.slideDown( 400, parentIframeLoaded );
    });

    $( '.transactions-list' ).on( 'click', '.btns-collapse a', function(e){
      e.preventDefault();
      var $product = $(this).closest('.row-product'),
          $contentCollapse = $product.find('.content-collapse');

      $contentCollapse.slideToggle( 400, parentIframeLoaded );
      $product.find('.show-collapse').toggle();
      $product.find('.hide-collapse').toggle();
    });

    $('.transactions-list').on('click', '.btn-action--delete', function(e){// delete product
      e.preventDefault();
      var $modal = $('#confirmModal'),
          $item = $(this).closest('.row-product');

      $modal.find('.modal-body').text('Seguro que desea eliminar este item?');
      $modal.find('.btn-primary').text('Eliminar');

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
                    parentIframeLoaded();

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

    $('[required]').on('input blur', function(){
      var $this = $(this);
      if ( !$this.val() ){
        $this.closest('.form-group').addClass('hasErrors');
      }
      else {
        $this.closest('.form-group').removeClass('hasErrors');
      }
    });

    $('.btn-print').on('click', function(e){
        e.preventDefault();
        var allValid = validInputs();

        if(!allValid) return;

        var data = $('.form-container').serialize() + '&lineas=' + getProdcutDataJSON();

        $('#downloadFile').find('[name=data]').val(data);
        $('#downloadFile').submit();

        // $.ajax({
        //         url: "../cotz/services/cotz.php",
        //         data: { data: data, action: 'print_cot' },
        //         type: "POST"
        //     })
        //     .done(function(data){
        //        $('#downloadFile').attr('href', data);
        //        $('#downloadFile').get(0).click();
        //         console.log('data',data);
        //       })
        //     .fail(function(e){
        //       console.log('fail',e);
        //     });
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

    $('.btn-save').on('click', function(e){
            e.preventDefault();
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
                })
              .fail(function(e){
                console.log('fail',e);
              });
            }
    });        


    $('#redondeo').on('change', function(){
      $('.row-product').each(function(){
        updateMonto( $(this) );
      });

      updateSubtotal();
      updateDescuento();
      updateIVA();
      updateTotal();
      updateFormatCurrency();
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

function log( ui ) {
  console.log(ui);
  var ui = ui.item;
      var desc = (ui.desc==null || ui.desc == '') ? "-" : ui.desc;
      var website = (ui.website==null || ui.website == '') ? "-" : ui.website;
      $( ".nombre_compania" ).text( ui.label );
      $( ".telefono_compania" ).text( ui.phone );
      $( ".website_compania" ).text( website );
      $( ".description_company" ).text( desc );
      $('.add_compania').removeClass('disabled');
      $('.id_compania').text(ui.id);
      
    }

$('#companiasModal').on('hidden.bs.modal', function (e) {
   $( ".nombre_compania" ).text( "" );
      $( ".telefono_compania" ).text( "" );
      $( ".website_compania" ).text( "" );
      $( ".description_company" ).text( "" );
      $('.add_compania').addClass('disabled');
      $( "#companiaInput" ).val("");
      $('.id_compania').text("");
})

$('.add_compania').on('click', function(e){
  e.preventDefault();
  $('#company_id').val($('.id_compania').text());
  $('#cuentaNombreAux').val($('.nombre_compania').text());
  $('#cuentaNombreAux').trigger('input');
  $('#companiasModal').modal('hide');


})

$("#companiaInput").autocomplete({
        minLength: 2,
        source: function(request, response) {
            $.ajax({
                url: "../cotz/services/cotz.php",
                data: { term: request.term,action: 'term_company' },
                dataType: "json",
                type: "POST",
                success: function(data){
                  //console.log(data);
                   var result = $.map(data, function(item){
                    console.log(item);
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
         log(ui);
        }
    })
  .autocomplete( "instance" )._renderItem = function( ul, item ) {
    console.log(item);
      var desc = (item.desc==null || item.desc == '') ? "-" : item.desc;
      return $( "<li>" )
        .append( "<div>" + item.label + "<br> Descripcion: " + desc + "<br> Telefono: " + item.phone + "</div>" )
        .appendTo( ul );
    };

})(jQuery);
