<!DOCTYPE html>
<?php
  $table = "master_role";

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
        echo "<script>location.href='panel.php?page=master-role&e=b'</script>";die;
      }
    }
    if(checkExists($table, $arrayData) == 1){
      echo "<script>location.href='panel.php?page=master-role&e=e'</script>";die;
    }
    $arrayData['status'] = filter_values($_POST['status']);
    if(save($table, $arrayData) == 1)
    {
     $role_id = $con->lastInsertId();

     if(isset($_POST['sno']) && $_POST['sno'] !='')
      {
        $role_id = filter_values($_POST['sno']);
            $sql_query="UPDATE user_access SET deleted = '1' WHERE user_role_id=:user_role_id";
            $strQ=$con->prepare($sql_query);
            $strQ->bindValue('user_role_id', $role_id);
            $strQ->execute();
      }
     
      if(isset($_POST['name_action'])){
        if(count($_POST['name_action'])>0){
          foreach ($_POST['name_action'] as $key => $value) {
              if (!empty($value))
              {
                $roleArray = array();
                $roleArray['user_role_id'] = $role_id;
                $roleArray['action_id'] = $value;
                $roleArray['status'] = $_POST['status'];
                $save = save('user_access', $roleArray);
              }
          }
        }
      }
       echo "<script>location.href='panel.php?page=master-role&s=a'</script>";die;
    }
    else
    {
        echo "<script>location.href='panel.php?page=master-role&e=w'</script>";
    }
  }
  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
  {
    $sno=filter_values($_GET['sno']);
    $sno = base64_decode($sno);
    if(isset($sno) && !empty($sno) && $sno != ''){
      if(mark_deleted($table, $sno) == 1)
      {
        echo "<script>location.href='panel.php?page=master-role&s=d'</script>";die;
      }
      else
      {
        echo "<script>location.href='panel.php?page=master-role&e=w'</script>";
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
  <style type="text/css">
    li {
      list-style: none;
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
            <h1>Role Master</h1>
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
                  <h5><i class="icon fas fa-ban"></i>Please Fill Are Required Fields.!</h5>
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
              <li class="breadcrumb-item active">Role Master</li>
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
                <h3 class="card-title">All Role</h3>
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
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $s = 0;
                    $field_array = array('sno', 'name', 'status');
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
                    <td><?php echo $data['name'];?></td>
                    <td class="project-state">
                     <span class="badge badge-<?php if($data['status'] == 1){ echo "success"; } else if($data['status'] == 0) { echo "danger";}?> "><?php echo statusMaster($data['status']);?></span>
                    </td>
                    <td class="project-actions text-right">
                      <a class="btn btn-info btn-sm" href="panel.php?page=master-role&sno=<?php echo base64_encode($data['sno']);?>&action=edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Delete This Row.')" href="panel.php?page=master-role&sno=<?php echo base64_encode($data['sno']);?>&action=delete">
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
					<h3 class="card-title">Add New <small>Role</small></h3>
				</div>
              <!-- /.card-header -->
              <!-- form start -->
			  
				<form id="quickForm" method="POST">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="Role">Role</label>
								<input type="text" name="name" class="form-control" id="Role" placeholder="Enter Role">
								
							</div>
							<div class="form-group col-md-6">
								<label for="status">Status</label>
								<select id="status" name="status" class="form-control custom-select">
								  <option value="1" selected>Active</option>
								  <option value="0">Deactive</option>
								</select>
							</div>
						</div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="Role">Menu Assign To Role</label>
                <div class="control-group">
                    <ul>
                  <?php
                  $field_array = array('sno', 'name', 'type');
                  $where = "setting_menu.status = '1' AND setting_menu.parent_id = '0'";
                  $order_by = "name ASC";
                  $menus = retrieve('setting_menu', null, $field_array, $where, $order_by);
                  
                  if($menus)
                  {
                    foreach ($menus as $key => $value) {
                      $id = $value['sno'];
                      $type = $value['type'];
                      $field_array = array('sno', 'name', 'type');
                      $where = "setting_menu.status = '1' AND setting_menu.parent_id = '$id'";
                      $order_by = "name ASC";
                      $sub_menus = retrieve('setting_menu', null, $field_array, $where, $order_by);
                      if($sub_menus==""){ 
                          
                        ?>

                        <li><input type="checkbox" id="<?php echo $id;?>" class="chk" value="<?php echo $id;?>" name="name_action[]" /><strong> <?php echo $value['name'];?></strong></li>

                      <?php } else {
                      ?>
                         <li><input type="checkbox" id="<?php echo $id;?>" class="chk" value="<?php echo $id;?>" name="name_action[]" /><strong> <?php echo $value['name'];?></strong>
                          <ul class="sub-menu">
                            <?php 
                              foreach ($sub_menus as $key => $value) {
                                $sub_menus_id = $value['sno'];
                                $sub_menus_type = $value['type'];
                            ?>
                                <li><input type="checkbox" class="checkbox_<?php echo $id;?> checkbox" name="name_action[]" tabindex="<?php echo $id;?>" value="<?php echo $sub_menus_id;?>"/> <?php echo $value['name'];?></li>
                              <?php } ?>
                              </ul>
                            </li>
                      <?php }
                  ?>

                  <?php
                    }
                  }
                  ?>
                  </ul>
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
                $field_array = array('status', 'name');
                $where = "";
                $result = retrieve($table, $sno, $field_array, $where);
                if($result)
                {
                  foreach($result as $data)
                  {
                    $name = $data['name'];
                    $status = $data['status'];
                  }                  
                }
                else
                {
                  echo '<script>window.location.href="panel.php?page=master-role";</script>';die();
                }
              }
              else
              {
                echo '<script>window.location.href="panel.php?page=master-role";</script>';die();
              }
            ?>
            <div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Edit <small>Role</small></h3>
				</div>
              <!-- /.card-header -->
              <!-- form start -->
				<form id="quickForm" method="POST">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="Role">Role</label>
								<input type="text" name="name" class="form-control" id="Role" placeholder="Enter Role" value="<?php echo $name; ?>">
							</div>
							<div class="form-group col-md-6">
								<label for="status">Status</label>
								<select id="status" name="status" class="form-control custom-select">
								  <option value="1" <?php if($status == 1) { echo "selected"; }?>>Active</option>
								  <option value="0" <?php if($status == 0) { echo "selected"; }?>>Deactive</option>
								</select>
							</div>
						</div>


            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="Role">Menu Assign To Role</label>
                <?php
                  $field_array = array('sno', 'name', 'type');
                  $where = "setting_menu.status = '1' AND setting_menu.parent_id = '0'";
                  $order_by = "name ASC";
                  $menus = retrieve('setting_menu', null, $field_array, $where, $order_by);
                  if($menus)
                  {
                    foreach ($menus as $key => $value) {
                      $id = $value['sno'];
                      $type = $value['type'];
                      $total_count = getTotalCount("SELECT sno FROM user_access WHERE deleted = '0' AND status = 1 AND user_role_id = '$sno' AND action_id = '$id'");
                  ?>
                  <ul >
                      <li><input type="checkbox" id="<?=$id;?>" class="chk" value="<?=$id;?>" name="name_action[]" <?php if($total_count>0){echo "checked";}?> /><strong><?=$value['name'];?></strong></li>
                      <?php
                    $field_array = array('sno', 'name', 'type');
                    $where = "setting_menu.status = '1' AND setting_menu.parent_id = '$id'";
                    $order_by = "name ASC";
                    $sub_menus = retrieve('setting_menu', null, $field_array, $where, $order_by);
                    if($sub_menus)
                    {
                      foreach ($sub_menus as $key => $value) {
                        $sub_menus_id = $value['sno'];
                        $sub_menus_type = $value['type'];

                        $total_count_sub = getTotalCount("SELECT sno FROM user_access WHERE deleted = '0' AND status = '1' AND user_role_id = '$sno' AND action_id = '$sub_menus_id'");
                    ?>
                      <ul>
                          <li><input type="checkbox" class="checkbox_<?=$id;?> checkbox" name="name_action[]" tabindex="<?=$id;?>" value="<?=$sub_menus_id;?>" <?php if($total_count_sub>0){echo "checked";}?>/><?=$value['name'];?></li>
                      </ul>
                      <?php
                      }
                    }
                    ?>
                  </ul>
                  <?php
                    }
                  }
                  ?>
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
  $('.chk').on('click',function(){
      var id=$(this).attr('id');
        
       if(this.checked){
            $('.checkbox_'+id).prop('checked',true);
        }
        else{
            $('.checkbox_'+id).prop('checked',false);
        }
    });
    
    $('.checkbox').on('click',function(){
      var pid=$(this).attr('tabindex');
        if($('.checkbox_'+pid+':checked').length == $('.checkbox_'+pid).length){
            $('#'+pid).prop('checked',true);
        }
        else if($('.checkbox_'+pid+':checked').length > 0){
            $('#'+pid).prop('checked',true);
        }
        else{
            $('#'+pid).prop('checked',false);
        }
    });
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
        required: "Please enter a Role",
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
