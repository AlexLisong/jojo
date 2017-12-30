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
?>

<div class="typo-tools">
	<ul>
		<li class="toggle-reading">
			<a class="toggle" href="#" title="<?php echo JText::_('TPL_TYPO_TOOL_READING_MODE') ?>" data-action="onOff" data-value="reading-mode" data-default="off" data-target="html" data-key="reading-mode" data-cookie="no"> <i class="fa fa-sign-out hide"></i><span class="hidden-xs"><?php echo JText::_('TPL_TYPO_TOOL_READING_MODE') ?><span></a>
		</li>
    <li data-fonts="Sans-serif,Serif" data-loop="false">
			<a class="btn font font-sans-serif hasTooltip" href="#" title="<?php echo JText::_('TPL_TYPO_TOOL_FONT_FAMILY_PREV') ?>" data-value="-1" data-target=".article" data-action="nextPrev" data-key="font"><div class="font-type"><b>aA</b></div></a>
			<a class="btn font font-serif hasTooltip" href="#" title="<?php echo JText::_('TPL_TYPO_TOOL_FONT_FAMILY_NEXT') ?>" data-value="+1" data-target=".article" data-action="nextPrev" data-key="font" data-default="Default"><div class="font-type"><b>aA</b></div></a>
		</li>
		<li data-fss="Smaller,Small,Medium,Big,Bigger">
			<a class="btn hasTooltip" href="#" title="<?php echo JText::_('TPL_TYPO_TOOL_FONT_SIZE_DECREASE') ?>" data-value="-1" data-target=".article" data-action="nextPrev" data-key="fs"><i class="fa fa-minus"></i></a>
			<a class="btn hasTooltip" href="#" title="<?php echo JText::_('TPL_TYPO_TOOL_FONT_SIZE_INCREASE') ?>" data-value="+1" data-target=".article" data-action="nextPrev" data-key="fs" data-default="Medium"><i class="fa fa-plus"></i></a>
		</li>
	</ul>
</div>
