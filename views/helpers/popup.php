<?php
class PopupHelper extends AppHelper {
  
  /************************************************************
    * Load Html and Javascript helpers to use for the popup link
    */
  var $helpers = array('Html', 'Javascript');
  
  /************************************************************
    * popup counter
    * @var int popup counter
    * @access private
    */
  var $__popups = 0;
  
  /************************************************************
    * Constructor to load in the view object so we can use our own elements.
    */
  function __construct(){
    $this->View =& ClassRegistry::getObject('view');
  }
  
  /************************************************************
    * Link returns a link to be used to load a css popup.
    * Option keys:
    *    'content' is the string of text that will be loaded into the popup.
    *    'element' is the element file (/views/elements/) to be loaded into the popup.
    *  If both option keys are set, 'content' takes priority.
    *
    *  Any other option key will be used by the HtmlHelper. 
    *  View the HtmlHelper options (http://book.cakephp.org/view/836/link) for more information.
    *
    * Examples:
    *   $popup->link('click me', array('content' => 'this will appear in the popup'));
    *   $popup->link('click me', array('element' => 'my_element', array('myvar' => 'hello')); //loads /views/elements/my_element.ctp
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
      'onclick' => "$('$id').show(); return false;",
      'escape' => false
    );
    $link_options = array_merge($default_link_options,$options);
    unset($link_options['element']);
    unset($link_options['content']);
    
    //The link
    $retval = $this->Html->link($title, '#', $link_options);
    
    //The popup
    $popup = $this->Javascript->escapeString($this->__popup( array_merge($options, array('id' => $id)), $elementVars ));
    $retval .= $this->Javascript->codeBlock("
      document.observe('dom:loaded', function(){
        $('popups').insert('$popup', {position: 'bottom'})
      });
    ");
    
    return $retval;
  }
  
  /************************************************************
    * retuns a new unique popup id.
    * @access private
    * @return String popup_id
    */
  function __id(){
    return 'popup_' . $this->__popups++;
  }
  
  /************************************************************
    * returns a popup element
    * @access private
    * @param $options passed in options from link
    * @param elementVars array of the vars to pass into the new element if we're using elements
    * @return a popup element
    */
  function __popup($options = array(), $elementVars = array()){
    $vars = array_keys($elementVars);
    $popup_options = array_merge($options, $elementVars, array('plugin' => 'popup', 'vars' => $vars));
    return $this->View->element('popup', $popup_options);
  }

}
?>