<?php

  include '../../../utils/dbutils.php';
  
  $CONTIKI_BASE_DIR = "/home/tiago/git/contiki-llsec/examples/er-rest-example";

  $llsec = str_split(getKeys()[0], 2);
  $formated_llsec = "#define NONCORESEC_CONF_KEY {";

  $size = count($llsec);
  for($i = 0; $i < $size; ++$i){
	if($i!=0){
	   $formated_llsec.= ",0x".$llsec[$i];
	} else{
	   $formated_llsec.= "0x".$llsec[$i];
	}
   }
  $formated_llsec.="}";
  
  $llsec_file_path = $CONTIKI_BASE_DIR."/bootstrap-key.h";
  $file = fopen($llsec_file_path, 'w');
  fwrite($file, $formated_llsec);
  fclose($file);
  
  $keycode = '#define ID '.$_POST['id'];
  print_r($keycode);
  $keycode_file_path = $CONTIKI_BASE_DIR."/resources/bootstrap-id.h";
  $file = fopen($keycode_file_path, 'w');
  fwrite($file, $keycode);
  fclose($file);

  $cmd_clean = "sudo make clean -C ";
  $cmd_make = "sudo make -C ";
  
  $cmd_target = $CONTIKI_BASE_DIR." TARGET=";
  $cmd_upload = " er-example-server.upload";

  $device = escapeshellarg($_POST['device']);
  
  $cmd_full_clean = $cmd_clean.$cmd_target.$device;
  $cmd_full_flash = $cmd_make.$cmd_target.$device.$cmd_upload;
  
  exec("/home/tiago/workspace/parallax/scripts/flash.sh '$cmd_full_clean'");
  exec("/home/tiago/workspace/parallax/scripts/flash.sh '$cmd_full_flash'");

?>
