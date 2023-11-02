<?php defined('C5_EXECUTE') or die('Access Denied.');

/* @var $this BlockView */
/* @var $controller ResponsiveTableBlockController */
/* @var $bID int */
/* @var $rows array */
/* @var $columnCount int */
/* @var $useFirstRowAsHeaders int|null */
/* @var $hideHeadersOnDesktop int|null */

/* @var $th TextHelper */

$th = Core::make('helper/text');

$headers = ($useFirstRowAsHeaders) ? array_shift($rows) : array();

if ( ! empty($headers) || !  empty($rows)) {
?>

	<div class="responsive-table row-has-<?= $columnCount; ?>-columns tablet-overflow">
		<table>

			<?php if ( ! ($hideHeadersOnDesktop) && is_array($headers) && ! empty($headers)) { ?>
			<thead>
			<tr <?= ($headers['class']) ? ' class="' . $th->entities($headers['class']) . '" ' : ''; ?>>
				<?php foreach ($headers['data'] as $column) { ?>
					<th><?= $th->entities($column); ?></th>
				<?php } ?>
				</tr>
			</thead>
			<?php } ?>

			<tbody>
			<?php foreach ($rows as $row) { ?>
				<tr <?= ($row['class']) ? ' class="' . $th->entities($row['class']) . '" ' : ''; ?>>
				<?php for ($i = 0; $i < $columnCount; $i++) {
					$attributes = ($useFirstRowAsHeaders && $headers && isset($headers['data'][$i]) && $headers['data'][$i]) ? ' data-title="' . $th->entities($headers['data'][$i]) . '" ' : '';
					?>
					<td <?= $attributes; ?>><?= $th->entities($row['data'][$i] ?: ''); ?></td>
				<?php } ?>
				</tr>
			<?php } ?>
			</tbody>

		</table>
	</div>

<?php } else if (Page::getCurrentPage()->isEditMode() && empty($headers) && empty($rows)) { ?>

	<div class="ccm-edit-mode-disabled-item">
		<div style="padding:8px 0px;"><?= t('Table is empty'); ?></div>
	</div>

<?php } ?>