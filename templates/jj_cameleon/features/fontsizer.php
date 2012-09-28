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

<?php if ($this->getParam('fontsizer')) { ?>
<div class="font-sizer">
	<a class="btn_fs_big" title="Increase font size" rel="nofollow" href="?font_size=big">A+</a>
	<a class="btn_fs_reset" title="Reset font size" rel="nofollow" href="?font_size=reset">R</a>
	<a class="btn_fs_small" title="Decrease font size" rel="nofollow" href="?font_size=small">A-</a>
</div>
<?php
	$font_size  = isset($_COOKIE[$this->theme . '_font_size']) ? $_COOKIE[$this->theme . '_font_size'] : 'reset';
	if(isset($_GET['font_size'])) {
		setcookie($this->theme . '_font_size', $_GET['font_size'], time() + 3600*30, '/'); 
		$font_size = $_GET['font_size'];
	}
	if ($font_size=='big') {
		$this->API->addStyleDeclaration('body {font-size:14px}');	
	} elseif ($font_size=='small') {
		$this->API->addStyleDeclaration('body {font-size:11px}');	
	}
?>
<?php } ?>