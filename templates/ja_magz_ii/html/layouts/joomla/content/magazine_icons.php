<?php
/**
 * ------------------------------------------------------------------------
 * JA Magz II Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */


defined('JPATH_BASE') or die;
$item = $displayData['item'];
$params = $item->params;
$canEdit = $displayData['item']->params->get('access-edit');

?>
<?php if (empty($displayData['print'])) : ?>
	<?php if ($params->get('show_print_icon') || $canEdit || $params->get('show_email_icon')) : ?>
		<div class="view-tools">
			<?php // Note the actions class is deprecated. Use dropdown-menu instead. ?>
			<ul>
				<?php if ($params->get('show_print_icon')) : ?>
					<li class="print-icon"> <?php echo JHtml::_('icon.print_popup', $item, $params); ?> </li>
				<?php endif; ?>
				<?php if ($params->get('show_email_icon')) : ?>
					<li class="email-icon"> <?php echo JHtml::_('icon.email', $item, $params); ?> </li>
				<?php endif; ?>
				<?php if ($canEdit) : ?>
					<li class="edit-icon"> <?php echo JHtml::_('icon.edit', $item, $params); ?> </li>
				<?php endif; ?>
			</ul>
		</div>
	<?php endif; ?>
<?php endif; ?>