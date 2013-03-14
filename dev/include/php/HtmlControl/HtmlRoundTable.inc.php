<?php
require_once('HtmlTable.inc.php');

if (isset($css_include))
	$css_include[] = CSS_INCLUDE_DIR . 'roundtable.css';
else
	$css_include = array(CSS_INCLUDE_DIR . 'roundtable.css');

class HtmlRoundTable extends HtmlTable
{
	function HtmlRoundTable($id = '')
	{
		parent::HtmlTable($id);
	}
	
	function Render($bEchoHtml = true)
	{
		$tableContent = $this->body;
		
		$this->SetTableAttribute('border', 0);
		$this->SetTableAttribute('cellpadding', 0);
		$this->SetTableAttribute('cellspacing', 0);
		
		$i = $this->AddRow();
		$this->SetRowAttributes($i, array('style' => 'line-height: 1px'));

		$this->SetCellAttribute($i, 1, 'width', '21px');
		$this->SetCellContent($i, 1, '<img src="/images/top-left.gif" width="21px" height="21px" alt="">');
		$this->SetCellAttribute($i, 2, 'class', 'topHorizLine');
		$this->SetCellContent($i, 2, '');
		$this->SetCellAttribute($i, 3, 'width', '21px');
		$this->SetCellContent($i, 3, '<img src="/images/top-right.gif" width="21px" height="21px" alt="">');
		
		$i = $this->AddRow();
		$this->SetCellAttribute($i, 1, 'width', '21px');
		$this->SetCellAttribute($i, 1, 'class', 'leftVertLine');
		$this->SetCellContent($i, 1, '');
		$this->SetCellAttribute($i, 2, 'align', 'center');
		$this->SetCellContent($i, 2, $tableContent);
		$this->SetCellAttribute($i, 3, 'width', '21px');
		$this->SetCellAttribute($i, 3, 'class', 'rightVertLine');
		$this->SetCellContent($i, 3, '');
		
		$i = $this->AddRow();
		$this->SetCellAttribute($i, 1, 'width', '21px');
		$this->SetCellContent($i, 1, '<img src="/images/bottom-left.gif" width="21px" height="21px" alt="">');
		$this->SetCellAttribute($i, 2, 'class', 'bottomHorizLine');
		$this->SetCellContent($i, 2, '');
		$this->SetCellAttribute($i, 3, 'width', '21px');
		$this->SetCellContent($i, 3, '<img src="/images/bottom-right.gif" width="21px" height="21px" alt="">');
		
		return parent::Render($bEchoHtml);
	}
}
?>
