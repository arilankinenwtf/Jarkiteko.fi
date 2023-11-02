<?php
defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\Area\ContainerArea;

?>
<div class="container-fluid white-container ">
    <div class="row">
        <div class="col-12">
            <?php
            $area = new ContainerArea($container, 'Leveä sarake');
            $a->setAreaGridMaximumColumns(12);
            $area->display($c);
            ?>
        </div>
    </div>
</div>