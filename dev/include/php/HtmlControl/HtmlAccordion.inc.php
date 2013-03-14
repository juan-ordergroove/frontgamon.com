<?php
require_once('HtmlControl.inc.php');

// REQUIRES: jQuery
class HtmlAccordion extends HtmlControl
{
  function HtmlAccordion($id = '')
  {
    $this->id = strlen($id) ? $id : 'taxi-accordion';
    $this->tag = 'div';
    $this->value = '';

    parent::HtmlControl();
    
    $this->styles['margin'] = '1em 1em 4em';
    $this->className = 'taxi-accordion';
  }

  function AddAccordion($headerId, $header, $accordionData)
  {
    $header = sprintf("<h3 id='%s' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>\n
        %s\n
        </h3>\n", $headerId, $header);
    $accordion = sprintf("<div style='overflow:visible;'>\n
        %s\n
        </div>", $accordionData);

    $this->body .= sprintf("%s\n%s\n", $header, $accordion);
  }

  function Render($bEchoHtml = true)
  {
    if (strlen($this->value))
      $this->body = $this->value;

    return parent::Render($bEchoHtml);
  }
}
?>
