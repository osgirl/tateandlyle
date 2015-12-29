(function($){
  $(document).ready(function () {
    $('.popup').addClass('modal fade').attr('id', 'myModal');
    $('.popup .paragraph').addClass('modal-content');
    $('.imagine').attr('data-toggle', 'modal').attr('data-target', '#myModal');
  });
})(jQuery);
