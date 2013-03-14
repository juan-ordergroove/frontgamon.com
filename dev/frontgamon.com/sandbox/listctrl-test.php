<html>
<?php
$PAGE_HEAD['title'] = "ListCtrl Test"; // Set title

require_once(PHP_DEV . 'page-open-head.inc.php'); // Open head
?>
<style>
.btnDivClicked {
  border-left: 1px solid black;
  border-top: 1px solid black;
  border-right: 1px solid white;
  border-bottom: 1px solid white;
}

.btnDivNotClicked {
    border-left:1px solid white;
    border-top: 1px solid white;
    border-right: 1px solid black;
    border-bottom: 1px solid black;
}

.btnLabelNotClicked {
}

.btnLabelClicked{
  position: relative;
  left: 1px;
  top: 1px;
}
</style>

<?php
require_once(PHP_DEV . 'includes.inc.php'); // JavaScript libraries and utilites
require_once(PHP_DEV . 'page-close-head.inc.php'); // Close head
?>
<body>
<div style='width: 400px; background-color: #AAAAAA; padding: 10px;'>
<table width="400px" cellspacing=0 cellpadding=0 style="border: 1px solid gray; font-size: 10pt; background-color: white;">
<tr id='listCtrlHeader' height='20px'>
		<td style='width: 50%; background: url(/images/listctrl-header.gif); font-weight: bold; color: #052537; border-bottom: 1px solid gray; border-right: 1px solid black; padding-left: 5px; '>Title</td>
		<td style='width: 50%; background: url(/images/listctrl-header.gif); font-weight: bold; color: #052537; border-bottom: 1px solid gray; border-left: 1px solid white; padding-left: 5px;'>Header</td>
</tr>
<tr id='listCtrl1' listCtrlValue='1' onmouseover="hoverList('1');" onclick="clickList('1');" onmouseout="idleList('1');">
		<td style='border-bottom: 1px solid gray; padding: 0px 10px'><label>Test</label></td>
		<td style='border-bottom: 1px solid gray; padding: 0px 10px'></label>Col 2</label></td>
</tr>
<tr id='listCtrl2' listCtrlValue='2' onmouseover="hoverList('2');" onclick="clickList('2');" onmouseout="idleList('2');">
		<td style="padding: 0px 10px;"><label>Test 2</label></td>
		<td style="padding: 0px 10px;"><label>col 4</label></td>
</tr>
</table>
<div style='text-align:left; padding: 5px 5px 15px 5px;'>
		<div id='editBtnDiv' class="btnDivNotClicked" onclick="btn_EditClick();" style='float: left; width: 25px;	padding: 3px 10px;'>
		  <label id='editBtnLabel' class="btnLabelNotClicked">
		    Edit
		  <label>
		</div>
		<img src="/images/spacer.gif" width='5' style='float: left;'>
		<div id='deleteBtnDiv' class="btnDivNotClicked" onclick='btn_DeleteClick();' style='float: left; width: 40px;	padding: 3px 10px;'>
		  <label id='deleteBtnLabel' class="btnLabelNotClicked">
		    Delete
		  <label>
		</div>
</div>
</div>
</body>
<script type='text/javascript'>
function btnRegister(btnId)
{
  var btnDiv = document.getElementById(btnId + 'BtnDiv');

  btnDiv.onmousedown = function() {
    var btnDiv = document.getElementById(btnId + 'BtnDiv');
    var btnLabel = document.getElementById(btnId + 'BtnLabel');

    btnLabel.className = 'btnLabelClicked';
    btnDiv.className = 'btnDivClicked';
  };

  btnDiv.onmouseup = function() {
    var btnDiv = document.getElementById(btnId + 'BtnDiv');
    var btnLabel = document.getElementById(btnId + 'BtnLabel');

    btnLabel.className = 'btnLabelNotClicked';
    btnDiv.className = 'btnDivNotClicked';
  }

  btnDiv.onmouseout = btnDiv.onmouseup;
}

btnRegister('edit');
btnRegister('delete');

function btn_DeleteClick()
{
  alert('delete');
}

function btn_EditClick()
{
  alert('edit');
}
</script>

<script type='text/javascript'>
var isClicked = false;
var currId = '0';

function hoverList(idNum)
{
  if (currId != idNum)
  {
    var tr = document.getElementById('listCtrl' + idNum);
    tr.style.backgroundColor = '#ffe7f6';
  }
}

function clickList(idNum)
{
  var tr = document.getElementById('listCtrl' + idNum);
  
  if (currId != idNum)
  {
    tr.style.backgroundColor = '#ee97a6';
    
    if (currId != '0')
    {
      tr = document.getElementById('listCtrl' + currId);
      tr.style.backgroundColor = 'white';
    }
    
    currId = idNum;
  }
  else
  {
    tr.style.backgroundColor = '#ffe7f6';
    currId = '0';
  }
}

function idleList(idNum)
{
  if (currId != idNum)
  {
    var tr = document.getElementById('listCtrl' + idNum);
    tr.style.backgroundColor = 'white';
  }
}
</script>
</html>
