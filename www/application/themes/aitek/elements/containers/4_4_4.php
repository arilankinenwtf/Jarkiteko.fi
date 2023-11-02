<?php
defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\Area\ContainerArea;

?>
<div class="three-column-container">
    <div class="row">
        <div class="col-md-4">
            <?php
            $area = new ContainerArea($container, '1. sarake');
            $a->setAreaGridMaximumColumns(12);
            $area->display($c);
            ?>
        </div>
        <div class="col-md-4">
            <?php
            $area = new ContainerArea($container, '2. sarake');
            $a->setAreaGridMaximumColumns(12);
            $area->display($c);
            ?>
        </div>
        <div class="col-md-4">
            <?php
            $area = new ContainerArea($container, '3. sarake');
            $a->setAreaGridMaximumColumns(12);
            $area->display($c);
            ?>
        </div>
    </div>
</div>