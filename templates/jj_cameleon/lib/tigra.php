<?php

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

$docs = JFactory::getDocument();
$tigra_path = JPATH_PLUGINS.DS.'system'.DS.'tigra'.DS.'core'.DS.'class.helper.php';
if (file_exists($tigra_path)) {
    require_once($tigra_path);
	$tigra = new tigraHelper($docs);
}
else {
    echo JText::_('Tigra framework not found.');
    die;
}
