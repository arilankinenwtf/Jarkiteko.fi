<?php defined('C5_EXECUTE') or die("Access Denied.");
$imgMaxwidth = '150px';
$imgMaxHeight = '150px';
?>


<div class="kumppani-list-wrapper my-4" id="list-<?php echo $bID; ?>">

  <ul class="kumppani-list-ul">
    <?php foreach ($rows as $row) { ?>
        <li class="kumppani-list-item my-4">
          <div class="kumppani-list-item-image">
            <?php 
            $f = File::getByID($row['fID']);
            if (is_object($f)) {
                $tag = Core::make('html/image', array('f' => $f))->getTag();
                $tag->width = $imgMaxwidth;
                $tag->height = $imgMaxHeight;
                $tag->alt("");
                echo $tag;
            }
            ?>
          </div>

          <div class="kumppani-list-item-text">
            <<?php echo $headingType;?> class="list-item-title">
              <?php echo $row['titleText'] ?>
            </<?php echo $headingType;?>>
            <div class="kumppani-list-item-description"><?php echo $row['descriptionText']; ?></div>
          </div>

        </li>
    <?php } ?>
  </ul>
</div>