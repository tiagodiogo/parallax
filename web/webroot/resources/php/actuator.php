<?php

    include '../../../utils/dbutils.php';

    if (isset($_POST['command'])) {
        $command = $_POST['command'];
     
        switch($command){
            case 'update_keys':
                $llsec = $_POST['llsec'];
                $dtls = $_POST['dtls'];
                setKeys($llsec, $dtls);
                break;
              
            case 'insert_zone':
            	$name = $_POST['name'];
                $description = $_POST['description'];
                insertZone($name, $description);
                break;
                
            case 'remove_zone':
            	$id = $_POST['id'];
                removeZone($id);
                break;
                
            case 'insert_node':
            	$name = $_POST['name'];
            	$type = $_POST['type'];
            	$zone = $_POST['zone'];
            	$id = insertNode($name, $type, $zone);
            	echo $id;
        }
    }
?>