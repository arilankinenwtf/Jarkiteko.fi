<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="feature-toggle">
  <a href="#feature-toggle-<?php echo $bID; ?>" class="feature-toggle-wrapper" type="button" data-bs-toggle="collapse" data-bs-target="#feature-toggle-paragraph-<?php echo $bID; ?>" aria-expanded="false" aria-controls="feature-toggle-paragraph-<?php echo $bID; ?>" id="feature-toggle-<?php echo $bID; ?>">
    <div class="feature-toggle-title">
      <i class="fa fa-icon fa-<?php echo $icon; ?>"></i>
      <span class="feature-toggle-highlight-text"><?php echo $linkURL; ?></span>
      <h2><?php echo h($title); ?></h2>
    </div>
  </a>
  <div class="collapse feature-toggle-open" id="feature-toggle-paragraph-<?php echo $bID; ?>" aria-labelledby="feature-toggle-<?php echo $bID; ?>">
    <div class="feature-toggle-open-wrapper">
      <?php echo $paragraph; ?>
    </div>
  </div>
  <button class="feature-toggle-icon feature-toggle-icon-chevron" aria-hidden="true"></button>
</div>