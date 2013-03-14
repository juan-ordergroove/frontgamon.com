<?php
require_once('HtmlControl.inc.php');

class HtmlImage extends HtmlControl
{
	var $src;
	
	function HtmlImage($id = '')
	{
		$this->id = $id;
		$this->tag = 'img';
		$this->height = '';
		$this->width = '';
		$this->src = '#';
		$this->alt = '';
		
		parent::HtmlControl();
	}
	
	function Render($bEchoHtml = true)
	{
		if (strlen($this->height))
			$this->attributes['height'] = $this->height;

		if (strlen($this->width))
			$this->attributes['width'] = $this->width;

		if (strlen($this->src))
			$this->attributes['src'] = $this->src;

		if (strlen($this->alt) || !isset($this->attributes['alt']))
			$this->attributes['alt'] = $this->alt;
		
		return parent::Render($bEchoHtml);
	}
}
?>
