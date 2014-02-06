<?php
/**
* == CakePHP Popup Plugin ==
*
* CakePHP Popup Plugin is a plugin that allows for easy to manage css/xhtml popup content.
* Content for the popups can be loaded dynamically or read from an element.

* @Author: Nick Baker
* @Version: 2.0
* @Link: http://www.webtechnick.com
* @License: MIT
*/
class PopupHelper extends AppHelper {
	
	/**
	* Load Html and Javascript helpers to use for the popup link
	*/
	var $helpers = array('Html', 'Js');
	
	/**
	* popup counter
	* @var int popup counter
	* @access private
	*/
	var $__popups = 0;
	
	/**
	* Javascript library to use (Jquery or Prototype) Prototype by default.
	* @access public
	*/
	var $library = 'Prototype'; //Jquery or Prototype
	
	/**
	* Constructor to load in the view object so we can use our own elements.
	* Set the javascript library if settings passed in.
	* @param array settings
	*/
	function __construct(View $View, $settings = array()){
		if(is_array($settings) && isset($settings[0])){
			$this->library = $settings[0];
		}	elseif(is_string($settings)){
			$this->library = $settings;
		}
		$this->View = $View;
		parent::__construct($View, $settings);
	}
	
	/**
	* Link returns a link to be used to load a css popup.
	* Option keys:
	*  - 'content' is the string of text that will be loaded into the popup.
	*  - 'element' is the element file (/views/elements/) to be loaded into the popup.
	*  If both option keys are set, 'content' takes priority.
	*
	*  Any other option key will be used by the HtmlHelper. 
	*  View the HtmlHelper options (http://book.cakephp.org/view/836/link) for more information.
	*
	* @example $popup->link('click me', array('content' => 'this will appear in the popup'));
	* @example $popup->link('click me', array('element' => 'my_element', array('myvar' => 'hello')); //loads /views/elements/my_element.ctp
	*
	* @author Nick Baker
	* @param String $title is the text/image to be displayed as a link 
	* @param Array $options is the options array used to pass content into the popup and html link
	* @param Array $elementVars is the array that will be based into the element if you've set an element to popup.
	* @access public
	* @return an html link pointed to a new popup element.
	*/
	function link($title = null, $options = array(), $elementVars = array()){
		$id = $this->__id();
		
		//the link options
		$default_link_options = array(
			'onclick' => $this->__buildJsShow($id),
			'escape' => false
		);
		
		$link_options = array_merge($default_link_options,$options);
		unset($link_options['element']);
		unset($link_options['content']);
		
		//The link
		$retval = $this->Html->link($title, '#', $link_options);
		
		//The popup
		$popup = $this->Js->escape($this->__popup(array_merge($options, array('id' => $id)), $elementVars ));
		$retval .= $this->__buildJsDomReady($popup);
		return $retval;
	}
	
	/**
	* Build the javascript library specific popup
	* @param string id of element to show
	* @return string  of javascript onclick element
	* @access private
	*/
	function __buildJsShow($id){
		if ($this->library == 'Jquery') {
			return '$("#'.$id.'").show(); return false;';
		} else {
			return '$("'.$id.'").show(); return false;';
		}
	}
	
	/**
	* Build the Javascript library specific popup dom ready funtion
	* @param string id of element to show
	* @return string  of javascript document ready to build
	* @access private
	*/
	function __buildJsDomReady($popup){
		if ($this->library == 'Jquery') {
			return $this->Html->scriptBlock('
				$(document).ready(function(){
					$("#'.$popup.'").appendTo("#popups");
				});
			');
		}	else {
			return $this->Html->scriptBlock("
				document.observe('dom:loaded', function(){
					\$('popups').insert(\"$popup\", {position: 'bottom'})
				});
			");
		}
	}
	
	/**
	* retuns a new unique popup id.
	* @access private
	* @return String popup_id
	*/
	function __id(){
		return 'popup_' . $this->__popups++;
	}
	
	/**
	* returns a popup element
	* @access private
	* @param $options passed in options from link
	* @param elementVars array of the vars to pass into the new element if we're using elements
	* @return a popup element
	*/
	function __popup($options = array(), $elementVars = array()){
		$vars = array_keys($elementVars);
		$popup_options = array_merge($options, $elementVars, array('library' => $this->library, 'vars' => $vars));
		return $this->View->element('Popup.popup', $popup_options);
	}
}