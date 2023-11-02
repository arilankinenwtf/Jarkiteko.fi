<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<main id="main-content" class="page-not-found">
    <div class="container" id="container-area">
        <div class="row">
            <div class="col-sm-12">
                <?php
                $a = new Area('Main');
                $a->enableGridContainer();
                $a->display($c);
                ?>
            </div>
        </div>
    </div>
</main>

<?php  $this->inc('elements/footer.php'); ?>
