<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Url;

/** @var \Concrete\Core\Validation\CSRF\Token $token */
/** @var \Concrete\Core\Form\Service\Form $form */
/** @var string $baseUrl */
/** @var string|null $error */
?>

<link href="<?php echo $baseUrl . '/concrete/css/app.css'; ?>" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&amp;display=swap" media="all" onload="this.media='all'">
<div class="ccm-ui">
    <div class="controls" id="site-password-form">
        <form method="post">
            <?php
            $token->output('site_password.login');
            ?>

            <img height="100" width="100" src="<?php echo $baseUrl . '/packages/site_password/images/logo.png';?>">

            <h1><?php echo t('Kirjaudu kehityssivustolle'); ?></h1>

            <p>
                <?php
                echo t('Tämän sivuston katselemiseen vaaditaan salasana.');
                ?>
            </p><br>

            <?php
            if ($error) {
                ?>
                <div class="alert alert-danger">
                    <div>
                         <?php
                        echo h($error);
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="form-group">
                <?php
                echo $form->label('password', t('Password'));
                echo $form->password('password', null, [
                    'autofocus' => 'autofocus',
                    'style' => 'min-width: 250px;',
                ]);
                ?>

                <button class="btn btn-primary">
                    <?php echo t('Kirjaudu'); ?>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
#site-password-form {
    font-family: 'Montserrat',sans-serif;
    margin: 40px;
    max-width: 500px;
}
#site-password-form h1 {
    font-size: 25px;
}
#site-password-form label {
    display: block;
    margin-right: 5px;
    width: 100%;
}
#site-password-form .btn-primary {
    background-color: black;
    border: 0;
    border-radius: 0;
    color: white;
    cursor: pointer;
    margin-top: 10px;
    padding: 5px 15px;
    text-transform: uppercase;
}
#site-password-form .alert {
    background-color: #F9F9F9;
    color: #E61D72;
    font-size: 12px;
    margin-bottom: 10px;
    padding: 5px;
}
#site-password-form .btn-primary,
#site-password-form input {
    height: 30px;
}
</style>
