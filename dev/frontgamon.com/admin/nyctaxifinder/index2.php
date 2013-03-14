<?php
require_once(PHP_DEV . 'HtmlControl/HtmlTable.inc.php');
require_once(PHP_DEV . 'classes/NYC/NYCTaxiFactory.class.php'); 
require_once(PHP_DEV . 'classes/NYC/YellowCabMedallion.class.php');

function BuildDataTable($dataArray, $tableId = '')
{
	$columnHeaders = array_keys($dataArray[0]);
	
	$table = new HtmlTable($tableId);
	$table->SetTableAttribute('border', 1);
	$i = $table->AddRow();
	$col = 1;

  foreach ($columnHeaders as $header)
	{
		if (is_numeric($header))
			continue;
		$table->SetCellContent($i, $col++, $header);
	}

	foreach ($dataArray as $data)
	{
		$i = $table->AddRow();
		$col = 1;
		foreach ($data as $header => $value)
		{
			if (is_numeric($header))
				continue;
			$table->SetCellContent($i, $col++, $value);
		}
	}

  return $table;
}

$yellowCabMedallion = new YellowCabMedallion();

$licenseNumber = isset($_POST['licenseNumber']) ? $_POST['licenseNumber'] : '';
if (!preg_match('/^\d[A-Za-z]\d\d$/', $licenseNumber))
  $licenseNumber = '';

$taxiFactory = new NYCTaxiFactory($yellowCabMedallion, $licenseNumber);
$taxiFactory->BuildLicenseNumberData();
?>

<html>
  <head>
    <title>NYCTaxiFinder.com - Lose something? Find it!</title>
  </head>
    <script type='text/javascript' src='/js/jquery-ui/js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='/js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js'></script>

    <script type='text/javascript'>

    $(document).ready(function() {
      $('#tabs').tabs();
      $('#tabs').tabs('select', 0);
      
      $('h3').click(function () {
        $(this).next().slideToggle('slow');
        if ($(this).hasClass('ui-state-active'))
        {
          $(this).removeClass('ui-state-active');
          $(this).addClass('ui-state-default');
        }
        else
        {
          $(this).removeClass('ui-state-default');
          $(this).addClass('ui-state-active');
        }
        return false;
        }).next().hide();

      $('h3').mouseover(function() {
          $(this).addClass('ui-state-hover');
      });

      $('h3').mouseout(function() {
          $(this).removeClass('ui-state-hover');
      });
      
      <?php if (strlen($licenseNumber)) echo "$('#accordion-1').click();"; ?>
    });
    </script>

    <link type='text/css' rel='STYLESHEET' href='/js/jquery-ui/css/ui-darkness/jquery-ui-1.7.2.custom.css'>
    
    <style>
    #info-frame {
      border: 1px solid #DDDDDD;
      width: 60em;
      margin-left: auto; 
      margin-right: auto;
      margin-top: 13em;
    }
     
    body, td {
      font-family: Arial,Helvetica,Verdana,sans-serif;
      font-size: 0.7em;
    }
   
    #taxi-accordion label {
      margin: 0.5em;
      display: block;
    }
    
    #taxi-accordion div {
      margin: 1em;
    }

    #taxi-accordion td {
      font-family: Arial,Helvetica,Verdana,sans-serif;
      font-size: 0.7em;
      color: white;
    }

    /* Remove margins from the 'html' and 'body' tags, and ensure the page takes up full screen height */
    html, body {
      height:100%; 
      margin:0; 
      padding:0;
    }
    
    /* Set the position and dimensions of the background image. */
    #page-background {
      position:fixed; 
      top:0; 
      left:0; 
      width:100%; 
      height:100%;
    }

    /* Specify the position and layering for the content that needs to appear in front of the background image. Must have a higher z-index value than the background image. Also add some padding to compensate for removing the margin from the 'html' and 'body' tags. */
    #content {
      position:relative; 
      z-index:1; 
      padding:10px;
    }
    </style>

    <!-- The above code doesn't work in Internet Explorer 6. To address this, we use a conditional comment to specify an alternative style sheet for IE 6 -->
    <!--[if gte IE 6]>
    <style type="text/css">
    html { overflow-y:hidden; }
    body { overflow-y:auto; }
    #page-background { position:absolute; z-index:-1; }
    #content { position:static; padding:10px; }
    </style>
    <![endif]-->
  <body>
  <div id="page-background"><img src="/images/checkered3.jpg" width="100%" height="100%"></div>
  <table id="content" align="center">
  <tr>
  <td>
  <?php
 /* 
  if ($taxiFactory->FetchBulkData($licenseNumber))
  {
    $table = BuildDataTable($taxiFactory->FactoryResults[$licenseNumber][NYC_DRIVER], 'driver');
    $table->Render();

    echo "<br><br>\n";
    if ($taxiFactory->FactoryResults[$licenseNumber][NYC_DETAILS])
    {
      echo "Driver details\n";
      $table = BuildDataTable($taxiFactory->FactoryResults[$licenseNumber][NYC_DETAILS], 'detail');
      $table->Render();
    }
    else
    {
      echo $taxiFactory->ResultMessage[NYC_DETAILS];
    }
  }
  else
  {
    echo $taxiFactory->ResultMessage[NYC_DRIVER];
  }
  */
  ?>

  <br>
