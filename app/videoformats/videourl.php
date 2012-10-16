<?php
require('JSON.php');
$json = new Services_JSON();

header('Content-Type: text/plain;charset=UTF-8');
$id = $_REQUEST['id'];


  $link = mysql_connect("localhost", "readonly", "abcd1234")  
          or die("Could not connect<br>");
 
 $select = mysql_select_db ("media_framework"); 

 if (!$select) {
    die('Not connected : ' . mysql_error());
	}

	$query = "select * from media_main where id=".$id; 
     $result = mysql_query($query); 
     if (!$result) { 
		echo 'Unknown ID';
		exit; 
     } 
      
	$rows  = mysql_num_rows($result); 

     $i = 0; 
	
	
	
     while ($i<$rows) { 
          $row = mysql_fetch_row($result);
		
		$media_type = "video/mpeg";
		if($row[1] == 0){
			$media_type = "video/mp4";
		}else if($row[1] == 1){
			$media_type = "video/mpeg";
		}else if($row[1] == 2){
			$media_type = "application/dash+xml";	
		}else if($row[1] == 3){
			$media_type = "application/vnd.apple.mpegurl";	
		}else if($row[1] == 4){
			$media_type = "application/vnd.ms-sstr+xml";	
		}
          echo $media_type."#".$row[2];
          $i++;
     } 
	 
	
	mysql_close($link); 
?>
