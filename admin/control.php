<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include('database.php');
$con = db_connect();
include('function.php');
session_start();
  $spass=$_SESSION['spass'];
  $user_name =  $_SESSION['user_name'];
  $user_type =  $_SESSION['user_type'];
  $user_id =  $_SESSION['userid'];
  
if($user_id=="" && $spass=="")
{
   header("location:index.php");die();
}
$actionmenu = array('0' => 'Read','1' => 'Write','2' => 'Edit','3' => 'Delete');
$paymentModes = array('0' => 'Cash','1' => 'Cheque','2' => 'Online');
$startYear = '2021';
$startMonth = '04';

$currentYear = date('Y');
$currentMonth = date('m');
$month_array = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');

$themeFields = array('name', 'permissionType', 'logo', 'favicon', 'companyName', 'companyLink', 'title');
$whereFields = "";
$setting_theme = retrieve('setting_theme', null, $themeFields, $whereFields);
if($setting_theme){
	foreach($setting_theme as $data)
	{
	  $site_name = $data['name'];
	  $permissionType = $data['permissionType'];
	  $logo = $data['logo'];
	  $favicon = $data['favicon'];
	  $companyName = $data['companyName'];
	  $companyLink = $data['companyLink'];
	  $title_name = $data['title'];
	}
}

$pagename=$_SERVER['REQUEST_URI'];
$page2=explode('/', $pagename);
$current_page=$page2[count($page2) - 1];
if(isset($_REQUEST['page']) && $_REQUEST['page'] != '')
{
  $current_page = $_REQUEST['page'];
  $expl_page = explode('?', $current_page);
  $current_page = $expl_page[0];
}
if($user_type != 'admin')
{
	$role_id = $_SESSION['user_role'];
	$field_array = array('sno','name');
	$where = "master_role.status = '1' AND master_role.sno = '$role_id'";
	$roleData = retrieve('master_role', null, $field_array, $where);
	if($roleData)
	{
		$role_id = $roleData[0]['sno'];
	}

	$field_array = array('sno','name', 'parent_id', 'menuUrl');
	$where = "setting_menu.status = '1' AND setting_menu.menuUrl = '$current_page'";
	$menus = retrieve('setting_menu', null, $field_array, $where);
	
	if($menus)
	{
		foreach ($menus as $key => $value) {
			$id = $value['sno'];
			$total_count = getTotalCount("SELECT sno FROM user_access WHERE deleted = '0' AND status = '1' AND user_role_id = '$role_id' AND action_id = '$id'");
			
			if($total_count==0){
				
				header("location:dashboard.php");
				exit;
			}
		}
	}
}
// echo "<pre>";
// print_r($_SESSION);
function userAcess()
{
	global $con;
	$addWhere = "";
	if($_SESSION['user_type'] != 'admin')
	{
		$addWhere .= " AND (userID = '".$_SESSION['userid']."' OR account_manager = '".$_SESSION['userid']."')";

		return $data = array('addWhere' => $addWhere);
	}
}
$access = userAcess();

function userAcess1()
{
	global $con;
	$addWhere1 = "";
	if($_SESSION['user_type'] != 'admin')
	{
		$addWhere1 .= " AND (userID = '".$_SESSION['userid']."')";

		return $data1 = array('addWhere1' => $addWhere1);
	}
}
$access1 = userAcess1();
?>