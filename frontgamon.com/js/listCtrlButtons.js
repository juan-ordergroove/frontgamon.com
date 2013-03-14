function listctrlBtn(btnId, disabled)
{
				var btnDiv = document.getElementById(btnId);
				
				if (!disabled)
				{
								btnDiv.onmousedown = listctrlBtn.onmousedown;
								btnDiv.onmouseup = listctrlBtn.onmouseup;
								btnDiv.onmouseout = listctrlBtn.onmouseup;
								btnDiv.setAttribute("disabled", "");
				}
				else
				{
								btnDiv.setAttribute("disabled", "disabled");
				}
}

listctrlBtn.onmousedown = function() {
			 this.className = 'btnLabelClicked';
				this.className = 'btnDivClicked';
};

listctrlBtn.onmouseup = function() {
			 this.className = 'btnLabelNotClicked';
				this.className = 'btnDivNotClicked';

				var btnName = document.getElementById('btnName');
				if (btnName && btnName.id.length)
				{
								var title = this.id.substr(0, this.id.indexOf('Btn'));
								btnName.value = title;
				}
};
