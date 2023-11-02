var ResponsiveTableBlock = {

    init: function() {
        // make rows sortable
        $('#ccm-ResponsiveTableBlock-entries')
            .sortable({
                handle: '.handle-move',
                cursor: 'move',
                start: function() {
                    $(this).addClass('sorting').sortable('refreshPositions');
                },
                stop: function() {
                    $(this).removeClass('sorting');
                }
            })
            .disableSelection()
            // fix sortable bug on firefox
            .find('input, textarea, select')
                .on('click.sortable mousedown.sortable', function(e) {
                    e.stopImmediatePropagation();
                });

        // move controls to dialog footer
        $('.movable-controls').each(function() {
            $(this)
                .closest('.ui-dialog-content')
                    .find('.ccm-buttons')
                        .append(this)
                        .end()
                    .end()
                .find('> *')
                    .unwrap();
        });
    },

    addRowId: 0,
    addRow: function() {
        this.addRowId--;
        var $newRow = $('<div/>', {
            'id'    : 'ccm-ResponsiveTableBlock-' + this.addRowId,
            'class' : 'ccm-ResponsiveTableBlock-row',
            'html'  : $('#ccm-ResponsiveTableBlock-template-holder .ccm-ResponsiveTableBlock-row').html().replace(/tempRowId/g, this.addRowId)
        });
        $newRow
            .appendTo('#ccm-ResponsiveTableBlock-entries')
            // fix sortable bug on firefox
            .find('input, textarea, select')
                .on('click.sortable mousedown.sortable', function(e){
                    e.stopImmediatePropagation();
                })
                .end()
            // scroll to new row
            .parents('.ui-dialog-content')
                .scrollTop($newRow.offset().top);
    },

    removeRow: function(fID){
        $('#ccm-ResponsiveTableBlock-'+fID).remove();
    },

    addColumn: function() {
        $('.ccm-ResponsiveTableBlock-row').each(function() {
            var $lastColumn = $(this).find('input.data-column').last();
            $lastColumn.after($lastColumn.clone().val(''));
        });
        $('.remove-column').removeClass('disabled').addClass('danger');
        this.updateColumnCountClass();
    },

    removeLastColumn: function() {
        $('.ccm-ResponsiveTableBlock-row').each(function() {
            var $columns = $(this).find('input.data-column');
            if ($columns.length > 1) {
                $columns.last().remove();
            } else {
                $('.remove-column').addClass('disabled').removeClass('danger');
            }
        });
        this.updateColumnCountClass();
    },

    updateColumnCountClass: function() {
        var entries = $('#ccm-ResponsiveTableBlock-entries')[0];
        entries.className = entries.className.replace(/row-has-[0-9]+-columns/g, '').replace(/\s+/, ' ').trim() + ' row-has-' + $('.ccm-ResponsiveTableBlock-row').last().find('input.data-column').length + '-columns';
    },

    toggleOtherCheckboxes: function(el) {
        var $others = $(el).closest('div').find('input[type="checkbox"]').not(el);
        if ($(el).is(':checked')) {
            $others.prop('disabled', false);
        } else {
            $others.prop('disabled', true).prop('checked', false);
        }
    }

};
