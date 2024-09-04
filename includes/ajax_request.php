<?php
	include("../admin/database.php");
	include("../admin/function.php");
	$con=db_connect();	
	
	if(isset($_POST['action']) && ($_POST['action']=='getModel'))
	{
		if(isset($_POST['id']) && ($_POST['id']!='') && !empty($_POST['id']))
		{
			$id = $_POST['id'];
			$field_array = array('sno', 'name');
			$where = "master_model.status = '1' AND master_model.brand_id = '$id' AND sno IN (SELECT model_id FROM new_package WHERE deleted = 0 AND status = '1' AND brand_id = '$id')";
			$order_by = "name ASC";
			$doctor_rec = retrieve('master_model', null, $field_array, $where, $order_by);
					
			if($doctor_rec)
			{
				$data = '<option value=""> Select Model</option>';
				foreach ($doctor_rec as $key => $value) {
					$data .= '<option value="'.$value['sno'].'" >'.$value['name'].'</option>';
				 }
				echo $data;
				die;
			}
			echo 0;die;
		}
		echo 2; die;
	}

	if(isset($_POST['action']) && ($_POST['action']=='getFuel'))
	{
		if(isset($_POST['id']) && ($_POST['id']!='') && !empty($_POST['id']) && isset($_POST['model_id']) && ($_POST['model_id']!='') && !empty($_POST['model_id']))
		{
			$id = $_POST['id'];
			$model_id = $_POST['model_id'];
			$field_array = array('model_type');
			$where = "new_package.status = '1' AND new_package.brand_id = '$id' AND new_package.model_id = '$model_id'  GROUP BY model_type";
			$order_by = "model_type ASC";
			$doctor_rec = retrieve('new_package', null, $field_array, $where, $order_by);
					
			if($doctor_rec)
			{
				$data = '<option value=""> Select Fuel Type</option>';
				foreach ($doctor_rec as $key => $value) {
					$fueltypename = fuelType($value['model_type']);
					$data .= '<option value="'.$value['model_type'].'" >'.$fueltypename.'</option>';
				 }
				echo $data;
				die;
			}
			echo 0;die;
		}
		echo 2; die;
	}

	function fuelType($id)
	{
		if($id == 1)
		{
			$type = "Diesel";
		}
		else if($id == 2)
		{
			$type = "Petrol";
		}
		else if($id == 3)
		{
			$type = "CNG";
		}
		return $type;
	}

	if(isset($_POST['action']) && ($_POST['action']=='getservice'))
	{
		if(isset($_POST['id']) && ($_POST['id']!='') && !empty($_POST['id']) && isset($_POST['model_id']) && ($_POST['model_id']!='') && !empty($_POST['model_id']) && isset($_POST['model_type']) && ($_POST['model_type']!='') && !empty($_POST['model_type']))
		{
			$id = $_POST['id'];
			$model_id = $_POST['model_id'];
			$model_type = $_POST['model_type'];
			
			$field_array = array('name','service_type');
			$where = "new_package.status = '1' AND new_package.brand_id = '$id' AND new_package.model_id = '$model_id' AND new_package.model_type = '$model_type'";
			$order_by = "sno ASC";
			$doctor_rec = retrieve('new_package', null, $field_array, $where, $order_by);
			if($doctor_rec)
			{
				$data = '<option value=""> Select Service</option>';
				foreach ($doctor_rec as $key => $value) 
				{
    			    $field_array = array('sno', 'name');
                    $where = "master_service_category.status = '1' AND sno = '".$value['service_type']."'";
                    $order_by = "name ASC";
                    $service_list = retrieve('master_service_category', null, $field_array, $where, $order_by);
                    if($service_list)
                    {
                        $servicename = $service_list[0]['name'];
                    }
                    
                    $pkg_name ="";
                    $field_array3 = array('name');
                    $where3 = "master_services.status = '1'";
                    $order_by3 = "name ASC";
                    $service_list2 = retrieve('master_services', $value['name'], $field_array3, $where3, $order_by3);
                    if($service_list2)
                    {
                       $pkg_name = $service_list2[0]['name'];
                    }
                    $srvicename = $pkg_name." (".$servicename.")";
                
					$data .= '<option value="'.$value['name'].'" >'.$srvicename.'</option>';
				 }
				echo $data;
				die;
			}
			echo 0;die;
		}
		echo 2; die;
	}
?>