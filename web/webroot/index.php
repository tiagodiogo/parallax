<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <link href="resources/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="resources/icon.png">
    <link href="resources/css/cover.css" rel="stylesheet">

    <title>Parallax</title>

    <?php
      ini_set('display_errors',1);
      error_reporting(E_ALL|E_STRICT);
      include '../utils/dbutils.php';
      $zones = getZones();
    ?>
   
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
			<ul id="myTab" class="nav nav-tabs">
				<?php
	          		$size = count($zones);
	          		for($i = 0; $i < $size; ++$i){
	          			if($i == 0){
	          				echo "<li class='active'><a href='#".$zones[$i][1]."' data-toggle='tab'>".$zones[$i][1]."</a></li>";
	          			} else {
	          				echo "<li class=''><a href='#".$zones[$i][1]."' data-toggle='tab'>".$zones[$i][1]."</a></li>";
	          			}      
	          		}
	        	 ?>
			</ul>
			<div id="myTabContent" class="tab-content">
				<?php
	          		$size = count($zones);
	          		for($i = 0; $i < $size; ++$i){
		          		if($i == 0){
		          			echo "<div class='tab-pane fade active in' id='".$zones[$i][1]."'>";	
		          		} else {
		          			echo "<div class='tab-pane fade in' id='".$zones[$i][1]."'>";
		          		}
		          		echo "<h3>".$zones[$i][2]."</h3>";
		          		echo "<div>";
		          			echo "<table id='".$zones[$i][1]."' style='margin-top: 30px' class='table'>";
			          			echo "<thead>";
			          				echo "<tr><th width='50%'>Name</th><th width='30%'>Resource</th><th width='20%'>Latest Reading</th></tr>";
					  			echo "</thead>";
					  			echo "<tbody></tbody>";
				  			echo "</table>";
		          		echo "</div>";
		          		echo "</div>";
		          	}  
	        	 ?>
  		    </div>

	 
			
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
  	$(document).ready(function(){
	    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
	        var currentTab = $(e.target).text();
	        //alert(currentTab);
	        $.ajax({
	  			type: 'post',
	     		url:'resources/php/actuator.php',
	     		data:{command: 'get_resources',
	     			  zone: $(e.target).text()},
	     		success :function(response){
	     			$('table#'+$(e.target).text()+' tbody').html(response);
	     		},
   			}); 
	    });
	});
   </script>
  
</html>
