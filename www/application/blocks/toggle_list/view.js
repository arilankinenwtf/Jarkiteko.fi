$(document).ready(function () {

  $('.toggle-list-item-wrapper').on('click', function (e) {
    e.preventDefault();
    $(this).toggleClass('active').attr('aria-expanded','true');
  });

  $(function () {
    $('.toggle-list-item-wrapper[data-toggle="collapse"]').collapse()
  });
});