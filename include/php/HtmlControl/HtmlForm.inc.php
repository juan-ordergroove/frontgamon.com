<?php
require_once('HtmlControl.inc.php');
	
class HtmlForm extends HtmlControl
{
	var $action;
	var $method;
	var $hidden;
	
	function HtmlForm($id = '', $method = 'post')
	{
		$this->id = $id;
		$this->tag = 'form';
		$this->hidden = array();
		$this->method = $method;
		$this->action = '';
		
		parent::HtmlControl();
	}

	function SetSubmitValue($key, $value)
	{
		$this->hidden[$key] = $value;
	}
	
	function IsPostBack()
	{
		$REQUEST_METHOD = getenv('REQUEST_METHOD');
		return ($REQUEST_METHOD === 'POST');		
	}
	
	function Clicked($id)
	{
			return (isset($_REQUEST[$id]) || ($_REQUEST['btnName'] == $id));
	}
	
	function Render($bEchoHtml = true)
	{
		if (strlen($this->action) || !isset($this->attributes['action']))
			$this->attributes['action'] = $this->action;

		if (strlen($this->method) || !isset($this->attributes['method']))
			$this->attributes['method'] = $this->method;

		if (count($this->hidden))
			foreach ($this->hidden as $key => $value)
				$this->body .= "<input type='hidden' id='$key' name='$key' value='$value'>";

		return parent::Render($bEchoHtml);
	}
}
?>
