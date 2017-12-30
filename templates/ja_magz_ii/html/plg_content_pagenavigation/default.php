<?php
/*
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

defined('_JEXEC') or die;

$table = JTable::getInstance ('content');
$prev_title = $next_title = '';
if ($row->prev) {
	$prev = $rows[$location - 1];
	$table->load ($prev->id);
	$prev_title = $table->title;
}
if ($row->next) {
	$next = $rows[$location + 1];
	$table->load ($next->id);
	$next_title = $table->title;
}
?>
<ul class="pager pagenav">

  <?php if ($row->prev) : ?>
	<li class="previous">
  	<a href="<?php echo $row->prev; ?>" rel="prev">
      <i class="fa fa-angle-left"></i>
      <span><?php echo JText::_('TPL_PREV_ARTICLE'); ?></span>
      <strong><?php echo $prev_title; ?></strong>
    </a>
	</li>
  <?php endif; ?>

  <?php if ($row->next) : ?>
	<li class="next">
  	<a href="<?php echo $row->next; ?>" rel="next">
      <i class="fa fa-angle-right"></i>
      <span><?php echo JText::_('TPL_NEXT_ARTICLE'); ?></span>
      <strong><?php echo $next_title; ?></strong>
    </a>
	</li>
  <?php endif; ?>
  
</ul>
