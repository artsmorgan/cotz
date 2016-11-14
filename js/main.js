
(function ($){
  $(document).ready(function(){
    var $productForm = $('.row-product').clone().addClass('disp--hide');

    $('.row-foot .btn').click(function(){
      var $product = $('.row-product:last'),
          $contentCollapse = $product.find('.content-collapse'),
          $newProduct = $productForm.clone();

      if($contentCollapse.is(':visible')){
        $contentCollapse.slideUp();
        $product.find('.show-collapse').toggle();
        $product.find('.hide-collapse').toggle();
      }

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

    $('.transactions-list').on('click', '.btn-action--delete', function(e){
      e.preventDefault();
      var $modal = $('#confirmModal'),
          $item = $(this).closest('.row-product');

      $modal.find('.modal-body').text('Seguro que desea eliminar este item?');
      $modal.find('.btn-primary').text('Eliminar');

      $modal.modal({ backdrop: 'static', keyboard: false })
        .one('click', '.modal-footer button', function (e) {
            if( $(this).is('#action-exc') ){
                $item.slideUp(400, function(){
                    $item.remove();
                });
            }

            $('.modal-footer button').off('click');
        });
    });

    $('.info-cliente button').on('click', function(){
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

  });

})(jQuery);
