<!DOCTYPE html>
<?php
  $table = "new_package";

  if(isset($_POST['sub']))
  {
	
    $arrayData = array();
    $arrayData['brand_id'] = filter_values($_POST['brand_name']);
    $arrayData['model_id'] = filter_values($_POST['model_name']);
    $arrayData['model_type'] = filter_values($_POST['model_type']);
    $arrayData['service_type'] = filter_values($_POST['services_type']);
    $arrayData['name'] = filter_values($_POST['package_name']);
    
    // per image change has to be made each page
    if(isset($_POST['sno']) && $_POST['sno'] !='')
    {
      $arrayData['sno'] = filter_values($_POST['sno']);
    }
    foreach($arrayData as $field) {
      if (empty($field)) {
        echo "<script>location.href='panel.php?page=new_package&e=b'</script>";die;
      }
    }
    if(checkExists($table, $arrayData) == 1){
      echo "<script>location.href='panel.php?page=new_package&e=e'</script>";die;
    }
	$arrayData['package_price'] = filter_values($_POST['package_price']);
	$arrayData['sales_price'] = filter_values($_POST['sale_price']);
    $arrayData['labour_price'] = filter_values($_POST['labour_price']);
    $arrayData['description'] = filter_values($_POST['package_description']);
    $arrayData['service_duration'] = filter_values($_POST['service_duration']);
    $arrayData['status'] = filter_values($_POST['status']);
    


	// Upload Profile Picture
	if(isset($_FILES['packagePhoto'])){
	if(file_exists($_FILES['packagePhoto']['tmp_name']) && $_FILES['packagePhoto']['name'] != '')
	    {
		$ran_profile=rand(1,1000);
		$size=$_FILES['packagePhoto']['size'];
		$filetype=$_FILES['packagePhoto']['type'];
		$modelPic=$_POST['package_name']."_profile_".$ran_profile."_".$_FILES['packagePhoto']['name'];
		$source=$_FILES['packagePhoto']['tmp_name'];
			
		if($size<=0){$modelPic="";}
			$uploadedpaths="../product-img/";
			$dest=$uploadedpaths.$modelPic;
			if(($size>0)&&($filetype=="image/jpeg" || $filetype=="image/png" || $filetype=="image/jpg"))
			{
				
				move_uploaded_file($source,$dest);
				$arrayData['packagePhoto'] = $modelPic;
				
			}else {
				echo "<script>alert('Uploaded file type is not valid');</script>";
				echo "<script>location.href='panel.php?page=new_package&e=e'</script>";die;
			}
	}
	}
	//die;
    if(save($table, $arrayData) == 1)
    {
       echo "<script>location.href='panel.php?page=new_package&s=a'</script>";die;
    }
    else
    {
		
        echo "<script>location.href='panel.php?page=new_package&e=w'</script>";
    }
  }
  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
  {
    $sno=filter_values($_GET['sno']);
    $sno = base64_decode($sno);
    if(isset($sno) && !empty($sno) && $sno != ''){
      if(mark_deleted($table, $sno) == 1)
      {
        echo "<script>location.href='panel.php?page=new_package&s=d'</script>";die;
      }
      else
      {
        echo "<script>location.href='panel.php?page=new_package&e=w'</script>";
      }
    }
  }
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title_name;?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
  .note-editable{
	min-height:250px;
  }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
   <?php
    include('common/navbar.php');
  ?> 
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php
    include('common/aside.php');
  ?> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1>New Package</h1>
          </div>
          <div class="col-sm-5">
            <?php
              if((isset($_GET['e']) && $_GET['e']!='') || (isset($_GET['s']) && $_GET['s']!=''))
              {
                 if(isset($_GET['s']) && $_GET['s'] == 'a')
                  {
                ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i>Record Saved Successfully.!</h5>
                  </div>
                <?php 
                  }
                  else if(isset($_GET['s']) && $_GET['s'] == 'd')
                  {
                ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Record Deleted Successfully.!</h5>
                  </div>
                <?php
                  }
                  else if(isset($_GET['e']) && $_GET['e'] == 'b')
                  {
                ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-ban"></i>Please Fill All Required Fields.!</h5>
                </div>
                <?php
                  }
                  else if(isset($_GET['e']) && $_GET['e'] == 'e')
                  {
                ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-ban"></i>This name already exists!</h5>
                </div>
                <?php 
                    }
                    else if(isset($_GET['e']) && $_GET['e'] == 'w')
                    {
                ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-ban"></i>Something Wents Wrong!!! Please Try Again Later.!</h5>
                </div>
                <?php 
                    }
              }
            ?>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Package</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
            <?php
              if(!isset($_REQUEST['action']))
              {
            ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Package Lists </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SNo.</th>
                    <th>Brand Name</th>
					
                    <th>Model Name</th>
                    <th>Model Type</th>
                    <th>Item Name</th>
                    <th>Status</th>
                    <th style="text-align:right;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $s = 0;
                    $field_array = array('sno', 'name', 'brand_id','model_id','model_type', 'status');
                    $where = "";
                    $orderby = "name ASC";
                    $result = retrieve($table, null, $field_array, $where, $orderby);
                    if($result){
                      foreach($result as $data)
                      {
                        $s++;
                  ?>
                  <tr>
                    <td><?php echo $s;?></td>
                    <td><?php 
						$c_id = $data['brand_id'];
						$field_array = array('sno', 'name');
						$where = " sno ='$c_id' AND status='1'";
						
						$brand = retrieve('master_brand', $c_id, $field_array, $where);
					
					echo $brand[0]['name'];
					?></td>
					
                    <td><?php $c_id = $data['model_id'];
						$field_array = array('sno', 'name');
						$where = " sno ='$c_id' AND status='1'";
						
						$model = retrieve('master_model', $c_id, $field_array, $where);
					
					echo $model[0]['name'];;?></td>
					
					<td><?php $model_type = $data['model_type'];
						if($model_type==1){
							echo "Diesel";
						}elseif($model_type==2){
							echo "Petrol";
						}elseif($model_type==3){
							echo "CNG";
						}else{
							echo "";
						}
					?>
					</td>
					<td><?php $sid = $data['name'];
				    	$field_array = array('sno', 'name');
						$where = " sno ='$sid' AND status='1'";
						
						$package_name = retrieve('master_services', $sid, $field_array, $where);
					
					echo $package_name[0]['name'];
					?></td>
					
                    <td class="project-state">
                     <span class="badge badge-<?php if($data['status'] == 1){ echo "success"; } else if($data['status'] == 0) { echo "danger";}?> "><?php echo statusMaster($data['status']);?></span>
                    </td>
                    <td class="project-actions text-right">
                      <a class="btn btn-info btn-sm" href="panel.php?page=new_package&sno=<?php echo base64_encode($data['sno']);?>&action=edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Delete This Row.')" href="panel.php?page=new_package&sno=<?php echo base64_encode($data['sno']);?>&action=delete">
                          <i class="fas fa-trash">
                          </i>
                          Delete
                      </a>
                    </td>
                  </tr>
                  <?php 
                      }
                    }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Add New <small>Package</small></h3>
				</div>
              <!-- /.card-header -->
              <!-- form start -->
			  
				<form id="quickForm" method="POST" enctype="multipart/form-data">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-3">
								<label>Brand Name</label>
								<select name="brand_name" id="brand_id" class="brand_id form-control custom-select">
									<option value="" selected>Select Brand</option>
									<?php 
										$field_array = array('sno', 'name');
										$where = "master_brand.status = '1'";
										$order_by = "name ASC";
										$brand_list = retrieve('master_brand', null, $field_array, $where, $order_by);
										foreach ($brand_list as $key => $value) {
										?>
										<option value="<?php echo $value['sno'];?>"><?php echo $value['name'];?></option>
										<?php
										}
									?>
								</select>
								
							</div>
							<div class="form-group col-md-3">
								<label>Model Name</label>
								<select name="model_name" id="model_id" class="model_id form-control custom-select">
								</select>
							</div>
							
							<div class="form-group col-md-3">
								<label>Fuel Type</label>
								<select name="model_type" id="model_type" class="form-control custom-select">
									<option value="">Select </option>
									<option value="1">Diesel </option>
									<option value="2">Petrol </option>
									<option value="3">CNG </option>
									
								</select>
							</div>
							<div class="form-group col-md-3">
								<label>Service Type</label>
								<select name="services_type" id="services_type" class="form-control custom-select">
									<option value="">Select </option>
									<?php 
										$field_array = array('sno', 'name');
										$where = "master_service_category.status = '1'";
										$order_by = "name ASC";
										$service_list = retrieve('master_service_category', null, $field_array, $where, $order_by);
										foreach ($service_list as $key => $value) {
										?>
										<option value="<?php echo $value['sno'];?>"><?php echo $value['name'];?></option>
										<?php
										}
									?>
								</select>
							</div>
							<div class="form-group col-md-3" id="package_name">
								<label for="brand">Item Name</label>
								<select name="package_name"  class="package_name form-control custom-select">
									<option value="">Select </option>
									<?php 
										$field_array = array('sno', 'name');
										$where = "master_services.status = '1'";
										$order_by = "name ASC";
										$service_list = retrieve('master_services', null, $field_array, $where, $order_by);
										foreach ($service_list as $key => $value) {
										?>
										<option value="<?php echo $value['sno'];?>"><?php echo $value['name'];?></option>
										<?php
										}
									?>
								</select>
								
							</div>
							<div class="form-group col-md-3" id="package_price">
								<label for="brand">Package Price</label>
								<input type="text" name="package_price" class="form-control"  placeholder="Enter Package Price">
								
							</div>
							
							<div class="form-group col-md-3" id="sale_price">
								<label for="brand">Sales Price</label>
								<input type="text" name="sale_price" class="form-control"  placeholder="Enter Sale Price">
							</div>
							
							<div class="form-group col-md-3" id="labour_price">
								<label for="brand">Labour Charge</label>
								<input type="text" name="labour_price" class="form-control"  placeholder="Enter Labour Charge">
								
							</div>
							<div class="col-md-12">
							  <div class="card card-outline card-info">
								<div class="card-header">
									<h3 class="card-title">
										Package Description
									</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
								  <textarea id="summernote" name="package_description" rows="6" cols="10">
										
								  </textarea>
								</div>
								
							  </div>
							</div>
							
							<div class="form-group col-md-3">
								<label>Item Photo<span class="required">*</span></label>
								<input class="form-control" name="packagePhoto" type="file" required>
							</div>
							<div class="form-group col-md-3">
								<label for="brand">Time Taken</label>
								<input type="text" name="service_duration" class="form-control" id="service_duration" placeholder="Enter Service Duration">
								
							</div>
							<div class="form-group col-md-3">
								<label for="status">Status</label>
								<select id="status" name="status" class="form-control custom-select">
								  <option value="1" selected>Active</option>
								  <option value="0">Deactive</option>
								</select>
							</div>
						</div>
					</div>
					<!-- /.card-body -->
					<div class="card-footer">
					  <button type="submit" name="sub" class="btn btn-primary">Submit</button>
					</div>
				</form>
            </div>
            <?php 
            }
            else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
            {
              if(isset($_GET['sno']) && $_GET['sno']!='')
              {
                $sno = base64_decode($_GET['sno']);
                $field_array = array('status', 'name','brand_id');
                $where = "";
                $result = retrieve($table, $sno, null, $where);
                if($result)
                {
                  foreach($result as $data)
                  {
                    $name = $data['name'];
                    $status = $data['status'];
                    $brand_id = $data['brand_id'];
                    $model_id = $data['model_id'];
                    $model_type = $data['model_type'];
                    $service_type = $data['service_type'];
                    $package_price = $data['package_price'];
                    $sales_price = $data['sales_price'];
                    $labour_price = $data['labour_price'];
                    $description = $data['description'];
                    $service_duration = $data['service_duration'];
                    $packagePhoto = $data['packagePhoto'];
                  }                  
                }
                else
                {
                  echo '<script>window.location.href="panel.php?page=new_package";</script>';die();
                }
              }
              else
              {
                echo '<script>window.location.href="panel.php?page=new_package";</script>';die();
              }
            ?>
            <div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Edit <small>Package</small></h3>
				</div>
              <!-- /.card-header -->
              <!-- form start -->
				<form id="quickForm" method="POST" enctype="multipart/form-data">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-3">
								<label>Brand Name</label>
								<select name="brand_name" id="brand_id" class="brand_id form-control custom-select">
									<option value="" selected>Select Brand</option>
									<?php 
										$field_array = array('sno', 'name');
										$where = "master_brand.status = '1'";
										$order_by = "name ASC";
										$brand_list = retrieve('master_brand', null, $field_array, $where, $order_by);
										foreach ($brand_list as $key => $value) {
										?>
										<option value="<?php echo $value['sno'];?>" <?php if($value['sno']==$brand_id){ echo "selected"; }?>><?php echo $value['name'];?></option>
										<?php
										}
									?>
								</select>
								
							</div>
							<div class="form-group col-md-3">
								<label>Model Name</label>
								<select name="model_name" id="model_id" class="model_id form-control custom-select">
									<?php 
										$field_array = array('sno', 'name');
										$where = "master_model.status = '1'";
										$order_by = "name ASC";
										$brand_list = retrieve('master_model', null, $field_array, $where, $order_by);
										foreach ($brand_list as $key => $value) {
										?>
										<option value="<?php echo $value['sno'];?>" <?php if($value['sno']==$model_id){ echo "selected"; }?>><?php echo $value['name'];?></option>
										<?php
										}
									?>
								</select>
							</div>
							
							<div class="form-group col-md-3">
								<label>Fuel Type</label>
								<select name="model_type" id="model_type" class="form-control custom-select">
									<option value="">Select </option>
									<option value="1" <?php if($model_type==1){ echo "selected";} ?>>Diesel </option>
									<option value="2" <?php if($model_type==2){ echo "selected";} ?>>Petrol </option>
									<option value="3" <?php if($model_type==3){ echo "selected";} ?>>CNG </option>
									
								</select>
							</div>
							<div class="form-group col-md-3">
								<label>Service Type</label>
								<select name="services_type" id="services_type" class="form-control custom-select">
									<option value="">Select </option>
									<?php 
										$field_array = array('sno', 'name');
										$where = "master_service_category.status = '1'";
										$order_by = "name ASC";
										$service_list = retrieve('master_service_category', null, $field_array, $where, $order_by);
										foreach ($service_list as $key => $value) {
										?>
										<option value="<?php echo $value['sno'];?>" <?php if($value['sno']==$service_type){ echo "selected"; }?>><?php echo $value['name'];?></option>
										<?php
										}
									?>
								</select>
							</div>
							
							<?php 
							    if($service_type ==2){
							        
							    }
							?>
							<div class="form-group col-md-3">
								<label for="brand">Item Name</label>
								<select name="package_name" class="package_name form-control custom-select">
									<option value="">Select </option>
									<?php 
										$field_array = array('sno', 'name');
										$where = "master_services.status = '1'";
										$order_by = "name ASC";
										$service_list = retrieve('master_services', null, $field_array, $where, $order_by);
										foreach ($service_list as $key => $value) {
										?>
										<option value="<?php echo $value['sno'];?>" <?php if($value['sno']==$name){ echo "selected"; }?>><?php echo $value['name'];?></option>
										<?php
										}
									?>
								</select>
								
								
							</div>
							<div class="form-group col-md-3" <?php if($service_type ==2){ ?> style="display:none;"<?php } ?>>
								<label for="brand">Package Price</label>
								<input type="text" name="package_price" class="form-control" value="<?php echo $package_price;?>"  placeholder="Enter Package Price">
								
							</div>
							
							<div class="form-group col-md-3" <?php if($service_type ==4 || $service_type ==6){ ?> style="display:none;"<?php } ?>>
								<label for="brand">Sales Price</label>
								<input type="text" name="sale_price" class="form-control"  value="<?php echo $sales_price;?>" placeholder="Enter Sale Price">
							</div>
							
							<div class="form-group col-md-3" <?php if($service_type ==4 || $service_type ==6){ ?> style="display:none;"<?php } ?>>
								<label for="brand">Labour Charge</label>
								<input type="text" name="labour_price" class="form-control" value="<?php echo $labour_price;?>" placeholder="Enter Labour Charge">
								
							</div>
							<div class="col-md-12">
							  <div class="card card-outline card-info">
								<div class="card-header">
									<h3 class="card-title">
										Package Description
									</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
								  <textarea id="summernote" name="package_description" rows="6" cols="10">
										<?php echo $description;?>
								  </textarea>
								</div>
								
							  </div>
							</div>
							
							<div class="form-group col-md-3">
								<label>Item Photo</label>
								<input class="form-control" name="packagePhoto" type="file">
							</div>
							<div class="form-group col-md-3">
								<label for="brand">Time Taken</label>
								<input type="text" name="service_duration" value="<?php echo $service_duration;?>" class="form-control" id="service_duration" placeholder="Enter Service Duration">
								
							</div>
							<div class="form-group col-md-6">
								<label for="status">Status</label>
								<select id="status" name="status" class="form-control custom-select">
								  <option value="1" <?php if($status == 1) { echo "selected"; }?>>Active</option>
								  <option value="0" <?php if($status == 0) { echo "selected"; }?>>Deactive</option>
								</select>
							</div>
						</div>
					  
					</div>
					<!-- /.card-body -->
					<div class="card-footer">
					  <input type="hidden" name="sno" value="<?php echo $sno; ?>" class="">
					  <button type="submit" name="sub" class="btn btn-primary">Submit</button>
					</div>
				</form>
            </div>

            <?php 
              }
            ?>

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
  </div>
  <!-- /.content-wrapper -->
  <?php
    include('common/footer.php');
  ?> 
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->

