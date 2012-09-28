<?php
/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 Tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://www.tigracon.com 
-----------------------------------------------------------------*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');
?>

<?php if /*--- Module Position panel1 to panel6 ---*/ ($mods= $this->getModules('panel1,panel2,panel3,panel4,panel5,panel6')) { ?>
<!--Start Top Panel-->
<div class="tc-toppanel-wrap clearfix">
	<div id="tc-toppanel" class="clearfix">
		<div class="tc-wrap clearfix">
			<div id="tc-top" class="tc-inner clearfix">
				<?php $this->renderModules($mods,'tc_flat');?>
			</div>
			<div id="toppanel-handler">
				<div class="handler-left">
					<div class="handler-right">
						<div class="handler-mid">
							<?php echo JText::_('TOP_PANEL') ?>
						</div>	
					</div>	
				</div>	
			</div>
		</div>
	</div>
</div>
<?php $this->addCSS('toppanel.css') ?>
<?php $this->addJS('toppanel.js') ?>
<!--End Top Panel-->
<?php } ?>