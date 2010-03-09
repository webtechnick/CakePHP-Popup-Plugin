<?php

  //Content
  if(isset($content) && !empty($content)){
    $popcont = $content;
  }
  elseif(isset($element) && !empty($element)){
    $passedVars = array();
    if(count($vars)){
      $defined_vars = get_defined_vars();
      
      foreach($vars as $var_key){
        $passedVars["$var_key"] = $defined_vars[$var_key];
      }
    }
    $popcont = $this->element($element, $passedVars);
  }
  else {
    $popcont = "<b>Error:</b> </i>No Data</i> <br /><br />
    
    Please set 'content' => 'some value', or 'element' => 'element_file' to display content in this popup. <br />
    Examples:<br />
    \$popup->link('click me!', array('content' => 'hello world')); <br />
    \$popup->link('click me!', array('element' => 'my_element')); //loads file /views/elements/my_element.ctp";
  }
  
  //Theme
  $theme = isset($theme) ? $theme . str_replace("_theme","",$theme) . "_theme" : false;
  if($theme){
    echo $html->css("popup/css/$theme");
  }
  //Library to use
  $library = isset($library) ? $library : 'Prototype';
  $onclick_pre = ($library == 'Prototype') ? '' : '#'; 
?>
<div id="<?= $id; ?>" style="display:none;">
  <div class="hideshow">
    <div class="fade"></div>
    <div class="popup_block">
      <div class="popup">
        <a href="#" onclick="$('<?= $onclick_pre . $id; ?>').hide(); return false;"><?= $html->image('/popup/img/icon_close.png', array('class' => 'cntrl', 'alt' => 'close')); ?></a>
        <div id="popup-content"><?= $popcont; ?></div>
      </div>
    </div>
  </div>
</div>