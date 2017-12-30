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
JHtml::_('bootstrap.tooltip');

$blockPosition = $displayData['params']->get('info_block_position', 2);
?>
	<dl class="article-info  muted">

		<?php if ($displayData['position'] == 'above' && ($blockPosition == 0 || $blockPosition == 2)
				|| $displayData['position'] == 'below' && ($blockPosition == 1)
				) : ?>

			<dt class="article-info-term">
				<?php // TODO: implement info_block_show_title param to hide article info title ?>
				<?php if ($displayData['params']->get('info_block_show_title', 1)) : ?>
					<?php echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?>
				<?php endif; ?>
			</dt>
<?php 
	$articleParams = JComponentHelper::getParams('com_content');
 ?>
			<?php if ($displayData['params']->get('show_author') && !empty($displayData['item']->author)) : 
							if (($displayData['params']->get('show_author') == 'use_article' && $displayData['item']->params->get('show_author','') == 'use_article' && $articleParams->get('show_author','1') == '1')
									|| ($displayData['params']->get('show_author') == 'use_article' && $displayData['item']->params->get('show_author','') == '1')
									|| ($displayData['params']->get('show_author') == '' && $articleParams->get('show_author','1') == '1')
									|| ($displayData['params']->get('show_author') == '1')
							) :
			?>
				
				<?php echo JLayoutHelper::render('joomla.content.info_block.author', $displayData); ?>
			<?php 
							endif;
			endif; 
			?>

			<?php if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.parent_category', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_category')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.category', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_publish_date')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.publish_date', $displayData); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($displayData['position'] == 'above' && ($blockPosition == 0)
				|| $displayData['position'] == 'below' && ($blockPosition == 1 || $blockPosition == 2)
				) : ?>

			<dt class="hide"><?php echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?></dt>

			<?php if ($displayData['params']->get('show_create_date')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.create_date', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_modify_date')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.modify_date', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_hits')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.hits', $displayData); ?>
			<?php endif; ?>
		<?php endif; ?>
	</dl>
