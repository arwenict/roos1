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

if(!class_exists('plgCommunityWordfilter'))
{
	class plgCommunityWordfilter extends CApplications
	{
		var $name		= 'Wordfilter';
		var $_name		= 'wordfilter';
	
	    function plgCommunityWordfilter(& $subject, $config)
	    {
			parent::__construct($subject, $config);
	    }
	
		/**
		 * Replacement method which acts similarly to str_ireplace
		 * 
		 * access	private	 
		 * param	string	search	The text that should be searched for
		 * param	string	replace	The text that should be replaced
		 * param	string	subject	The text that is to be searched on
		 **/
		function _replace( $search , $replace , $subject )
		{
	
			// If str_ireplace already exists, we just use it. PHP5 only.
			if( function_exists( 'str_ireplace' ) )
				return str_ireplace( $search , $replace , $subject );
	
			$search		= preg_quote( $search , '/' );
			return preg_replace( '/' . $search . '/i' , $replace , $subject );
		}
	
	
		/**
		 * Censors the specific text based on the text that is given
		 * 
		 * access	private	 
		 * param	string	text	The text that should be checked against
		 **/
		function _censor( $text )
		{
			// Get the badwords that needs to be replaced
			$badwords	= $this->params->get( 'badwords' , '' );
			
			// If no badwords specified, just ignore everything else.
			if( empty( $badwords ) )
				return $text;
	
			// Get the replacement parameter
			$replacement	= $this->params->get( 'replacement' , '*' );
	
			// Split the words up based on the separator ','
			$badwords	= explode( ',' , $badwords );
                        
                        // Generate text to individual word.
                        $aWord = array();
                        $token = " `~!@#$%^&*()_+-=[]\{}|;':\",./<>?\n\t\r";
                        $tword = strtok($text, $token);
                                
                        while (false !== $tword) {
                            $aWord[] = $tword;
                            $tword   = strtok($token);
                        }
                        // reset token.
                        strtok('', '');

			foreach( $badwords as $word )
			{
                            // Trim all the badwords so that spaces will not be affected.
                            $word   = trim( strtolower($word) );

                            $filter = in_array($word, $aWord);
                            
                            if (!$filter) {
                               $filter = in_array(strtoupper($word), $aWord);     
                            }

                            if ($filter !== FALSE) {
                                $replace = '';    
                                // There is words that needs to be censored.
                                for( $i = 0; $i < JString::strlen( $word ); $i++ )
                                {
                                    $replace .= $replacement;
                                }
                                $text = $this->_replace( $word , $replace , $text );
                            }
			}
			return $text;
		}
		
		/**
		 * ->title
		 * ->comment 	 
		 */	 	
		function onWallDisplay( &$row )
		{
			CError::assert( $row->comment, '', '!empty', __FILE__ , __LINE__ );
			
			// Censor text
			$row->comment	= $this->_censor( $row->comment );
		}
		
		/**
		 * ->message
		 */	 	
		function onBulletinDisplay( &$row )
		{
			CError::assert( $row->message, '', '!empty', __FILE__ , __LINE__ );
			
			// Censor text
			$row->message	= $this->_censor( $row->message );
		} 
		
		/**
		 * ->message
		 */
		function onDiscussionDisplay( &$row ) {
			CError::assert( $row->message, '', '!empty', __FILE__ , __LINE__ );
			
			// Censor text
			$row->message	= $this->_censor( $row->message );
		} 
		
		function onMessageDisplay( &$row )
		{
			CError::assert( $row->body, '', '!empty', __FILE__ , __LINE__ );
			
			// Censor text
			$row->body	= $this->_censor( $row->body );
		}	
	
	}
}


