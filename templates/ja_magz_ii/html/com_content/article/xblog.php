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
JHtml::addIncludePath(T3_PATH . '/html/com_content');
JHtml::addIncludePath(dirname(dirname(__FILE__)));

// Create shortcuts to some parameters.
$params   = $this->item->params;
$images   = json_decode($this->item->images);
$urls     = json_decode($this->item->urls);
$canEdit  = $params->get('access-edit');
$user     = JFactory::getUser();
$info    = $params->get('info_block_position', 2);
$aInfo1 = ($params->get('show_publish_date') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author'));
$aInfo2 = ($params->get('show_create_date') || $params->get('show_modify_date') || $params->get('show_hits'));
$topInfo = ($aInfo1 && $info != 1) || ($aInfo2 && $info == 0);
$botInfo = ($aInfo1 && $info == 1) || ($aInfo2 && $info != 0);
$icons = !empty($this->print) || $canEdit || $params->get('show_print_icon') || $params->get('show_email_icon');

JHtml::_('behavior.caption');
JHtml::_('bootstrap.tooltip');
?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header clearfix">
		<h1 class="page-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</div>
<?php endif; ?>

<div class="item-page<?php echo $this->pageclass_sfx ?> xblog-item clearfix">

<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $this->item->event->beforeDisplayContent; ?>

<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position))) || (empty($urls->urls_position) && (!$params->get('urls_position')))): ?>
	<?php echo $this->loadTemplate('links'); ?>
<?php endif; ?>

<?php	if ($params->get('access-view')): ?>

	<?php	if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
		echo $this->item->pagination;
	endif; ?>
	<?php if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative) : ?>
	<?php echo $this->item->pagination; ?>

<?php endif; ?>

