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

$col = 3;
$count = $params->get('count');
$i = 0;
$db = JFactory::getDbo();
$idArr = array();
foreach ($list as $item)
	$idArr[] = $item->id;
$query = 'SELECT id, images FROM #__content WHERE id IN ('.implode(',', $idArr).')';
$db->setQuery($query);
$result = $db->loadObjectList();
$imgArr = array();
foreach ($result AS $res) {
	$imagesObj = json_decode($res->images);
	if (trim($imagesObj->image_intro) != '')
		$imgArr[$res->id] = $imagesObj->image_intro;
}
?>
<div class="relateditems article-list">
<?php foreach ($list as $item) : ?>
  <?php if ($i%$col==0) : ?>
  <div class="items-row cols-<?php echo $col; ?> <?php echo $moduleclass_sfx; ?>">  
    <div class="equal-height equal-height-child row">
  <?php endif; ?>
      <div class="item col column-1 col-sm-4">  
      <article> 
        <div class="item-content clearfix">
			<?php if (isset($imgArr[$item->id])) : ?>
			<div class="img-intro">
				<img class="img-responsive" src="<?php echo $imgArr[$item->id]; ?>" />
			</div>
			<?php endif;?>
			
			<div class="detail-related">
				<aside class="article-aside">
				  <dl class="article-info  muted">
					<dt class="article-info-term"></dt>
					<?php if ($showDate) : ?>
					<dd title="" class="published hasTooltip" data-original-title="Published: ">
					  <time itemprop="datePublished" datetime="<?php echo $item->created; ?>">
						  <?php echo JATemplateHelper::relTime($item->created); ?>
					  </time>
					</dd>
					<?php endif; ?>
				  </dl>
				</aside>
				<header class="article-header">
				<h2 itemprop="name" class="article-title">
				  <a title="<?php echo $item->title; ?>" itemprop="url" href="<?php echo $item->route; ?>">
					<?php echo $item->title; ?>
				  </a>
				</h2>
				</header>
			</div>
			  
        </div>
        </article>
      </div>
  <?php if ( ($i%$col==($col-1)) || $i==($count-1) ) : ?>
    </div></div>
  <?php endif; ?>
  <?php $i++; ?>
<?php endforeach; ?>
</div>