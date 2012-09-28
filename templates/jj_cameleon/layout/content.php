<?php

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');
?>

<section id="tc-maincol" class="minner">

<?php if($this->countModules('user-top')) { ?>
	<div id="user-top">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="user-top" style="tigra" />
		</div>
	</div>		
<?php } ?>
<!--Module Position content1 to content4-->
<?php if($mods= $this->getModules('content1,content2,content3,content4')) { ?>
	<div id="tc-content1" class="clearfix">
		<div class="tc-inner">
			<?php $this->renderModules($mods,'tigra');?>
		</div>					
	</div>
<?php } ?>			
<div class="clr"></div>
<?php if($this->countModules('inset1')) { ?>
	<div id="inset1">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="inset1" style="tigra" />
		</div>
	</div>		
<?php } ?>
<!--Component Area-->
<?php if (!$this->hideItem())  { ?>
	<article id="inner_content">
		<div class="tc-inner clearfix">
			<?php if((!$this->isFrontPage()) && ($this->countModules('breadcrumbs'))) { /* Module Position breadcrumbs */ ?>
				<div id="breadcrumbs" class="clearfix">
					<jdoc:include type="modules" name="breadcrumbs" />
				</div>
			<?php } ?>		
			<jdoc:include type="message" />
			<jdoc:include type="component" />
		</div>
	</article>
<?php } ?>
<?php if($this->countModules('inset2')) { ?>
	<div id="inset2">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="inset2" style="tigra" />
		</div>
	</div>		
<?php } ?>
<!--End Component Area-->
<div class="clr"></div>
<!--Module Position content5 to content8-->
<?php if($mods= $this->getModules('content5,content6,content7,content8')) { ?>
	<div id="tc-content2" class="clearfix">
		<div class="tc-inner">
			<?php $this->renderModules($mods,'tigra');?>
		</div>					
	</div>
<?php } ?>
<?php if($this->countModules('user-bottom')) { ?>
	<div id="user-bottom">
		<div class="tc-inner clearfix">
			<jdoc:include type="modules" name="user-bottom" style="tigra" />
		</div>
	</div>	
<?php } ?>
</section>
