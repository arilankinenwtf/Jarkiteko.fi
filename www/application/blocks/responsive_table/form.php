<?php defined('C5_EXECUTE') or die('Access Denied.');

/* @var $this BlockView */
/* @var $controller ResponsiveTableBlockController */
/* @var $bID int */
/* @var $rows array */
/* @var $columnCount int */
/* @var $useFirstRowAsHeaders int|null */
/* @var $hideHeadersOnDesktop int|null */

/* @var $fh FormHelper */

$fh = Core::make('helper/form');

?>

<style>
	#ccm-ResponsiveTableBlock-header-controls {
		background: #f5f5f5;
		margin: -10px -10px 10px;
		padding: 7px 10px;
		border-bottom: 1px solid #ddd;
	}
	#ccm-ResponsiveTableBlock-header-controls label {
		display: inline-block;
		margin-right: 5px;
	}
	#ccm-ResponsiveTableBlock-header-controls label span {
		display: inline-block;
		padding: 1px 0 0 7px;
	}
	#ccm-ResponsiveTableBlock-header-controls label input[type="checkbox"] {
		float: left;
	}
	#ccm-ResponsiveTableBlock-header-controls label input[type="checkbox"]:disabled + span {
		color: #bbb;
	}
	#ccm-ResponsiveTableBlock-entries .row-columns {
		display: inline-block;
		width: 90%;
	}
	#ccm-ResponsiveTableBlock-entries .row-controls {
		position: absolute;
		top: 12px;
		right: 10px;
	}
	#ccm-ResponsiveTableBlock-entries select.row-classes {
		background: #eee;
		color: #666;
		width: 9%;
		vertical-align: top;
		height: 30px;
		line-height: 30px;
		margin-right: 2px;
		border-radius: 3px;
		border-color: #ccc;
	}
	#ccm-ResponsiveTableBlock-entries input[type=text] {
		width: 6.775%;
		padding: 5px 1%;
		margin: 0 6px 6px 0;
	}
	#ccm-ResponsiveTableBlock-entries.row-has-1-columns input[type=text] { width: 92.50%; }
	#ccm-ResponsiveTableBlock-entries.row-has-2-columns input[type=text] { width: 44.85%; }
	#ccm-ResponsiveTableBlock-entries.row-has-3-columns input[type=text] { width: 29.00%; }
	#ccm-ResponsiveTableBlock-entries.row-has-4-columns input[type=text] { width: 21.05%; }
	#ccm-ResponsiveTableBlock-entries.row-has-5-columns input[type=text] { width: 16.30%; }
	#ccm-ResponsiveTableBlock-entries.row-has-6-columns input[type=text] { width: 13.12%; }
	#ccm-ResponsiveTableBlock-entries.row-has-7-columns input[type=text] { width: 10.86%; }
	#ccm-ResponsiveTableBlock-entries.row-has-8-columns input[type=text] { width:  9.16%; }
	#ccm-ResponsiveTableBlock-entries.row-has-9-columns input[type=text] { width:  7.83%; }

	#ccm-ResponsiveTableBlock-entries .ccm-ResponsiveTableBlock-row {
		position: relative;
		background: #fff;
		border-top: 1px dashed #ccc;
		padding: 6px 6px 0px;
	}
	#ccm-ResponsiveTableBlock-entries .ccm-ResponsiveTableBlock-row:nth-child(odd) {
		background: #f6f6f6;
	}
	#ccm-ResponsiveTableBlock-entries .ccm-ResponsiveTableBlock-row:last-child {
		border-bottom: 1px dashed #ccc;
	}
	#ccm-ResponsiveTableBlock-entries .handle-move {
		cursor: move;
		padding: 6px 2px 6px 4px;
	}
	#ccm-ResponsiveTableBlock-entries a.remove-entry {
		display: inline-block;
		cursor: pointer;
	}
	#ccm-ResponsiveTableBlock-entries a.remove-entry img {
		margin-bottom: -1px;
	}
	.ccm-ui .btn-responsive-table-control {
		float: right;
		margin-right: 10px;
	}
	.ccm-ui .btn-responsive-table-control i {
		margin-top: 1px;
	}
</style>


<div id="ccm-ResponsiveTableBlock-header-controls">
	<label>
		<?= $fh->checkbox('useFirstRowAsHeaders', 1, ($useFirstRowAsHeaders || is_null($useFirstRowAsHeaders)), array('onchange' => 'ResponsiveTableBlock.toggleOtherCheckboxes(this);')); ?>
		<span><?= t('Use first row as table headers'); ?></span>
	</label>
	<label>
		<?= $fh->checkbox('hideHeadersOnDesktop', 1, (bool)$hideHeadersOnDesktop, (( ! ($useFirstRowAsHeaders || is_null($useFirstRowAsHeaders))) ? array('disabled' => 'disabled') : array())); ?>
		<span><?= t('Hide headers on desktop mode'); ?></span>
	</label>
</div>

<div class="movable-controls">
	<a class="btn btn-responsive-table-control btn-success add-column" onclick="ResponsiveTableBlock.addColumn(); return false;">
		<?= t('Add column'); ?>&nbsp;
		<i class="fa fa-long-arrow-right"></i>
	</a>
	<a class="btn btn-responsive-table-control btn-danger remove-column <?= ($columnCount === 1) ? 'disabled' : 'danger'; ?> >
		<?= t('Remove column'); ?>" onclick="ResponsiveTableBlock.removeLastColumn(); return false;">
		<?= t('Remove column'); ?>&nbsp;
		<i class="fa fa-long-arrow-left"></i>
	</a>
	<a class="btn btn-responsive-table-control btn-success add-row" onclick="ResponsiveTableBlock.addRow(); return false;">
		<?= t('Add row'); ?>&nbsp;
		<i class="fa fa-long-arrow-down"></i>
	</a>
</div>

<div id="ccm-ResponsiveTableBlock-entries" class="ccm-ui row-has-<?= $columnCount; ?>-columns">
	<?php
	foreach ($rows as $row) {
		$this->inc('row.php',
			array(
				'columns' => $columnCount,
				#'classes' => $classes,
				'row'     => $row,
			)
		);
	}
	?>
</div>

<div id="ccm-ResponsiveTableBlock-template-holder" style="display: none;">
	<?php
	$this->inc('row.php',
		array(
			'columns' => $columnCount,
			#'classes' => $classes,
			'row'     => array(
				'rowID' => 'tempRowId',
				'data'  => array(),
				'class' => '',
			),
		)
	);
	?>
</div>

<script>
	$(function() {
		ResponsiveTableBlock.init();
	});
</script>