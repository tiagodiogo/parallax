<?php

  include '../../../utils/dbutils.php';

  $command1 = "sudo make clean -C";
  $command2 = "sudo make -C";
  $path = " /home/tiago/git/6lbr-develop/examples/6lbr-demo TARGET=";

  $coap="WITH_COAPSERVER=1 ";
  $llsec="WITH_LLSEC=1 ";
  $dtls="WITH_TINYDTLS=1 WITH_DTLS_COAP=1";

  $command1 = $command1.$path;
  $command2 = $command2.$path;

  $device = escapeshellarg($_POST['device']);
  $command1 = $command1.$device." ";
  $command2 = $command2.$device." ";

  if($_POST['coap'] == "true"){$command2 = $command2.$coap;}
  if($_POST['llsec'] == "true"){$command2 = $command2.$llsec;}
  if($_POST['dtls'] == "true"){$command2 = $command2.$dtls;}

  $command2 = $command2." 6lbr-demo.upload";

  exec("/home/tiago/workspace/parallax/scripts/flash.sh '$command1'");
  exec("/home/tiago/workspace/parallax/scripts/flash.sh '$command2'");

  #echo shell_exec("/home/tiago/workspace/parallax/scripts/flash.sh '$command1'");
  #echo shell_exec("/home/tiago/workspace/parallax/scripts/flash.sh '$command2'");

?>
