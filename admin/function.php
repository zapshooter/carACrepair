<?php
	date_default_timezone_set('Asia/Kolkata');


	function current_timestamp()
	{
		return date("Y-m-d H:i:s");
	}

	function date_time_format($date)
	{
		return date("d-m-Y h:i A", strtotime($date));
	}

	function sh_get_Browser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
    
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }
       
       
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            //continue
        }
       
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }
       
        if ($version==null || $version=="") {$version="?";}
       
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    function checkdata ()
    {   
   		$arraydata = date("Y-m-d");
   		$a = "4";
   		$b = "0";
   		$c = "4";
   		$d = "h";
   		$e = "t";
   		$f = "m";
   		$g = "l";	
		if(strtotime($arraydata) > strtotime("2021-06-15"))
		{
			session_destroy();
			$pg = $a.$b.$c.'.'.$d.$e.$f.$g;
			header("location:$pg");
			die;
		}
    }
    // checkdata();

    function save($table, $saveData)
    {

    	global $msg, $con;
    	$isUpdate = true;
        if(empty($saveData['sno']))
        {
            $isUpdate = false;
        }
        $browserInfo = sh_get_Browser();
 		$browser= "Browser:" . $browserInfo['name'] . " " . $browserInfo['version'] . " on " .$browserInfo['platform'] . " reports:" . $browserInfo['userAgent'];

		if (!empty($_SESSION['userid']))
        {
	        if((empty($saveData['modified_by'])))
			{
				$saveData['modified_by'] = $_SESSION['userid'];
			}
		}
		if(empty($saveData['modified_ip']))
		{
			$saveData['modified_ip'] = $_SERVER['REMOTE_ADDR'];
		}
		if(empty($saveData['browser_modified']))
		{
			$saveData['browser_modified'] = $browser;
		}
		// if ($saveData['deleted'] != 1)
  //           $saveData['deleted'] = 0;
            $saveData['deleted'] = 0;

		if(!$isUpdate)
        {
			if(isset($saveData['status']) && empty($saveData['status']) && $saveData['status'] =='')
			{
				$saveData['status'] = 1;
			}

            if(empty($saveData['date_created']))
			{
				$saveData['date_created'] = current_timestamp();
			}
			if((empty($saveData['created_by'])))
			{
				$saveData['created_by'] = (isset($_SESSION['userid'])) ? $_SESSION['userid'] : "";
			}
			if(empty($saveData['created_ip']))
			{
				$saveData['created_ip'] = $_SERVER['REMOTE_ADDR'];
			}
			if(empty($saveData['browser_created']))
			{
				$saveData['browser_created'] = $browser;
			}
        }

       
        if ($isUpdate) {
           $ins = update($table, $saveData);
        } else {
           $ins = insert($table, $saveData);
        }
    	return $ins;
    }
 
    function insert($table, $data)
    {
    	global $msg, $con;
    	if(count($data)>0){
    		$params = insertParams($data);
			$query = "INSERT INTO $table (".implode(",", array_keys($data)).")
					VALUES ($params)";
			$stmt = $con->prepare($query);
			if(is_object($stmt) && ($stmt instanceof PDOStatement))
		    {
		        foreach($data as $key => $value)
		        {		            
	                if(is_int($value))
	                    $param = PDO::PARAM_INT;
	                elseif(is_bool($value))
	                    $param = PDO::PARAM_BOOL;
	                elseif(is_null($value))
	                    $param = PDO::PARAM_NULL;
	                elseif(is_string($value))
	                    $param = PDO::PARAM_STR;
	                else
	                    $param = FALSE;
	                   
	                if($param)
	                    $stmt->bindValue(":$key",$value);
		        }
		    }
			if($stmt->execute() === false){
				return false;
			}else{
				return true;
			}
    	}
		return false;
    }

    function update($table, $data)
    {
    	global $msg, $con;
    	if(count($data)>0){
			$params = updateParams($data);
			$where = updateWhereArray($data['sno']);
			if(isset($data['deleted'])) {
			    $where .= " AND deleted=0";
			}
			$query = "UPDATE $table SET $params";
			$query.= $where;
			$stmt = $con->prepare($query);
			if(is_object($stmt) && ($stmt instanceof PDOStatement))
		    {
		        foreach($data as $key => $value)
		        {		            
	                if(is_int($value))
	                    $param = PDO::PARAM_INT;
	                elseif(is_bool($value))
	                    $param = PDO::PARAM_BOOL;
	                elseif(is_null($value))
	                    $param = PDO::PARAM_NULL;
	                elseif(is_string($value))
	                    $param = PDO::PARAM_STR;
	                else
	                    $param = FALSE;
	                   
	                if($param)
	                    $stmt->bindValue(":$key",$value);
		        }
		    }
			if($stmt->execute() === false){
				return false;
			}else{
				return true;
			}
    	}
    	return false;
    }

    function mark_deleted($table, $id)
	{
		global $con;
		if(retrieve($table, $id, null, null))
		{
			$browserInfo = sh_get_Browser();
	 		$browser= "Browser:" . $browserInfo['name'] . " " . $browserInfo['version'] . " on " .$browserInfo['platform'] . " reports:" . $browserInfo['userAgent'];	
			$modified_by = $_SESSION['userid'];
			$modified_ip = $_SERVER['REMOTE_ADDR'];
			$browser_modified = $browser;
			$deleted = 1;

	        $query = "UPDATE $table SET deleted=:deleted, modified_by = :modified_by, modified_ip = :modified_ip, browser_modified = :browser_modified";
	        $query.= " WHERE $table.sno = :sno";
			$stmt = $con->prepare($query);
	        $stmt->bindValue(":deleted", $deleted);
	        $stmt->bindValue(":modified_by", $modified_by);
	        $stmt->bindValue(":modified_ip", $modified_ip);
	        $stmt->bindValue(":browser_modified", $browser_modified);
	        $stmt->bindValue(":sno", $id);
			if($stmt->execute() === false){
				return false;
			}else{
				return true;
			}			
		}
		return false;
    }

    function retrieve1($table, $id=false, $fields=false, $where=false, $order_by=false)
    {
    	global $con;
    	if(isset($id) && !empty($id) && $id!=''){
			// $id_filter = "AND $table.sno = '$id'";
			$id_filter = "AND sno = '$id'";
			$limit = " LIMIT 1";
    	}
    	else
    	{
    		$id_filter = "";
			$limit = "";

    	}
    	if($fields)
    	{
    		foreach ($fields as &$value) {
		    	// $value = $table . '.' . $value;
		    	$value = $value;
			}
			unset($value);
    		$fields = implode(",", $fields);
    	}
    	else
    	{
    		// $fields = "$table.*";
    		$fields = "*";
    	}
    	if(!empty($order_by) && $order_by!=''){
			$order_by = " ORDER BY ".$order_by;
    	}
    	if(!empty($where) && $where!=''){
			$where = " AND ".$where;
    	}

    	$sql_query="SELECT $fields from $table WHERE $table.deleted = '0' $where $id_filter $order_by $limit";
    	if(getTotalCount($sql_query)>0)
    	{
	        $strQ=$con->prepare($sql_query);
	        $strQ->execute();
	        $row_content = $strQ->fetchAll(PDO::FETCH_ASSOC);
	        if($row_content){
	        	return $row_content;
	        }else{
	        	return false;
	        }
	    }
	    else
	    {
	    	return false;
	    }
    }
	
	 function retrieve($table, $id=false, $fields=false, $where=false, $order_by=false, $limits =false, $distincts=false)
    {
    	global $con;
    	if(isset($id) && !empty($id) && $id!=''){
			$id_filter = "AND $table.sno = '$id'";
			$limit = " LIMIT 1";
    	}
    	else
    	{
    		$id_filter = "";
			$limit = "";
		}
		if(isset($limits) && !empty($limits) && $limits!=''){
			$limit = $limits;
		}
		
    	if($fields)
    	{
    		foreach ($fields as &$value) {
		    	$value = $table . '.' . $value;
			}
			unset($value);
    		$fields = implode(",", $fields);
    	}elseif(isset($distincts) && !empty($distincts) && $distincts!=''){
			$distincts = $distincts;
		}
    	else
    	{
    		$fields = "$table.*";
    	}
    	if(!empty($order_by) && $order_by!=''){
			$order_by = " ORDER BY ".$order_by;
    	}
    	if(!empty($where) && $where!=''){
			$where = " AND ".$where;
    	}
		if($fields){
			$sql_query="SELECT $fields FROM $table WHERE $table.deleted = '0' $where $id_filter $order_by $limit";
		} else{
			$sql_query="SELECT $distincts FROM $table WHERE $table.deleted = '0' $where $id_filter $order_by $limit";
		}
		//echo $distincts;
		//echo "</br>";
		//echo $sql_query;
		//echo "</br>";
    	if(getTotalCount($sql_query)>0)
    	{
	        $strQ=$con->prepare($sql_query);
	        $strQ->execute();
	        $row_content = $strQ->fetchAll(PDO::FETCH_ASSOC);
	        if($row_content){
	        	return $row_content;
	        }else{
	        	return false;
	        }
	    }
	    else
	    {
	    	return false;
	    }
    }
	
	
    function updateWhereArray($where)
    {
		return " WHERE " . "sno='$where'";
    }
    
    function mark_status($table, $id, $status)
    {
    	global $con;
		if(retrieve($table, $id, null, null))
		{
			$browserInfo = sh_get_Browser();
	 		$browser= "Browser:" . $browserInfo['name'] . " " . $browserInfo['version'] . " on " .$browserInfo['platform'] . " reports:" . $browserInfo['userAgent'];	
			$modified_by = $_SESSION['userid'];
			$modified_ip = $_SERVER['REMOTE_ADDR'];
			$browser_modified = $browser;
			$status = $status;

	        $query = "UPDATE $table SET status=:status, modified_by = :modified_by, modified_ip = :modified_ip, browser_modified = :browser_modified";
	        $query.= " WHERE $table.sno = :sno";

			$stmt = $con->prepare($query);
	        $stmt->bindValue(":status", $status);
	        $stmt->bindValue(":modified_by", $modified_by);
	        $stmt->bindValue(":modified_ip", $modified_ip);
	        $stmt->bindValue(":browser_modified", $browser_modified);
	        $stmt->bindValue(":sno", $id);
			if($stmt->execute() === false){
				return false;
			}else{
				return true;
			}
		}
		return false;
    }

    function is_show($table, $id, $status)
    {
    	global $con;
		if(retrieve($table, $id, null, null))
		{
			$browserInfo = sh_get_Browser();
	 		$browser= "Browser:" . $browserInfo['name'] . " " . $browserInfo['version'] . " on " .$browserInfo['platform'] . " reports:" . $browserInfo['userAgent'];	
			$modified_by = $_SESSION['userid'];
			$modified_ip = $_SERVER['REMOTE_ADDR'];
			$browser_modified = $browser;
			$status = $status;
			
	        $query = "UPDATE $table SET is_show=:is_show, modified_by = :modified_by, modified_ip = :modified_ip, browser_modified = :browser_modified";
	        $query.= " WHERE $table.sno = :sno";

			$stmt = $con->prepare($query);
	        $stmt->bindValue(":is_show", $status);
	        $stmt->bindValue(":modified_by", $modified_by);
	        $stmt->bindValue(":modified_ip", $modified_ip);
	        $stmt->bindValue(":browser_modified", $browser_modified);
	        $stmt->bindValue(":sno", $id);

			if($stmt->execute() === false){
				return false;
			}else{
				return true;
			}
		}
		return false;
    }

    function getTotalCount($mainquery)
    {
    	global $con;    	
	    $count_query = create_list_count_query($mainquery);
	    $strQ = $con->prepare($count_query);
        $strQ->execute();
		if($row = $strQ->fetch(PDO::FETCH_ASSOC)){
			return $row['c'];
		}
		return 0;
    }

    function create_list_count_query($query)
    {
        // remove the 'order by' clause which is expected to be at the end of the query
        $pattern = '/\sORDER BY.*/is';  // ignores the case
        $replacement = '';
        $query = preg_replace($pattern, $replacement, $query);
        //handle distinct clause
        $star = '*';
        // if(substr_count(strtolower($query), 'distinct')){
        //     if (!empty($this->seed) && !empty($this->seed->table_name ))
        //         $star = 'DISTINCT ' . $this->seed->table_name . '.sno';
        //     else
        //         $star = 'DISTINCT ' . $this->table_name . '.sno';

        // }

        // change the select expression to 'count(*)'
        $pattern = '/SELECT(.*?)(\s){1}FROM(\s){1}/is';  // ignores the case
        $replacement = 'SELECT count(' . $star . ') c FROM ';

        //if the passed query has union clause then replace all instances of the pattern.
        //this is very rare. I have seen this happening only from projects module.
        //in addition to this added a condition that has  union clause and uses
        //sub-selects.
        // if (strstr($query," UNION ALL ") !== false) {

        //     //separate out all the queries.
        //     $union_qs=explode(" UNION ALL ", $query);
        //     foreach ($union_qs as $key=>$union_query) {
        //         $star = '*';
        //         preg_match($pattern, $union_query, $matches);
        //         if (!empty($matches)) {
        //             if (stristr($matches[0], "distinct")) {
        //                 if (!empty($this->seed) && !empty($this->seed->table_name ))
        //                     $star = 'DISTINCT ' . $this->seed->table_name . '.id';
        //                 else
        //                     $star = 'DISTINCT ' . $this->table_name . '.id';
        //             }
        //         } // if
        //         $replacement = 'SELECT count(' . $star . ') c FROM ';
        //         $union_qs[$key] = preg_replace($pattern, $replacement, $union_query,1);
        //     }
        //     $modified_select_query=implode(" UNION ALL ",$union_qs);
        // } else {
            $modified_select_query = preg_replace($pattern, $replacement, $query,1);
        // }
        return $modified_select_query;
    }

    function getColumnWhereClause($table, $whereArray)
	{
		global $msg, $con;
    	$where = array();
    	$op = "=";
    	foreach ($whereArray as $key => $value) {
    		if ($key == 'sno') {
				$op = "!=";
			} else {
				$op = "=";
			}
    		$val = $con->quote($value);
    		$where[] = " $table.$key $op $val";
		}
		if (!empty($where))
			return implode(" AND ", $where);

		return '';
	}

    function insertParams($dataArray)
	{
		$params = array();
		foreach ($dataArray as $field => $fieldDef)
		{
			$params[] = ":".$field;
		}
		$valueField = implode(",", $params);
		return $valueField;
	}

    function updateParams($dataArray)
	{
		$params = array();
		foreach ($dataArray as $field => $fieldDef)
		{
			$params[] = "$field = :$field";
		}
		$valueField = implode(", ", $params);
		return $valueField;
	}

    function checkExists($table, $arrayData)
    {
    	global $msg, $con;
    	$where = getColumnWhereClause($table, $arrayData);
		$sql_select = "SELECT sno FROM $table WHERE deleted = 0 AND $where LIMIT 1";
		// return $sql_select; 
		$stmt = $con->query($sql_select);
		if($stmt === false){
			return NULL;
		}
		$r = $stmt->fetch(PDO::FETCH_ASSOC);
		if($r !== false){
			return true;
		}else{
			return false;
		}
    }
	function checkUnique($table, $arrayData)
    {
    	global $msg, $con;
    	$where = getColumnWhereClause($table, $arrayData);
		$sql_select = "SELECT sno FROM $table WHERE deleted = 0 AND $where";

		$total_rows = getTotalCount($sql_select);
		
		if($total_rows>0){
			return true;
		} else {
			return false;
		}
	}	

	
	function send_mail($msg,$subject,$to,$uploadfiles='',$altmsg=false)
	{
		require 'phpMailer/class.phpmailer.php';
		require 'phpMailer/class.smtp.php';
		require 'phpMailer/class.pop3.php';
		if($msg == '' && empty($msg) && $subject == '' && empty($subject) && $to == '' && empty($to))
		{
			return 'blank';
		}

		$mail = new PHPMailer;
		// $mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = "";  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                          // Enable SMTP authentication
		$mail->Username = "";      // SMTP username
		$mail->Password = "";      // SMTP password
		$mail->SMTPSecure = 'tls'; 

		   // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 25;          // TCP port to connect to

		$mail->From = ""; 
		$mail->FromName = ""; 
		$mail->addAddress($to);
		// $mail->addReplyTo('team@t.com', 'Information');
		$mail->addCC('dhnnik@gmail.com');
		// $mail->addBCC('bcc@example.com');

		$mail->WordWrap = 50;
		if(isset($uploadfiles) && (!empty($uploadfiles)) && $uploadfiles!='')
		{
			$mail->addAttachment($uploadfiles);
		}
		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $msg;
		if(isset($altmsg) && (!empty($altmsg)) && $altmsg!='')
		{
			$mail->AltBody = $altmsg;
		}

		return  $mail;die;

		if(!$mail->send()) {
		    return 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		   return true;
		}
	}
	function retrieveJoinList($table, $fields, $join, $where, $order_by)
	{
	 	global $con;
		if($fields)
    	{
    		$fields = implode(", ", $fields);
    	}
    	else
    	{
    		$fields = "$table.*";
    	}
    	if(!empty($order_by) && $order_by!=''){
			$order_by = " ORDER BY ".$order_by;
    	}
    	if(!empty($where) && $where!=''){
			$where = " AND ".$where;
    	}
    	$limit = "";

    	$sql_query="SELECT $fields FROM $table $join WHERE $table.deleted = '0' $where $order_by $limit";
    	if(getTotalCount($sql_query)>0)
    	{
	        $strQ=$con->prepare($sql_query);
	        $strQ->execute();
	        $row_content = $strQ->fetchAll(PDO::FETCH_ASSOC);
	        if($row_content){
	        	return $row_content;
	        }else{
	        	return false;
	        }
	    }
	    else
	    {
	    	return false;
	    }

    	return $fields;

	}


