<?php
require_once('HtmlControl.inc.php');

class HtmlDiv extends HtmlControl
{	
		function HtmlDiv($id = '')
		{
				$this->id = $id;
				$this->tag = 'div';
				$this->value = '';
				
				parent::HtmlControl();
		}
		
		function Render($bEchoHtml = true)
		{
				if (strlen($this->value))
						$this->body = $this->value;
				
				return parent::Render($bEchoHtml);
		}
}
?>
