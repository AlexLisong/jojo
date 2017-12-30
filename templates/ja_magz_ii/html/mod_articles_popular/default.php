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
?>
<ul class="mostread <?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) :  ?>
  <li>
    <?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>
    <div class="item-content">
    <aside class="article-aside clearfix">
        <dl class="article-info  muted">
          <dt class="article-info-term"><?php echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?></dt>
          <dd class="hits">
            <meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>" />
            <?php echo JText::sprintf('TPL_COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
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
