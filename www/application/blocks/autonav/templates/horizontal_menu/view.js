$(document).ready(function () {  

    if(!$('html').hasClass('ccm-edit-mode')) {

        $('.horizontal-nav li.nav-path-selected').addClass('submenu-open');
        $('.horizontal-nav li.nav-path-selected .submenu-wrapper').addClass('show-submenu');
        
        $('.horizontal-nav li.has-submenu .subnav-icon').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $liItem = $(this).closest('li');
            var $submenu = $(this).closest('li').find('.submenu-wrapper');
            
            // open clicked submenu
            $liItem.toggleClass('submenu-open');
            $submenu.toggleClass('show-submenu');

            // close other open submenus
            $('li.has-submenu').not($liItem).removeClass('submenu-open');
            $('.submenu-wrapper').not($submenu).removeClass('show-submenu');
        });

    }


    /*
    * Alla hover funktiot alavalikon avaamiselle
    * Poista jos et tarvi
    *
    $('.horizontal-nav li.has-submenu').bind('mouseenter focus', function(e){
        var $submenu = $(this).find('.submenu-wrapper');
        $(this).addClass('submenu-open');
        $submenu.addClass('show-submenu');
    }); 
    
    $('.horizontal-nav li.has-submenu').bind('mouseleave', function(e){
        var $submenu = $(this).find('.submenu-wrapper');
        $(this).removeClass('submenu-open');
        $submenu.removeClass('show-submenu');
    }); 
    */
});