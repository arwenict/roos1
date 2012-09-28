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

require_once(dirname(__FILE__).DS.'lib'.DS.'tigra.php');
$app = JFactory::getApplication();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<?php
		$tigra->loadHead();
		$tigra->addCSS('system.css');
		if ($tigra->getDirection() == 'rtl') $tigra->addCSS('system_rtl.css');
		$tigra->favicon('favicon.ico');
	?>
</head>

<body class="offline_bg">
	<div id="top" class="offline-top">
	<jdoc:include type="message" />

	<p class="offline_message">
		<?php echo $app->getCfg('offline_message'); ?>
	</p>
	<div class="offline_message_bellow">
	</div>
	<form action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login">
<div class="input">
		<div id="form-login-username">
			<label for="username"><?php echo JText::_('JGLOBAL_USERNAME') ?></label>
			<input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('JGLOBAL_USERNAME') ?>" size="18" />
		</div>
		<div id="form-login-password">
			<label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
			<input type="password" name="password" class="inputbox" size="18" alt="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" id="passwd" />
		</div>
		</div></div>
	<div id="bottom" class="offline-bottom">
		<div id="form-login-remember">
			<label for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
			<input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" id="remember" />
		</div>
		<div id="form-login-button">
		<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
		<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
	</form>
	</div>

</body>
</html>
