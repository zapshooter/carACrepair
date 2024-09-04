<?php
include('control.php');
	if($current_page!='')
	{
		$field_page = array('sno', 'fileName');
      $where_page = "setting_menu.status = '1' AND ( setting_menu.menuUrl = '$current_page' || setting_menu.fileName = '$current_page')";
      $fileData = retrieve('setting_menu', null, $field_page, $where_page);
      if($fileData)
      {
      	$file_name = $fileData[0]['fileName'];
      	if(file_exists($file_name))
      	{
		    include($file_name);
      	}
      	else
      	{
      		echo $file_name ." file not found";
      		die;
      	}
		}
	}
	else
	{
		echo "<script>location.href='dashbaord.php';</script>";die;
	}
?>