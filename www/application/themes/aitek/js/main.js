$(document).ready(function () {

  // Adding styles after document ready, example:
  //$('.hero-title').addClass("reveal");

  $('.menu-toggle').on('click', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $('.mobile-menu').slideToggle(300);
    $(this).closest('.mobile-wrapper').toggleClass('open');
    $(this).find(".js-toggle-menu").toggleClass("open");
  }); 

  $('.toggle-submenu').on('click', function(e){
    $(this).next('ul').slideToggle(100);
    $(this).find('.open-icon').toggle();
    $(this).find('.close-icon').toggle();
  }); 

  if ($('#back-to-top').length) {
    var scrollTrigger = 200,
    backToTop = function () {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > scrollTrigger) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
  }

});
