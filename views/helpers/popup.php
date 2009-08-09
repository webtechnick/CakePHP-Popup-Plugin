<?php
class PopupHelper extends AppHelper {
  
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
    *   $popup->link('click me', array('element' => 'my_element')); //loads /views/elements/my_element.ctp
    *
    * @author Nick Baker
    * @param String $title is the text/image to be displayed as a link 
    * @param Array $options is the options array used to pass content into the popup and html link
    * @access public
    * @return an html link pointed to a new popup element.
    */
  function link($title = null, $options = array()){
    $id = $this->__id();
    $default_options = array(
      'onclick' => "$('$id').show();",
      'escape' => false
    );
    $link_options = array_merge($default_options,$options);
    
    //The link
    $retval = $this->Html->link($title, '#', $link_options);
    
    //The popup
    $popup = $this->Javascript->escapeString($this->__popup( array_merge($options, array('id' => $id)) ));
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
    * @return a popup element
    */
  function __popup($options = array()){
    $options = array_merge(array('plugin' => 'popup'), $options);
    return $this->View->element('popup', $options);
  }

}
?>