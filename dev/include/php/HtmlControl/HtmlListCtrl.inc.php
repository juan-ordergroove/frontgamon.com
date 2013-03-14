<?php
require_once('HtmlControl.inc.php');
require_once('HtmlTable.inc.php');
require_once('HtmlLabel.inc.php');
require_once('HtmlDiv.inc.php');

if (isset($js_include))
{
  $js_include[] = JS_INCLUDE_DIR . 'listctrl.js';
		$js_include[] = JS_INCLUDE_DIR . 'listCtrlButtons.js';
}
else
{
  $js_include = array(JS_INCLUDE_DIR . 'listctrl.js', JS_INCLUDE_DIR . 'listCtrlButtons.js');
}

class HtmlListCtrl extends HtmlTable
{
		var $headers;
		var $headerCol;
		var $width;
		var $scrollHeight;
		var $buttons;
		var $btnEvents;
		var $align;
		
		function HtmlListCtrl($id = '')
		{
				$this->headers = array();
				$this->headerCol = 1;
				$this->width = '0%';
				$this->buttons = array();
				$this->btnEvents = array();
				$this->scrollHeight = '';
				$this->align = '';
				
				parent::HtmlTable($id);
				
				$this->SetTableAttribute('style', 'border: 1px solid gray; font-size: 10pt; background-color: white;');
		}

		function AddHeader($header, $width = '1%')
		{
				if ($this->GetCurrentRow() == 0)
						$this->AddRow();
				
				if (strlen($header))
				{
						$headerStyle = array("width: $width",
																											'background: url(/images/listctrl-header.gif) repeat-x',
																											'font-weight: bold',
																										 'color: #052537',
																											'border-bottom: 1px solid gray',
																											'padding-left: 5px'
																											);
						
						if ($this->headerCol > 1)
								$headerStyle[] = 'border-left: 1px solid black;';
						
						$label = new HtmlLabel("listctrl-label-$this->headerCol");
						$label->value = $header;
						
						$this->SetRowAttributes(1, array('height' => '20px'));
						$this->SetCellContent(1, $this->headerCol, $label->Render(false));
						$this->SetCellStyle(1, $this->headerCol, $headerStyle);
						$this->headerCol++;
				}
		}
		
		function AddListCtrl($listCtrlId = 0)
		{
				$i = $this->AddRow();
				$rowAttributes = array("onmouseout" => "idleList(\"$listCtrlId\");",
																											"onclick" => "clickList(\"$listCtrlId\");",
																											"onmouseover" => "hoverList(\"$listCtrlId\");",
																											"id" => $listCtrlId
																											);

				$this->SetRowAttributes($i, $rowAttributes);
				return $i;
		}

		function AddButton($btnName, $btnWidth, $btnOnClick, $bIsDisabled = false)
		{
				$this->buttons[$btnName] = $btnWidth;
				$this->btnEvents[$btnName] = $btnOnClick;
				$this->buttons['disabled'][$btnName] = $bIsDisabled;
		}
		
		function Render($bEchoHtml = true)
		{
				$this->SetTableAttribute('width', "$this->width");
				$this->SetTableAttribute('cellspacing', "0");
				$this->SetTableAttribute('cellpadding', "0");
				$this->SetTableAttribute('style', 'background-color: white; border: 1px solid gray; font-size: 8pt;');

				if ($this->GetCurrentRow())
				{
						$scrollDiv = new HtmlDiv('scrolldiv-' . $this->id);
						$scrollDiv->styles['overflow'] = 'auto';
						$scrollDiv->styles['height'] = $this->scrollHeight;
						$scrollDiv->value = parent::Render(false);
				}
				
				$btnDivBar = new HtmlTable('btnDivBar-' . $this->id);
				$btnDivBar->SetTableAttribute('cellspacing', '0');
				$btnDivBar->SetTableAttribute('cellpadding', '0');
				$btnDivBar->SetTableAttribute('style', 'padding-top: 10px;');
				$btnDivBar->SetTableAttribute('align', (strlen($this->align) ? $this->align : 'center'));

				$i = $btnDivBar->AddRow();
				$col = 1;
				foreach($this->buttons as $btnName => $btnWidth)
				{
						if (!strcmp($btnName, 'disabled'))
								continue;
						
						$btnLabel = new HtmlLabel($btnName . 'BtnLabel');
						$btnLabel->className = ($this->buttons['disabled'][$btnName] ? 'btnDisabled' : 'btnLabelNotClicked');
						$btnLabel->value = $btnName;
						
						$btnDiv = new HtmlDiv($btnName . 'BtnDiv');
						$btnDiv->className = 'btnDivNotClicked';
						$btnDiv->events['onclick'] = $this->btnEvents[$btnName];
						$btnDiv->styles['float'] = 'left';
						$btnDiv->styles['width'] = $btnWidth;
						$btnDiv->styles['padding'] = '3px 10px';
						$btnDiv->value = $btnLabel->Render(false);
						
						$btnDivBar->SetCellContent($i, $col, $btnDiv->Render(false) . "<img src='/images/spacer.gif' width='10' style='float: left;' alt=''>");

						$col++;
				}
				
				$div = new HtmlDiv('listctrl-div-' . $this->id);
				$div->styles['background-color'] = '#d3d3d3';
				$div->styles['padding'] = '10px';
				$div->value = (isset($scrollDiv) ? $scrollDiv->Render(false) : '') . ($btnDivBar->GetCurrentRow() ? $btnDivBar->Render(false) : '');
				
				return $div->Render($bEchoHtml);
		}

		function RenderScript()
		{
				echo "<script type='text/javascript'>\n";
				foreach (array_keys($this->buttons) as $btnName)
				{
						if (!strcmp($btnName, "disabled"))
								continue;
						echo "\t$(document).ready(function() {\n";
						echo "\t\tlistctrlBtn(\"{$btnName}BtnDiv\", ";
						echo ($this->buttons['disabled'][$btnName] ? "true" : "false") . ");\n";
						echo "\t});\n";
				}
				
				echo "</script>\n";
		}
}
?>
