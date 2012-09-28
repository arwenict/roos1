<?php

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

if ($this->countModules ( 'left' )) {
	define('_LEFT', 1);
	?>
	<aside id="tc-leftcol" class="minner">
		<div class="tc-inner clearfix">
			<?php 
				if($mods= $this->getModules('left')) {
					$this->renderModules($mods,'tigra');					
				} 

			?>
			
		</div>
	</aside>
	<?php
}
?>