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


defined('_JEXEC') or die;
// Template helper
JLoader::register('JATemplateHelper', T3_TEMPLATE_PATH . '/helper.php');

$currentMenu = JFactory::getApplication()->getMenu()->getActive();
$catid = '';
$catclass = '';
if ($currentMenu) {
  if ($currentMenu->query['option'] == 'com_content' && $currentMenu->query['view']=='category') {
    $catid = $currentMenu->query['id'];
    $catclass = JATemplateHelper::getCategoryClass($catid, false);
    $catclass = preg_replace('/\s+/', '', $catclass);
    $logopath = T3Path::getUrl('images/logo.png', '', true);
  }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"
	  class='<jdoc:include type="pageclass" />'>

<head>
	<jdoc:include type="head" />
	<?php $this->loadBlock('head') ?>
</head>

<body class="<?php echo $catclass; ?>">

<div class="t3-wrapper"> <!-- Need this wrapper for off-canvas menu. Remove if you don't use of-canvas -->

  <?php $this->loadBlock('header') ?>

  <?php $this->loadBlock('mainnav') ?>

  <?php $this->loadBlock('banner-top') ?>
  
  <?php $this->loadBlock('masthead') ?>

  <?php $this->loadBlock('mainbody-content-left') ?>

  <?php $this->loadBlock('sections') ?>

  <?php $this->loadBlock('banner-bottom') ?>

  <?php $this->loadBlock('navhelper') ?>

  <?php $this->loadBlock('footer') ?>

</div>

</body>

</html>