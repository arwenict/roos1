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

jimport('joomla.filesystem.file');
class tigraHelper {
	var $API;
	var $tigraPath;
	var $tigraUrl;
	var $theme;
	var $themePath;
	var $themeUrl;
	var $basePath;
	var $baseUrl;
	
	//initialize 
    function __construct($_this){
		$this->API=$_this;
		$this->theme=$_this->template;
		$this->basePath=JPATH_BASE;
		$this->baseUrl=$_this->baseurl;
		$this->themePath=$this->basePath .DS. 'templates' .DS. $this->theme;	
		$this->themeUrl=$this->baseUrl . '/templates/'. $this->theme;		
		$this->tigraPath=JPATH_PLUGINS .DS. 'system' .DS.'tigra';		
		$this->tigraUrl= $this->baseUrl . '/plugins/system/tigra';
    }
	
	//get parameter
	function getParam($paramName, $default=null){
		return $this->API->params->get($paramName, $default);
	}
	
	//set parameter
	function setParam($paramName, $paramValue){
		return $this->API->params->set($paramName, $paramValue);
	}

	function import($path) {//import file
		$path=str_replace( '.', DS, $path );
		$filepath=$path . '.php';
		
		if(JFile::exists('templates'. DS. $this->theme . DS . $filepath)) { //cheack template path
            require_once('templates'. DS. $this->theme . DS . $filepath);
		} elseif(JFile::exists($this->tigraPath . DS . $filepath)) { //if not found, then check from tigra path
           require_once($this->tigraPath . DS . $filepath);
		} 
	}

		
  function loadLayout($layout) {//load left layout
		
			$this->import("layout.$layout");
	}


	function addFeature($feature) {
		$this->import("features.$feature");//import feature
	}
	
	function getFonts () {//function to add web and normal type font
		if ($this->getParam('body_selectors')!='') {
			$body_font=explode('|',$this->getParam('body_font'));
			$body_selectors=$this->getParam('body_selectors');
			$body_font_type=$body_font[0];
			$body_sfont_family=$body_font[1];
			$body_gfont_family=$body_font[2];
			($body_font_type=='google') ? $this->addGoggleFonts($body_gfont_family,$body_selectors) : $this->addStandardFonts($body_sfont_family,$body_selectors);
		}

		if ($this->getParam('header_selectors')!='') {
			$header_font=explode('|',$this->getParam('header_font'));
			$header_selectors=$this->getParam('header_selectors');
			$header_font_type=$header_font[0];
			$header_sfont_family=$header_font[1];
			$header_gfont_family=$header_font[2];
			($header_font_type=='google') ? $this->addGoggleFonts($header_gfont_family,$header_selectors) : $this->addStandardFonts($header_sfont_family,$header_selectors);
		}

		if ($this->getParam('other_selectors')!='') {
			$other_font=explode('|',$this->getParam('other_font'));
			$other_selectors=$this->getParam('other_selectors');
			$other_font_type=$other_font[0];
			$other_sfont_family=$other_font[1];
			$other_gfont_family=$other_font[2];
			($other_font_type=='google') ? $this->addGoggleFonts($other_gfont_family,$other_selectors) : $this->addStandardFonts($other_sfont_family,$other_selectors);
		}
	}
	
	function addStandardFonts ($font_family,$selectors) {//standard fonts
		$this->API->addStyleDeclaration("$selectors { font-family: " . $font_family . " }");
	}

	function addGoggleFonts ($font_family,$selectors) {//Google fonts
		$this->API->addStyleSheet('http://fonts.googleapis.com/css?family='.str_replace(" ","+",$font_family));
		$googlefont = $font_family;
		if(stripos($googlefont, ':') !== FALSE) {
			$gfont_cut = stripos($googlefont, ':');
			$googlefont = substr($googlefont, 0, $gfont_cut);
		}
		$this->API->addStyleDeclaration("$selectors { font-family: '" . str_replace("+"," ",$googlefont) . "', 'Helvetica', arial, serif; }");
	}
	
	function addJS ($srcs) {//add javascript
		$srcs = explode (',',$srcs);
		if (!is_array($srcs)) $srcs = array($srcs);   
		foreach ($srcs as $src) {
			if(JFile::exists($this->themePath .DS. 'js' .DS. $src)) { //check template path
				$this->API->addScript($this->themeUrl . '/js/' . $src);
			} elseif(JFile::exists($this->tigraPath . '/js/' . $src)) { //if not found, then check from tigra path
			   $this->API->addScript($this->tigraUrl . '/js/' . $src);
			}		
		}
	}
	
