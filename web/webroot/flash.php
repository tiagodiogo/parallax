<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>Parallax</title>
   
    <link href="resources/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="icon" href="resources/icon.png">
    <link href="resources/css/cover.css" rel="stylesheet">
    
    <script src="resources/js/jquery-2.2.2.min.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
    
    <?php
      ini_set('display_errors',1);
      error_reporting(E_ALL|E_STRICT);
      include '../utils/dbutils.php';
      $hardware = getHardware();
      $zones = getZones();
    ?>

  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"><img height="48" width="48" src="resources/icon.png">&nbsp;</img>Parallax</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li><a href="index.php">Monitor</a></li>
                  <li class="active"><a href="#">Flash</a></li>
                  <li><a href="setup.php">Setup</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div style="text-align: left">
            <h2>Firmware Flasher</h2>
            <p class="lead">Plug your device into a USB port and place it into bootloader mode</p>
          
            <form id="form" class="form-horizontal">
			  <div style="margin-top: 30px;" class="form group">
			  	<label style="padding-top: 8px;" for "name" class="col-sm-3 col-sm-offset-1 control-label">Device Name</label>
			    <div style="margin-right: 80px" class="col-sm-6">
			    	<input type="text" class="form-control" id="name" placeholder="tmp-sensor-room-001">
			  	</div>
			  </div>
			  <div style="margin-top: 10px" class="form group">
			  	<label style="padding-top: 18px" for "device-type" class="col-sm-3 col-sm-offset-1 control-label">Device Type</label>
			  	<div style="padding-top: 10px; margin-right: 80px" class="col-sm-6">
			  		<select id="device-type" class="form-control">
			  			<?php
                    		$size = count($hardware);
                    		for($i = 0; $i < $size; ++$i){
                      			echo '<option value="'.$hardware[$i][0].'-'.$hardware[$i][1].'">'.$hardware[$i][2].'</option>';
                    		}
                  		?>
			  		</select>
			  	</div>
			  </div>
			  <div style="margin-top: 10px;" class="form group">
			  	<label style="padding-top: 18px;" for "infra-zone" class="col-sm-3 col-sm-offset-1 control-label">Infrastructure Zone</label>
			    <div style="padding-top: 10px; margin-right: 80px" class="col-sm-6">
			  		<select id="infra-zone" class="form-control">
			  			<?php
                    		$size = count($zones);
                    		for($i = 0; $i < $size; ++$i){
                      			echo '<option value="'.$zones[$i][0].'">'.$zones[$i][2].'</option>';
                    		}
                  		?>
			  		</select>
			  	</div>
			  </div>
			
			<div style="text-align: center" class="form group">  
			 	<label style="margin-top: 30px" class="checkbox-inline">
					<input type="checkbox" id="coap"> CoAP Server
			  	</label>
				<label style="margin-top: 30px" class="checkbox-inline">
	  				<input name=llsec type="checkbox" id="llsec"> Link-Layer Security
				</label>
				<label style="margin-top: 30px" class="checkbox-inline">
	  				<input name=dtls type="checkbox" id="dtls"> DTLS
				</label>
			</div>
			  
			<div style="margin-top: 35px; text-align: center"> 
				<button type="submit" class="btn btl-lg btn-default">Flash Device</button>
			</div>
			
			</form>
			
          </div>
          
          <h3 style="margin-top:20px" id="data"></h3>

          <div class="mastfoot">
            <div class="inner">
              <p>Available on <a href="https://github.com/tiagodiogo/parallax">GitHub</a>, by <a href="http://www.tiagodiogo.com">Tiago Diogo</a></p>
            </div>
          </div>

        </div>

      </div>

    </div>

  </body>
  
  <script>
  	$( "#form" ).submit(function( event ) {
  		event.preventDefault();
		$('#data').html("flashing new firmware, please wait...");
  		$.ajax({   
  			type: 'post',
     		url:'resources/php/actuator.php',
     		data:{ 
     			  command: "insert_node",
     			  name: $('#name').val(),	
     			  type: $('#device-type').val().split("-")[0],
     			  zone: $('#infra-zone').val()},
     		success :function(keycode){
     			$.ajax({   
  					type: 'post',
     				url:'resources/php/contiki-flasher.php',
     				data:{
     				    id: keycode, 	
     			  		device: $('#device-type').val().split("-")[1],
     			  		coap: $('#coap').is(':checked'),
     			  		llsec: $('#llsec').is(':checked'),
     			  		dtls: $('#dtls').is(':checked')},
     				success :function(response2){
						$('#data').html("Flashing Completed");
     				},	
   				});
     		}	
   		});
	});
   </script>
  
</html>