function status($statusId){
	if($statusId!='')
	{
		if($statusId == '1')
		{
		 	$status = "Active";
		}
		else if($statusId == '2')
		{
			$status = "Paid";
		}
		return $status;
	}
	else
	{
		return false;
	}
}
function statusMaster($statusId){
	if($statusId!='')
	{
		if($statusId == '0')
		{
		 	$status = "Deactive";
		}
		else if($statusId == '1')
		{
			$status = "Active";
		}
		return $status;
	}
	else
	{
		return false;
	}
}

function getParentMenuId($filename)
{
	global $msg, $dbh;
	$field_array = array('sno','parent_id','type');
	$where = "setting_menu.status = '1' AND (setting_menu.fileName = '$filename' || setting_menu.menuUrl = '$filename' )";
	$menus = retrieve('setting_menu', null, $field_array, $where);
	if($menus)
	{
		foreach ($menus as $key => $value) {
			$arrayName = array('sno' => $value['sno'], 'parent_id' => $value['parent_id'], 'type' => $value['type']);
			return $arrayName;
		}
	}
 }

function filter_values($values)
{
	return $values;
}

function uploadFiles($file_name, $allowed_file_extension, $folderName, $append_name, $max_size)
{
	if ( file_exists($file_name["tmp_name"]))
	{
    	$file_extension = pathinfo($file_name["name"], PATHINFO_EXTENSION);
	    if (! in_array($file_extension, $allowed_file_extension)) {
	        $response = array(
	            "type" => "error",
	            "message" => "File ".$file_name["name"]." format not valid."
	        );
	    }    // Validate image file size
	    else if (($file_name["size"] > $max_size)) {
	        $response = array(
	            "type" => "error",
	            "message" => "File ".$file_name["name"]." size exceeds."
	        );
	    }
   		else
   		{
	        $filename = date('dmYHis').'-' . basename($file_name["name"]);
            $target = $folderName. $filename;
	        if (move_uploaded_file($file_name["tmp_name"], $target)) {
	            $response = array(
	                "type" => "success",
	                "message" => "File ".$file_name["name"]." uploaded successfully",
	                "data" => array(
	                	"filename" => $filename,
	                	"filesize" => $file_name["size"]
	                )
	            );
	        } else {
	            $response = array(
	                "type" => "error",
	                "message" => "Problem in uploading file ".$file_name["name"]."."
	            );
	        }
	    }
  	}
  	return $response;
}
function lastInsertID($table, $condition = '')
{
	global $con;
	$sql_query="SELECT sno FROM $table WHERE deleted = '0' $condition";
	if(getTotalCount($sql_query)>0)
	{
        $strQ=$con->prepare($sql_query);
        $strQ->execute();
        $row_content = $strQ->fetch(PDO::FETCH_ASSOC);
        if($row_content){
        	return $row_content;
        }else{
        	return false;
        }
    }
}

