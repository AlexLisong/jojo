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


$tplparams = JFactory::getApplication()->getTemplate(true)->params;
$typo_tools = $params->get('show_typo_tools', '') == '' ? $tplparams->get('show_typo_tools', 1) : $params->get('show_typo_tools');
$sharing_tools = $params->get('show_sharing_tools', '') == '' ? $tplparams->get('show_sharing_tools', 1) : $params->get('show_sharing_tools');
$tools = $icons || $typo_tools || $sharing_tools;

JHtml::_('behavior.caption');
JHtml::_('bootstrap.tooltip');

// Add Facebook tags
$doc = JFactory::getDocument();
$fblog = '<meta property="og:type" content="article" />'."\n";
$fblog .= '<link rel="image_src" content="'.JUri::base().$images->image_fulltext.'" />'."\n";
$fblog .= '<meta property="og:image" content="'.JUri::base().$images->image_fulltext.'" />'."\n";
if($this->item->tags->itemTags != null){
    $this->item->rawtagLayout = new JLayoutFile('joomla.content.rawtags');
    $fblog .= '<meta property="article:tag" content="'.$this->item->rawtagLayout->render($this->item->tags->itemTags).'" />'."\n";
}
$doc->addCustomTag($fblog);

?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header clearfix">
		<h1 class="page-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</div>
<?php endif; ?>

<div class="item-page<?php echo $this->pageclass_sfx ?> clearfix">

<?php if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative) : ?>
	<?php echo $this->item->pagination; ?>
<?php endif; ?>

<!-- Article -->
<article class="article" itemscope itemtype="http://schema.org/Article">
	<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
	<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />

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
<!-- Aside -->
<?php if ($topInfo || $this->print) : ?>
<aside class="article-aside clearfix">
  <?php if ($topInfo): ?>
  <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $this->params, 'position' => 'above')); ?>
  <?php endif; ?>
  <?php if(!empty($this->print)) : 
  	echo JHtml::_('icon.print_screen', $this->item, $params); 
  	endif; 
  ?>
  
	<?php echo $this->item->event->afterDisplayTitle; ?>
	
</aside>  
<?php endif; ?>
<!-- //Aside -->

<?php if ($params->get('show_title')) : ?>
	<?php echo JLayoutHelper::render('joomla.content.item_title', array('item' => $this->item, 'params' => $params, 'title-tag'=>'h1')); ?>
<?php endif; ?>
<?php 
	$sidebar_modules = 'article-sidebar';
	$attrs = array();
	$attrs['style'] = 'T3xhtml';
	$result = null;
	$renderer = JFactory::getDocument()->loadRenderer('modules');
	$sidebar = $renderer->render($sidebar_modules, $attrs, $result); ?>
	
<div class="row equal-height">
	<?php
		$attribs = new JRegistry ($this->item->attribs);
		$content_type = $attribs->get('ctm_content_type', 'article'); 
	?>
	<div class="col-xs-12 <?php if ($content_type=='video' && $params->get('access-view') ): ?>affix-video<?php endif; ?>">
		<?php if ($content_type=='video' && $params->get('access-view') ): ?>
		<div id="ja-main-player" class="embed-responsive embed-responsive-16by9">
			<span itemscope itemtype="http://schema.org/VideoObject" style="display:none;">
				<span itemprop="name"><?php echo $this->item->title; ?></span>
				<span itemprop="description"><?php //echo $this->item->text; ?></span>
				<img itemprop="thumbnailUrl" src="<?php echo JURI::base() ?><?php echo $params->get('ctm_thumbnail'); ?>" alt="<?php echo $this->item->title; ?>"/>
				<meta itemprop="uploadDate" content="<?php echo JHtml::_('date', $this->item->publish_up, 'c'); ?>"/>
			</span>
			<div id="videoplayer">
			  <?php echo JLayoutHelper::render('joomla.content.video_play', array('item' => $this->item, 'context' => 'featured')); ?>
			</div>
		</div>
		<hr />
		<?php elseif ($content_type=='gallery' && $params->get('access-view')): ?>
		  <div class="ja-gallery-list-wrap">
		    <?php echo JLayoutHelper::render('joomla.content.gallery_play', $this->item); ?>
		  </div>
		<?php endif; ?>
	</div>
	<div class="col col-xs-12 <?php if ($sidebar) : ?> col-md-8 <?php endif; ?> item-main">

		<?php	if ($params->get('access-view') && $content_type!='video' & $content_type!='gallery'): ?>
			<?php echo JLayoutHelper::render('joomla.content.fulltext_image', array('item' => $this->item, 'params' => $params)); ?>
		<?php endif; ?>

		<div class="row">
		<?php if ($tools): ?>
		<div class="col-lg-3">
			<div class="article-tools">
				<div class="title-reading hide"> <?php echo $this->item->title; ?></div>
				<?php if ($icons): ?>
					<div class="default-tools">
					<?php echo JLayoutHelper::render('joomla.content.magazine_icons', array('item' => $this->item, 'params' => $params)); ?>
					</div>
				<?php endif; ?>

				<?php if ($typo_tools): ?>
				<?php echo JLayoutHelper::render('joomla.content.typo_tools', array()); ?>
				<?php endif ?>

				<?php if ($sharing_tools): ?>
				<?php echo JLayoutHelper::render('joomla.content.sharing_tools', array()); ?>
				<?php endif ?>
			</div>
		</div>
		<?php endif ?>

		<div class="article-content-main <?php if ($tools): ?>col-lg-9 <?php else: ?> col-lg-12 <?php endif ?>">
		<?php if (isset ($this->item->toc)) : ?>
			<?php echo $this->item->toc; ?>
		<?php endif; ?>

		<?php echo $this->item->event->beforeDisplayContent; ?>

		<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position))) || (empty($urls->urls_position) && (!$params->get('urls_position')))): ?>
			<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>

		<?php	if ($params->get('access-view')): ?>

			<?php	if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
				echo $this->item->pagination;
			endif; ?>

			<section class="article-content clearfix" itemprop="articleBody">
				<?php echo $this->item->text; ?>
			</section>

		  <!-- footer -->
		  <?php if ($botInfo) : ?>
		  <footer class="article-footer clearfix">
		    <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
		  </footer>
		  <?php endif; ?>
		  <!-- //footer -->

			<?php
			if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative): ?>
				<?php
				echo '<section class="row article-navigation top">';
				echo str_replace(array('</i>','</a>'),array('</i><div class="navigation-detail">','</div></a>'),$this->item->pagination);
				echo '</section>';
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
		
			<?php if ($params->get('show_tags', 1) && !empty($this->item->tags)) : ?>
				<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
			<?php endif; ?>
			</div>
		</div></div>

		<?php if ($sidebar) : ?>
			<div class="col col-md-4 item-sidebar"><div class="affix-wrap">
				<?php echo $sidebar; ?>
			</div></div>
		<?php endif; ?>
	</div> <!-- //Row -->
</article>
<!-- //Article -->

<?php if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative): ?>
	<?php echo $this->item->pagination; ?>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>

<?php 
	$releated_modules = 'article-bottom';
	$attrs = array();
	$attrs['style'] = 'T3xhtml';
	$result = null;
	$renderer = JFactory::getDocument()->loadRenderer('modules');
	$releated = $renderer->render($releated_modules, $attrs, $result); ?>

	<?php if ($releated) : ?>
	<div class="article-releated">
			<?php echo $releated; ?>
	</div>
	<?php endif; ?>

</div>