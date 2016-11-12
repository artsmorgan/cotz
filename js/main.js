
(function ($){
  $(document).ready(function(){
    var $productForm = $('.row-product').clone();

    $('.row-foot .btn').click(function(){
      var $product = $('.row-product:last'),
          $contentCollapse = $product.find('.content-collapse');

      if($contentCollapse.is(':visible')){
        $contentCollapse.slideUp();
        $product.find('.show-collapse').toggle();
        $product.find('.hide-collapse').toggle();
      }

      $(this).closest('.row-foot').before($productForm.clone());
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
        .one('click', '#action-exc', function (e) {
            $item.remove();
        });
    });

  });

})(jQuery);
