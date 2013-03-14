<?php
require_once('HtmlControl.inc.php');
	
class HtmlSpan extends HtmlControl
{
	function HtmlSpan($id = '')
	{
		$this->id = $id;
		$this->tag = 'span';
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