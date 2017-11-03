<?php
  // post request?
  $request_method = $_SERVER['REQUEST_METHOD'];
  if ($request_method != "POST"){
    http_response_code(404);
    return;
  }

  // get post json data
  $post_data = $GLOBALS['HTTP_RAW_POST_DATA'];
  $json_data = json_decode($post_data, true);
  $sql = "\"".$json_data['sql']."\"";
  
  #$sql = "\"select * from user where phone = '123'\"";
  $command = '/mnt/SQLAdvisor/sqladvisor/sqladvisor -h 1.1.1.1  -P 3306  -u root -p "123" -d test -q '.$sql.' -v 1';

  // exec local Program, and get return data
  $descriptorspec = array(
               2 => array("pipe", "w")
  );
  $process = proc_open($command, $descriptorspec, $pipes);

  #$stderr = stream_get_contents($pipes[2]);
  $ret = "";
  while(!feof($pipes[2])) {
    $ret = $ret.fgets($pipes[2])."<br />";
  }
  fclose($pipes[2]);

  echo $ret;
?>