	function addCSS ($srcs) {//Add stylesheets
		$srcs = explode (',',$srcs);
		if (!is_array($srcs)) $srcs = array($srcs);   
		foreach ($srcs as $src) {
			if(JFile::exists($this->themePath .DS. 'css' .DS. $src)) { //cheack template path
				$this->API->addStyleSheet($this->themeUrl . '/css/' . $src);
			} elseif(JFile::exists($this->tigraPath . '/css/' . $src)) { //if not found, then check from tigra path
			   $this->API->addStyleSheet($this->tigraUrl . '/css/' . $src);
			}		
		}
	}	

	function addInlineJS($code) {//add inline js code
		$this->API->addScriptDeclaration($code); 
	}

	function addInlineCSS($code) {//add inline css code
		$this->API->addStyleDeclaration($code);	
	}
	
	
	
	function hideItem() {//Itemid for hiding component area
		if ($this->getParam('hide_component')) {	
			$menu = JSite::getMenu();
			if (isset($menu->getActive()->id)) {
				$Itemid = $menu->getActive()->id;//Detect active menu item
				$hide_menu_items = $this->getParam('hide_menu_items');//Itemid to hide component area
				if ($hide_menu_items=='') return;//empty item
				if (!is_array($hide_menu_items)) $hide_menu_items = array($hide_menu_items);
				if (in_array($Itemid, $hide_menu_items)) return true;
			} 
		}	
	}
    
	function getSiteName() {//get site name
        $app = JFactory::getApplication();
        return $app->getCfg('sitename');
    }
	
    function countModules($modules) {
        return $this->API->countModules($modules);//Count Modules
    }
	
	function renderModules($mods,$style='tc_raw',$style='tc_menu',$style='tigra',$class='') {//Load modules
		$output='';
		foreach($mods as $mod) {
			$output	.='<div style="width:' . $mod['width'] . '%" class="tc-block '. $mod['sep'] . '">';
			$output	.='<div id="' . $mod['name'] . '" class="mod-block ' . $class . $mod['extra-css'] . '">';
			$output	.='<jdoc:include type="modules" name="' . $mod['name'] . '" style="' . $style . '" />';
			$output	.='</div>';	
			$output	.='</div>';		
		}	
		echo $output;
	}
	
    //check for module
    function hasModule($position){	
		$position = explode (',',$position);
		if (!is_array($position)) $position = array($position);           
		if(is_array($position)){    
			$modcount=0;
			$modules=array();
			foreach($position as $val){
				$val=trim($val);
				if($this->API->countModules($val)){
					array_push($modules,$val);
					$modcount++;
				} 
			}
			
			if($modcount==0){
				return false;
			}
			return $modules; 
		}
        
    }
	
    //render module
    function getModules($pos){
		$activeMod= $this->hasModule($pos);
		$max= count($activeMod);
		$width= round((100/$max),3);
        $count=1;
        if(is_array($activeMod)){
            $modules = array();
            foreach($activeMod as $val){
                if($count==1){
                    $modules[$count] = array(
                    'name'=>$val,
                    'width'=>$width,
                    'extra-css'=> ($max==1) ? ' single' : ' first',
                    'sep'=> ($max==1) ? '' : ' separator'
                    );  
                }
                elseif($count==$max){
                    $modules[$count] = array(
                    'name'=>$val,
                    'width'=>$width,
                    'extra-css'=> ' last',
                    'sep'=> ''
                    );  
                } 
                else{
                    $modules[$count] = array(
                    'name'=>$val,
                    'width'=>$width,
                    'extra-css'=> '',
                    'sep'=> ' separator'
                    );  
                }
                
				$count++;
            }  
            return $modules;
        }
        return false;
    }
	
	//Detect IE version
	function isIE($version = false) {   
		$agent=$_SERVER['HTTP_USER_AGENT'];  
		$found = strpos($agent,'MSIE ');  
		if ($found) { 
				if ($version) {
					$ieversion = substr(substr($agent,$found+5),0,1);   
					if ($ieversion == $version) return true;
					else return false;
				} else {
					return true;
				}
				
			} else {
					return false;
			}
		if (stristr($agent, 'msie'.$ieversion)) return true;
		return false;        
	}

