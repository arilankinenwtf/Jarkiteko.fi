<?php defined('C5_EXECUTE') or die("Access Denied.");
$ih = Core::make('multilingual/interface/flag');
?>
<div class="switch-language">
	
    <?php foreach($languageSections as $ml) { ?>
	<div class="switch-language-item">
        <a href="<?php echo $view->action('switch_language', $cID, $ml->getCollectionID())?>"
           title="<?php echo $ml->getLanguageText($locale)?>"
        class="<?php if ($activeLanguage == $ml->getCollectionID()) { ?>switch-language-active<?php } ?>"><?php echo substr($ml->getLocale(), 0, -3); ?></a>
	</div>
    <?php } ?>
</div>