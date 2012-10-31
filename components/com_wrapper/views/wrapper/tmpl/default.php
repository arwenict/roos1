<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_wrapper
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<script type="text/javascript">
function iFrameHeight() {
	var h = 0;
	if (!document.all) {
		h = document.getElementById('blockrandom').contentDocument.height;
		document.getElementById('blockrandom').style.height = h + 60 + 'px';
	} else if (document.all) {
		h = document.frames('blockrandom').document.body.scrollHeight;
		document.all.blockrandom.style.height = h + 20 + 'px';
	}
}
</script>
<div id="overlay" class="popup-wrapper" >
    <div class="popup resizable">
        <div id='cpt_lghtbx' class="mid fixedBox" style='overflow-y:scroll;'>
            <a href="#" id="close-captions" onclick="javascript:closePopUp()" class="close">&nbsp;</a>
            <h2>Help <?php echo $this->params->get('page_title')  ?></h2>

            <div class="hightlight-box">
                <h3>Sub heading 1 </h3>
                <?php if ($this->params->get('page_title') == "Timetable") {?>
                <p>Timetable help</p>
                <?php } elseif ($this->params->get('page_title') == "Instructors") { ?>
                <p>Instructors help</p>
                <?php } elseif ($this->params->get('page_title') == "Attendance") { ?>
                <p>Attendance help</p>
                <?php } elseif ($this->params->get('page_title') == "Instructor Pay") { ?>
                <p>Instructor Pay help</p>
                <?php } elseif ($this->params->get('page_title') == "Class Stats") { ?>
                <p>Class Stats help</p>
                <?php } ?>
            </div>


        </div>
    </div>
</div>
<div class="contentpane<?php echo $this->pageclass_sfx; ?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1>
		<?php if ($this->escape($this->params->get('page_heading'))) :?>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		<?php else : ?>
			<?php echo $this->escape($this->params->get('page_title')); ?>
		<?php endif; ?>
	</h1>
<?php endif; ?>
<?php
if ($this->params->get('page_title') == "Timetable") 
    $styles = "float:right; position:absolute; right:45px; top:45px;";
else 
    $styles = "float:right; position:absolute; right:50px; top:20px;";


?>
<a style='<?php echo $styles ?>' href="#" id='open-help' onclick="javascript:openPopUp();"class="help-link"> </a>
<iframe <?php echo $this->wrapper->load; ?>
	id="blockrandom"
	name="iframe"
	src="<?php echo $this->escape($this->wrapper->url); ?>"
	width="<?php echo $this->escape($this->params->get('width')); ?>"
	height="<?php echo $this->escape($this->params->get('height')); ?>"
	scrolling="<?php echo $this->escape($this->params->get('scrolling')); ?>"
	frameborder="<?php echo $this->escape($this->params->get('frameborder', 1)); ?>"
	class="wrapper<?php echo $this->pageclass_sfx; ?>">
	<?php echo JText::_('COM_WRAPPER_NO_IFRAMES'); ?>
</iframe>
</div>
