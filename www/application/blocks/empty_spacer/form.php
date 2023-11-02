<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>


<fieldset>
    <legend>Tyhjän tilan korkeus</legend>

    <div class="form-group">
        <?php echo $form->label('heightDesktop', t('Desktop (1200px->)'));?>
        <select class="form-control" id="heightDesktop" name="heightDesktop" value="<?php echo $heightDesktop?>">
            <option value="medium" <?php if($heightDesktop == 'medium') echo 'selected';?>>Medium (40px)</option>
            <option value="small"<?php if($heightDesktop == 'small') echo 'selected';?>>Small (10px)</option>
            <option value="large" <?php if($heightDesktop == 'large') echo 'selected';?>>Large (100px)</option>
            <option value="none"<?php if($heightDesktop == 'none') echo 'selected';?>><?= t('None');?></option>
        </select>
    </div>

    <div class="form-group">
        <?php echo $form->label('heightTablet', t('Tablet (770px-1200px)'));?>
        <select class="form-control" id="heightTablet" name="heightTablet" value="<?php echo $heightTablet?>">
            <option value="medium" <?php if($heightTablet == 'medium') echo 'selected';?>>Medium (40px)</option>
            <option value="small"<?php if($heightTablet == 'small') echo 'selected';?>>Small (10px)</option>
            <option value="large" <?php if($heightTablet == 'large') echo 'selected';?>>Large (100px)</option>
            <option value="none"<?php if($heightTablet == 'none') echo 'selected';?>><?= t('None');?></option>
        </select>
    </div>

    <div class="form-group">
        <?php echo $form->label('heightMobile', t('Mobile (<-770px)'));?>
        <select class="form-control" id="heightMobile" name="heightMobile" value="<?php echo $heightMobile?>">
            <option value="medium" <?php if($heightMobile == 'medium') echo 'selected';?>>Medium (40px)</option>
            <option value="small"<?php if($heightMobile == 'small') echo 'selected';?>>Small (10px)</option>
            <option value="large" <?php if($heightMobile == 'large') echo 'selected';?>>Large (100px)</option>
            <option value="none"<?php if($heightMobile == 'none') echo 'selected';?>><?= t('None');?></option>
        </select>
    </div>

</fieldset>
