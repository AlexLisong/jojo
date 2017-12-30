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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
JHtml::addIncludePath(T3_PATH.'/html/com_content');
JHtml::addIncludePath(dirname(dirname(__FILE__)));
JHtml::_('behavior.caption');
$input = JFactory::getApplication()->input;
$tmpl = $input->get('tmpl');
?>
<div class="blog<?php echo $this->pageclass_sfx;?> xblog">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header clearfix">
		<h1 class="page-title"> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
	</div>
	<?php endif; ?>
	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
  	<div class="page-subheader clearfix">
  		<h2 class="page-subtitle"><?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
			<small class="subheading-category"><?php echo $this->category->title;?></small>
			<?php endif; ?>
  		</h2>
	</div>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php echo JLayoutHelper::render('joomla.content.tags', $this->category->tags->itemTags); ?>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc clearfix">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) : ?>
			<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>


	<?php if(!$tmpl): ?>
		<!-- do not show leading article on ajax request -->
		<?php $leadingcount = 0; ?>
		<?php if (!empty($this->lead_items)) : ?>
		<div class="items-leading">
			<?php foreach ($this->lead_items as &$item) : ?>
			<div class="leading leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
				<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php $leadingcount++; ?>
			<?php endforeach; ?>
		</div><!-- end items-leading -->
		<?php endif; ?>
	<?php endif; ?>

	<?php
		$introcount = (count($this->intro_items));
		$counter = 0;
	?>

	<?php if (!empty($this->intro_items) || !empty($this->lead_items)) : ?>

	<?php // merge lead items with intro items for ajax request
		if ($tmpl) {
			$leads = array_reverse($this->lead_items);
			foreach ($leads as $litem) {
				array_unshift($this->intro_items, $litem);
			}
		}
	 ?>
    <div id="item-container">

	<?php foreach ($this->intro_items as $key => &$item) : ?>
		<?php $rowcount = ((int) $counter % (int) $this->columns) + 1; ?>
		<?php if ($rowcount == 1) : ?>
			<?php $row = $counter / $this->columns; ?>
		<div class="items-row cols-<?php echo (int) $this->columns;?> <?php echo 'row-'.$row; ?> row">
		<?php endif; ?>
			<div class="col-sm-<?php echo round((12 / $this->columns));?>">
				<div class="item column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
				</div><!-- end item -->
				<?php $counter++; ?>
			</div><!-- end span -->
			<?php if (($rowcount == $this->columns) or ($counter == $introcount)) : ?>			
		</div><!-- end row -->
		<div class="sep"></div>
		<?php endif; ?>
	<?php endforeach; ?>
    </div>
	<?php endif; ?>
	
	<?php if (!empty($this->link_items)) : ?>
	<div class="items-more">
	<?php echo $this->loadTemplate('links'); ?>
	</div>
	<?php endif; ?>
	
	<?php if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
	<div class="cat-children">
		<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
		<h3> <?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
		<?php endif; ?>
		<?php echo $this->loadTemplate('children'); ?> </div>
	<?php endif; ?>
	<?php
        $show_option = $this->params->get('show_pagination');
        $pagination_type = $this->params->get('pagination_type');
    ?>
	<?php 
  $pagesTotal = isset($this->pagination->pagesTotal) ? $this->pagination->pagesTotal : $this->pagination->get('pages.total');
  if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($pagesTotal > 1)) : ?>
	<div class="pagination-wrap">
		<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
		<div class="counter"> <?php echo $this->pagination->getPagesCounter(); ?></div>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?> </div>
	<?php  endif; ?>
    
    <!-- Show load more use infinitive-scroll -->
    <?php
        if ($show_option && $pagination_type > 0){
            JFactory::getDocument()->addScript (T3_TEMPLATE_URL . '/js/infinitive-paging.js');
            JFactory::getDocument()->addScript (T3_TEMPLATE_URL . '/js/jquery.infinitescroll.js');
            $mode = $this->params->def('pagination_type', 2) == 1 ? 'manual' : 'auto';
            
            if($this->pagination->get('pages.total') > 1 ) : ?>
                <script>
                    jQuery(".pagination-wrap").css('display','none');
                </script>
                <div id="infinity-next" class="btn btn-primary  hide" data-limit="<?php echo $this->pagination->limit; ?>" data-url="<?php echo JUri::current(); ?>" data-mode="<?php echo $mode ?>" data-pages="<?php echo $this->pagination->get('pages.total') ?>" data-finishedmsg="<?php echo JText::_('TPL_INFINITY_NO_MORE_ARTICLE');?>"><?php echo JText::_('TPL_INFINITY_MORE_ARTICLE')?></div>
            <?php else:  ?>
                <div id="infinity-next" class="btn btn-primary  disabled" data-pages="1"><?php echo JText::_('TPL_INFINITY_NO_MORE_ARTICLE');?></div>    
            <?php endif;
        }
    ?>
</div>