<?php defined('C5_EXECUTE') or die('Access Denied.');?>

<div class="ccm-toggle-container">
    <?php if (count($rows) > 0) { ?>
        <div class="ccm-toggle-list-entries">
            <?php foreach ($rows as $row) { 
                $itemId = $bID . '-' . $row['id']; ?>
                <div class="toggle-list-item">
                    <a href="#toggle-list-item-<?php echo $itemId; ?>" class="toggle-list-item-wrapper" type="button" 
                        data-toggle="collapse" data-target="#toggle-list-item-paragraph-<?php echo $itemId; ?>" aria-expanded="false" 
                        aria-controls="toggle-list-item-paragraph-<?php echo $itemId; ?>" id="toggle-list-item-<?php echo $itemId; ?>">
                            
                        <div class="toggle-list-item-title">
                            <<?php echo $headingType;?> class="list-item-title">
                                <?php echo $row['title']; ?>
                            </<?php echo $headingType;?>>
                            <button class="toggle-list-item-icon toggle-list-item-icon-plus" aria-hidden="true">+</button>
                            <button class="toggle-list-item-icon toggle-list-item-icon-minus" aria-hidden="true">-</button>
                        </div>
                    </a>

                    <div class="collapse toggle-list-item-open" id="toggle-list-item-paragraph-<?php echo $itemId; ?>" 
                        aria-labelledby="toggle-list-item-<?php echo $itemId; ?>">
                            
                        <div class="toggle-list-item-open-wrapper">
                            <?php echo $row['description']; ?>
                        </div>
                    </div>
                </div><?php
            } ?>
        </div>
    <?php
    } else {
    ?>
        <div class="ccm-faq-block-links">
            <p><?php echo t('No Entries Entered.'); ?></p>
        </div>
    <?php
    }
    ?>
</div>
