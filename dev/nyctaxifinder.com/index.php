<html>
  <head>
    <title>NYCTaxiFinder.com - Lose something? Find it! New York City Taxi Search</title>
  </head>
    <script type='text/javascript' src='/js/jquery-ui/js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='/js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js'></script>

    <script type='text/javascript'>
    function expandContent(obj)
    {
      $(obj).next().slideDown('slow');
      $(obj).removeClass('ui-state-default');
      $(obj).addClass('ui-state-active');
    }

    function manageAccordions()
    {
      $('h3').unbind('click', initAccordion);
      $('h3').click(initAccordion).next().hide();
      $('h3').mouseover(function() {
        $(this).addClass('ui-state-hover');
      });
      $('h3').mouseout(function() {
        $(this).removeClass('ui-state-hover');
      });
    }
    
    function initAccordion(evt)
    {
      var headerObj = null;
      if ($(evt.target).is('label'))
        headerObj = $(evt.target).parent();
      else if ($(evt.target).is('a'))
        headerObj = $(evt.target).parent().parent();
      else if ($(evt.target).is('span'))
        headerobj = $(evt.target).parent().parent().parent();
      else
        headerObj = $(evt.target);

      $(headerObj).next().slideToggle('slow');
      if ($(headerObj).hasClass('ui-state-active'))
      {
        $(headerObj).removeClass('ui-state-active');
        $(headerObj).addClass('ui-state-default');
      }
      else
      {
        $(headerObj).removeClass('ui-state-default');
        $(headerObj).addClass('ui-state-active');
      }

      return false;
    }

    $(document).ready(function() {
      $('#tabs').tabs();
      $('#tabs').tabs('select', 0);

      $('#yellowDialog').dialog({
        bgiframe: true,
        autoOpen: false,
        modal: true,
        width: 550,
        resizable: false
      })

      $('#yellowTaxiHow').click(function() {
        $('#yellowDialog').dialog('open');
      });
      
      manageAccordions();

      var loadingHtml = '<div align="center"><img src="/images/ajax-loader.gif"></div>';
      $('#paratransitSubmit').click(function() {
        var licensePlateVal = ($('#paraLicensePlate').val().match(/^(T\d+C)|(\d+LA)|(AMBU\d+)$/) != null) ? $('#paraLicensePlate').val() : '';
          
        $('.paraLicenseContainer').html(' - ' + licensePlateVal);

        $('#paraBaseContainer').html(loadingHtml);
        $('#paraVehicleContainer').html(loadingHtml);
        $.get('paratransit-query.php', { licensePlate: licensePlateVal },
          function(data) {
            expandContent($('#accordion-paraBase'));
            expandContent($('#accordion-paraVehicle'));

            setTimeout(function() {
              var paraData = eval('(' + data + ')');
              $('#paraBaseContainer').html(paraData.base);
              $('#paraVehicleContainer').html(paraData.vehicle);
          }, 1000);
        });
      });

      $('#fhvSubmit').click(function() {
          var licensePlateVal = $('#fhvLicensePlate').val();

          $('.fhvLicenseContainer').html(' - ' + licensePlateVal);

          $('#fhvBaseContainer').html(loadingHtml);
          $('#fhvVehicleContainer').html(loadingHtml);

          $.get('fhv-query.php', { licensePlate: licensePlateVal },
            function(data) {
              expandContent($('#accordion-fhvBase'));
              expandContent($('#accordion-fhvVehicle'));

              setTimeout(function() {
                var fhvData = eval('(' + data + ')');
                $('#fhvBaseContainer').html(fhvData.base);
                $('#fhvVehicleContainer').html(fhvData.vehicle);
                
                $('.fhvLicenseContainer').append(' - ' + fhvData.type);
              }, 1000);
          });
      });

      $('#yellowCabSubmit').click(function() {
        var licenseNumberVal = ($('#licenseNumber').val().match(/^\d[A-Za-z]\d\d$/) != null) ? $('#licenseNumber').val() : '';

        $('.yellowMedContainer').html(' - ' + licenseNumberVal);

        $('#yellowTypeContainer').html(loadingHtml);
        $('#yellowDriverContainer').html(loadingHtml);
        $('#yellowVehicleContainer').html(loadingHtml);
        $.get('yellowcab-query.php', { licenseNumber: licenseNumberVal },
          function(data) {
            expandContent($('#accordion-yellowType'));
            expandContent($('#accordion-yellowDriver'));

            setTimeout(function() {
              var yellowData = eval('(' + data + ')');
              $('#yellowTypeContainer').html(yellowData.licenseType);
              $('#yellowDriverContainer').html(yellowData.drivers);
              $('#yellowVehicleContainer').html(yellowData.insurance);
            }, 1000);
          });
      });
      
      $('#zipSubmit').click(function() { 
        var zipCodeVal = ($('#zipCode').val().match(/^\d\d\d\d\d$/) != null) ? $('#zipCode').val() : '';

        $('#zipCodeContainer').html(loadingHtml);
        $.get('zip-query.php', { zipCode: zipCodeVal },
          function (data) {
            setTimeout(function() {
              $('#zipCodeContainer').html(data);
              manageAccordions();
            }, 1000);
          });
      });

      $('#licensePlate').keyup(function(e) {
        if(e.keyCode == 13) { $('#paratransitSubmit').click(); }
      });

      $('#licenseNumber').keyup(function(e) {
        if(e.keyCode == 13) { $('#yellowCabSubmit').click(); } 
      });

      $('#paraLicensePlate').keyup(function(e) {
        if(e.keyCode == 13) { $('#paratransitSubmit').click(); }
      });

      $('#zipCode').keyup(function(e) {
        if(e.keyCode == 13) { $('#zipSubmit').click(); }
      });
    });
    </script>

    <link type='text/css' rel='STYLESHEET' href='/js/jquery-ui/css/custom-theme/jquery-ui-1.7.2.custom.css'>
    
    <style>
    #info-frame {
      border: 1px solid #DDDDDD;
      width: 75em;
      margin-left: auto; 
      margin-right: auto;
    }
     
    body, td {
      font-family: Arial,Helvetica,Verdana,sans-serif;
      font-size: 0.7em;
    }
   
    .taxi-accordion label {
      margin: 0.5em;
      display: block;
    }
    
    .taxi-accordion div {
      margin: 1em;
    }

    .taxi-accordion td {
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
  </style>  
  <body bgcolor='black'>
  <div id="page-banner" align='center'><img src="/images/120509_taxibanner.gif"></div>
  <table id="content" align="center">
  <tr>
  <td>

<div id='yellowDialog' style='display: none;' align='center'>
  <div style='float: left'>
    <img src='/images/cabTop.jpg'>
  </div>
  <div style='float:right'>
    <img src='/images/cabFront.jpg'>
  </div>

  <div style='width: 30em; margin-top: 11em; margin-bottom: 2em; margin-left: auto; margin-right: auto;'>
    <p style='text-align: justify;'>
    The medallion number is a combination of
    number-letter-number-number unique to each yellow cab in New York
    City. It can be found on the taxi receipt, the taxi license plate, on
    the roof of the taxi or inside the car on the back of the partition.
    </p>
  </div>
</div>

<div id='info-frame'>
  <div id='tabs'>
    <ul>
      <li><a href="#tabs-1">Yellow Cabs</a></li>
      <li><a href="#tabs-4">Zip Code Search</a></li>
      <li><a href="#tabs-2">"Access-A-Ride"</a></li>
      <li><a href="#tabs-3">FHV Drivers</a></li>
      <li><a href="#tabs-about">About Us</a></li>
    </ul>
    <div id="tabs-1" style="margin-bottom: 2.5em; margin-top: 1.5em;">
    
    <label>Medallion Number: </label>
    <input type='text' id='licenseNumber' name='licenseNumber' value=''>
    <input type='button' id='yellowCabSubmit' value='Search' /> - <span id='yellowTaxiHow'><a href='#'>Need help? Check this out</a></span>
    
    <div class='taxi-accordion' style='margin: 1em 1em 4em;'>
      <h3 id='accordion-yellowType' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
        <label><a href='#'>Base Details<span class='yellowMedContainer'></span></a></label>
      </h3>
      <div id='yellowTypeContainer' style='overflow:visible;'>
      &nbsp;
      </div>

      <h3 id='accordion-yellowDriver' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
        <label><a href='#'>Driver Details<span class='yellowMedContainer'></span></a></label>
      </h3>
      <div id='yellowDriverContainer' style='overflow:visible;'>
      &nbsp;
      </div>

      <h3 id='accordion-yellowVehicle' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
        <label><a href='#'>Vehicle Details<span class='yellowMedContainer'></span></a></label>
      </h3>
      <div id='yellowVehicleContainer' style='overflow:visible;'>
      &nbsp;
      </div>
    </div>
  </div>

  <div id='tabs-2' style='margin-top: 1.5em;'>
    <label>License Plate Number: </label>
    <input type='text' id='paraLicensePlate' name='paraLicensePlate' value=''>
    <input type='button' value='Search' id='paratransitSubmit'>

    <div class='taxi-accordion' style='margin: 1em 1em 4em;'>
      <h3 id='accordion-paraBase' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
        <label><a href='#'>Base Details<span class='paraLicenseContainer'></span></a></label>
      </h3>
      <div id='paraBaseContainer' style='overflow:visible;'>
      &nbsp;
      </div>

      <h3 id='accordion-paraVehicle' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
        <label><a href='#'>Vehicle Details<span class='paraLicenseContainer'></span></a></label>
      </h3>
      <div id='paraVehicleContainer' style='overflow:visible;'>
      &nbsp;
      </div>
    </div>
  </div>

  <div id='tabs-3' style='margin-top:1.5em'>
				<label>License Plate Number: </label>
				<input type='text' id='fhvLicensePlate' name='fhvLicensePlate' value=''>
				<input type='button' value='Search' id='fhvSubmit'>

				<div class='taxi-accordion' style='margin: 1em 1em 4em;'>
						<h3 id='accordion-fhvBase' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
						  <label><a href='#'>Base Details<span class='fhvLicenseContainer'></span></a></label>
						</h3>
				  <div id='fhvBaseContainer' style='overflow:visible;'>
								&nbsp;
						</div>

						<h3 id='accordion-fhvVehicle' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
						  <label><a href='#'>Vehicle Details<span class='fhvLicenseContainer'></span></a></label>
						</h3>
						<div id='fhvVehicleContainer' style='overflow:visible;'>
								&nbsp;
						</div>
				</div>
		</div>
  <div id='tabs-4' style='margin-top:1.5em'>
    <label>Zip Code: </label>
    <input type='text' id='zipCode' name='zipCode' value=''>
    <input type='button' value='Search' id='zipSubmit'>
    <div id='zipCodeContainer' style='margin-bottom: 5em;'>

    </div>
  </div>
  <div id='tabs-about' class='taxi-accordion' style='height: 15em; margin: 0em 1em;'>
    <h3 id='accordion-about' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
      <label><a href='#'>How to use this</a></label>
    </h3>
    <div style='text-align:justify; margin-top: 1em; margin-left: auto; margin-right: auto'>
      NYCTaxifinder.com is a resource for detailed information about 
      vehicles licensed by the New York City Taxi and Limousine Commission. 
      All information provided on this site is publicly available 
      and NYCTaxifinder.com makes no warranty or any other claim 
      regarding the accuracy, validity or timeliness of the information 
      provided here. 
    </div>

    <h3 id='accordion-about' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-all' role='tab' aria-expanded='false' tabindex='-1'>
      <label><a href='#'>Links</a></label>
    </h3>
    <div style='text-align:justify; margin-top: 1em; margin-left: auto; margin-right: auto'>
      Coming soon...
    </div>
  </div>
</div>
</td>
</tr>
<tr>
<td align='center'>
<div style='width:50%; margin-top: 1em;'>
  <div class='ui-tabs-panel ui-widget-content'>
    <div style='margin: 1em 0em;'>
      &copy; 2009-2010 NYCTaxifinder.com<br>
      <a href="mailto:taxiadmin@nyctaxifinder.com">Contact Us - taxiadmin@nyctaxifinder.com</a>
    </div>
  </div>
</div>
</td>
</tr>
</table>

<?php
$hostname = explode('.', $_SERVER['HTTP_HOST']);

if ($hostname[0] != 'dev')
{
  echo '
  <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
    try {
      var pageTracker = _gat._getTracker("UA-5600052-2");
      pageTracker._trackPageview();
    } catch(err) {}
  </script>
  ';
}
?>
  </body>
</html>
