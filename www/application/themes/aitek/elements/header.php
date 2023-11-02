<?php defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header_top.php');
?>

<div class="header">
  <div class="header-logo">
    <?php
      $site = Site::getSite();
      $siteName = Config::get('concrete.site');
      $siteLogo = '';
      if ($site->getAttribute('site_logo')) { $siteLogo = $site->getAttribute('site_logo')->getURL();}
    ?>

    <a href="/"><img src="<?php echo $siteLogo; ?>" alt="<?php echo $siteName . " - " . t('Etusivu'); ?>"></a>
  </div>
  <div class="header-navigation">
    <?php
    $a = new GlobalArea('Header Navigation');
    $a->display($c);
    ?>
  </div>
  <div class="mobile-wrapper">
    <a href="#" class="menu-toggle" aria-label="Open mobilemenu">
      <div class="toggle-nav js-toggle-menu" aria-hidden="true">
        <div class="menu-icon">
          <div class="line line-1"></div>
          <div class="line line-2"></div>
          <div class="line line-3"></div>
        </div>
      </div>
    </a>
    <div class="mobile-menu">
      <?php
      $a = new GlobalArea('Mobile Menu');
      $a->display();
      ?>
    </div>
  </div>
</div>
