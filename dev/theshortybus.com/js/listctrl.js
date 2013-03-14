var isClicked = false;
var currId = '0';

function hoverList(idNum)
{
		if (currId != idNum)
		{
						var tr = document.getElementById(idNum);
						tr.className = 'listctrlHover';
		}
}

function clickList(idNum)
{
  var tr = document.getElementById(idNum);
		
		var btnLabels = $('.btnDisabled');
		var btnDivs = $('.btnDivNotClicked');
		
		if (btnLabels.hasClass('btnDisabled'))
		{
						btnLabels.addClass("btnLabelNotClicked").removeClass('btnDisabled');
						btnDivs.each(function() {
														listctrlBtn(this.id, false);
						});
		}
		
		if (currId != idNum)
		{
						tr.className = 'listctrlSelected';
						
						if (currId != '0')
						{
										tr = document.getElementById(currId);
										tr.className = 'listctrlNotSelected';
						}
						
						currId = idNum;
		}
}

function idleList(idNum)
{
	 if (currId != idNum)
		{
				var tr = document.getElementById(idNum);
				tr.className = 'listctrlNotSelected';
		}
}

function loadList(o)
{
				alert('Hi');
}