<?php
defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\Area\ContainerArea;
?>

<div class="full-width-image-container-parallax full-width-image-container"
     id="full-width-image-container-parallax-<?php echo $bID; ?>">
  <?php
  $area = new ContainerArea($container, 'Lisää taustakuvan päälle sisältöä');
  $area->display($c);
  ?>
  <div class="image-container-caption">
    <?php
    $area = new ContainerArea($container, 'Kuvateksti');
    $area->display($c);
    ?>
  </div>
</div>
<script>
  $(function() {
        var $el = $('#full-width-image-container-parallax-<?php echo $bID; ?> [class^="ccm-custom-style-"]');
        $(window).on('resize scroll', function () {
            // parallax only for desktop
            if(window.innerWidth >= 770) {

              var scroll = $(document).scrollTop();
              var elOffset = Math.round($el.offset().top);
              var windowHeight = $(window).height();
              var scrollWindow = scroll + windowHeight;

              if((scrollWindow - elOffset) >= 0) {
                $el.css({
                    'background-position':'0% ' + -(scrollWindow - elOffset) / 10 + 'px'
                });
              }
            }
        });
  });
</script>