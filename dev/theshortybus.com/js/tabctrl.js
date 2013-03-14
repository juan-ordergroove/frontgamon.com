var currID = '1';

function switchTabs(id)
{
	 var currPanel = document.getElementById("panel" + currID);
		var currTab = document.getElementById("tab" + currID);
		
		var newPanel = document.getElementById("panel" + id);
		var newTab = document.getElementById("tab" + id);
		
		if (currID != id && newPanel.className == "tabPanelNotSelected" && newTab.className == "tabNotSelected")
		{
				currPanel.className = "tabPanelNotSelected";
				currTab.className = "tabNotSelected";
				
				newPanel.className = "tabPanelSelected";
				newTab.className = "tabSelected";
				
				currID = id;
		}
}
