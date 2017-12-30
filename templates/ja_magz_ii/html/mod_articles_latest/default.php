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

// Template helper
JLoader::register('JATemplateHelper', T3_TEMPLATE_PATH . '/helper.php');

?>
<ul class="latestnews<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) :  ?>
	<li>
    <?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>
    <div class="item-content">
    <aside class="article-aside clearfix">
        <dl class="article-info  muted">
          <dt class="article-info-term"><?php echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?></dt>
          <dd title="" class="published hasTooltip" data-original-title="Published: ">
            <time itemprop="datePublished" datetime="<?php echo $item->publish_up; ?>"><?php echo JATemplateHelper::relTime($item->publish_up); ?></time>
          </dd>
      </dl>
    </aside>

		<a href="<?php echo $item->link; ?>" itemprop="url">
			<span itemprop="name">
				<?php echo $item->title; ?>
			</span>
		</a>
    </div>
	</li>
<?php endforeach; ?>
</ul>
