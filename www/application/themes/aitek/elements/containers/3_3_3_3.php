<?php
defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Area\ContainerArea;

?>
<div class="container custom-container">
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <?php
            $area = new ContainerArea($container, 'Item 1');
            $area->display($c);
            ?>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <?php
            $area = new ContainerArea($container, 'Item 2');
            $area->display($c);
            ?>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <?php
            $area = new ContainerArea($container, 'Item 3');
            $area->display($c);
            ?>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <?php
            $area = new ContainerArea($container, 'Item 4');
            $area->display($c);
            ?>
        </div>
    </div>
</div>