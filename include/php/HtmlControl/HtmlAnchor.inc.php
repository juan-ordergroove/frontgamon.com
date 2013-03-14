<?php
require_once('HtmlControl.inc.php');
	
class HtmlAnchor extends HtmlControl
{	
	var $href;
	
	function HtmlAnchor($id = '')
	{
		$this->id = $id;
		$this->tag = 'a';
		$this->href = '#';
		$this->title = '';

		parent::HtmlControl();
	}
	
	function Render($bEchoHtml = true)
	{
		$this->attributes['href'] = $this->href;

		if (strlen($this->title))
			$this->body = $this->title;
		
		return parent::Render($bEchoHtml);
	}
}
?>