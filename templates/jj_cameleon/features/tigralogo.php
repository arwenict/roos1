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

<?php
	if ($this->getParam('show_tigra_logo')) {
	$tigra_url='http://tigra.eucso.info';
	$tigra_title='Tigra Framework';
	$tigra_logo=$this->getParam('tigra_logo');
?>
<div id="powered-by" class="tigra-logo tigra-logo-<?php echo $tigra_logo ?>">
	<a target="_blank" title="<?php echo $tigra_title ?>" href="<?php echo $tigra_url ?>"><?php echo $tigra_title ?></a>
</div> 
<?php } ?>