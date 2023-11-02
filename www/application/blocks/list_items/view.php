<?php defined('C5_EXECUTE') or die("Access Denied.");
$imgMaxwidth = '150px';
$imgMaxHeight = '150px';
?>


<div class="list-wrapper my-4" id="list-<?php echo $bID; ?>">

  <ul class="list-ul">
    <?php foreach ($rows as $row) { ?>
        <li class="list-item my-4">
          <div class="list-item-image">
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

          <div class="list-item-text">
            <<?php echo $headingType;?> class="list-item-title">
              <?php echo $row['titleText'] ?>
            </<?php echo $headingType;?>>
            <div class="list-item-description"><?php echo $row['descriptionText']; ?></div>
          </div>

        </li>
    <?php } ?>
  </ul>
</div>