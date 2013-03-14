<?php
require_once('HtmlControl.inc.php');
	
class HtmlBody extends HtmlControl
{	
	function HtmlBody()
	{
		$this->tag = 'body';
		
		parent::HtmlControl();
	}
	
	function Render($bEchoHtml = true)
	{
		return parent::Render($bEchoHtml);
	}
}
?>