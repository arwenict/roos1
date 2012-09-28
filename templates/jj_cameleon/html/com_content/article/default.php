<?php
/**
 * @version		$Id: default.php 20817 2011-02-21 21:48:16Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

// Create shortcuts to some parameters.
$params		= $this->item->params;
$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();
?>
<div class="item-page<?php echo $this->pageclass_sfx?>">
<?php 
if ($params->get('show_title')
|| ($params->get('show_create_date'))
|| ($params->get('show_publish_date'))
|| ($params->get('show_author') && !empty($this->item->author ))
|| ($params->get('show_category')) 
|| ($params->get('show_parent_category'))	
|| ($params->get('show_print_icon')) 
|| ($params->get('show_email_icon'))
|| ($params->get('show_hits')) 
|| $canEdit): 
?>
<div class="article-tools clearfix">
<?php if ($params->get('show_create_date')) : ?>
	<?php
		$date_format 	= JHTML::_('date', $this->item->created, JText::_('DATE_FORMAT_LC4')); 
		$date_display 	= explode(".",$date_format);
		$format_date	= date("d-M-Y", @mktime(0, 0, 0, $date_display[1], $date_display[0], $date_display[2]));
		$final_date 	= explode("-",$format_date);
		$output = "<div class=\"tc_date\">
					<div class=\"tc_date_month\">".$final_date[1]."</div>
					<div class=\"tc_date_day\">".$final_date[0]."</div>
					</div>";
		echo $output;
	?>
<?php endif; ?>

<?php if ($params->get('show_title')) : ?>
	<h2>
		<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
			<?php echo $this->escape($this->item->title); ?></a>
		<?php else : ?>
			<?php echo $this->escape($this->item->title); ?>
		<?php endif; ?>
	</h2>
<?php endif; ?>

<?php 
if ($params->get('show_publish_date')
|| ($params->get('show_author') && !empty($this->item->author ))
|| ($params->get('show_category')) 
|| ($params->get('show_parent_category'))	
|| ($params->get('show_print_icon')) 
|| ($params->get('show_email_icon'))
|| ($params->get('show_hits')) 
|| $canEdit): 
?>
<dl class="article-info">
	<?php if ($params->get('show_publish_date')) : ?>
			<dd class="published">
			<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE', JHTML::_('date',$this->item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?>
			</dd>
	<?php endif; ?>	

	<?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
		<dd class="createdby"> 
			<?php $author =  $this->item->author; ?>
			<?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);?>

				<?php if (!empty($this->item->contactid ) &&  $params->get('link_author') == true):?>
					<?php 	echo JText::sprintf('COM_CONTENT_WRITTEN_BY' , 
					 JHTML::_('link',JRoute::_('index.php?option=com_contact&view=contact&id='.$this->item->contactid),$author)); ?>

				<?php else :?>
					<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
				<?php endif; ?>
		</dd>
	<?php endif; ?>	

	<?php if (($params->get('show_category')) || ($params->get('show_parent_category'))) : ?>
	
	<?php if ($params->get('show_parent_category')) : ?>
			<dd class="parent-category-name">
				<?php $title = $this->escape($this->item->parent_title);
					$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)) . '">' . $title . '</a>'; ?>
				<?php if ($params->get('link_parent_category') AND $this->item->parent_slug) : ?>
					<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
					<?php else : ?>
					<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
				<?php endif; ?>
			</dd>
	<?php endif; ?>
	<?php if ($params->get('show_category')) : ?>
			<dd class="category-name">
				<?php $title = $this->escape($this->item->category_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';?>
				<?php if ($params->get('link_category') AND $this->item->catslug) : ?>
					<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
					<?php else : ?>
					<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
				<?php endif; ?>
			</dd>
	<?php endif; ?>
	
	<?php endif; ?>
	
	<?php if ($params->get('show_hits')) : ?>
			<dd class="hits">
			<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
			</dd>
	<?php endif; ?>			
</dl>

<?php if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
	<ul class="buttonheading">
		<?php if ($params->get('show_print_icon')) : ?>
		<li class="print-icon">
			<?php echo JHtml::_('icon.print_popup', $this->item, $params); ?>
		</li>
		<?php endif; ?>
		<?php if ($params->get('show_email_icon')) : ?>
		<li class="email-icon">
			<?php echo JHtml::_('icon.email', $this->item, $params); ?>
		</li>
		<?php endif; ?>
		<?php if ($canEdit) : ?>
		<li class="edit-icon">
			<?php echo JHtml::_('icon.edit', $this->item, $params); ?>
		</li>
		<?php endif; ?>
	</ul>
<?php endif; ?>
<?php endif; ?>
</div>
<?php endif; ?>

<?php  if (!$params->get('show_intro')) :
	echo $this->item->event->afterDisplayTitle;
endif; ?>

<?php if (isset ($this->item->toc)) : ?>
	<?php echo $this->item->toc; ?>
<?php endif; ?>

<?php if ($params->get('show_modify_date')) : ?>
		<dd class="modifydate">
		<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHTML::_('date',$this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
		</dd>
<?php endif; ?>

<?php if ($params->get('access-view')):?>
	<?php echo $this->item->text; ?>
	
	<?php //optional teaser intro text for guests ?>
<?php elseif ($params->get('show_noauth') == true AND  $user->get('guest') ) : ?>
	<?php echo $this->item->introtext; ?>
	<?php //Optional link to let them register to see the whole article. ?>
	<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
		$link1 = JRoute::_('index.php?option=com_users&view=login');
		$link = new JURI($link1);?>
		<p class="readmore">
		<a href="<?php echo $link; ?>">
		<?php $attribs = json_decode($this->item->attribs);  ?> 
		<?php 
		if ($attribs->alternative_readmore == null) :
			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
		elseif ($readmore = $this->item->alternative_readmore) :
			echo $readmore;
			if ($params->get('show_readmore_title', 0) != 0) :
			    echo JHTML::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
			endif;
		elseif ($params->get('show_readmore_title', 0) == 0) :
			echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');	
		else :
			echo JText::_('COM_CONTENT_READ_MORE');
			echo JHTML::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
		endif; ?></a>
		</p>
	<?php endif; ?>
<?php endif; ?>
<?php echo $this->item->event->afterDisplayContent; ?>
</div>
