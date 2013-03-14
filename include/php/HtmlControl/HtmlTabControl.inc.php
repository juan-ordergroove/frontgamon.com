<?php
require_once ('HtmlControl.inc.php');
require_once ('HtmlTable.inc.php');
require_once ('HtmlDiv.inc.php');

if (isset($js_include))
		$js_include[] = JS_INCLUDE_DIR . 'tabctrl.js';
else
		$js_include = array(JS_INCLUDE_DIR . 'tabctrl.js');

class HtmlTabControl extends HtmlControl
{
		var $width;
		var $tabs;
		
		function HtmlTabControl($id = '')
		{
				$this->tabs = array();
				$this->width = 0;

				parent::HtmlControl($id);
		}

		function AddTab($tabTitle, $tabContent)
		{
				if (strlen($tabTitle))
						if (strlen($tabContent))
								$this->tabs[$tabTitle] = $tabContent;
		}

		function Render($bEchoHtml = true)
		{
				$bFirstTab = true;
				
				$tabs = new HtmlTable();
				$tabs->SetTableAttribute('width', '100%');
				$tabs->SetTableAttribute('cellspacing', '0');
				$tabs->SetTableAttribute('cellpadding', '0');
				$row = $tabs->AddRow();
				$col = 1;
				
				$tabPanels = new HtmlDiv('tabPanels');
				$tabPanels->styles['border-bottom'] = '1px solid white';
				$tabPanels->styles['border-right'] = '1px solid white';
				$tabPanels->styles['border-left'] = '1px solid white';
				$tabPanels->styles['padding'] = '10px';
				
				foreach ($this->tabs as $tabTitle => $tabContent)
				{
						$className = "tabNotSelected";
						if ($bFirstTab)
								$className = "tabSelected";
						
						$tabs->SetCellContent($row, $col, $tabTitle);
						$tabs->SetCellStyle($row, $col, "width: 1%");
						$tabs->SetCellAttribute($row, $col, "class", $className);
						$tabs->SetCellAttribute($row, $col, 'id', 'tab' . $col);
						$tabs->SetCellAttribute($row, $col, 'onclick', "switchTabs('$col');");
						
						$className = "tabPanelNotSelected";
						if ($bFirstTab)
								$className = "tabPanelSelected";
						
						$tabPanel = new HtmlDiv("panel" . $col);
						$tabPanel->className = $className;
						$tabPanel->value = $tabContent;

						$tabPanels->value .= $tabPanel->Render(false);
						
						$bFirstTab = false;
						$col++;
				}
				
				$tabs->SetCellContent($row, $col, "&nbsp;");
				$tabs->SetCellAttribute($row, $col, "class", "tabNotSelectable");
				
				$div = new HtmlDiv();
				$div->styles['width'] = $this->width;
				$div->styles['background-color'] = '#AAAAAA';
				$div->styles['padding'] = '10px';
				$div->value = $tabs->Render(false) . $tabPanels->Render(false);
				
				return $div->Render($bEchoHtml);
		}
}
?>