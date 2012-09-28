<?php

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

if ($this->countModules ( 'right or right1 or right2 or right-mid or right3 or right4 or right-bottom' )) {
	define('_RIGHT', 1);
	
	?>
	<aside id="tc-rightcol">
		<div class="tc-inner clearfix">
			<?php 
				if($mods= $this->getModules('right')) {
					$this->renderModules($mods,'tigra');					
				} 

				if($mods= $this->getModules('right1,right2')) {
					$this->renderModules($mods,'tigra');					
				}

				if($mods= $this->getModules('right-mid')) {
					$this->renderModules($mods,'tigra');					
				}	

				if($mods= $this->getModules('right3,right4')) {
					$this->renderModules($mods,'tigra');					
				}
				
				if($mods= $this->getModules('right-bottom')) {
					$this->renderModules($mods,'tigra');					
				} 			
			?>
		</div>
	</aside>
	<?php
}
?>