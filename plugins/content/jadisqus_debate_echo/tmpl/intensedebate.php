<?php
/**
 * ------------------------------------------------------------------------
 * JA Disqus Debate Echo plugin for J3x
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//IntenseDebate config
$account        = $this->plgParams->get('provider-intensdebate-account');

$url = str_replace('&amp;', '&', $this->_url );
?>

