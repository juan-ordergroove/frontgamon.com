<?php
require_once('HtmlControl.inc.php');
	
class HtmlLabel extends HtmlControl
{
	function HtmlLabel($id = '')
	{
		$this->id = $id;
		$this->tag = 'label';
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