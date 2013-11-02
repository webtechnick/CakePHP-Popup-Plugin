<?php
App::import('Helper','Popup.Popup');
App::import('Helper', 'Html');
App::import('Helper', 'Javascript');
class PopupHelperTest extends PopupHelper{
  var $options = array();
  var $elementVars = array();
  
  function __popup($options = array(), $elementVars = array()){
    $this->__options = $options;
    $this->__elementVars = $elementVars;
  }
}
class PopupHelperTest extends CakeTestCase {
  
  function startTest(){
    $this->Popup = new PopupHelperTest();
    $this->Popup->Html = new HtmlHelper();
    $this->Popup->Javascript = new JavascriptHelper();
  }
  
  function testPrototypeLink(){
    $results = $this->Popup->link('Title', array('content' => 'Content'));
    $expected = "<a href=\"#\" onclick=\"\$('popup_0').show(); return false;\">Title</a><script type=\"text/javascript\">
//<![CDATA[

        document.observe('dom:loaded', function(){
          \$('popups').insert('', {position: 'bottom'})
        });
      
//]]>
</script>";
    $this->assertEqual($expected, $results);
  }
  
  function testJqueryLink(){
    $this->Popup->library = 'Jquery';
    $results = $this->Popup->link('Title', array('content' => 'Content'));
    $expected = "<a href=\"#\" onclick=\"\$('#popup_0').show(); return false;\">Title</a><script type=\"text/javascript\">
//<![CDATA[

        \$(document).ready(function(){
          \$('').appendTo('#popups');
        });
      
//]]>
</script>";
    $this->assertEqual($expected, $results);
  }
  
  function endTest(){
    unset($this->Popup);
  }
}
?>