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
class JFormFieldTitle extends JFormField
{
	protected $type = 'Title';	
	protected function getInput() {
		$html = '<span class="tab-text">' . $this->element['label'] . '</span>';
		return $html;	
	}	
}