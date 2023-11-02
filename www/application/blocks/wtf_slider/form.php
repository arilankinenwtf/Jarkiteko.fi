<?php defined('C5_EXECUTE') or die("Access Denied.");

$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();

$getString = Core::make('helper/validation/identifier')->getString(18);
$tabs = [
    ['slides-' . $getString, t('Items'), true],
];
echo Core::make('helper/concrete/ui')->tabs($tabs);
?>
<script>
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor'); ?>";
    <?php
    $editorJavascript = Core::make('editor')->outputStandardEditorInitJSFunction();
    ?>
    var launchEditor = <?=$editorJavascript; ?>;
    $(document).ready(function() {
        var ccmReceivingEntry = '';
        var sliderEntriesContainer = $('.ccm-image-slider-entries-<?php echo $bID; ?>');
        var _templateSlide = _.template($('#imageTemplate-<?php echo $bID; ?>').html());

        var attachDelete = function($obj) {
            $obj.click(function() {
                var deleteIt = confirm('<?php echo t('Are you sure?'); ?>');
                if (deleteIt === true) {
                    var slideID = $(this).closest('.ccm-image-slider-entry').find('.editor-content').attr('id');
                    if (typeof CKEDITOR === 'object') {
                        CKEDITOR.instances[slideID].destroy();
                    }

                    $(this).closest('.ccm-image-slider-entry-<?php echo $bID; ?>').remove();
                    doSortCount();
                }
            });
        };

        var attachFileManagerLaunch = function($obj) {
            $obj.click(function() {
                var oldLauncher = $(this);
                ConcreteFileManager.launchDialog(function(data) {
                    ConcreteFileManager.getFileDetails(data.fID, function(r) {
                        jQuery.fn.dialog.hideLoader();
                        var file = r.files[0];
                        oldLauncher.html(file.resultsThumbnailImg);
                        oldLauncher.next('.image-fID').val(file.fID);
                    });
                });
            });
        };

        var doSortCount = function() {
            $('.ccm-image-slider-entry-<?php echo $bID; ?>').each(function(index) {
                $(this).find('.ccm-image-slider-entry-sort').val(index);
            });
        };

        <?php if ($rows) {
          foreach ($rows as $row) { ?>
            sliderEntriesContainer.append(_templateSlide({
                fID: '<?php echo $row['fID']; ?>',
                <?php 
                if (File::getByID($row['fID'])) { ?>
                  image_url: '<?php echo File::getByID($row['fID'])->getThumbnailURL('file_manager_listing'); ?>',
                <?php
                } else { ?>
                  image_url: '',<?php 
                } ?>
                titleText: '<?php echo $row['titleText']; ?>',
                descriptionText: '<?php echo str_replace(["\t", "\r", "\n"], "", addslashes(h($row['descriptionText']))); ?>',
                sort_order: '<?php echo $row['sortOrder']; ?>'
            })); <?php
          }
        } ?>

        doSortCount();
        sliderEntriesContainer.find('select[data-field=entry-link-select]').trigger('change');

        $('.ccm-add-image-slider-entry-<?php echo $bID; ?>').click(function() {
            var thisModal = $(this).closest('.ui-dialog-content');
            sliderEntriesContainer.append(_templateSlide({
                fID: '',
                titleText: '',
                descriptionText: '',
                sort_order: '',
                image_url: ''
            }));

            $('.ccm-image-slider-entry-<?php echo $bID; ?>').not('.slide-closed').each(function() {
                $(this).addClass('slide-closed');
                var thisEditButton = $(this).closest('.ccm-image-slider-entry-<?php echo $bID; ?>').find('.btn.ccm-edit-slide');
                thisEditButton.text(thisEditButton.data('slideEditText'));
            });
            var newSlide = $('.ccm-image-slider-entry-<?php echo $bID; ?>').last();
            var closeText = newSlide.find('.btn.ccm-edit-slide').data('slideCloseText');
            newSlide.removeClass('slide-closed').find('.btn.ccm-edit-slide').text(closeText);

            thisModal.scrollTop(newSlide.offset().top);
            launchEditor(newSlide.find('.editor-content'));
            attachDelete(newSlide.find('.ccm-delete-image-slider-entry-<?php echo $bID; ?>'));
            attachFileManagerLaunch(newSlide.find('.ccm-pick-slide-image'));
            doSortCount();
        });

        $('.ccm-image-slider-entries-<?php echo $bID; ?>').on('click','.ccm-edit-slide', function() {
            $(this).closest('.ccm-image-slider-entry-<?php echo $bID; ?>').toggleClass('slide-closed');
            var thisEditButton = $(this);
            if (thisEditButton.data('slideEditText') === thisEditButton.text()) {
                thisEditButton.text(thisEditButton.data('slideCloseText'));
            } else if (thisEditButton.data('slideCloseText') === thisEditButton.text()) {
                thisEditButton.text(thisEditButton.data('slideEditText'));
            }
        });

        $('.ccm-image-slider-entries-<?php echo $bID; ?>').sortable({
            placeholder: "ui-state-highlight",
            axis: "y",
            handle: "i.fa-arrows",
            cursor: "move",
            update: function() {
                doSortCount();
            }
        });

        attachDelete($('.ccm-delete-image-slider-entry-<?php echo $bID; ?>'));
        attachFileManagerLaunch($('.ccm-pick-slide-image-<?php echo $bID; ?>'));
        $(function() {  // activate editors
            if ($('.editor-content-<?php echo $bID; ?>').length) {
                launchEditor($('.editor-content-<?php echo $bID; ?>'));
            }
        });

        $('div.ccm-block-select-icon').on('change', 'select', function(event) {
            $(event.delegateTarget).find('i[data-preview="icon"]').removeClass();
            if ($(this).val()) {
                $(event.delegateTarget).find('i[data-preview="icon"]').addClass('fa fa-' + $(this).val());
            }
        });
    });
