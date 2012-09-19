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

<?php if($this->getParam('showtop')) { ?>
	<a id="topofpage" href="#" rel="nofollow"><?php echo JText::_('GOTO_TOP') ?></a>
	<?php $this->addJS('totop.js'); ?>
<?php } ?>