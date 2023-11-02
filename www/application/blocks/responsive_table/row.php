<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<div id="ccm-ResponsiveTableBlock-<?= $row['rowID']; ?>" class="ccm-ResponsiveTableBlock-row">
	<div class="cmc-propertiesLookAlikeTableBlock-imgRowIcons"></div>
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td>
				<?php if (! empty($classes)) { ?>
				<select class="row-classes" name="class[<?= $row['rowID']; ?>]" title="Select a class for this row">
					<option value=""></option>
					<?php foreach ((array)$classes as $value => $name) { ?>
							<option value="<?= $value; ?>" <?= ($row['class'] === $value) ? ' selected ' : ''; ?>><?= $name; ?></option>
						<?php } ?>
				</select>
				<?php } ?>
				<div class="row-columns">
				<?php for ($i = 0; $i < $columns; $i++) {
					?><input class="data-column" type="text" name="data[<?= $row['rowID']; ?>][]" value="<?= $row['data'][$i]; ?>" /><?php
				} ?>
					<div class="row-controls">
						<span class="handle-move">
							<img src="<?= ASSETS_URL_IMAGES; ?>/icons/up_down.png" />
						</span>
						<a class="remove-entry" onclick="ResponsiveTableBlock.removeRow('<?= $row['rowID']; ?>')">
							<img src="<?= ASSETS_URL_IMAGES; ?>/icons/delete_small.png" />
						</a>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>