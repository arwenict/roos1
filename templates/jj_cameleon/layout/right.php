<?php

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

if ($this->countModules ( 'right' )) {
	define('_RIGHT', 1);
	
	?>
	<aside id="tc-rightcol" class="minner">
		<div class="tc-inner clearfix">
			<?php 
				if($mods= $this->getModules('right')) {
					$this->renderModules($mods,'tigra');					
				} 
		
			?>
		</div>
	</aside>
	<?php
}
?>