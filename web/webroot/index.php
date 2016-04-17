<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <!-- Bootstrap core CSS -->
    <link href="resources/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="icon" href="resources/icon.png">

    <title>Parallax</title>

    <!-- Custom styles for this template -->
    <link href="resources/css/cover.css" rel="stylesheet">

  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner" style="vertical-align: top">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"><img height="48" width="48" src="resources/icon.png">&nbsp;</img>Parallax</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="#">Monitor</a></li>
                  <li><a href="flash.php">Flash</a></li>
                  <li><a href="setup.php">Setup</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover" style="margin-top: 150px; text-align: left">
<ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="#">NT-1F</a></li>
  <li role="presentation"><a href="#">DM</a></li>
  <li role="presentation"><a href="#">CL</a></li>
</ul>

	  <h3>North Tower - First Floor</h3>
      <table style="margin-top: 30px" class="table">
  			<tr>
  				<th width="50%">Name</th>
  				<th width="30%">Resource</th>
  				<th width="20%">Latest Reading</th>
  			</tr>
  			<tr>
  				<td>tmp-sensor-room-001</td>
  				<td>temperature</td>
  				<td style="text-align:center">23ºC</td>
  			</tr>
  			<tr>
  				<td>hum-sensor-room-125</td>
  				<td>humidity</td>
  				<td style="text-align:center">OK</td>
  			</tr>
  			<tr>
  				<td>hum-sensor-room-234</td>
  				<td>humidity</td>
  				<td style="text-align:center">HIGH</td>
  			</tr>
		  </table>
			
          </div>
          

          <div class="mastfoot">
            <div class="inner">
              <p>Available on <a href="https://github.com/tiagodiogo/parallax">GitHub</a>, by <a href="http://www.tiagodiogo.com">Tiago Diogo</a></p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="resources/js/jquery-2.2.2.min.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
  </body>
  
  <script>
  	$( "#form" ).submit(function( event ) {
  		event.preventDefault();
		$('#data').html("flashing new firmware, please wait...");
  		$.ajax({    //fetches data from file and inserts it in <div id="data"></div>
  			type: 'post',
     		url:'flash.php',
     		data:{device: $('#device-type').val(),
     			  coap: $('#coap').is(':checked'),
     			  llsec: $('#llsec').is(':checked'),
     			  dtls: $('#dtls').is(':checked')},
     		success :function(data){
				$('#data').html("Flashing Completed");
     		}	
   		}); 
	});
   </script>
  
</html>