</script>
<style>
    .ccm-image-slider-block-container input[type="text"],
    .ccm-image-slider-block-container textarea {
        display: block;
        width: 100%;
    }
    .ccm-image-slider-block-container .btn-success {
        margin-bottom: 20px;
    }
    .ccm-image-slider-entries {
        padding-bottom: 30px;
        position: relative;
    }
    .ccm-image-slider-block-container .slide-well {
        min-height: 20px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    }
    .ccm-pick-slide-image {
        padding: 5px;
        cursor: pointer;
        background: #dedede;
        border: 1px solid #cdcdcd;
        text-align: center;
        vertical-align: middle;
        width: 72px;
        height: 72px;
        display: table-cell;
    }
    .ccm-pick-slide-image img {
        max-width: 100%;
    }
    .ccm-image-slider-entry {
        position: relative;
    }
    .ccm-image-slider-entry.slide-closed .form-group {
        display: none;
    }

    .ccm-image-slider-entry .form-group {
        margin-left: 0px !important;
        margin-right: 0px !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
        border-bottom: none !important;
    }

    .ccm-image-slider-entry.slide-closed .form-group:first-of-type {
        display: block;
        margin-bottom: 0px;
    }
    .ccm-image-slider-entry.slide-closed .form-group:first-of-type label {
        display: none;
    }
    .btn.ccm-edit-slide {
        position: absolute;
        top: 10px;
        right: 127px;
    }
    .btn.ccm-delete-image-slider-entry {
        position: absolute;
        top: 10px;
        right: 41px;
    }
    .ccm-image-slider-block-container i:hover {
        color: #428bca;
    }
    .ccm-image-slider-block-container i.fa-arrows {
        position: absolute;
        top: 6px;
        right: 5px;
        cursor: move;
        font-size: 20px;
        padding: 5px;
    }
    .ccm-image-slider-block-container .ui-state-highlight {
        height: 94px;
        margin-bottom: 15px;
    }
    .ccm-image-slider-entries .ui-sortable-helper {
        -webkit-box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
        -moz-box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
        box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
    }
    .ccm-image-slider-block-container .show-slide-link {
        display: block;
    }
    .ccm-image-slider-block-container .hide-slide-link {
        display: none;
    }
    .ccm-block-select-icon .input-group-addon {
        min-width:70px;
    }
    .ccm-block-select-icon i {
        font-size: 22px;
    }
</style>

<div id="ccm-tab-content-slides-<?php echo $getString; ?>" class="ccm-tab-content">
    <div class="ccm-image-slider-block-container">
        <div class="ccm-image-slider-entries ccm-image-slider-entries-<?php echo $bID; ?>"></div>
        <div>
            <button type="button" class="btn btn-success ccm-add-image-slider-entry ccm-add-image-slider-entry-<?php echo $bID; ?>"><?php echo t('Add item'); ?></button>
        </div>
    </div>
</div>

<script type="text/template" id="imageTemplate-<?php echo $bID; ?>">
    <div class="ccm-image-slider-entry ccm-image-slider-entry-<?php echo $bID; ?> slide-well slide-closed">
        <div class="form-group">
            <label class="control-label"><?php echo t('Image'); ?></label>
            <div class="ccm-pick-slide-image ccm-pick-slide-image-<?php echo $bID; ?>">
                <% if (image_url.length > 0) { %>
                    <img src="<%= image_url %>" />
                <% } else { %>
                    <i class="fa fa-picture-o"></i>
                <% } %>
            </div>
            <input type="hidden" name="<?php echo $view->field('fID'); ?>[]" class="image-fID" value="<%=fID%>" />
        </div>
        <div class="form-group" >
            <label class="control-label"><?php echo t('Title'); ?></label>
            <input class="form-control ccm-input-text" type="text" name="<?php echo $view->field('titleText'); ?>[]" value="<%=titleText%>" />
        </div>
        <div class="form-group" >
            <label class="control-label"><?php echo t('Content'); ?></label>
            <div class="editor-edit-content"></div>
            <textarea id="ccm-slide-editor-<%= _.uniqueId() %>" style="display: none" class="editor-content editor-content-<?php echo $bID; ?>" name="<?php echo $view->field('descriptionText'); ?>[]"><%=descriptionText%></textarea>
        </div>

        <button type="button" class="btn btn-sm btn-default ccm-edit-slide ccm-edit-slide-<?php echo $bID; ?>" data-slide-close-text="<?php echo t('Collapse entry'); ?>" data-slide-edit-text="<?php echo t('Edit item'); ?>"><?php echo t('Edit item'); ?></button>
        <button type="button" class="btn btn-sm btn-danger ccm-delete-image-slider-entry ccm-delete-image-slider-entry-<?php echo $bID; ?>"><?php echo t('Remove'); ?></button>
        <i class="fa fa-arrows"></i>

        <input class="ccm-image-slider-entry-sort" type="hidden" name="<?php echo $view->field('sortOrder'); ?>[]" value="<%=sort_order%>"/>
    </div>
</script>
