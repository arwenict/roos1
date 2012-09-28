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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language;?>" >
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php
		$tigra->loadHead();

		$tigra->addCSS('template.css,joomla.css,system.css,modules.css,typography.css,custom.css');
		if ($tigra->getDirection() == 'rtl') $tigra->addCSS('template_rtl.css');
		$tigra->getStyle();
		$tigra->favicon('favicon.ico');
		$tigra->addJS('css3-mediaqueries.js,jj.js,html5.js');
	?>
<!--[if (gte IE 6)&(lte IE 8)&(!IEMobile)]>
		<script src="/js/selectivizr.js"></script>
	<![endif]-->
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

</head>
<?php $tigra->addFeature('ie6warn'); ?>
<body class="bg clearfix">
	<div class="tc-wrap clearfix">
		<?php $tigra->addFeature('toppanel'); ?>
		<header id="header" class="tc-inner clearfix">
			<?php $tigra->addFeature('logo') ?>	
			<?php $tigra->addFeature('fontsizer')?>	
			<?php if ($tigra->countModules('search')) { ?>
				<div id="search">
					<jdoc:include type="modules" name="search" />
				</div>
			<?php } ?>	
		</header>	
		<nav id="mainnav">	
		<div class="tc-inner clearfix">
			<?php $tigra->addFeature('nav')?>	
		</div>
		</nav>

		<?php if($tigra->countModules('slides')) { ?>	
			<section id="slides" class="tc-inner clearfix">
				<jdoc:include type="modules" name="slides" />			
			</section>				
		<?php } ?>	
	
		<?php if($mods= $tigra->getModules('user1,user2,user3,user4,user5,user6')) {  ?>
			<section id="tc-userpos" class="clearfix">
				<div class="tc-inner">
					<?php $tigra->renderModules($mods,'tigra');?>
				</div>
		
			</section>
		<?php } ?>

		<div id="main" class="minner">

<?php if($mods= $tigra->getModules ( 'left and right' )) : ?>
<section id="tc-maincol">

<?php else : ?> 

<?php if($mods= $tigra->getModules ( 'left' )) : ?>
<section id="tc-maincolmidl">
<?php endif; ?>	

<?php if($mods= $tigra->getModules ( 'right' )) : ?>
<section id="tc-maincolmidr">
<?php endif; ?>	

<section id="tc-maincolfull"> 

<?php endif; ?>	

<?php if($mods= $tigra->getModules('user-top')) { ?>
	<div id="user-top">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="user-top" style="tigra" />
		</div>
	</div>		
<?php } ?>
<!--Module Position content1 to content4-->
<?php if($mods= $tigra->getModules('content1,content2,content3,content4')) { ?>
	<div id="tc-content1" class="clearfix">
		<div class="tc-inner">
			<?php $tigra->renderModules($mods,'tigra');?>
		</div>					
	</div>
<?php } ?>			
<div class="clr"></div>
<?php if($mods= $tigra->getModules('inset1')) { ?>
	<div id="inset1">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="inset1" style="tigra" />
		</div>
	</div>		
<?php } ?>
<!--Component Area-->
<?php if (!$tigra->hideItem())  { ?>
	<article id="inner_content">
		<div class="tc-inner clearfix">
			<?php if((!$tigra->isFrontPage()) && ($this->countModules('breadcrumbs'))) { /* Module Position breadcrumbs */ ?>
				<div id="breadcrumbs" class="clearfix">
					<jdoc:include type="modules" name="breadcrumbs" />
				</div>
			<?php } ?>		
			<jdoc:include type="message" />
			<jdoc:include type="component" />
		</div>
	</article>
<?php } ?>
<?php if($mods= $tigra->getModules('inset2')) { ?>
	<div id="inset2">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="inset2" style="tigra" />
		</div>
	</div>		
<?php } ?>
<!--End Component Area-->
<div class="clr"></div>
<!--Module Position content5 to content8-->
<?php if($mods= $tigra->getModules('content5,content6,content7,content8')) { ?>
	<div id="tc-content2" class="clearfix">
		<div class="tc-inner">
			<?php $tigra->renderModules($mods,'tigra');?>
		</div>					
	</div>
<?php } ?>
<?php if($mods= $tigra->getModules('user-bottom')) { ?>
	<div id="user-bottom">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="user-bottom" style="tigra" />
		</div>
	</div>	
<?php } ?>
</section>
</div>

<?php if($mods= $tigra->getModules ( 'left' ))

$tigra->loadLayout('left'); ?>

<?php if($mods= $tigra->getModules ( 'right' )) 

$tigra->loadLayout('right'); ?> 
	
		<div style="clear:left;"></div>

	<?php if($mods= $tigra->getModules('bottom1,bottom2,bottom3,bottom4,bottom5,bottom6')) { ?>
		<section id="tc-bottom" class="clearfix" >
			<div class="tc-inner">	
			<?php $tigra->renderModules($mods,'tigra');?>
			</div>
		</section>	
	<?php } ?>
	
	<?php if($mods= $tigra->getModules('menu-mob')) { ?>
	<div id="menu-mob">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="menu-mob" style="tigra" />
		</div>
	</div>	
	<?php } ?>
		
	<!--Footer-->
	<footer id="tc-footer" class="clearfix">
		<div class="tc-inner">	
			<div class="cp">
			<?php $tigra->addFeature('copyright') ?>
			</div>	
		<?php $tigra->addFeature('totop'); ?>		
		<?php if ($tigra->countModules('footer-nav')){ ?>
			<div id="footer-nav">
				<jdoc:include type="modules" name="footer-nav" />
			</div>
		<?php } ?>
		<div class="clr"></div>
		<?php $tigra->addFeature('tigralogo'); ?>
		</div>	
	</footer>

	</div>
	<?php $tigra->addFeature('analytics'); ?>
	<?php $tigra->addFeature('jquery');?>
	<?php $tigra->addFeature('ieonly'); ?>
	<?php $tigra->compress();  ?>	
	<?php $tigra->getFonts()?>	
	<jdoc:include type="modules" name="debug" />
<script type="text/javascript">
window.addEvent('load', function () {
var columnizer = new Equalizer('#tc-userpos .inner').equalize('height');
new Equalizer('#tc-bottom  .inner').equalize('height');
new Equalizer('#tc-content1 .inner').equalize('height');
new Equalizer('#tc-content2 .inner').equalize('height');
new Equalizer('#inset1 .inner').equalize('height');
new Equalizer('#inset2 .inner').equalize('height');
new Equalizer('.tc-wrap .minner').equalize('height');
});
</script>
</body>
</html>
