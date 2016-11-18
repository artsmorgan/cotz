
(function ($){
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

  function updateMonto( $productRow ){
    var cantidad = $productRow.find( '.art-cantidad' ).val(),
        precioUnitario = $productRow.find( '.art-precioUni' ).val();
        $dispMonto = $productRow.find( '.op-total-monto' );

        cantidad = cantidad ? cantidad : 0;
        precioUnitario = precioUnitario ? precioUnitario : 0;

        monto = cantidad * precioUnitario;

        $productRow.find( '.op-hidden-monto' ).val( monto );
        $dispMonto.text( monto );
  }

  function updateSubtotal(){
    var subtotal = 0;
    $('.row-product .op-total-monto').each(function(){
      subtotal += $(this).asNumber();
    });

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

    $('.op-hidden-descuento').val(descuento);
    $('.op-total-descuento').text(descuento);
  }

  function updateIVA(){
    var iva = 13 / 100,
        subtotal = $('.op-total-subtotal').asNumber(),
        descuento = $('.op-total-descuento').asNumber()
        totalIva = ( subtotal - descuento ) * iva;

    $('.op-hidden-iva').val(totalIva);
    $('.op-total-iva').text(totalIva);
  }

  function updateTotal(){
    var iva = $('.op-total-iva').asNumber(),
        subtotal = $('.op-total-subtotal').asNumber(),
        descuento = $('.op-total-descuento').asNumber(),
        total = subtotal - descuento + iva;

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

  $( document ).ready(function(){

    updateFormatCurrency();

    var $productForm = $( '.row-product' ).clone().addClass( 'disp--hide' );

    $( '.row-foot .btn' ).click(function(e){ //add product
      e.preventDefault();
      var $product = $( '.row-product:last' ),
          $contentCollapse = $product.find( '.content-collapse' ),
          $newProduct = $productForm.clone(),
          consecutive = $product.index() < 1 ? 1 : $product.index() + 1;

      if($contentCollapse.is( ':visible' )){
        $contentCollapse.slideUp();
        $product.find( '.show-collapse' ).toggle();
        $product.find( '.hide-collapse' ).toggle();
      }

      updateConsecutiveAttr( consecutive, $newProduct );

      $(this).closest('.row-foot').before($newProduct);
      $newProduct.slideDown();
    });

    $('.transactions-list').on('click', '.btns-collapse a', function(e){
      e.preventDefault();
      var $product = $(this).closest('.row-product'),
          $contentCollapse = $product.find('.content-collapse');

      $contentCollapse.slideToggle();
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

    $('.btn-save').on('click', function(e){
      e.preventDefault();
      var data = $('.form-container').serialize() + '&lineas=' + getProdcutDataJSON();
      console.log(data);

      // $.post('URL', data, function(){
      //   console.log('success');
      // }).fail( function(){
      //   console.log('fail');
      // });
    });
  });

})(jQuery);
