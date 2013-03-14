<?php
require_once('HtmlTable.inc.php');
require_once('HtmlImage.inc.php');
require_once('HtmlSpan.inc.php');

class HtmlNewsTable extends HtmlControl
{
  var $table;
  var $value;

  function HtmlNewsTable($id = '')
  {
    $this->table = new HtmlTable($id);
    $this->table->SetTableAttribute('width', '100%');
    $this->table->SetTableAttribute('cellspacing', '0');

    $this->value = array();
  }

  function SetNewsItem($header, $content, $displayDate, $username)
  {
    $img = new HtmlImage();
    $img->src = IMAGES_DIR . 'spacer.gif';
    $img->height = '4';

				$titleSpan = new HtmlSpan('news-title-' . $header);
				$titleSpan->styles['dispay'] = 'block';
				$titleSpan->value = '"' . $header . '" - ' . $displayDate;

				$userSpan = new HtmlSpan('news-user-' . $username);
				$userSpan->styles['display'] = 'block';
				$userSpan->styles['font-size'] = '8pt';
				$userSpan->styles['font-weight'] = 'normal';
				$userSpan->value = 'by: ' . $username;
				
    $titleStyle = 'background: url(/images/news-bar-top.gif) repeat-x; text-align: left; font-weight: bold; font-size: 10pt; padding: 5px 15px;';
				
				$i = $this->table->AddRow();
				$this->table->SetCellContent($i, 1, $titleSpan->Render(false) . $userSpan->Render(false));
				$this->table->SetCellStyle($i, 1, $titleStyle . 'border-top: 2px solid #a94f4e; border-bottom: 1px solid #d9aeae;');
				
				$i = $this->table->AddRow();
				$this->table->SetCellContent($i, 1, $content);
				$this->table->SetCellStyle($i, 1, 'text-align: left; padding: 10px 5px;');
  }

  function Render($bEchoHtml = true)
  {
    return $this->table->Render($bEchoHtml);
  }
}
?>
