var salesPersons = [{
  id: 0,
  name: 'Roberto Castro Araya'
},
  {
  id: 1,
  name: 'Patricia Valverde Test'
},
{
  id: 2,
  name: 'Carme Herra Roldan'
},
{
  id: 3,
  name: 'Tomas Calderon Arias'
},
{
  id: 4,
  name: 'Cecilia Hernandez Ramirez'
},
{
  id: 5,
  name: 'Pablo Test Uva'
}
];


var clients = [
  {
    id: 123456,
    name: 'Dos pinos'
  },
  {
    id: 7891011,
    name: 'Dos pin'
  },
  {
    id: 1234789,
    name: 'pinitos'
  },
  {
    id: 7890125,
    name: 'un coral'
  }
];


function gotoList(){
    window.location.href = "index.html";
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
      symbol: $('#moneda option:selected').text()
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
      $( 'input', this ).each(function(){
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

    return roundTo(number, round);
  }

  function roundTo(number, round ){
    return round * Math.round(number/round);
  }

  $( document ).ready(function(){

    var $productForm = $( '.row-product' ).clone().addClass( 'disp--hide' ),
        $productRow = {},
        productData = {};

    updateFormatCurrency();
    parentIframeLoaded();
    //$( '.fixed-table-toolbar' ).prepend(createCotBtn);

   $( '#table' ).bootstrapTable({
      url: 'http://crm.local/cotz/api/inv.json',
      onLoadSuccess: function(){
        parentIframeLoaded();
      },
      onAll: function(name, args){
         parentIframeLoaded();
      }
    });

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
      format: 'dd/mm/yyyy'
    });

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

    $('.btn-save').on('click', function(e){
      e.preventDefault();
      var data = $('.form-container').serialize() + '&lineas=' + getProdcutDataJSON(),
          allValid = true,
          elems = $('[required]');

      for(var i = 0; i < elems.length; i++){
        var $elem = $(elems[i]);
        if ( !$elem.val() ){
          $elem.closest('.form-group').addClass('hasErrors');
          allValid = false;
        }
      }

      // $.post('URL', data, function(){
      //   console.log('success');
      // }).fail( function(){
      //   console.log('fail');
      // });
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

    $('#vendedor').autocomplete({
      minLength: 3,
      source: function(request, response) {
        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(salesPersons, function(value) {
            return matcher.test(value.name);
        }));
      },
      focus: function( event, ui ){
        $('#vendedor').val( ui.item.name );
        return false;
      },
      select: function( event, ui ){
        $('#vendedor').attr( 'data-id', ui.item.id );
        $('#vendedor').val( ui.item.name );
        return false;
      }
    }).autocomplete('instance')._renderItem = function( ul, item ){
      return $( "<li>" )
        .append( '<div class="small">' + item.name + '</div>'  )
        .appendTo( ul );
    };

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
  });

})(jQuery);
