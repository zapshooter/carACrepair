<!DOCTYPE html>
<?php
  include('control.php');
  $table = "setting_menu";
  if($user_type!='admin')
  {
    echo "<script>location.href='dashboard.php?e=b'</script>";die;
  }
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
        echo "<script>location.href='menu-setting.php?e=b'</script>";die;
      }
    }
    if(checkExists($table, $arrayData) == 1){
      echo "<script>location.href='menu-setting.php?e=e'</script>";die;
    }
    $arrayData['parent_id'] = filter_values($_POST['parent_id']);
    $arrayData['type'] = filter_values($_POST['type']);
    $arrayData['fileName'] = filter_values($_POST['fileName']);
    $arrayData['menuUrl'] = filter_values($_POST['menuUrl']);
    $arrayData['icon'] = filter_values($_POST['icon']);
    $arrayData['is_show'] = filter_values($_POST['is_show']);
    $arrayData['sorder'] = filter_values($_POST['sorder']);
    $arrayData['status'] = filter_values($_POST['status']);
    if(save($table, $arrayData) == 1)
    {
      if(isset($_POST['action_name']))
      {
        $count = count(array_filter(filter_values($_POST['action_name'])));
        if($count > 0)
        {
          if(isset($_POST['sno']) && $_POST['sno'] !='')
          {
            $menu_id = filter_values($_POST['sno']);
            $field_array = array('sno');
            $where = "setting_menu_action.menu_id='".$menu_id."'";
            $chkData = retrieve('setting_menu_action', null, $field_array, $where);
            if($chkData)
            {
              foreach ($chkData as $key => $value) {
               $action_id = $value['sno'];
                mark_deleted('setting_menu_action', $action_id);
              }              
            }
          }
          else
          {            
            $field_array = array('sno');
            $where = "$table.status = '1' AND $table.name='".$arrayData['name']."'";
            $menusData = retrieve($table, null, $field_array, $where);
            if($menusData)
            {
              $menu_id = $menusData[0]['sno'];
            }
          }

          if($menu_id)
          {
            $array = array();
            for($i= 0; $i<$count; $i++)
            {
              $array['menu_id'] = $menu_id;
              $array['name'] = filter_values($_POST['action_name'][$i]);
              $array['status'] = filter_values($_POST['status']);
              save('setting_menu_action', $array);
            }
          }
        }
      }
      echo "<script>location.href='menu-setting.php?s=a'</script>";die;
    }
    else
    {
      echo "<script>location.href='menu-setting.php?e=w'</script>";
    }
  }

  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
  {
    $sno=filter_values($_GET['sno']);
    $sno = base64_decode($sno);
    if(isset($sno) && !empty($sno) && $sno != ''){
      if(mark_deleted($table, $sno) == 1)
      {
        echo "<script>location.href='menu-setting.php?s=d'</script>";die;
      }
      else
      {
        echo "<script>location.href='menu-setting.php?e=w'</script>";
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
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
            <h1>Menus Setting</h1>
          </div>
          <div class="col-sm-6">
            <?php
              if((isset($_GET['e']) && $_GET['e']!='') || (isset($_GET['s']) && $_GET['s']!=''))
              {
                  if(isset($_GET['s']) && $_GET['s'] == 'au')
                  {
                ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i>Data Updated Successfully.!</h5>
                  </div>
                <?php
                  }
                  else if(isset($_GET['s']) && $_GET['s'] == 'a')
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
          <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Menus Setting</li>
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
                <h3 class="card-title">All Menus</h3>
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
                    <th>Parent Menu</th>
                    <th>Menu Name</th>
                    <th>File Name</th>
                    <th>Menu URL</th>
                    <th>Menu Actions</th>
                    <th>Show</th>
                    <th>Sorder</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $s = 0;
                    $field_array = "";
                    $where = "";
                    $orderby = "parent_id ASC";
                    $result = retrieve($table, null, $field_array, $where, $orderby);
                    if( $result )
                    {
                      foreach($result as $data)
                      {
                        $is_show = "No";
                        if($data['is_show'] == 1)
                        {
                         $is_show = "Yes";
                        }
                        $s++;
                  ?>
                  <tr>
                    <td><?php echo $s;?></td>
                    <td>
                      <?php
                        if($data['parent_id']==0){
                          echo $parent_menu = "";
                        } else {
                          $field_array = array('parent_id','name');
                          $where = "";
                          $parentmenu = retrieve($table, $data['parent_id'], $field_array, $where);
                          echo $parentmenu[0]['name'];
                        }
                      ?>
                    </td>
                    <td><?php echo $data['name'];?></td>
                    <td><?php echo $data['fileName'];?></td>
                    <td><?php echo $data['menuUrl'];?></td>
                    <td>
                      <?php
                        $field_array = array('name');
                        $where = "setting_menu_action.status = '1' AND setting_menu_action.menu_id = '".$data['sno']."'";
                        $actionData = retrieve('setting_menu_action', NULL, $field_array, $where);
                        if($actionData)
                        {
                          foreach ($actionData as $key => $value) {
                           echo '<span class="badge badge-info">'.$value['name'].'</span>&nbsp;';
                          }
                        }
                      ?>
                    </td>
                    <td class="project-state">
                      <span class="badge badge-<?php if($data['is_show'] == 1){ echo "success"; } else if($data['is_show'] == 0) { echo "danger";}?> "><?php echo $is_show;?></span>
                    </td>
                    <td><?php echo $data['sorder'];?></td>
                    <td class="project-state">
                      <span class="badge badge-<?php if($data['status'] == 1){ echo "success"; } else if($data['status'] == 0) { echo "danger";}?> "><?php echo statusMaster($data['status']);?></span>
                    </td>
                    <td class="project-actions text-right">
                      <a class="btn btn-info btn-sm" href="menu-setting.php?sno=<?php echo base64_encode($data['sno']);?>&action=edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Delete This Row.')" href="menu-setting.php?sno=<?php echo base64_encode($data['sno']);?>&action=delete">
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
                <h3 class="card-title">Add New <small>Menu</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" method="POST">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Parent Menu</label>
                        <select id="parent_id" name="parent_id" class="form-control select2bs4">
                          <option value="0" selected>No Parent Menu</option>
                          <?php 
                            $field_array = array('sno', 'name');
                            $where = "$table.status = '1' AND $table.parent_id=0";
                            $order_by = "name ASC";
                            $menusData = retrieve($table, null, $field_array, $where, $order_by);
                            if($menusData){
                              foreach ($menusData as $key => $value) {
                          ?>
                          <option value="<?=$value['sno'];?>"><?=$value['name'];?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="name">Menu Name <code>*</code></label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Menu Name" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="fileName">File Name</label>
                        <input type="text" name="fileName" class="form-control" id="fileName" placeholder="File Name">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="menuUrl">Menu URL</label>
                        <input type="text" name="menuUrl" class="form-control" id="menuUrl" placeholder="Enter Menu URL">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="type">Menu Type <code>*</code></label>
                        <select id="type" name="type" class="form-control custom-select">
                          <option value="" selected>Select</option>
                          <option value="p">Main Menu</option>
                          <option value="s">Sub Menu</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="icon">Menu Icon</label>
                        <input type="text" name="icon" class="form-control" id="icon" placeholder="Enter Menu Icon">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="is_show">Show In Side Bar?</label>
                        <select id="is_show" name="is_show" class="form-control custom-select">
                          <option value="1" selected>Yes</option>
                          <option value="0">No</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="sorder">Sorder</label>
                        <input type="text" name="sorder" class="form-control" id="sorder" placeholder="Enter sorder" maxlength="2">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group clearfix">
                        <label for="sorder">Menu Actions</label>
                        <br/>
                        <?php
                          if($actionmenu)
                          {
                            foreach ($actionmenu as $key => $value) {
                        ?>
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="checkboxPrimary<?php echo $key+1;?>" name="action_name[]" value="<?php echo $value;?>">
                          <label for="checkboxPrimary1"> <?php echo $value;?></label>
                        </div>&nbsp;&nbsp;
                      <?php } } ?>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control custom-select">
                          <option value="1" selected>Active</option>
                          <option value="0">Deactive</option>
                        </select>
                      </div>
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
                $field_array = "";
                $where = "";
                $result = retrieve($table, $sno, $field_array, $where);
                foreach($result as $data)
                {
                  $name = $data['name'];
                  $status = $data['status'];
                  $parent_id = $data['parent_id'];
                  $sorder = $data['sorder'];
                  $icon = $data['icon'];
                  $type = $data['type'];
                  $fileName = $data['fileName'];
                  $menuUrl = $data['menuUrl'];
                  $is_show = $data['is_show'];
                }
              }
              else
              {
                 echo '<script>window.location.href="new-registration.php";</script>';die();
              }
            ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit <small>Menu</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" method="POST">
                 <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Parent Menu</label>
                        <select id="parent_id" name="parent_id" class="form-control select2bs4">
                          <option value="0" selected>No Parent Menu</option>
                          <?php 
                            $field_array = array('sno', 'name');
                            $where = "$table.status = '1' AND $table.parent_id=0";
                            $order_by = "name ASC";
                            $menusData = retrieve($table, null, $field_array, $where, $order_by);
                            if($menusData){
                              foreach ($menusData as $key => $value) {
                          ?>
                          <option value="<?=$value['sno'];?>" <?php if($parent_id == $value['sno']){ echo "selected";}?>><?=$value['name'];?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="name">Menu Name <code>*</code></label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Menu Name" required value="<?php echo $name; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="fileName">File Name</label>
                        <input type="text" name="fileName" class="form-control" id="fileName" placeholder="File Name" value="<?php echo $fileName; ?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="menuUrl">Menu URL</label>
                        <input type="text" name="menuUrl" class="form-control" id="menuUrl" placeholder="Enter Menu URL" value="<?php echo $menuUrl; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="type">Menu Type <code>*</code></label>
                        <select id="type" name="type" class="form-control custom-select">
                          <option value="">Select</option>
                          <option value="p" <?php if($type == 'p') { echo "selected"; }?>>Main Menu</option>
                          <option value="s" <?php if($type == 's') { echo "selected"; }?>>Sub Menu</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="icon">Menu Icon</label>
                        <input type="text" name="icon" class="form-control" id="icon" placeholder="Enter Menu Icon"  value="<?php echo $icon; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="is_show">Show In Side Bar?</label>
                        <select id="is_show" name="is_show" class="form-control custom-select">
                          <option value="1" <?php if($is_show == 1) { echo "selected"; }?>>Yes</option>
                          <option value="0" <?php if($is_show == 0) { echo "selected"; }?>>No</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="sorder">Sorder</label>
                        <input type="text" name="sorder" class="form-control" id="sorder" placeholder="Enter sorder" maxlength="2" value="<?php echo $sorder; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group clearfix">
                        <label for="sorder">Menu Actions</label>
                        <br/>
                        <?php
                          if($actionmenu)
                          {
                            foreach ($actionmenu as $key => $value) {
                            $total_count = getTotalCount("SELECT sno FROM setting_menu_action WHERE deleted = '0' AND status = 1 AND name = '$value' AND menu_id = '$sno'");
                        ?>
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="checkboxPrimary<?php echo $key+1;?>" name="action_name[]" value="<?php echo $value;?>" <?php if($total_count>0){echo "checked";}?>>
                          <label for="checkboxPrimary1"> <?php echo $value;?></label>
                        </div>&nbsp;&nbsp;
                      <?php } } ?>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control custom-select">
                          <option value="1" <?php if($status == 1) { echo "selected"; }?>>Active</option>
                          <option value="0" <?php if($status == 0) { echo "selected"; }?>>Deactive</option>
                        </select>
                      </div>
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
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
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
 //Initialize Select2 Elements
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })

  $('#quickForm').validate({
    rules: {
      name: {
        required: true,
      },
      type: {
        required: true,
      },
    },
    messages: {
      name: {
        required: "Please enter a menu name.",
      },
      type: {
        required: "Please select menu type.",
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
