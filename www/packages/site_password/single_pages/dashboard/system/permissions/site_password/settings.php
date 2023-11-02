<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Url;

/** @var bool $enabled */
/** @var bool $hasPassword */
?>

<div class="ccm-dashboard-content-inner">
    <form method="post" action="<?php echo $this->action('save'); ?>">
        <?php
        echo $token->output('a3020.site_password.settings');
        ?>

        <div class="form-group">
            <div>
                <label class="control-label launch-tooltip"
                       title="<?php
                       echo t('If enabled, visitors are required to enter a password before they can access the website.') . ' ' .
                           t( 'Users who are logged in, are not required to enter this password.');
                       ?>"
                       for="enabled">
                    <?php
                    echo $form->checkbox('enabled', 1, $enabled);
                    ?>
                    <?php echo t('Enable %s', t('Site Password')); ?>
                </label>
            </div>
        </div>

        <div class="form-group">
            <?php
            $placeholder = t('Please enter a password. If left empty, no login form will be shown.');

            if ($hasPassword) {
                $placeholder = t('Leave empty to keep the current (encrypted) password.');
            }

            echo $form->label('password', ($hasPassword) ? t('Overwrite password') : t('Password'));
            echo $form->password('password', null, [
                'autofocus' => 'autofocus',
                'placeholder' => $placeholder,
            ]);
            ?>
        </div>

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?php echo Url::to('/dashboard/system/permissions/site_password/settings'); ?>" class="btn btn-default pull-left">
                    <?php echo t('Cancel'); ?>
                </a>

                <?php
                echo $form->submit('submit', t('Save settings'), [
                    'class' => 'btn-primary pull-right',
                ]);
                ?>
            </div>
        </div>
    </form>
</div>
