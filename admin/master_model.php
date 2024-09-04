<!DOCTYPE html>
<?php
  $table = "master_model";

  if(isset($_POST['sub']))
  {
    $arrayData = array();
    $arrayData['name'] = filter_values($_POST['name']);
    if(isset($_POST['sno']) && $_POST['sno'] !='')
    {
      $arrayData['sno'] = filter_values($_POST['sno']);
    }
    foreach($arrayData as $field) {
      if (empty($field)) {
        echo "<script>location.href='panel.php?page=master_model&e=b'</script>";die;
      }
    }
    if(checkExists($table, $arrayData) == 1){
      echo "<script>location.href='panel.php?page=master_model&e=e'</script>";die;
    }
    $arrayData['status'] = filter_values($_POST['status']);
    $arrayData['brand_id'] = filter_values($_POST['brand_name']);
	
	// Upload Profile Picture
	if(file_exists($_FILES['modelPhoto']['tmp_name']) && $_FILES['modelPhoto']['name'] != '')
	{
		$ran_profile=rand(1,1000);
		$size=$_FILES['modelPhoto']['size'];
		$filetype=$_FILES['modelPhoto']['type'];
		$modelPic=$_POST['name']."_profile_".$ran_profile."_".$_FILES['modelPhoto']['name'];
		$source=$_FILES['modelPhoto']['tmp_name'];
			
		if($size<=0){$modelPic="";}
			$uploadedpaths="brand-model/";
			$dest=$uploadedpaths.$modelPic;
			if(($size>0)&&($filetype=="image/jpeg" || $filetype=="image/png" || $filetype=="image/jpg"))
			{
				
				move_uploaded_file($source,$dest);
				$arrayData['modelPhoto'] = $modelPic;
				
			}else {
				echo "<script>alert('Uploaded file type is not valid');</script>";
				echo "<script>location.href='panel.php?page=master_model&e=e'</script>";die;
			}
	}
	
    if(save($table, $arrayData) == 1)
    {
       echo "<script>location.href='panel.php?page=master_model&s=a'</script>";die;
    }
    else
    {
		
        echo "<script>location.href='panel.php?page=master_model&e=w'</script>";
    }
  }
  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
  {
    $sno=filter_values($_GET['sno']);
    $sno = base64_decode($sno);
    if(isset($sno) && !empty($sno) && $sno != ''){
      if(mark_deleted($table, $sno) == 1)
      {
        echo "<script>location.href='panel.php?page=master_model&s=d'</script>";die;
      }
      else
      {
        echo "<script>location.href='panel.php?page=master_model&e=w'</script>";
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
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
            <h1>Model Master</h1>
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
              <li class="breadcrumb-item active">Model Master</li>
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
                <h3 class="card-title">Model Lists </h3>
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
                    <th>Photo</th>
                    <th>Status</th>
                    <th style="text-align:right;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $s = 0;
                    $field_array = array('sno', 'name', 'brand_id','modelPhoto', 'status');
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
                    <td><?php echo $data['name'];?></td>
                    <td><img src="brand-model/<?php echo $data['modelPhoto'];?>" style="width:100px;"></td>
                    <td class="project-state">
                     <span class="badge badge-<?php if($data['status'] == 1){ echo "success"; } else if($data['status'] == 0) { echo "danger";}?> "><?php echo statusMaster($data['status']);?></span>
                    </td>
                    <td class="project-actions text-right">
                      <a class="btn btn-info btn-sm" href="panel.php?page=master_model&sno=<?php echo base64_encode($data['sno']);?>&action=edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Delete This Row.')" href="panel.php?page=master_model&sno=<?php echo base64_encode($data['sno']);?>&action=delete">
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
					<h3 class="card-title">Add New <small>Model</small></h3>
				</div>
              <!-- /.card-header -->
              <!-- form start -->
			  
				<form id="quickForm" method="POST" enctype="multipart/form-data">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-4">
								<label>Brand Name<span class="required">*</span></label>
								<select name="brand_name" class="form-control custom-select" required>
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
							<div class="form-group col-md-4">
								<label>Model Name<span class="required">*</span></label>
								<input type="text" name="name" class="form-control" id="model_name" placeholder="Enter Model Name" required>
							</div>
							<div class="form-group col-md-4">
								<label>Model Photo</label>
								<input class="form-control" name="modelPhoto" type="file">
							</div>
							<div class="form-group col-md-4">
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
                $result = retrieve($table, $sno, $field_array, $where);
                if($result)
                {
                  foreach($result as $data)
                  {
                    $name = $data['name'];
                    $status = $data['status'];
                    $brand_id = $data['brand_id'];
                  }                  
                }
                else
                {
                  echo '<script>window.location.href="panel.php?page=master_model";</script>';die();
                }
              }
              else
              {
                echo '<script>window.location.href="panel.php?page=master_model";</script>';die();
              }
            ?>
            <div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Edit <small>Model</small></h3>
				</div>
              <!-- /.card-header -->
              <!-- form start -->
				<form id="quickForm" method="POST">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-4">
								<label>Brand Name<span class="required">*</span></label>
								<select name="brand_name" class="form-control custom-select" required>
									<option value="" selected>Select Brand</option>
									<?php 
										$field_array = array('sno', 'name');
										$where = "master_brand.status = '1'";
										$order_by = "name ASC";
										$brand_list = retrieve('master_brand', null, $field_array, $where, $order_by);
										foreach ($brand_list as $key => $value) {
										?>
										<option value="<?php echo $value['sno'];?>" <?php if($value['sno'] == $brand_id){ echo "selected";} ?>><?php echo $value['name'];?></option>
										<?php
										}
									?>
								</select>
								
							</div>
							<div class="form-group col-md-6">
								<label>Model Name<span class="required">*</span></label>
								<input type="text" name="name" class="form-control" id="model_name" placeholder="Enter Model" value="<?php echo $name; ?>" required>
							</div>
							<div class="form-group col-md-4">
								<label>Model Photo<span class="required">*</span></label>
								<input class="form-control" name="modelPhoto" type="file">
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
</body>
</html>
