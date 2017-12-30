<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php if ($this->countModules('banner-bottom')) : ?>
	<!-- Banner Bottom -->
	<div class="wrap t3-banner t3-banner-bottom<?php $this->_c('banner-bottom') ?>">
		<div class="container">
			<jdoc:include type="modules" name="<?php $this->_p('banner-bottom') ?>" />
		</div>
	</div>
	<!-- //Banner Bottom -->
<?php endif ?>