	//get menutype	
	function getMenu() {
		$menutype  = isset($_COOKIE[$this->theme . '_menu']) ? $_COOKIE[$this->theme . '_menu'] : $this->API->params->get('tcmenu','css');
		if(isset($_GET['menu'])) {
			setcookie($this->theme . '_menu', $_GET['menu'], time() + 3600, '/'); 
			$menutype = $_GET['menu'];
		}
		return $menutype;
	}	
	
	//get color
	function getStyle() {
		$style  = isset($_COOKIE[$this->theme . '_style']) ? $_COOKIE[$this->theme . '_style'] : $this->API->params->get('style','style1');
		if(isset($_GET['style'])) {
			setcookie($this->theme . '_style', $_GET['style'], time() + 3600, '/'); 
			$style = $_GET['style'];
		}
		
		$this->API->addStyleSheet($this->themeUrl . '/css/styles/'.$style.'.css');
	}
	
	//get language direction
	function getDirection() {
		$direction  = isset($_COOKIE[$this->theme . '_direction']) ? $_COOKIE[$this->theme . '_direction'] : $this->API->params->get('direction','ltr');
		if(isset($_GET['direction'])) {
			setcookie($this->theme . '_direction', $_GET['direction'], time() + 3600, '/'); 
			$direction = $_GET['direction'];
		}
		
		if(($direction=='rtl') || ($this->API->direction == 'rtl')) $direction='rtl';
			else $direction='ltr';
		
		return $direction;		
	}

	function loadHead() {//load head
		echo '<jdoc:include type="head" />';
		JHTML::_('behavior.mootools');
		$this->API->addStylesheet($this->baseUrl."/templates/system/css/system.css");
		$this->API->addStylesheet($this->baseUrl."/templates/system/css/general.css");

	}

	function favicon($src='favicon.ico') {//add favicon
		echo '<link href="' . $this->themeUrl . '/images/' . $src . '" rel="shortcut icon" type="image/x-icon" />';
	}
	
	//Detect frontpage
    function isFrontPage(){
        return (JRequest::getVar( 'view' ) == 'featured');   
    }
	
	//Load menu
	function loadMenu () {
		require_once (dirname(__FILE__).DS."class.menu.php");
		return new TigraMenu ($this->API->params,$this->getMenu());
	}

	function compress () {//compress css and js files
		if ($this->getParam('compress_css')) $this->compressCSS();
		if ($this->getParam('compress_js')) $this->compressJS();		
	}
	
    function compressJS() {//function to compress js files
		require_once (dirname(__FILE__).DS."class.jsmin.php");//include jsmin class
		$js_files = array();
		$cache_time = $this->getParam('cache_time');//Cache time in minute
		$diff=false;
		$tigra_folder='tigra_assets';//path of cache where to save
        $output = array();
        $md5sum = null;
		
        $scripts = $this->API->_scripts;//get all scripts
		
        foreach ($scripts as $fileSrc => $fileAttr) {//separate path from attribute
            $md5sum .= md5($fileSrc);
            $js_files[] = $fileSrc;
        }
		
        if (!is_writable(JPATH_CACHE)) {//check for cache path writable, if not return
            return;
        } 
		
		if (is_writable(JPATH_CACHE)) {//add tigra_assets folder under cache directory
			if (!file_exists(JPATH_CACHE.DS.$tigra_folder)) mkdir (JPATH_CACHE.DS.$tigra_folder);
		}

        if (count($js_files) > 0) {//if any js file available
            $cache_name = md5($md5sum) . ".js";
            $cache_path = JPATH_CACHE . DS . $tigra_folder . DS . $cache_name;


            //see if file is stale
            if (!file_exists($cache_path)) {
				$diff=true;   
            } elseif(filesize($cache_path) == 0 || ((filemtime($cache_path) + $cache_time * 60) < time())) {
				$diff=true; 
            }
			
			foreach ($js_files as $files) {
				unset($this->API->_scripts[$files]); //Remove js files from the header
			}
			
            if ($diff) {
                $output = '';
                foreach ($js_files as $files) {
					$filepath = $this->realPath($files);
                    if (JFile::exists($filepath)) {
                        $js = JSMin::minify(JFile::read($filepath));//read and compress js files
                        $output .= "/*------ " . $files . " ------*/\n" . $js . "\n\n";//add file name to compressed JS
                    }
                }
                JFile::write($cache_path, $output);//write cache to the joomla cache directory
            }
			
            $cache_url = $this->API->baseurl . "/cache/" . $tigra_folder . '/' . $cache_name;//path of css cache to add as script
            $this->API->addScript($cache_url);//add script to the header
        }
    }

