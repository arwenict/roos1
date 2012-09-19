<?php
/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 euCSO. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://tigra.eucso.info
-----------------------------------------------------------------*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');
?>

<?php if($this->getParam('showtop')) { ?>
	<a id="topofpage" href="#" rel="nofollow"><?php echo JText::_('GOTO_TOP') ?></a>
	<?php $this->addJS('totop.js'); ?>
<?php } ?>