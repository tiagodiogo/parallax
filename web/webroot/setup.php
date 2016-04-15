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
      $keys = getKeys();
      $zones = getZones();
    ?>
    
    <script>
      $( document ).ready(function() {
      	$("#responsePanel").hide();
      });
    </script>

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
                  <li><a href="index.html">Monitor</a></li>
                  <li><a href="flash.html">Flash</a></li>
                  <li class="active"><a href="#">Setup</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div style="text-align: left">
          	<div id="responsePanel" class="alert alert-success" role="alert"></div>
            <h3>Security</h3>
          
            <form id="keys" class="form-horizontal">
			  <div style="margin-top: 20px;" class="form group">
			  	<label style="padding-top: 8px;" for "llsec" class="col-sm-4">Link Layer Security Key</label>
			    <div class="col-sm-8">
			    	<?php
			    		echo "<input value=".$keys[0]." type='text' class='form-control' id='llsec' placeholder='000102030405060708090A0B0C0D0E0F'>"
			    	?>
			  	</div>
			  </div>
			  <div class="form group">
			  	<label style="padding-top: 18px;"for "dtls" class="col-sm-4">DTLS Key</label>
			    <div style="padding-top: 10px;" class="col-sm-8">
			    	<?php
			    		echo "<input value=".$keys[1]." type='text' class='form-control' id='dtls' placeholder='000102030405060708090A0B0C0D0E0F'>"
			    	?>
			  	</div>
			  </div>
			   <div style="margin-right: 20px; text-align: right;"> 
				<button type="submit" style="margin-top: 15px;" class="btn btl-lg btn-default">Update Keys</button>
			  </div>
			</form>
			
			<h3>Infrastructure</h3>
			<form id="zones" class="form-horizontal">
			  <div style="margin-top: 20px;" class="form group">
			  	<label style="padding-top: 8px;" for "name" class="col-sm-4">Zone Name</label>
			    <div class="col-sm-8">
			    	<input type="text" class="form-control" id="name" placeholder="NT-1F">
			  	</div>
			  </div>
			  <div class="form group">
			  	<label style="padding-top: 18px;"for "description" class="col-sm-4">Zone Description</label>
			    <div style="padding-top: 10px;" class="col-sm-8">
			    	<input type="text" class="form-control" id="description" placeholder="North Tower - First Floor">
			  	</div>
			  </div>
			  <div style="margin-right: 20px; text-align: right;"> 
				<button type="submit" style="margin-top: 15px;" class="btn btl-lg btn-default">Insert Zone</button>
			  </div>
		    </form>
          
          <table style="margin-top: 30px" class="table">
  			<tr>
  				<th width="20%">Name</th>
  				<th width="55%">Description</th>
  				<th width="15%">Node Count</th>
  				<th width="10%">Actions</th>
  			</tr>
  			<?php
	          $size = count($zones);
	          for($i = 0; $i < $size; ++$i){
	              echo "<tr>";
	              	echo "<td>".$zones[$i][1]."</td>";
	              	echo "<td>".$zones[$i][2]."</td>";
	              	echo "<td style='text-align:center'>".$zones[$i][3]."</td>";
	              	echo "<td style='text-align:center'><button type='button' class='btn btn-xs btn-danger' onclick='deleteZone(".$zones[$i][0].")'>Delete</button></td>";
	              echo "</tr>";	          
	          }
	        ?>
		  </table>
		 
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
  
  	function deleteZone(id){
  		$.ajax({
  			type: 'post',
     		url:'resources/php/actuator.php',
     		data:{command: "remove_zone",
     			  id: id},
     		success :function(data){
     			$('#responsePanel').empty();
				$('#responsePanel').html("Zone Deleted");
				$('#responsePanel').show();
     		}	
   		}); 
  	}
  
  	$( "#keys" ).submit(function( event ) {
  		event.preventDefault();
  		$.ajax({
  			type: 'post',
     		url:'resources/php/actuator.php',
     		data:{command: "update_keys",
     			  llsec: $('input#llsec').val(),
     			  dtls: $('input#dtls').val()},
     		success :function(data){
     			$('#responsePanel').empty();
				$('#responsePanel').html("Keys Updated");
				$('#responsePanel').show();
     		}	
   		}); 
	});
	
	$( "#zones" ).submit(function( event ) {
  		event.preventDefault();
  		$.ajax({
  			type: 'post',
     		url:'resources/php/actuator.php',
     		data:{command: "insert_zone",
     			  name: $('input#name').val(),
     			  description: $('input#description').val()},
     		success :function(data){
     			$('#responsePanel').empty();
				$('#responsePanel').html("Zone Inserted");
				$('#responsePanel').show();
     		}	
   		}); 
	});
		
   </script>
  
</html>
