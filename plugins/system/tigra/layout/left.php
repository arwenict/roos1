<?php

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

if ($this->countModules ( 'left or left1 or left2 or left-mid or left3 or left4 or left-bottom' )) {
	define('_LEFT', 1);
	?>
	<aside id="tc-leftcol">
		<div class="tc-inner clearfix">
			<?php 
				if($mods= $this->getModules('left')) {
					$this->renderModules($mods,'tigra');					
				} 

				if($mods= $this->getModules('left1,left2')) {
					$this->renderModules($mods,'tigra');					
				}

				if($mods= $this->getModules('left-mid')) {
					$this->renderModules($mods,'tigra');					
				}	

				if($mods= $this->getModules('left3,left4')) {
					$this->renderModules($mods,'tigra');					
				}
				
				if($mods= $this->getModules('left-bottom')) {
					$this->renderModules($mods,'tigra');					
				} 			
			?>
			
		</div>
	</aside>
	<?php
}
?>