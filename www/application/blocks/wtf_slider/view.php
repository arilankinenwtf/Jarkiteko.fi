<?php defined('C5_EXECUTE') or die("Access Denied.");
$imgMaxwidth = '150px';
$imgMaxHeight = '150px';
?>


<div class="wtfslider-list splide" id="wtf-slider-<?php echo $bID; ?>">

  <div class="splide__track">
		<ul class="splide__list">
      <?php foreach ($rows as $row) { ?>
          <li class="wtfslider-item splide__slide">
            <div class="wtfslider-item-image">
              <?php 
              $f = File::getByID($row['fID']);
              if (is_object($f)) {
                  $tag = Core::make('html/image', array('f' => $f))->getTag();
                  $tag->width = $imgMaxwidth;
                  $tag->height = $imgMaxHeight;
                  $tag->alt("");
                  echo $tag;
              } else {
                echo '<div class="wtfslider-item-icon"></div>';
              }
              ?>
            </div>

            <div class="wtfslider-item-text">
              <?php if($row['titleText'] != '') { ?>
                <h2 class="wtfslider-item-title"><?php echo $row['titleText'] ?></h2>
              <?php } ?>
              <?php if($row['descriptionText'] != '') { ?>
                <div class="wtfslider-item-description"><?php echo $row['descriptionText']; ?></div>
              <?php } ?>

            </div>

          </li>
      <?php } ?>
    </ul>

    <?php if(count(array($rows)) > 1): ?>
      <button class="wtfslider-next-arrow splide__arrow wtfslider-arrow" id="wtfslider-next-dia-<?php echo $bID; ?>"></button>
    <?php endif; ?>
  </div>

  <?php if(count(array($rows)) > 1): ?>
    <div class="splide__arrows">
      <button class="splide__arrow splide__arrow--prev wtfslider-arrow"></button>
      <div class="wtfslider-counter">
        <span id="wtfslider-counter-index-<?php echo $bID; ?>">1</span>
        <span id="wtfslider-counter-total-<?php echo $bID; ?>"><?php echo "/" . $rowsCount; ?></span>
      </div>
      <button class="splide__arrow splide__arrow--next wtfslider-arrow"></button>
    </div>
  <?php endif; ?>

  </div>

<script>
document.addEventListener( 'DOMContentLoaded', function () {

	var splide = new Splide( '#wtf-slider-<?php echo $bID; ?>', {
    rewind: true,
    pagination: false,
    autoplay: true,
    interval: 8000
    //lazyload: 'nearby'
  } ).mount();

  splide.on( 'move', function() {
    $i = splide.index + 1;
    $('#wtfslider-counter-index-<?php echo $bID; ?>').html($i);
  });

  $("#wtfslider-next-dia-<?php echo $bID; ?>").on('click', function() {
    splide.go('+1'); 
  });

});
</script>

<style>
    <?php if(count(array($rows)) <= 1): ?>
      .splide__arrows {
        display: none;
      }
    <?php endif; ?>
</style>