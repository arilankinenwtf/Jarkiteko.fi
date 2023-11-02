<?php use Concrete\Core\Validation\CSRF\Token;

defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-12 footer-first py-5">
        <?php
        $a = new GlobalArea('Footer First');
        $a->display();
        ?>
      </div>
    </div>
  </div>
  <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
</div>

<?php $this->inc('elements/footer_bottom.php');?>

