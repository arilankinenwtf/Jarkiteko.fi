<?php
defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\Area\ContainerArea;
?>

<div class="full-width-image-container">
    <?php
    $area = new ContainerArea($container, 'Lisää kuva');
    $area->display($c);
    ?>
    <div class="image-container-caption">
        <?php
        $area = new ContainerArea($container, 'Kuvateksti');
        $area->display($c);
        ?>
    </div>
</div>