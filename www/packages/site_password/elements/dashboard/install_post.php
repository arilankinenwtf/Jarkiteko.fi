<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Page\Page;

?>
<p><?php echo t('Congratulations, the add-on has been installed!'); ?></p>
<br>

<?php
$page = Page::getByPath('/dashboard/system/permissions/site_password/settings');

echo '<a class="btn btn-primary" href="' . $page->getCollectionLink() . '">' . t('Go to %s', 'Site Password') . '</a>';
