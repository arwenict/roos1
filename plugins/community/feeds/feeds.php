<?php
/**
 * @category	Plugins
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php');

class plgCommunityFeeds extends CApplications
{
	var $name		= 'Feeds';
	var $_name		= 'feeds';
	var $_user		= null;
			
	function onProfileDisplay()
	{
		JPlugin::loadLanguage( 'plg_community_feeds', JPATH_ADMINISTRATOR );
	
		$css	= ( C_JOOMLA_15 ) 
				? 'plugins/community/feeds/' 
				: 'plugins/community/feeds/feeds/';
		CAssets::attach( 'style.css' , 'css' , $css );
		$model 	= CFactory::getModel('profile');
		$my		= CFactory::getUser();
		$user	= CFactory::getRequestUser();
		$this->loadUserParams();
		$mainframe	=& JFactory::getApplication();
		$data		= $model->getViewableProfile( $user->id );
		$path		= $this->userparams->get( 'path' , '' );
		$limit		= $this->userparams->get( 'count' , '' );
		$cacheable	= $this->params->get( 'cache' , 1 );
		$cacheable	= $cacheable ? $mainframe->getCfg( 'caching' ) : $cacheable;

		$cache		=& JFactory::getCache('community');
		$cache->setCaching( $cacheable );
		$content	= $cache->call( array( $this, '_getFeedHTML') , $path, $limit, $this->getLayout() );

		return $content;
	}
	
	function _getFeedHTML( $url , $limit , $layout ) 
	{
		if( empty( $url ) )
		{
			ob_start();
			?>
			<div id="application-feeds">
				<div class="nopost">
					<img class="icon-nopost" src="<?php echo JURI::root();?>components/com_community/assets/error.gif" alt="" />
					<span class="content-nopost"><?php echo JText::_('PLG_FEEDS_INVALID_FEED_PATH');?></span>
				</div>
			</div>
			<?php
			$html	= ob_get_contents();
			ob_end_clean();
						
	        return $html;
		}
		
		jimport('simplepie.simplepie');
		$feed	= new SimplePie();
		$feed->set_feed_url( $url );
		$feed->init();
		
		$items	= $feed->get_items( 0 , $limit );
		
		switch($layout)
		{
			case "sidebar-top":
			case "sidebar-bottom":
				$content = plgCommunityFeeds::getWidgetLayout($items, $limit);
				break;
			case "content":
			default:
				$content = plgCommunityFeeds::getContentLayout($items, $limit);
				break;
		}
		
		return $content;
	}
	
	static public function getContentLayout($items, $limit)
	{
		ob_start();
		if(count($items) > 0)
		{
		?>
		<div id="application-feeds">
		<ul class="fdList">
        <?php
			for($i = 0; ($i < count($items) && ($i<$limit)); $i++)
			{
				$item =& $items[$i];
				$feed	= $item->get_feed(); 
        ?>
				<li class="fdListLi">
				<div class="fdDate">
                    <strong><?php echo $item->get_date('j'); ?></strong>
                    <?php echo $item->get_date('M'); ?>
                    <span><?php echo $item->get_date('Y'); ?></span>
                </div>
				
				<div class="fdContent">
                    <h1 class="fdTitle"><a href="<?php echo $item->get_permalink(); ?>" rel="nofollow"><?php echo $item->get_title(); ?></a></h1>
                    <?php echo $item->get_content(); ?>
				</div>
				
				<div class="fdClr">&nbsp;&nbsp;&nbsp;</div>
				</li>
		<?php
			}
		?>
		</ul>
		</div>
        <?php
		}
		else
		{
		?>
		 	<div id="application-feeds">
                <div class="nopost">
		            <img class="icon-nopost" src='<?php echo JURI::base() ?>components/com_community/assets/error.gif' alt='' />
		            <span class="content-nopost">
		               <?php echo JText::_('PLG_FEEDS_UNABLE_TO_READ_FEED_CONTENT');?>
		           </span>
				</div>
            </div>
		<?php
		}	
		$content	= ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
	static public function getWidgetLayout($items, $limit)
	{
		ob_start();
		if(count($items) > 0)
		{
		?>
			<div id="application-feeds">
			<ul class="fdList">
        <?php
			for($i = 0; ($i < count($items) && ($i<$limit)); $i++)
			{
				$item =& $items[$i];
				$feed	= $item->get_feed(); 
        ?>
			<li class="fdListLi">
                <div class="fdDate">
                    <strong><?php echo $item->get_date('j'); ?></strong>
                    <?php echo $item->get_date('M'); ?>
                    <span><?php echo $item->get_date('Y'); ?></span>
                </div>
                
                <div class="fdContent">
                    <h1 class="fdTitle"><a href="<?php echo $item->get_permalink(); ?>" rel="nofollow"><?php echo $item->get_title(); ?></a></h1>
                    <?php echo $item->get_content(); ?>
                </div>
                
                <div class="fdClr">&nbsp;&nbsp;&nbsp;</div>
			</li>
		<?php
			}
		?>
			</ul>
			</div>
        <?php
		}
		else
		{
		?>
		 	<div>
				<?php echo JText::_('PLG_FEEDS_UNABLE_TO_READ_FEED_CONTENT');?>
			</div>
		<?php
		}	
		$content	= ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
}
