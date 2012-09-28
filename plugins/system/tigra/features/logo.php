<?php
/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 Tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://www.tigracon.com 
-----------------------------------------------------------------*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');
?>

<?php if ($this->getParam('logo_type')=='image') { ?>
	<a id="logo" style="width:<?php echo $this->getParam('logo_width') ?>px;height:<?php echo $this->getParam('logo_height') ?>px" href="<?php echo $this->baseUrl?>"></a>
<?php } else { ?>
	<div id="logo-text" style="width:<?php echo $this->getParam('logo_width') ?>px;height:<?php echo $this->getParam('logo_height') ?>px">
		<h1><a title="<?php echo $this->getSitename() ?>" href="<?php echo $this->baseUrl ?>"><span><?php echo $this->getParam('logo_text') ?></span></a></h1>
		<p class="site-slogan"><?php echo $this->getParam('logo_slogan') ?></p>
	</div>
<?php } ?>