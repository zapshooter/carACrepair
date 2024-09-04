<!DOCTYPE html>
<?php
  $table = "master_service";

  if(isset($_POST['sub']))
  {
    $arrayData = array();
	$arrayData['name'] = filter_values($_POST['name']);
	$arrayData['service_cat_id'] = filter_values($_POST['service_cat']);
	
	if(isset($_POST['sno']) && $_POST['sno'] !='')
    {
      $arrayData['sno'] = filter_values($_POST['sno']);
    }
    foreach($arrayData as $field) {
      if (empty($field)) {
        echo "<script>location.href='panel.php?page=master-service&e=b'</script>";die;
      }
    }
	if(checkExists($table, $arrayData) == 1){
      echo "<script>location.href='panel.php?page=master-service&e=e'</script>";die;
    }
	$arrayData['service_amount'] = filter_values($_POST['service_amount']);
    $arrayData['status'] = 1;
    if(save($table, $arrayData) == 1)
    {
       echo "<script>location.href='panel.php?page=master-service&s=a'</script>";die;
    }
    else
    {
        echo "<script>location.href='panel.php?page=master-service&e=w'</script>";
    }
  }
  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
  {
    $sno=filter_values($_GET['sno']);
    $sno = base64_decode($sno);
    if(isset($sno) && !empty($sno) && $sno != ''){
      if(mark_deleted($table, $sno) == 1)
      {
        echo "<script>location.href='panel.php?page=master-service&s=d'</script>";die;
      }
      else
      {
        echo "<script>location.href='panel.php?page=master-service&e=w'</script>";
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
            <h1>User Service</h1>
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
                  <h5><i class="icon fas fa-ban"></i>Please Fill all Required Fields.!</h5>
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
              <li class="breadcrumb-item active">Service Master</li>
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
                <h3 class="card-title">Service List</h3>
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
                    <th>Service Category</th>
					<th>Service</th>
					<th>Amount</th>
                    <th>Status</th>
                    <th style="text-align:right;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $s = 0;
                    $field_array = array('sno', 'name', 'status','service_cat_id','service_amount');
                    $where = "";
                    $orderby = "name ASC";
                    $result = retrieve($table, null, $field_array, $where, $orderby);
                    if($result){
                      foreach($result as $data)
                      {
                        $s++;
						$service_cat = $data['service_cat_id'];
						$field_cat = array('name');
						$where_cat_id =" status = 1 AND sno = $service_cat";
						$res_servicecat = retrieve('master_service_category', null, $field_cat, $where_cat_id, null);
						
                  ?>
                  <tr>
                    <td><?php echo $s;?></td>
                    <td><?php echo $res_servicecat[0]['name'];?></td>
                    <td><?php echo $data['name'];?></td>
                    <td><?php echo $data['service_amount'];?></td>
                    <td class="project-state">
                     <span class="badge badge-<?php if($data['status'] == 1){ echo "success"; } else if($data['status'] == 0) { echo "danger";}?> "><?php echo statusMaster($data['status']);?></span>
                    </td>
                    <td class="project-actions text-right">
                      <a class="btn btn-info btn-sm" href="panel.php?page=master-service&sno=<?php echo base64_encode($data['sno']);?>&action=edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Delete This Row.')" href="panel.php?page=master-service&sno=<?php echo base64_encode($data['sno']);?>&action=delete">
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
					<h3 class="card-title">Add New <small>Service</small></h3>
				</div>
              <!-- /.card-header -->
              <!-- form start -->
			  
				<form id="quickForm" method="POST">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-4">
								<label>Service Category</label>
								<select id="service" name="service_cat" class="form-control custom-select">
								<option value="" selected>Select a Service Category</option>
								<?php 
								$field_array_cat = array('sno', 'name', 'status');
								$where_cat = " status=1";
								$orderby_cat = "name ASC";
								$result_servicecat = retrieve('master_service_category', null, $field_array_cat, $where_cat, $orderby_cat);
									foreach($result_servicecat as $values){ ?>
										<option value="<?php echo $values['sno'];?>"><?php echo $values['name'];?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label>Service Name</label>
								<input type="text" name="name" class="form-control" id="name" placeholder="Enter Service Name">
							</div>
							<div class="form-group col-md-4">
								<label>Amount</label>
								<input type="text" name="service_amount" class="form-control" id="service_amount" placeholder="Enter Service Amount">
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
                $field_array = array('name', 'status','service_cat_id','service_amount');
                $where = "";
                $result = retrieve($table, $sno, $field_array, $where);
                if($result)
                {
                  foreach($result as $data)
                  {
                    $name = $data['name'];
					$status = $data['status'];
					$service_cat_id = $data['service_cat_id'];
					$service_amount = $data['service_amount'];
                  }                  
                }
                else
                {
                  echo '<script>window.location.href="panel.php?page=master-service";</script>';die();
                }
              }
              else
              {
                echo '<script>window.location.href="panel.php?page=master-service";</script>';die();
              }
            ?>
            <div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Edit <small>Service</small></h3>
				</div>
              <!-- /.card-header -->
              <!-- form start -->
				<form id="quickForm" method="POST">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-4">
								<label>Service Category</label>
								<select id="service" name="service_cat" class="form-control custom-select">
								<option value="" selected>Select a Service Category</option>
								<?php 
								$field_array_cat = array('sno', 'name', 'status');
								$where_cat = " status=1";
								$orderby_cat = "name ASC";
								$result_servicecat = retrieve('master_service_category', null, $field_array_cat, $where_cat, $orderby_cat);
									foreach($result_servicecat as $values){ ?>
										<option value="<?php echo $values['sno'];?>" <?php if($values['sno'] == $service_cat_id) { echo "selected"; }?>><?php echo $values['name'];?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label>Service Name</label>
								<input type="text" name="name" value="<?php echo $name; ?>" class="form-control" id="name" placeholder="Enter Service Name">
							</div>
							<div class="form-group col-md-4">
								<label>Amount</label>
								<input type="text" name="service_amount" value="<?php echo $service_amount; ?>" class="form-control" id="service_amount" placeholder="Enter Service Amount">
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
      } 
		service_amount: {
			required : true,
		},
    },
    messages: {
      name: {
        required: "Please enter a Service Name",
      }
	  service_amount: {
        required: "Please enter a Service Amount",
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