	function compressCSS() {//function to compress css files
		require_once (dirname(__FILE__).DS."class.cssminify.php");//include cssminify class
		$css_files = array();
		$cache_time = $this->getParam('cache_time');//Cache time in minute
		$tigra_folder='tigra_assets';//path of cache where to save
        $output = array();
        $md5sum = null;
		
        $csss = $this->API->_styleSheets;//get all CSS
		
        foreach ($csss as $fileSrc => $fileAttr) {//separate path from attribute
            $md5sum .= md5($fileSrc);
            $css_files[] = $fileSrc;
        }
		
        if (!is_writable(JPATH_CACHE)) {//check for cache path writable, if not return
            return;
        } 
		
		if (is_writable(JPATH_CACHE)) {//add tigra_assets folder under cache directory
			if (!file_exists(JPATH_CACHE.DS.$tigra_folder)) mkdir (JPATH_CACHE.DS.$tigra_folder);
		}

        if (count($css_files) > 0) {//if any css file available
            $cache_name = md5($md5sum) . ".css";
            $cache_path = JPATH_CACHE . DS . $tigra_folder . DS . $cache_name;
			$diff=false;

            //see if file is stale
            if (!file_exists($cache_path)) {
				$diff=true;   
            } elseif(filesize($cache_path) == 0 || ((filemtime($cache_path) + $cache_time * 60) < time())) {
				$diff=true; 
            }

			foreach ($css_files as $files) {
				unset($this->API->_styleSheets[$files]); //Remove all css files from the header
			}
			
            if ($diff) {
                $output = '';
                foreach ($css_files as $files) {
					$filepath = $this->realPath($files);//convert to real url
					
				    global $absolute_url;
					$absolute_url = $files;//absoulte path of each css file
                    if (JFile::exists($filepath)) {
                        $css = CSSMinify::process(JFile::read($filepath));//read and compress css files
						
						$css=preg_replace_callback('/url\(([^\)]*)\)/', array($this, 'replaceUrl'), $css);//call replaceUrl function to set absolute value to the urls
						
                        $output .= "/*------ " . $files . " ------*/\n" . $css . "\n\n";//add file name to compressed css
                    }
                }
                JFile::write($cache_path, $output);//write cache to the joomla cache directory
            }
			
            $cache_url = $this->API->baseurl . "/cache/" . $tigra_folder . '/' . $cache_name;//path of css cache to add as stylesheet
            $this->API->addStyleSheet($cache_url);//add stylesheet to the header
        }
    }
	
    function replaceUrl($matches) {//replace url with absolute path
        $url = str_replace(array('"', '\''), '', $matches[1]);
        $url = $this->fixUrl($url);
        return "url('$url')";
    }

    function fixUrl($url) {
	    global $absolute_url;
        $base = dirname($absolute_url);
        if (preg_match('/^(\/|http)/', $url))
            return $url;
        /*absolute or root*/
        while (preg_match('/^\.\.\//', $url)) {
            $base = dirname($base);
            $url = substr($url, 3);
        }

        $url = $base . '/' . $url;
        return $url;
    }	
	
	function realPath($strSrc) {//Real path of css or js file
		if (preg_match('/^https?\:/', $strSrc)) {
			if (!preg_match('#^' . preg_quote(JURI::base()) . '#', $strSrc)) return false; //external css
			$strSrc = str_replace(JURI::base(), '', $strSrc);
		} else {
			if (preg_match('/^\//', $strSrc)) {
				if (!preg_match('#^' . preg_quote(JURI::base(true)) . '#', $strSrc)) return false; //same server, but outsite website
				$strSrc = preg_replace('#^' . preg_quote(JURI::base(true)) . '#', '', $strSrc);
			}
		}
		$strSrc = str_replace('//', '/', $strSrc);
		$strSrc = preg_replace('/^\//', '', $strSrc);
		return $strSrc;
	}	
	
}
?>