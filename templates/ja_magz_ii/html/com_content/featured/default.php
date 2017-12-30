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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::addIncludePath(T3_PATH.'/html/com_content');
JHtml::addIncludePath(dirname(dirname(__FILE__)));
JHtml::_('behavior.caption');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<div class="blog<?php echo $this->pageclass_sfx;?>">
<?php if ($this->params->get('show_page_heading') != 0) : ?>
<div class="page-header">
	<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
</div>
<?php endif; ?>

<div id="item-container">
<?php $leadingcount = 0; ?>
<?php if (!empty($this->lead_items)) : ?>
<div class="items-leading clearfix"><div class="row equal-height">
	<div class="col col-sm-12 col-md-8 leading-main">
	<?php foreach ($this->lead_items as &$item) : ?>
		<div class="leading leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
			<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
			?>
		</div>
		<?php
			$leadingcount++;
			break;
		?>
	<?php endforeach; ?>
	</div>

	<div class="col col-sm-12 col-md-4 leading-sidebar">
		<?php 
		$ads_modules = 'leading-sidebar';
		$attrs = array();
		$result = null;
		$renderer = JFactory::getDocument()->loadRenderer('modules');
		$ads = $renderer->render($ads_modules, $attrs, $result);
		if ($ads) : ?>
		<div class="banner-sidebar">
			<?php echo $ads ?>
		</div>
		<?php endif ?>

		<?php $leadingcount = 0; ?>
		<?php foreach ($this->lead_items as &$item) : ?>
		<?php if($leadingcount > 0) : ?>
		<div class="leading leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
			<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
			?>
		</div>
		<?php endif; ?>
		<?php
			$leadingcount++;
		?>
	<?php endforeach; ?>
	</div>
</div></div>
<?php endif; ?>
<?php
	$introcount = (count($this->intro_items));
	$counter = 0;
?>
<?php if (!empty($this->intro_items)) : ?>
	<?php foreach ($this->intro_items as $key => &$item) : ?>

		<?php
		$key = ($key - $leadingcount) + 1;
		$rowcount = (((int) $key - 1) % (int) $this->columns) + 1;
		$row = $counter / $this->columns;

		if ($rowcount == 1) : ?>

		<div class="items-row cols-<?php echo (int) $this->columns;?>"><div class="equal-height equal-height-child <?php echo 'row-'.$row; ?> row">
		<?php endif; ?>
			<div class="item col column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> col-sm-<?php echo round((12 / $this->columns));?>">
			<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
			?>
			</div>
			<?php $counter++; ?>

			<?php if (($rowcount == $this->columns) or ($counter == $introcount)) : ?>

		</div></div>
		<?php endif; ?>

	<?php endforeach; ?>
<?php endif; ?>
</div>

<?php if (!empty($this->link_items)) : ?>
	<section class="items-more">
		<h3><?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?></h3>
		<?php echo $this->loadTemplate('links'); ?>
	</section>
<?php endif; ?>

<?php
	$show_option = $this->params->get('show_pagination');
	$pagination_type = $this->params->get('pagination_type');
?>

<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<nav class="pagination-wrap clearfix">

		<?php 
    $pagesTotal = isset($this->pagination->pagesTotal) ? $this->pagination->pagesTotal : $this->pagination->get('pages.total');
    if ($this->params->def('show_pagination_results', 1) && $pagesTotal > 1) : ?>
			<div class="counter">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</div>
		<?php  endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?>
	</nav>
<?php endif; ?>
<!-- show load more use infinitive-scroll -->
    <?php
        if ($show_option && $pagination_type > 0){
            JFactory::getDocument()->addScript (T3_TEMPLATE_URL . '/js/infinitive-paging.js');
            JFactory::getDocument()->addScript (T3_TEMPLATE_URL . '/js/jquery.infinitescroll.js');
            $mode = $this->params->def('pagination_type', 2) == 1 ? 'manual' : 'auto';

            if($this->pagination->get('pages.total') > 1 ) : ?>
                <script>
                    jQuery(".pagination-wrap").css('display','none');
                </script>
                <div id="infinity-next" class="btn btn-primary hide" data-limit="<?php echo $this->pagination->limit; ?>" data-url="<?php echo JUri::current(); ?>" data-mode="<?php echo $mode ?>" data-pages="<?php echo $this->pagination->get('pages.total') ?>" data-finishedmsg="<?php echo JText::_('TPL_INFINITY_NO_MORE_ARTICLE');?>"><?php echo JText::_('TPL_INFINITY_MORE_ARTICLE')?></div>
            <?php else:  ?>
                <div id="infinity-next" class="btn btn-primary disabled" data-pages="1"><?php echo JText::_('TPL_INFINITY_NO_MORE_ARTICLE');?></div>    
            <?php endif;
        }
    ?>
</div>
