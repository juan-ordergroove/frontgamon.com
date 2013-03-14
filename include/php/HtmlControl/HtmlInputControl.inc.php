<?php
require_once('HtmlControl.inc.php');
	
class HtmlSelect extends HtmlControl
{
	function HtmlSelect($id = '')
	{
		$this->id = $id;
		$this->tag = 'select';
		$this->items = array();
		
		parent::HtmlControl();
	}
	
	function addItems($items)
	{
		foreach ($items as $key => $value)
			$this->items[] = "<option value='{$key}'>{$value}</option>";
	}
	
	function Render($bEchoHtml = true)
	{
		foreach ($this->items as $item)
			$this->body .= "\t" . $item . "\n";
		
		return parent::Render($bEchoHtml);
	}
}

class HtmlTextArea extends HtmlControl
{
	function HtmlTextArea($id = '')
	{
		$this->id = $id;
		$this->tag = 'textarea';
		$this->name = $id;
		$this->rows = 1;
		$this->cols = 1;
		$this->value = '';

		parent::HtmlControl();
	}

	function Render($bEchoHtml = true)
	{
		$this->attributes['rows'] = $this->rows;
		$this->attributes['cols'] = $this->cols;

		if (!isset($this->attributes['name']))
			$this->attributes['name'] = $this->name;

  if (isset($this->value))
				$this->attributes['value'] = $this->value;

		return parent::Render($bEchoHtml);
	}
}

class HtmlInput extends HtmlControl
{
	var $type;
	var $value;
	var $size;
	
	function HtmlInput($id = '')
	{
		$this->id = $id;
		$this->tag = 'input';
		$this->name = $id;
		$this->type = '';
		$this->value = '';
		$this->size = 120;
		
		parent::HtmlControl();
	}
	
	function Render($bEchoHtml = true)
	{
			if (!isset($this->attributes['name']))
					$this->attributes['name'] = $this->name;
			
			if (!isset($this->attributes['type']))
					$this->attributes['type'] = $this->type;
			
			if (!isset($this->attributes['value']) && isset($this->value))
					$this->attributes['value'] = $this->value;
			
			if (!isset($this->attributes['size']))
					$this->attributes['size'] = $this->size;
			
			return parent::Render($bEchoHtml);
	}
}
?>
