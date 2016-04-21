<?php 

	include 'dbconfigs.php';

	//returns a PDO object
	function getConnection(){
		global $hostname,$database,$port,$dbuser,$dbuserpass;
		try{
			$db = new PDO("mysql:host=$hostname;port=$port;dbname=$database",
			 	$dbuser, $dbuserpass,
			 	array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		}
		catch(PDOException $e){
		    echo $e->getMessage();
	    }
	    return $db;
	}

	//updates the llsec and dtls network keys
	function setKeys($llsec, $dtls){
		print_r($llsec);
		print_r($dtls);
		try{
		    $db = getConnection();

		    $sql = "UPDATE network_keys SET network_key=? WHERE name='llsec'";
		    $stmt = $db->prepare($sql);
		    $stmt->execute(array($llsec));

		    $sql = "UPDATE network_keys SET network_key=? WHERE name='dtls'";
		    $stmt = $db->prepare($sql);
		    $stmt->execute(array($dtls));
		}
		catch(PDOException $e){
		    echo $e->getMessage();
	    }
	}

	//fetches the llsec and dtls network keys
	function getKeys(){
		try{
			$db = getConnection();

			$sql = "SELECT * FROM network_keys WHERE name = ?";
			$stmt = $db->prepare($sql);
			$stmt->execute(array("llsec"));
			$llsec = $stmt->fetch()['network_key'];

			$sql = "SELECT * FROM network_keys WHERE name = ?";
			$stmt = $db->prepare($sql);
			$stmt->execute(array("dtls"));
			$dtls = $stmt->fetch()['network_key'];
		}
		catch(PDOException $e){
		    echo $e->getMessage();
	    }
	    return array($llsec, $dtls);
	}

	//adds a new zone to the infrastructure
	function insertZone($name, $description){
		try{
			$db = getConnection();

			$sql = "INSERT INTO infrastructure_zones (name, description) VALUES(?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($name,$description));
		}
		catch(PDOException $e){
		    echo $e->getMessage();
	    }
	}

	//removes a zone from the infrastructure
	function removeZone($id){
		try{
			$db = getConnection();

			$sql = "DELETE FROM infrastructure_zones WHERE id = ?";
			$stmt = $db->prepare($sql);
			$stmt->execute(array($id));
		}
		catch(PDOException $e){
		    echo $e->getMessage();
	    }
	}

	//return the list of zones on the infrastructure
	function getZones(){
    	try{
    		$db = getConnection();

    		//query result array
		    $resultArray = array();

		    //get zone information and store in array of arrays
		    $sql = "SELECT * FROM infrastructure_zones";
		    $result = $db->query($sql);
		    foreach($result as $row){
				$id = $row['id'];
				$name = $row['name'];
				$description = $row['description'];
				$resultArray[] = array($id,$name,$description,0);
			} 

			//get number of nodes for each zone and add to result array
	        $size = count($resultArray);
	        for($i = 0; $i < $size; ++$i){
	            $sql = "SELECT COUNT(*) AS result FROM authorized_nodes WHERE zone='".$resultArray[$i][0]."'";
	            $result = $db->query($sql);
	            foreach($result as $row){
	                $records = $row['result'];
	                $resultArray[$i][3] = $records; 
	            }
	        }
	        $db = null;
	    }
	    catch(PDOException $e){
		    echo $e->getMessage();
	    }
		return $resultArray;
    }

    //returns the list of the platform supported hardware
    function getHardware(){
    	try{
    		$db = getConnection();

    		$sql = "SELECT id,code,name FROM supported_hardware";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			$stmt = null;
	    	$db = null;
		}
		catch(PDOException $e){
		    echo $e->getMessage();
	    }
	   
	    return $result;
    }

    //adds a new device to the authorized devices list
    function insertNode($name, $type, $zone){
    	try{
    		//random unique integer only ID
    		$id = hexdec(uniqid());
			$db = getConnection();

			$sql = "INSERT INTO authorized_nodes (keycode, name, type, zone, active) VALUES(?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($id,$name,$type,$zone,0));

            $stmt = null;
	    	$db = null;
		}
		catch(PDOException $e){
		    echo $e->getMessage();
	    }
	  
	    return $id;
    }


    //return nodes by zone name
    function getZoneNodes($zone){
    	try{
    		$db = getConnection();

    		$sql = "SELECT id FROM infrastructure_zones WHERE name = ?";
    		$stmt = $db->prepare($sql);
    		$stmt->execute(array($zone));
    		$zone_id = $stmt->fetch()['id'];
    		$stmt->closeCursor();

    		$sql = "SELECT id FROM authorized_nodes WHERE zone = ?";
			$stmt = $db->prepare($sql);
			$stmt->execute(array($zone_id));
			$result = $stmt->fetchAll();

			$stmt = null;
	    	$db = null;
    	}
    	catch(PDOException $e){
		    echo $e->getMessage();
	    }
	  
	    return $result;

    }

    //return up-to-date values on infrastructure resources for web display
    function getWebResources($zone){
    	try{

    		$nodes = getZoneNodes($zone);

  			$db = getConnection();  
    		$sql = "SELECT name,endpoint,value FROM node_resources WHERE node = ?";
    		foreach($nodes as $node){
				$stmt = $db->prepare($sql);
				$stmt->execute(array($node['id']));
				$result = $stmt->fetchAll();
				foreach($result as $row){
                    echo "<tr>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['endpoint']."</td>";
                        echo "<td style='text-align:center'>".$row['value']."</td>";
                    echo "</tr>";
				}
				$stmt = null;
    		}
			$db = null;

    	}
    	catch(PDOException $e){
		    echo $e->getMessage();
	    }
    }

?>