<!-- Article -->
<article itemscope itemtype="http://schema.org/Article">
	<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
	<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>

	<?php if(!$this->params->get('show_modify_date')) { ?>
    <meta content="<?php echo JHtml::_('date', $this->item->modified, 'c'); ?>" itemprop="dateModified">
  <?php } ?>

  <?php if(!$this->params->get('show_publish_date')) { ?>
    <meta content="<?php echo JHtml::_('date', $this->item->publish_up, 'c'); ?>" itemprop="datePublished">
  <?php } ?>

  <?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author);
  if(!$this->params->get('show_author')) { ?>
  <span itemprop="author" style="display: none;">
    <span itemprop="name"><?php echo $author; ?></span>
    <span itemtype="https://schema.org/Organization" itemscope="" itemprop="publisher" style="display: none;">
      <span itemtype="https://schema.org/ImageObject" itemscope="" itemprop="logo">
        <img itemprop="url" alt="logo" src="<?php echo JURI::base(); ?>/templates/<?php echo JFactory::getApplication()->getTemplate() ?>/images/logo.png">
        <meta content="auto" itemprop="width">
        <meta content="auto" itemprop="height">
      </span>
      <meta content="<?php echo $author; ?>" itemprop="name">
    </span>
  </span>
  <?php } ?>
	<?php endif; ?>

	<span style="display: none;" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
		<img
			src="<?php echo JURI::base(); ?>/templates/<?php echo JFactory::getApplication()->getTemplate() ?>/images/logo.png"
			alt="" itemprop="image"/>
	  <meta itemprop="height" content="auto" />
	  <meta itemprop="width" content="auto" />
	  <meta itemprop="url" content="<?php echo JURI::base(); ?>/templates/<?php echo JFactory::getApplication()->getTemplate() ?>/images/logo.png" />
	</span>

	<?php
		$attribs = new JRegistry ($this->item->attribs);
		$content_type = $attribs->get('ctm_content_type', 'article'); 
	?>

	<?php if ($content_type=='video' && $params->get('access-view') ): ?>
		<div id="ja-main-player" class="embed-responsive embed-responsive-16by9">
			<span itemscope itemtype="http://schema.org/VideoObject" style="display:none;">
				<span itemprop="name"><?php echo $this->item->title; ?></span>
				<span itemprop="description"><?php echo $this->item->text; ?></span>
				<img itemprop="thumbnailUrl" src="<?php echo JURI::base() ?><?php echo $params->get('ctm_thumbnail'); ?>" alt="<?php echo $this->item->title; ?>"/>
				<meta itemprop="uploadDate" content="<?php echo JHtml::_('date', $this->item->publish_up, 'c'); ?>"/>
			</span>
			<div id="videoplayer">
			  <?php echo JLayoutHelper::render('joomla.content.video_play', array('item' => $this->item, 'context' => 'featured')); ?>
			</div>
		</div>
		<?php elseif ($content_type=='gallery' && $params->get('access-view')): ?>
		  <div class="ja-gallery-list-wrap">
		    <?php echo JLayoutHelper::render('joomla.content.gallery_play', $this->item); ?>
		  </div>
		<?php endif; ?>
		<?php	if ($params->get('access-view') && $content_type!='video' & $content_type!='gallery'): ?>
			<?php echo JLayoutHelper::render('joomla.content.fulltext_image', array('item' => $this->item, 'params' => $params)); ?>
		<?php endif; ?>

	<!-- Aside -->
	<?php if ($topInfo || $icons) : ?>
	<aside class="article-aside clearfix">
	  <?php if ($topInfo): ?>
	  <?php echo JLayoutHelper::render('joomla.content.info_block.xblock', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
	  <?php endif; ?>
	  
	  <?php if ($icons): ?>
	  <?php echo JLayoutHelper::render('joomla.content.icons', array('item' => $this->item, 'params' => $params, 'print' => $this->print)); ?>
	  <?php endif; ?>
	</aside>

	<?php if ($params->get('show_title')) : ?>
		<?php echo JLayoutHelper::render('joomla.content.item_title', array('item' => $this->item, 'params' => $params, 'title-tag'=>'h1')); ?>
	<?php endif; ?>

	<?php if (isset ($this->item->toc)) : ?>
		<?php echo $this->item->toc; ?>
	<?php endif; ?>

	<section class="article-content clearfix" itemprop="articleBody">
		<?php echo $this->item->text; ?>
	</section>

	<?php if ($params->get('show_tags', 1) && !empty($this->item->tags)) : ?>
		<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
	<?php endif; ?>

  <!-- footer -->
  <?php if ($botInfo) : ?>
  <footer class="article-footer clearfix">
    <?php echo JLayoutHelper::render('joomla.content.info_block.xblock', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
  </footer>
  <?php endif; ?>
  <!-- //footer -->

	<?php
	if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative): ?>
		<?php
		echo '<hr class="divider-vertical" />';
		echo $this->item->pagination;
		?>
	<?php endif; ?>

	<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))): ?>
		<?php echo $this->loadTemplate('links'); ?>
	<?php endif; ?>

	<?php //optional teaser intro text for guests ?>
<?php elseif ($params->get('show_noauth') == true and  $user->get('guest')) : ?>

	<?php echo $this->item->introtext; ?>
	<?php //Optional link to let them register to see the whole article. ?>
	<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
		$link1 = JRoute::_('index.php?option=com_users&view=login');
		$link = new JURI($link1);
		?>
		<section class="readmore">
			<a href="<?php echo $link; ?>" itemprop="url">
						<span>
						<?php $attribs = json_decode($this->item->attribs); ?>
						<?php
						if ($attribs->alternative_readmore == null) :
							echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
						elseif ($readmore = $this->item->alternative_readmore) :
							echo $readmore;
							if ($params->get('show_readmore_title', 0) != 0) :
								echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
							endif;
						elseif ($params->get('show_readmore_title', 0) == 0) :
							echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
						else :
							echo JText::_('COM_CONTENT_READ_MORE');
							echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
						endif; ?>
						</span>
			</a>
		</section>
	<?php endif; ?>
<?php endif; ?>

</article>
<!-- //Article -->

<?php if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative): ?>
	<?php echo $this->item->pagination; ?>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>
</div>