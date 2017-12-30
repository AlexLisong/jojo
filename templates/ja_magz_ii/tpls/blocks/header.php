<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Template helper
JLoader::register('JATemplateHelper', T3_TEMPLATE_PATH . '/helper.php');

$currentMenu = JFactory::getApplication()->getMenu()->getActive();
$catid = '';
$logopath = '';
$catclass = '';
$logopathsm = '';
if ($currentMenu) {
	if ($currentMenu->query['option'] == 'com_content' && $currentMenu->query['view']=='category') {
		$catid = $currentMenu->query['id'];
		$catclass = JATemplateHelper::getCategoryClass($catid, false);
		$catclass = preg_replace('/\s+/', '', $catclass); 
	}
}

if ($catclass) {
	$logopath = 'images/joomlart/'.$catclass.'/logo.png';
	$logopathsm = 'images/joomlart/'.$catclass.'/logo-small.png';
} 


// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', T3Path::getUrl('images/logo.png', '', true)) : '';
$logoimgsm = ($logotype == 'image' && $this->params->get('enable_logoimage_sm', 0)) ? $this->params->get('logoimage_sm', T3Path::getUrl('images/logo-sm.png', '', true)) : false;

if (!$sitename) {
	$sitename = JFactory::getConfig()->get('sitename');
}

$logosize = 'col-md-4';
if ($headright = $this->countModules('head-search or languageswitcherload')) {
	$logosize = 'col-md-4';
}
?>

<!-- HEADER -->
<header id="t3-header" class="t3-header wrap">
	<div class="container">
		<div class="row">
			<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
				<?php $this->loadBlock ('off-canvas') ?>
			<?php endif ?>
				
			<!-- LOGO -->
			<div class="col-xs-12 <?php echo $logosize ?> logo">
				<div class="logo-<?php echo $logotype, ($logoimgsm ? ' logo-control' : '') ?>">
					<a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
						<?php if($logotype == 'image'): ?>
							<?php if ($catclass) { ?>
							<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logopath ?>" alt="<?php echo strip_tags($sitename) ?>" />
							<?php } else { ?>
							<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
							<?php } ?>
						<?php endif ?>
						<?php if($logoimgsm) : ?>
							<?php if ($catclass) { ?>
							<img class="logo-img-sm" src="<?php echo JURI::base(true) . '/' . $logopathsm ?>" alt="<?php echo strip_tags($sitename) ?>" />
							<?php } else { ?>
							<img class="logo-img-sm" src="<?php echo JURI::base(true) . '/' . $logoimgsm ?>" alt="<?php echo strip_tags($sitename) ?>" />
							<?php } ?>
						<?php endif ?>
						<span><?php echo $sitename ?></span>
					</a>
					<small class="site-slogan"><?php echo $slogan ?></small>
				</div>
			</div>
			<!-- //LOGO -->

			<?php if ($headright): ?>
				<div class="headright">
					<?php if ($this->countModules('head-search')) : ?>
						<!-- HEAD SEARCH -->
						<div class="head-search <?php $this->_c('head-search') ?>">
							<i class="fa fa-search"></i>
							<jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
						</div>
						<!-- //HEAD SEARCH -->
					<?php endif ?>
					
					<?php if ($this->countModules('languageswitcherload')) : ?>
						<!-- LANGUAGE SWITCHER -->
						<div class="languageswitcherload">
							<jdoc:include type="modules" name="<?php $this->_p('languageswitcherload') ?>" style="raw" />
						</div>
						<!-- //LANGUAGE SWITCHER -->
					<?php endif ?>
					
					<?php if ($this->countModules('head-social')) : ?>
						<!-- HEAD SOCIAL -->
						<div class="head-social <?php $this->_c('head-social') ?>">
							<jdoc:include type="modules" name="<?php $this->_p('head-social') ?>" style="raw" />
						</div>
						<!-- //HEAD SOCIAL -->
					<?php endif ?>
				</div>
			<?php endif ?>

		</div>
	</div>
</header>
<!-- //HEADER -->