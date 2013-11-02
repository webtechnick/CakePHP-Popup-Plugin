# CakePHP Popup Plugin
* Author: Nick Baker <nick@webtechnick.com>
* Version: 2.0
* Website: <http://www.webtechnick.com>
* License: MIT

CakePHP Popup Plugin is a plugin that allows for easy to manage css/xhtml popup content.
Content for the popups can be loaded dynamically or read from an element.

# Changelog
* 1.0 Initial Release
* 1.5 Updated to use Jquery or Prototype engines.
* 2.0 Updated to CakePHP 2.x

# Requirements
1. PHP5
2. Prototype or JQuery

# Install
1. clone into `app/Plugin/Popup` directory

		git clone git://github.com/webtechnick/CakePHP-Popup-Plugin.git app/Plugin/Popup
	
2. Edit app`/View/Layouts/Default.ctp` in the <head> of your layout add

		<?php echo $this->Html->css("/popup/css/default_theme"); ?>

3. Somewhere in the your layout add

		<div id="popups" style="z-index: 1000;"></div>

4. Add `Popup.Popup` helper in your controller helper list

		public $helpers = array('Popup.Popup'); //Prototype engine default
		public $helpers = array('Popup.Popup' => array('Jquery')); //use Jquery
		public $helpers = array('Popup.Popup' => array('Prototype')); //use Prototype
   
   
# Usage
Link returns a link to be used to load a popup.
	Option keys:
		-  `content` is the string of text that will be loaded into the popup.
		-  `element` is the element file (`app/views/elements`) to be loaded into the popup.
		If both option keys are set, `content` takes priority.

Any other option key will be used by the HtmlHelper. 
View the HtmlHelper options <http://book.cakephp.org/view/836/link> for more information.

	$this->Popup->link(String $title, Array $options);

# Examples

	//load string content into the popup
	$this->Popup->link('click me', array('content' => 'this will appear in the popup'));
  
	//load app/views/elements/my_element.ctp into the popup
	$this->Popup->link('click me', array('element' => 'my_element'));
	
	//load app/views/elements/my_element.ctp into the popup with variables
	$this->Popup->link('click me', array('element' => 'my_element'), array('first_var' => 'value', 'second_var' => 'value 2'));
  
  
# Customize
I will be adding more theme's soon.  Feel free to look at the `default_theme` for inspiration.
I've added plenty of hooks to play around with in each popup.