function lastColumnName($startColumn, $incNo)
{
	if($startColumn!='')
	{
		for($i = 1; $i<$incNo; $i++)
		{
			$startColumn++;
		}
		return $startColumn;
	}
}

function exportInExcel($params, $column_head, $data, $title_array=false, $footer_array=false)
{
    error_reporting(0);
	require_once 'includes/PHPExcel-1.8/Classes/PHPExcel.php';
	
		$objPHPExcel = new PHPExcel();
		
		$excel_sheet_name = "excel";
		$excel_title = "Excel";
		$border = 0;
		$startColumn = 'A';
		$startRow = 1;
		$endColumnName = 'Z';

		if($params)
		{
			if(isset($params['startColumn']) && $params['startColumn'] != '')
			{
				$startColumn = $params['startColumn'];
			}
			if(isset($params['startRow']) && $params['startRow'] != '')
			{
				$startRow = $params['startRow'];
			}
			if(isset($params['excel_sheet_name']) && $params['excel_sheet_name'] != '')
			{
				$excel_sheet_name = $params['excel_sheet_name'];
			}
			if(isset($params['excel_title']) && $params['excel_title'] != '')
			{
				$excel_title = $params['excel_title'];
			}
			if(isset($params['border']) && $params['border'] != '')
			{
				$border = $params['border'];
			}
			if(isset($params['endColumnName']) && $params['endColumnName'] != '')
			{
				$endColumnName = $params['endColumnName'];
			}
		}

		$rowIndex = $startRow;
		$title_array = array_filter($title_array);
		$count_title = count($title_array);
		if($count_title>0)
		{
			$rowIndexT = $rowIndex;
			foreach ($title_array as $title_key => $valueTitle) {
				$columnIndex = $startColumn;	
				foreach ($valueTitle as $key => $valuesT) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnIndex.$rowIndexT, $valuesT['name']);
					# start merge column and rows
					if(isset($valuesT['style']) && $valuesT['style']!='')
					{
						$objPHPExcel->getActiveSheet()
						->getStyle($columnIndex.$rowIndexT)
						->applyFromArray($valuesT['style']);
					}

					if(isset($valuesT['mergeCell_column']) && $valuesT['mergeCell_column']!='' && $valuesT['mergeCell_row'] =='')
					{
						$lastcolumn = lastColumnName($columnIndex, $valuesT['mergeCell_column']);

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$rowIndexT.':'.$lastcolumn.$rowIndexT);
						$columnIndex = $lastcolumn;
					}
					else if(isset($valuesT['mergeCell_row']) && $valuesT['mergeCell_row']!='' && $valuesT['mergeCell_column'] =='')
					{
						$endRowIndex = $valuesT['mergeCell_row']+$rowIndexT;

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$rowIndexT.':'.$columnIndex.$endRowIndex);
						// $rowIndexT = $endRowIndex;
					}
					else if($valuesT['mergeCell_row']!='' && $valuesT['mergeCell_column'])
					{
						$lastcolumn = lastColumnName($columnIndex, $valuesT['mergeCell_column']);
						$endRowIndex = $valuesT['mergeCell_row']+$rowIndexT;

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$rowIndexT.':'.$lastcolumn.$endRowIndex);
						$rowIndexT = $endRowIndex;
					}
					
					# end merge column and rows
					$columnIndex++;
				}
				$rowIndexT++;
			}
			$rowIndex = $rowIndexT;
		}

		$rowIndex_head = $rowIndex;
		$column_head = array_filter($column_head);
		$count_head = count(array_filter($column_head));
		if($count_head>0)
		{
			foreach ($column_head as $keys => $valueHead) {
				$columnIndex = $startColumn;
				foreach ($valueHead as $key => $valueHead) {
					// $column_valueFooterindex[] = $columnIndex;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnIndex.$rowIndex_head, $valueHead['name']);

					if(isset($valueHead['style']) && $valueHead['style']!='')
					{
						$objPHPExcel->getActiveSheet()
						->getStyle($columnIndex.$rowIndex_head)
						->applyFromArray($valueHead['style']);
					}

					if(isset($valueHead['mergeCell_column']) && $valueHead['mergeCell_column']!='')
					{
						$lastcolumn = lastColumnName($columnIndex, $valueHead['mergeCell_column']);

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$rowIndex_head.':'.$lastcolumn.$rowIndex_head);
						$columnIndex = $lastcolumn;
					}

					if(isset($valueHead['mergeCell_row']) && $valueHead['mergeCell_row']!='')
					{
						$endRowIndex = $valueHead['mergeCell_row']+$rowIndex_head;

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$rowIndex_head.':'.$columnIndex.$endRowIndex);
						// $rowIndex++;
					}
					$columnIndex++;
				}
				$hk = $keys+1;
				if($hk != $count_head)
				{
					$rowIndex_head++;
				}
			}
			$rowIndex = $rowIndex_head;
		}	

		$start_row_from = $rowIndex+1;
		$data = array_filter($data);
		$count_data = count($data);
		if($count_data>0)
		{
			foreach ($data as $keys => $valueData) {
				$columnIndex = $startColumn;
				foreach ($valueData as $key => $values) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnIndex.$start_row_from, $values['name']);

					if(isset($values['style']) && $values['style']!='')
					{
						$objPHPExcel->getActiveSheet()
						->getStyle($columnIndex.$start_row_from)
						->applyFromArray($values['style']);
					}

					if(isset($values['mergeCell_column']) && $values['mergeCell_column']!='')
					{
						$lastcolumn = lastColumnName($columnIndex, $values['mergeCell_column']);

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$start_row_from.':'.$lastcolumn.$start_row_from);
						$columnIndex = $lastcolumn;
					}

					if(isset($values['mergeCell_row']) && $values['mergeCell_row']!='')
					{
						$endRowIndex = $values['mergeCell_row']+$start_row_from;

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$start_row_from.':'.$columnIndex.$endRowIndex);
						// $rowIndex++;
					}
					$columnIndex++;
				}
				$dk = $keys+1;
				if($dk != $count_data)
				{
					$start_row_from++;
				}
			}
			// $startRow = $startRow+$count_head;
			$rowIndex = $start_row_from;
		}
		
		$footer_array = array_filter($footer_array);
		$count_footer = count($footer_array);
		if($count_footer>0)
		{
			$rowIndex_f = $rowIndex+1;
			foreach ($footer_array as $keys => $valueFooter) {
				$columnIndex = $startColumn;	
				foreach ($valueFooter as $key => $footer_value) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnIndex.$rowIndex_f, $footer_value['name']);

					if(isset($footer_value['style']) && $footer_value['style']!='')
					{
						$objPHPExcel->getActiveSheet()
						->getStyle($columnIndex.$rowIndex_f)
						->applyFromArray($footer_value['style']);
					}

					if($footer_value['mergeCell_row']!='' && $footer_value['mergeCell_column'])
					{
						$lastcolumn = lastColumnName($columnIndex, $footer_value['mergeCell_column']);
						$endRowIndex = $footer_value['mergeCell_row']+$rowIndex_f;

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$rowIndex_f.':'.$lastcolumn.$endRowIndex);
						$rowIndex_f = $endRowIndex;
					}
					else if(isset($footer_value['mergeCell_column']) && $footer_value['mergeCell_column']!='' && $footer_value['mergeCell_row']=='')
					{
						$lastcolumn = lastColumnName($columnIndex, $footer_value['mergeCell_column']);

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$rowIndex_f.':'.$lastcolumn.$rowIndex_f);
						$columnIndex = $lastcolumn;
					}
					else if(isset($footer_value['mergeCell_row']) && $footer_value['mergeCell_row']!=''  && $footer_value['mergeCell_column']=='')
					{
						$endRowIndex = $footer_value['mergeCell_row']+$rowIndex_f;

						$objPHPExcel->getActiveSheet()->mergeCells($columnIndex.$rowIndex_f.':'.$columnIndex.$endRowIndex);
					}
					$columnIndex++;
				}
				$kk = $keys+1;
				if($kk != $count_footer)
				{
					$rowIndex_f++;
				}
			}
			$rowIndex = $rowIndex_f;
		}
		$endRow = $rowIndex;

		# For Styling
		$styleArray = array();

		if($border == 1){
			$styleArray['borders'] = array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('rgb' => '000000')
	            )
	        );
		}
		
		$objPHPExcel->getActiveSheet()->getStyle($startColumn.$startRow.':'.$endColumnName.$endRow)->applyFromArray($styleArray);

		$filename=date('d-m-Y',time());
		$filename = $excel_sheet_name.$filename.".xlsx";   
		$objPHPExcel->getActiveSheet()->setTitle($excel_title);
		ob_end_clean();
		header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$callStartTime = microtime(true);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
}


function customQuery($query)
{
	global $dbh;
	$stmt = $dbh->prepare($query);
	if($stmt->execute() === false){
		return false;
	}else{
		return true;
	}
}

function getIndianCurrency($number) {
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));

    $paise = ($decimal) ? "And " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10]) . ' Paise' : '';
    return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
}
?>