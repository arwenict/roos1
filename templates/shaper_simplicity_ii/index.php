<?php
/*---------------------------------------------------------------
# Package - Joomla Template based on Helix Framework   
# ---------------------------------------------------------------
# Template Name - Shaper Simplicity - II
# Template Version 1.0.0
# ---------------------------------------------------------------
# Author - JoomShaper http://www.joomshaper.com
# Copyright (C) 2010 - 2012 JoomShaper.com. All Rights Reserved.
# license - PHP files are licensed under  GNU/GPL V2
# license - CSS  - JS - IMAGE files  are Copyrighted material 
# Websites: http://www.joomshaper.com - http://www.joomxpert.com
-----------------------------------------------------------------*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');
require_once(dirname(__FILE__).DS.'lib'.DS.'helix.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language;?>" >
<head>
	<?php
		$helix->loadHead();
		$helix->addCSS('template.css,joomla.css,custom.css,modules.css,typography.css,css3.css');
		if ($helix->getDirection() == 'rtl') $helix->addCSS('template_rtl.css');
		$helix->getStyle();
		$helix->favicon('favicon.ico');
	?>
</head>
<?php $helix->addFeature('ie6warn'); ?>
<body class="bg clearfix">
	<div class="bg1">
	<div class="sp-wrap main-bg clearfix">
		<?php $helix->addFeature('toppanel'); ?>
		<div id="header" class="clearfix">
			<?php $helix->addFeature('logo') /*--- Add logo ---*/?>	
			<?php $helix->addFeature('fontsizer') /*--- Font resizer ---*/?>	
			<?php if ($helix->countModules('search')) { /*--- Search Module ---*/?>
				<div id="search">
					<jdoc:include type="modules" name="search" />
				</div>
			<?php } ?>	
		</div>		
		<?php $helix->addFeature('hornav') /*--Main Navigation--*/?>	
		
		<!--Module Position slides-->	
		<?php if($helix->countModules('slides')) { /*--- Slideshow module ---*/?>	
			<div id="slides" class="sp-inner clearfix">
				<jdoc:include type="modules" name="slides" />			
			</div>	
		<?php } ?>	
	
		<!--Module Position user1 to user4-->
		<?php if($mods= $helix->getModules('user1,user2,user3,user4,user5,user6')) { ?>
			<div id="sp-userpos" class="clearfix">
				<div class="sp-inner">
					<?php $helix->renderModules($mods,'sp_xhtml','eqHeight');?>
				</div>
			</div>
			<?php $helix->fixHeight('eqHeight') /*Equal height for eqHeight class*/?>
		<?php } ?>
	
		<?php $helix->loadLayout(); /*--Load mainbody layout--*/?>
		
		<!--Module Position breadcrumbs-->
		<?php if($helix->countModules('breadcrumbs')) { ?>
			<div class="clr"></div>
			<div id="breadcrumbs" class="sp-inner clearfix">
				<jdoc:include type="modules" name="breadcrumbs" />
				<?php $helix->addFeature('totop') ?>
			</div>	
		<?php } ?>
		
		<!--Module Position bottom1 to bottom6-->
		<?php if($mods= $helix->getModules('bottom1,bottom2,bottom3,bottom4,bottom5,bottom6')) { ?>
			<div id="sp-bottom" class="clearfix">
				<div class="sp-inner">
					<?php $helix->renderModules($mods,'sp_flat','equal');?>
				</div>
			</div>
		<?php } ?>
		</div>
		</div>
		
		<!--Footer-->
		<div id="sp-footer" class="clearfix">
			<div class="sp-wrap">
				<div class="sp-inner">
					<?php $helix->addFeature('helixlogo'); /*--- Helix logo ---*/?>	
					<div class="cp">
						<?php $helix->addFeature('copyright') /*--- Show copyright ---*/?>
						<?php $helix->addFeature('brand') /*--You are not allowed to remove or modify brand link. You need to purchase copyright removal license from http://www.joomshaper.com/copyright-removal-license.html in order to remove this link.--*/ ?>
						<?php $helix->addFeature('jcredit') /*--- Joomla credit link ---*/?>
						<?php $helix->addFeature('validator') /*--- CSS and XHTML validator ---*/?>
					</div>
					<?php if ($helix->countModules('footer-nav')) /*--- Module position footer-nav ---*/{ ?>
						<div id="footer-nav">
							<jdoc:include type="modules" name="footer-nav" />
						</div>
					<?php } ?>				
				</div>
			</div>
		</div>
	</div>
	
	<?php $helix->addFeature('analytics'); /*--- Google analytics tracking code ---*/?>
	<?php $helix->addFeature('jquery'); /*--- Load jQuery library ---*/?>
	<?php $helix->addFeature('ieonly'); /*--- IE only Feature ---*/?>
	<?php $helix->getFonts() /*--- Standard and Google Fonts ---*/?>	
	<?php $helix->compress(); /* --- Compress CSS and JS files --- */ ?>	
	
	<jdoc:include type="modules" name="debug" />
</body>
</html>
