<?php
require_once('HtmlControl.inc.php');
require_once('HtmlDiv.inc.php');
require_once('HtmlP.inc.php');

/**
	<!-- start roundcorners --><div class="top-left"></div><div class="top-right"></div><div class="inside">
	<p class="notopgap">Liquid round corners:</p>
	<p class="nobottomgap">easy making!</p>
	<!-- finish roundcorners --></div><div class="bottom-left"></div><div class="bottom-right"></div>
**/
class HtmlLiquidCorners extends HtmlControl
{
	var $centered;
	
	function HtmlLiquidCorners($id = 'liquidCorners')
	{
		$this->id = $id;
		$this->tag = 'div';
		
		parent::HtmlControl($id);
	}
	
	function Render($bEchoHtml = true)
	{
		$topLeftDiv = new HtmlDiv('top-left');
		$topRightDiv = new HtmlDiv('top-right');
		$insideDiv = new HtmlDiv('inside');
		$notopgapP = new HtmlP('notopgap');
		$nobottomgapP = new HtmlP('nobottomgap');
		$bottomLeftDiv = new HtmlDiv('bottom-left');
		$bottomRightDiv = new HtmlDiv('bottom-right');
		
		$topLeftDiv->className = 'top-left';
		$topRightDiv->className = 'top-right';
		$insideDiv->className = 'inside';
		$notopgapP->className = 'notopgap nobottomgap';
		$nobottomgapP->className = 'nobottomgap notopgap';
		$bottomLeftDiv->className = 'bottom-left';
		$bottomRightDiv->className = 'bottom-right';
		
		$insideDiv->body = $notopgapP->Render(false) . $this->body . $nobottomgapP->Render(false);
		
		$this->body = $topLeftDiv->Render(false) . $topRightDiv->Render(false) . 
									$insideDiv->Render(false) . $bottomLeftDiv->Render(false) . $bottomRightDiv->Render(false);
		
		return parent::Render($bEchoHtml);
	}
}
?>
