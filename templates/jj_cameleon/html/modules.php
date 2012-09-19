<?php

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');
?>

<?php
function modChrome_tigra($module, $params, $attribs)
{
if (!empty ($module->content)) : ?>
        <?php if ($params->get('moduleclass_sfx')!='') : ?>
        <div class="<?php echo $params->get('moduleclass_sfx'); ?>">
        <?php endif; ?>	
		<div class="mod-wrapper">
		<?php if ($module->showtitle != 0) : ?>
			<div class="module-title">
                	<h3 class="title"><?php echo $module->title; ?></h3>
				</div>
                <?php endif; ?><div class="inner">
                <?php echo $module->content; ?></div><div class="clr"></div>
            </div>
        <?php if ($params->get('moduleclass_sfx')!='') : ?>
        </div>
	<?php endif; ?>
	<?php endif;

}



function modChrome_tc_raw($module, $params, $attribs)
{ 
	echo $module->content; 
}

function modChrome_tc_menu($module, $params, $attribs)
{ ?>
	<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">	
		<div class="mod-wrapper-menu clearfix">		
		<?php if ($module->showtitle != 0) { ?>
				<h3 class="header">			
				<?php 
					$title=explode(' ',$module->title);
					$title[0] = '<span>'.$title[0].'</span>';
					$title= join(' ', $title);
					echo $title; 
				?>
				</h3>
				<?php
					$modsfx=$params->get('moduleclass_sfx');
					if ($modsfx !='') echo '<span class="badge' . $modsfx . '"></span>';
				?>
			<?php } ?>
			<?php echo $module->content; ?>
		</div>
	</div>
	<?php
}

?>