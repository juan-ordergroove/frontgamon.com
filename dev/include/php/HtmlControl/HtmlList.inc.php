<?php
require_once('HtmlControl.inc.php');
	
class HtmlList extends HtmlControl
{
	var $items;
	
	function HtmlList($id = '', $ordered = false)
	{
		$this->id = $id;
		$this->tag = ($ordered ? 'ol' : 'ul');
		$this->items = array();
		
		parent::HtmlControl();
	}
	
	function addItems($items)
	{
		foreach ($items as $item)
			$this->items[] = '<li>' . $item . '</li>';
	}
	
	function Render($bEchoHtml = true)
	{
		foreach ($this->items as $item)
			$this->body .= "\t" . $item . "\n";
		
		return parent::Render($bEchoHtml);
	}
}
?>