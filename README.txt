== CakePHP Popup Plugin ==

CakePHP Popup Plugin is a plugin that allows for easy to manage css/xhtml popup content.
Content for the popups can be loaded dynamically or read from an element.

Author: Nick Baker
Version: 1.0
Website: http://www.webtechnick.com
Licence: MIT

Requirements:
1) PHP5
2) Prototype js

Install: 
1) copy /popup directory into /plugins/popup
2) Edit /views/layout/default.ctp
In the <head> of your layout add:
  <?php echo $html->css("/popup/css/default_theme"); ?>
  
Somewhere in the default.ctp page add:
  <div id="popups" style="z-index: 1000;"></div>

3) Add Popup.Popup helper in your controller helper list
   var $helpers = array('Popup.Popup');
   
   
Usage:
/************************************************************
  * Link returns a link to be used to load a popup.
  * Option keys:
  *    'content' is the string of text that will be loaded into the popup.
  *    'element' is the element file (/views/elements/) to be loaded into the popup.
  *  If both option keys are set, 'content' takes priority.
  *
  *  Any other option key will be used by the HtmlHelper. 
  *  View the HtmlHelper options (http://book.cakephp.org/view/836/link) for more information.
  *
$popup->link(String $title, Array $options);

Examples:
  //load string content into the popup
  $popup->link('click me', array('content' => 'this will appear in the popup'));
  
  //load /views/elements/my_element.ctp into the popup
  $popup->link('click me', array('element' => 'my_element'));
  
  
Customize:
I will be adding more theme's soon.  Feel free to look at the default_theme for inspiration.
I've added plenty of hooks to play around with in each popup.