<div style="float: left; margin-top: 13em; margin-left: auto; margin-right: 2em; width: 17.5em; border: 1px solid #DDDDDD;">
  <div class="ui-tabs ui-widget ui-widget-content">
    <div class="ui-widget-header ui-corner-all" style='padding: 0.7em 1em;' align='center'>Test</div>
    <div style='margin: 0em 1em;'>
    <p style='margin: 1em 0em;'>
    NYCTaxifinder.com is a resource for detailed
    information about vehicles licensed by the New York City Taxi and
    Limousine Commission. All information provided on this site is
    available in the public domain and NYCTaxifinder.com makes no warranty
    or any other claim regarding the accuracy, validity or timeliness of
    the information provided here.
    </p>
    </div>

  </div>
</div>
<div id='info-frame' style='float: right;'>
  <div id='tabs'>
    <ul>
      <li><a href="#tabs-1">Yellow Cabs</a></li>
    </ul>
    <div id="tabs-1" style="margin-bottom: 2.5em;">
    
    <form id='mainform' method='post'>
      <label>License/Medallion Number: </label>
      <input type='text' name='licenseNumber' value=<?php printf("'%s'", $licenseNumber);?> />
      <input type='submit' value='Search' />
      <?php
      if (isset($_POST['licenseNumber']) && strlen($licenseNumber) == 0)
        echo " - Please enter a valid license/medallion number";
      ?>
    </form>
    
    <div id='taxi-accordion' style='margin: 1em;'>
      <h3 id='accordion-1' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
        <label><a href='#'>Agent Details - <?php printf("%s", $licenseNumber); ?></a></label>
      </h3>
      <div style='overflow:visible;'>
        <?php
        if ($taxiFactory->FactoryResults[$licenseNumber][NYC_LICENSE_TYPE]) {
          $table = new HtmlTable('detail');
          $table->SetTableAttribute('cellspacing', 0);
          $table->SetTableAttribute('cellpadding', '4');
          $table->SetTableAttribute('border', 1);
          $table->SetTableAttribute('align', 'center');

          $i = $table->AddRow();
          $table->SetCellContent($i, 1, '<b>Licensee Name</b>');
          $table->SetCellAttribute($i, 1, 'align', 'center');
          $table->SetCellContent($i, 2, '<b>Address</b>');
          $table->SetCellAttribute($i, 2, 'align', 'center');
          $table->SetCellContent($i, 3, '<b>Telephone</b>');
          $table->SetCellAttribute($i, 3, 'align', 'center');
          $table->SetCellContent($i, 4, '<b>License Type</b>');
          $table->SetCellAttribute($i, 4, 'align', 'center');
  
          $taxiDetails = $taxiFactory->FactoryResults[$licenseNumber][NYC_LICENSE_TYPE];
          foreach ($taxiDetails as $details)
          {
            $address = sprintf('%s %s, %s, %s', $details['StreetAddress'], $details['City'], $details['State'], $details['ZipCode']);

            $i = $table->AddRow();
            $table->SetCellContent($i, 1, $details['NameOfLicensee']);
            $table->SetCellAttribute($i, 1, 'align', 'center');
            $table->SetCellContent($i, 2, $address);
            $table->SetCellAttribute($i, 2, 'align', 'center');
            $table->SetCellContent($i, 3, $details['Telephone']);
            $table->SetCellAttribute($i, 3, 'align', 'center');
            $table->SetCellContent($i, 4, $details['LicenseType']);
            $table->SetCellAttribute($i, 4, 'align', 'center');
          }
        
          $table->Render();
        }
        else {
          printf('There are no agent details currently available.');
        }
        ?>
      </div>

      <h3 id='accordion-2' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
        <label><a href='#'>Driver Details - <?php printf('%s', $licenseNumber); ?></a></label>
      </h3>
      <div style='overflow:visible;'>
        <?php
        if ($taxiFactory->FactoryResults[$licenseNumber][NYC_DRIVERS])
        {   
          $table = new HtmlTable('driver');
          $table->SetTableAttribute('cellspacing', 0);
          $table->SetTableAttribute('cellpadding', '4');
          $table->SetTableAttribute('border', 1);
          $table->SetTableAttribute('width', '50%');
          $table->SetTableAttribute('align', 'center');
        
          $i = $table->AddRow();
          $table->SetCellContent($i, 1, '<b>Driver Name</b>');
          $table->SetCellAttribute($i, 1, 'align', 'center');
          $table->SetCellAttribute($i, 1, 'width', '33%');
          $taxiDrivers = $taxiFactory->FactoryResults[$licenseNumber][NYC_DRIVERS];
          foreach ($taxiDrivers as $driver)
          {
            $driverNamePieces = explode(',', $driver['DriverName']);

            $i = $table->AddRow();
            $table->SetCellContent($i, 1, $driverNamePieces[1] . ' ' . $driverNamePieces[0]);
            $table->SetCellAttribute($i, 1, 'align', 'center');
          }

          $table->Render();
        }
        else
        {
          printf('There are no drivers specified.');
        }
        ?>
      </div>

      <h3 id='accordion-3' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
        <label></a>Insurance Details - <?php  printf('%s', $licenseNumber); ?></a></label>
      </h3>
      <div style='overflow:visible;'>
        <?php
        if ($taxiFactory->FactoryResults[$licenseNumber][NYC_INSURANCE])
        {
          // Insurance info is all the same for a car, so only grab it for the first driver
          $firstDriver = $taxiFactory->FactoryResults[$licenseNumber][NYC_INSURANCE][0];

          $table = new HtmlTable('insurance');
          $table->SetTableAttribute('cellspacing', 0);
          $table->SetTableAttribute('cellpadding', '4');
          $table->SetTableAttribute('border', 1);
          $table->SetTableAttribute('width', '50%');
          $table->SetTableAttribute('align', 'center');

          $i = $table->AddRow();
          $table->SetCellContent($i, 1, '<b>Vehicle Owner</b>');
          $table->SetCellAttribute($i, 1, 'align', 'center');
          $table->SetCellContent($i, 2, '<b>Insurance Code</b>');
          $table->SetCellAttribute($i, 2, 'align', 'center');
          $table->SetCellContent($i, 3, '<b>Insurance Policy Number</b>');
          $table->SetCellAttribute($i, 3, 'align', 'center');

          $i = $table->AddRow();
          $table->SetCellContent($i, 1, $firstDriver['VehicleOwnerName']);
          $table->SetCellAttribute($i, 1, 'align', 'center');
          $table->SetCellContent($i, 2, $firstDriver['InsuranceCode']);
          $table->SetCellAttribute($i, 2, 'align', 'center');
          $table->SetCellContent($i, 3, $firstDriver['InsurancePolicyNumber']);
          $table->SetCellAttribute($i, 3, 'align', 'center');

          $table->Render();
        }
        else
        {
          printf('There is no insurance information currently available.');
        }
        ?>
      </div>
    </div>
  </div>
  <div align='center'>
    &copy; 2009-2010 NYCTaxifinder.com<br>
    <a href="mailto:taxiadmin@nyctaxifinder.com">Contact Us - taxiadmin@nyctaxifinder.com</a>
  </div>
</div>
</td>
</tr>
</table>

<script type="text/javascript">
  var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
  document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
  try {
    var pageTracker = _gat._getTracker("UA-5600052-2");
    pageTracker._trackPageview();
  } catch(err) {}
</script>
  </body>
</html>
