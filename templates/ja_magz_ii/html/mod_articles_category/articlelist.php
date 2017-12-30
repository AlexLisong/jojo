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
JLoader::register('JATemplateHelper', T3_TEMPLATE_PATH . '/helper.php');

$modParams = new JRegistry($module->params);
$banner_pos = $modParams->get('module-position');
$banner_idx = (int) $modParams->get('display-order');

$col = $modParams->get('columns',3);
$count = $params->get('count');
$i = 0;

if ($banner_pos) {
	$banner = array($banner_idx=>$banner_pos);
	$list = ($banner_idx > 0 ? array_slice($list, 0, $banner_idx, true) : array()) + $banner + array_slice($list, $banner_idx, count($list)-$banner_idx, true);
	//$list = array_splice($list, $banner_idx, 0, (array)$banner_pos);
	$count++;
}
$doc = JFactory::getDocument();
?>
<div class="category-module article-list">

<?php if($modParams->get('link')) : ?>
<a class="btn btn-more" href="<?php echo $modParams->get('link'); ?>" title="More"><?php echo JText::_( 'TPL_MORE_ARTICLE' ); ?></a>
<?php endif; ?>

<?php foreach ($list as $item) : ?>
	<?php if ($i%$col==0) : ?>
	<div class="items-row cols-<?php echo $col; ?> <?php echo $moduleclass_sfx; ?>">	
		<div class="equal-height equal-height-child row">
	<?php endif; ?>

			<div class="item col column-1 col-sm-4">	
			<?php if (is_string($item)): ?>
				<?php echo $doc->getBuffer('modules', $item); ?>
			<?php else: ?>
			<?php 
				$ctm_attribs = new JRegistry ($item->attribs);
				$ctm_article_style = $ctm_attribs->get('ctm_article_style', 'default');
			?>
				<article class="<?php echo $ctm_article_style; ?>"> 
					<?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>
					<div class="item-content">
						<aside class="article-aside clearfix">
	            			<dl class="article-info  muted">
	            				<dt class="article-info-term"></dt>
            					<?php if ($item->displayCategoryTitle) : ?>
								<dd title="" class="category-name hasTooltip" data-original-title="Category: ">
									<?php echo $item->displayCategoryTitle; ?>							
								</dd>			
								<?php endif; ?>

								<?php if ($item->displayDate) : ?>
								<dd title="" class="published hasTooltip" data-original-title="Published: ">
									<time itemprop="datePublished" datetime="<?php echo $item->displayDate; ?>">
											<?php echo JATemplateHelper::relTime($item->displayDate); ?>
									</time>
								</dd>
								<?php endif; ?>

								<?php if ($params->get('show_author')) : ?>
								<dd title="" class="author hasTooltip" data-original-title="Author: ">
									<?php echo $item->displayAuthorName; ?>
								</dd>
								<?php endif; ?>
							</dl>
	          			</aside>

						<header class="article-header clearfix">
							<h2 itemprop="name" class="article-title">
								<?php if ($params->get('link_titles') == 1) : ?>
								<a title="<?php echo $item->title; ?>" itemprop="url" href="<?php echo $item->link; ?>">
								<?php endif; ?>
									<?php echo $item->title; ?>
								<?php if ($params->get('link_titles') == 1) : ?>
								</a>
								<?php endif; ?>
							</h2>
						</header>
			
						<?php if ($params->get('show_introtext')) : ?>
							<section itemprop="articleBody" class="article-intro clearfix">
								<?php echo $item->displayIntrotext; ?>
							</section>
						<?php endif; ?>

						<?php if ($item->displayHits) : ?>
							<span class="mod-articles-category-hits">
								(<?php echo $item->displayHits; ?>)
							</span>
						<?php endif; ?>
			
						<?php if ($params->get('show_readmore')) : ?>
							<p class="mod-articles-category-readmore">
								<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
									<?php if ($item->params->get('access-view') == false) : ?>
										<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
									<?php elseif ($readmore = $item->alternative_readmore) : ?>
										<?php echo $readmore; ?>
										<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
									<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
										<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
									<?php else : ?>
										<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
										<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
									<?php endif; ?>
								</a>
							</p>
						<?php endif; ?>
					</div>
				</article>
			<?php endif; ?>
			</div>
	<?php if ( ($i%$col==($col-1)) || $i==($count-1) ) : ?>
		</div></div>
	<?php endif; ?>
	<?php $i++; ?>
<?php endforeach; ?>
</div>