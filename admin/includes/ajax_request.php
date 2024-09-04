<?php
error_reporting(E_ALL);
	include("../database.php");
	include("../function.php");
	$con=db_connect();
	
	
	if(isset($_POST['action']) && ($_POST['action']=='getModel'))
	{
		if(isset($_POST['id']) && ($_POST['id']!='') && !empty($_POST['id']))
		{
			$id = $_POST['id'];
			$field_array = array('sno', 'name');
			$where = "master_model.status = '1' AND master_model.brand_id = '$id'";
			$order_by = "name ASC";
			$doctor_rec = retrieve('master_model', null, $field_array, $where, $order_by);
					
			if($doctor_rec)
			{	?>
				<option value=""> Select a Model</option>
		<?php 
				foreach ($doctor_rec as $key => $value) { ?>
					<option value="<?php echo $value['sno']; ?>" ><?php echo $value['name']; ?></option>
					
				<?php }
				die;
			}
			echo 0;die;
		}
		echo 2; die;
	}
	
	if(isset($_POST['action']) && ($_POST['action']=='getDesp'))
	{
		if(isset($_POST['id']) && ($_POST['id']!='') && !empty($_POST['id']))
		{
			$id = $_POST['id'];
			$field_array = array('sno', 'name','description');
			$where = "master_services.status = '1' AND master_services.sno = '$id'";
			$order_by = "name ASC";
			$service_rec = retrieve('master_services', null, $field_array, $where, $order_by);
					
			if($service_rec)
			{
				echo $service_rec[0]['description'];
				die;
			}
			echo 0;die;
			}
			echo 2; die;
		}
		
	
	
	if(isset($_POST['action']) && ($_POST['action']=='services'))
	{
		if(isset($_POST['service_cat_id']) && ($_POST['service_cat_id']!='') && !empty($_POST['service_cat_id']))
		{
			$id = $_POST['service_cat_id'];
			$field_array = array('sno', 'name');
			$where = "master_service.status = '1' AND master_service.service_cat_id = '$id'";
			$order_by = "name ASC";
			$service_rec = retrieve('master_service', null, $field_array, $where, $order_by);
				
			if($service_rec)
			{	?>
				<option value=""> Select a Service</option>
		<?php 
				foreach ($service_rec as $key => $value) { ?>
					<option value="<?php echo $value['sno']; ?>" ><?php echo $value['name']; ?></option>
					
				<?php }
				die;
			}
			echo 0;die;
		}
		echo 2; die;
	}
	
	
	if(isset($_POST['action']) && ($_POST['action']=='service_amount'))
	{
		if(isset($_POST['service_name_id']) && ($_POST['service_name_id']!='') && !empty($_POST['service_name_id']))
		{
			$id = $_POST['service_name_id'];
			$field_array = array('sno', 'service_amount');
			$where = "master_service.status = '1' AND master_service.sno = '$id'";
			$order_by = "name ASC";
			$service_amount_rec = retrieve('master_service', null, $field_array, $where, $order_by);
					
			if($service_amount_rec)
			{	
				$amount = $service_amount_rec[0]['service_amount'];
				echo $amount;
				die;
			}
			echo 0;die;
		}
		echo 2; die;
	}
	
?>