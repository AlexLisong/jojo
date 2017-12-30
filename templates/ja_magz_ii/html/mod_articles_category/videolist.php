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
$modParams = new JRegistry($module->params);
?>
<div class="video-list <?php echo $moduleclass_sfx; ?>">
  <?php if($modParams->get('link')) : ?>
  <a class="btn btn-more" href="<?php echo $modParams->get('link'); ?>" title="More"><?php echo JText::_( 'TPL_MORE_VIDEOS' ); ?></a>
  <?php endif; ?>
  <div class="row">
	<?php foreach ($list as $item) : ?>
		<?php 
			$attribs = new JRegistry ($item->attribs);
			$content_type = $attribs->get('ctm_content_type', 'article');
		?>
		<?php if($content_type=='video') : ?>
		<div class="player-wrap col-md-9" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
			<div id="ja-main-player" class="embed-responsive embed-responsive-16by9" itemprop="video">
				<div id="videoplayer">
					<?php echo JLayoutHelper::render('joomla.content.video_play', array('item' => $item, 'context' => 'featured')); ?>
				</div>
			</div>

			<script type="text/javascript">

				(function($){
					$(document).ready(function(){
						$('#ja-main-player').find('iframe.ja-video, video, .jp-video, .jp-jplayer').each(function(){
							var container = $('#ja-main-player');
							var width = container.outerWidth(true);
							var height = container.outerHeight(true);

							$(this).removeAttr('width').removeAttr('height');
							$(this).css({width: width, height: height});
						});
					});
				})(jQuery);
			</script>
		</div>
		<?php break; endif; ?>
	<?php endforeach; ?>
	<div class="videos-featured-list col-md-3">
		<ul>
		<?php foreach ($list as $item) : ?>
		<?php 
			$attribs = new JRegistry ($item->attribs);
			$content_type = $attribs->get('ctm_content_type', 'article');
		?>
		<?php if($content_type=='video') : ?>
		<li>
			<?php echo JLayoutHelper::render('joomla.content.image.video_thumb', $item); ?>
			<?php if ($params->get('link_titles') == 1) : ?>
				<h2 class="article-title"><a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
					<?php echo $item->title; ?>
				</a></h2>
			<?php else : ?>
				<h2 class="article-title"><?php echo $item->title; ?></h2>
			<?php endif; ?>

			<?php if ($item->displayHits) : ?>
				<span class="mod-articles-category-hits">
					(<?php echo $item->displayHits; ?>)
				</span>
			<?php endif; ?>

			<?php if ($params->get('show_author')) : ?>
				<span class="mod-articles-category-writtenby">
					<?php echo $item->displayAuthorName; ?>
				</span>
			<?php endif;?>

			<?php if ($item->displayCategoryTitle) : ?>
				<span class="mod-articles-category-category">
					(<?php echo $item->displayCategoryTitle; ?>)
				</span>
			<?php endif; ?>

			<?php if ($item->displayDate) : ?>
				<span class="mod-articles-category-date">
					<?php echo $item->displayDate; ?>
				</span>
			<?php endif; ?>

			<?php if ($params->get('show_introtext')) : ?>
				<p class="mod-articles-category-introtext">
					<?php echo $item->displayIntrotext; ?>
				</p>
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
		</li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
	</div>
</div></div>