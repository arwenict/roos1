<?php
/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 Tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://www.tigracon.com 
-----------------------------------------------------------------*/

// set document type as text/javascript	
header('Content-type: text/css; charset: UTF-8');
header('Cache-Control: must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
$url = $_REQUEST['url'].'/css/PIE/pie.php';
?>
.mod-wrapper,
.module_none .mod-wrapper .mod-content,
.mod-wrapper h3.header,
div.pagination ul li a,div.pagination p.counter,
.mod-wrapper .mod-content,.module_menu .mod-wrapper li:last-child,
#hornav ul.level-0 > li.menu-item:hover > a.menu-item,
.tc_news_higlighter,.tc-nh-item,.tc_date,
ul.userlinks,
a.readmore,
a.tc-slide-morein,
.adminform button,
#adminForm button,
.button,button[type=submit],
input[type=submit],
input[type=button]
{position:relative;behavior: url(<?php echo $url; ?>)}