<?php
require_once(PHP_DEV . 'lib/Dump.class.php');
require_once(PHP_DEV . 'lib/StringToolbox.class.php');

$validAttributes = array('style', 'align', 'disabled', 'type', 'height', 'width', 'rows', 'cols',
												'src', 'href', 'value', 'method', 'action', 'target', 'name', 'alt', 'class', 'rel');

class HtmlControl
{
		var $id;
		var $name;
		var $styles;
		var $disabled;
		var $attributes;
		var $events;
		var $tag;
		var $showHtml;
		var $body;
		
		function HtmlControl()
		{
				$this->tag = strtolower($this->tag);
				$this->styles = array();
				$this->events = array();
				$this->className = '';
				$this->attributes = array();
				$this->showHtml = false;
				$this->body = '';
				$this->disabled = '';
		}
	
		function Render($bEchoHtml = true)
		{
				global $validAttributes;
				
				if (strlen($this->tag))
						$html = '<' . $this->tag . (strlen($this->id) ? " id='{$this->id}'": '');
				else
						return '';
				
				if (strlen($this->className))
						$html .= " class='{$this->className}'";
				
				if (count($this->attributes))
						foreach ($this->attributes as $key => $value)
								if (in_array(strtolower($key), $validAttributes))
										$html .= " {$key}=" . (is_string($value) ? "'{$value}'" : "{$value}");
				
				if ($this->disabled)
						$html .= " disabled='disabled'";
				
				if (count($this->styles))
				{
						$html .= " style='";
						foreach ($this->styles as $key => $value)
								$html .= " {$key}: {$value};";
						
						$html .= "'";
				}
				
				if (count($this->events))
				{
						foreach ($this->events as $event => $function)
								$html .= " {$event}='{$function};'";
				}
				
				$html .= ">\n";
				if (strlen($this->body))
				{
						$this->body = str_replace("\n", "\n\t", $this->body);
						$html .= "\t\t{$this->body}";
				}
				
				if ($this->tag !== 'img' && $this->tag !== 'input')
						$html .= "\n\t</{$this->tag}>\n\t";
				
				if (!$bEchoHtml)
						return $html;
				else
						echo $html;
		}
}
?>
