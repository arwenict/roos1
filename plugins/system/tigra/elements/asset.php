<?php
/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 Tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://www.tigracon.com 
-----------------------------------------------------------------*/

defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField
{
	protected	$type = 'Asset';
	
	protected function getInput() {
		$doc = & JFactory::getDocument();
		$plg_path = JURI::root().'/plugins/system/tigra/elements/';	
		if($this->element['assettype'] == 'js') {
			return $doc->addScript($plg_path . $this->element['filename']);
		} else {
			return $doc->addStyleSheet($plg_path . $this->element['filename']);   
		}	
	}
} 
?>