<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
	$('#summernote').summernote();
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');    
  });
</script>
<script>
$(function () {
  // $.validator.setDefaults({
  //   submitHandler: function () {
  //     alert( "Form successful submitted!" );
  //   }
  // });
  $('#quickForm').validate({
    rules: {
      name: {
        required: true,
      },     
    },
    messages: {
      name: {
        required: "Please enter a Model Name",
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
<script>
	
$(".brand_id").change(function(){
	//alert(Hello);
	
	var id = $(".brand_id").val();
	
	if(id != '')
 	{
			$.ajax({
			type: 'POST',
			url: "includes/ajax_request.php",
			 // dataType:'json', // add json datatype to get json
    		data: ({id : id, action: 'getModel' }),
			success: function(resultData)
		    {
				console.log(resultData);
				if(resultData == 2 || resultData == 0)
		    	{
		    		return false;
		    	}
		    	$("#model_id").html(resultData);
		    }
		});
		}
		$("#model_id").html('');
		
	});
	
	$(".package_name").change(function(){
	//alert(Hello);
	
	var id = $(".package_name").val();
	
	if(id != '')
 	{
			$.ajax({
			type: 'POST',
			url: "includes/ajax_request.php",
			 // dataType:'json', // add json datatype to get json
    		data: ({id : id, action: 'getDesp' }),
			success: function(resultData)
		    {
				if(resultData == 2 || resultData == 0)
		    	{
		    		return false;
		    	}
		    	$('#summernote').summernote('code', resultData);
		    }
		});
		}
			$('#summernote').summernote('code', '');
		
	});
	
	
	$("#package_name").hide();
	$("#package_price").hide();
	$("#sale_price").hide();
	$("#labour_price").hide();
	
	$("#services_type").change(function(){
		var txtservice = $(this).val();
		if(txtservice==2){
		    $("#package_name").fadeIn(1000);
			$("#package_name").show();
			$("#sale_price").fadeIn(1000);
			$("#sale_price").show();
			$("#labour_price").fadeIn(1000);
			$("#labour_price").show();
			$("#package_price").fadeOut(1000);
			$("#package_price").hide();
		}else if(txtservice==4 || txtservice==6){
		    $("#package_price").fadeIn(1000);
			$("#package_price").show();
			
			$("#package_name").fadeIn(1000);
			$("#package_name").show();
			$("#sale_price").fadeOut(1000);
			$("#sale_price").hide();
			$("#labour_price").fadeOut(1000);
			$("#labour_price").hide();
			
		}
		
	 });
</script>
</body>
</html>
