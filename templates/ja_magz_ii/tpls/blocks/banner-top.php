<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php if ($this->countModules('banner-top')) : ?>
	<!-- Banner Top -->
	<div class="wrap t3-banner t3-banner-top<?php $this->_c('banner-top') ?>">
		<div class="container">
			<jdoc:include type="modules" name="<?php $this->_p('banner-top') ?>" />
		</div>
	</div>
	<!-- //Banner Top -->
<?php endif ?>
