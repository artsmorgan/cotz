
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

      $product.after($productForm.clone());
    });

    $('.transactions-list').on('click', '.btns-collapse a', function(e){
      e.preventDefault();
      var $product = $(this).closest('.row-product'),
          $contentCollapse = $product.find('.content-collapse');

      $contentCollapse.slideToggle();
      $product.find('.show-collapse').toggle();
      $product.find('.hide-collapse').toggle();
    });
  });

})(jQuery);
