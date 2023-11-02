$(document).ready(function () {

  $('.feature-toggle-wrapper').on('click', function (e) {
    e.preventDefault();

    if($(this).hasClass('active')) {
      $(this).removeClass('active').attr('aria-expanded','false');
      $(this).parent().find('.feature-toggle-icon').removeClass('active');
      $(this).parent().find('.feature-toggle-open').collapse('toggle');
      $(this).parent().find('a').removeClass('active').attr('aria-expanded','false');
    } else {
      $(this).addClass('active').attr('aria-expanded','true');
      $(this).parent().find('.feature-toggle-icon').addClass('active');
      $(this).parent().find('.feature-toggle-open').collapse('toggle');
      $(this).parent().find('a').addClass('active').attr('aria-expanded','true');
    }
  });

  $('.feature-toggle-icon').on('click', function (e) {
    if($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).parent().find('.feature-toggle-open').collapse('toggle');
      $(this).parent().find('a').removeClass('active').attr('aria-expanded','false');
    } else {
      $(this).addClass('active');
      $(this).parent().find('.feature-toggle-open').collapse('toggle');
      $(this).parent().find('a').addClass('active').attr('aria-expanded','true');
    }
  });

  $(function () {
    $('[data-bs-toggle="collapse"]').collapse()
  });
});