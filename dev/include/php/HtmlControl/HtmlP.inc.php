<?php
require_once('HtmlControl.inc.php');

class HtmlP extends HtmlControl
{
	function HtmlP($id = '')
	{
		$this->id = $id;
		$this->tag = 'p';
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
