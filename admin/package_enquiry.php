<!DOCTYPE html>
<?php
  $table = "enquiries";

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
            <h1>Package Enquiry</h1>
          </div>
          
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Enquiry Data</li>
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
                <h3 class="card-title">Package Enquiry Lists </h3>
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
                    <th>Contact No.</th>
                    <th>Enquiry Date</th>
                    <th>Brand Name</th>
					
                    <th>Model Name</th>
                    <th>Model Type</th>
                    <th>Package Name</th>
                    <th>Details</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $s = 0;
                    $field_array = array('sno', 'name', 'phone','pkgId','status','date_created');
                    $where = "";
                    $orderby = "name ASC";
                    $result = retrieve($table, null, $field_array, $where, $orderby);
                    if($result){
                      foreach($result as $data)
                      {
                        $s++;
						$pkgId = $data['pkgId'];
						$field_package = array('sno', 'brand_id', 'model_id','model_type','status','name','sales_price');
						$where_package = " status=1";
						$pkg_result = retrieve('new_package', $pkgId, $field_package, $where_package);
                  ?>
                  <tr>
                    <td><?php echo $s;?></td>
                    <td><b><?php echo $data['name'];?></b></td>
                    <td><b><?php echo $data['phone'];?></b></td>
                    <td><?php echo date("d-m-Y", strtotime($data['date_created']));?></td>
                    <td><?php 
						$c_id = $pkg_result[0]['brand_id'];
						$field_array = array('sno', 'name');
						$where = " sno ='$c_id' AND status='1'";
						
						$brand = retrieve('master_brand', $c_id, $field_array, $where);
					
					echo $brand[0]['name'];
					?></td>
					
                    <td><?php $c_id = $pkg_result[0]['model_id'];
						$field_array = array('sno', 'name');
						$where = " sno ='$c_id' AND status='1'";
						
						$model = retrieve('master_model', $c_id, $field_array, $where);
					
					echo $model[0]['name'];;?></td>
					
					<td><?php $model_type = $pkg_result[0]['model_type'];
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
					<td><?php $sid = $pkg_result[0]['name'];
				    	$field_array = array('sno', 'name');
						$where = " sno ='$sid' AND status='1'";
						
						$package_name = retrieve('master_services', $sid, $field_array, $where);
					
					echo $package_name[0]['name'];
					?></td>
					<td class="project-actions text-right">
                      <a class="btn btn-info btn-sm" href="panel.php?page=package_enquiry&sno=<?php echo base64_encode($data['sno']);?>&action=view">
                          <i class="fas fa-eye">
                          </i>
                          View
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
			<?php 
            }
			else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
            {
              if(isset($_GET['sno']) && $_GET['sno']!='')
              {
                $sno = base64_decode($_GET['sno']);
				//$field_array = array('sno', 'name', 'phone','pkgId','status','date_created');
                $where = " sno=$sno";
                $orderby = "name ASC";
                $result = retrieve($table, null, null, $where, $orderby);
                
                if($result){
					$pkgId = $result[0]['pkgId'];
					$name = $result[0]['name'];
					$phone = $result[0]['phone'];
					$email = $result[0]['email'];
					$address = $result[0]['address'];
					$message = $result[0]['message'];
					$orderid = $result[0]['enqId'];
					$field_package = array('sno', 'brand_id', 'model_id','model_type','status','name','sales_price','packagePhoto');
					$where_package = " status=1";
					$pkg_result = retrieve('new_package', $pkgId, $field_package, $where_package);
					
					if($pkg_result){
					    	$sid = $pkg_result[0]['name'];
				    	    $field_array = array('sno', 'name');
						    $where = " sno ='$sid' AND status='1'";
						
						    $package_name = retrieve('master_services', $sid, $field_array, $where);
						    
					    
                        if($pkg_result[0]['packagePhoto'] != '' && file_exists("../product-img/".$pkg_result[0]['packagePhoto']))
                        {
                            $pkg_img = "../product-img/" .$pkg_result[0]['packagePhoto'];
                        }else{
                            $pkg_img = "../img/product/1.png";
                        }
                                            
					}
				
				}
			  }
			  ?>
			 

<div class="card card-solid">
<div class="card-body">
<div class="row">
<div class="col-12 col-sm-6">
<h3 class="d-inline-block d-sm-none"><?php echo $package_name[0]['name']; ?></h3>
<div class="col-12">
<img src="<?php echo $pkg_img; ?>" class="product-image" alt="Product Image">
</div>

</div>
<div class="col-12 col-sm-6">
<h3 class="my-3"><?php echo $package_name[0]['name']; ?></h3>
<p><strong>Order ID: </strong> <?php echo $orderid; ?></p>
<p><strong>Order Date: </strong> <?php echo date("d-m-Y", strtotime($result[0]['date_created']));?></p>
<p><strong>Customer Message: </strong> <?php echo $message; ?></p>
<hr>
<h4>Customer Information</h4>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email ID </th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $phone; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $address; ?></td>
        </tr>
    </tbody>
</table>
</div>

<hr>
<h4>Order Information</h4>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Brand Name</th>
            <th>Model Name</th>
            <th>Model Type </th>
            
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php 
						$c_id = $pkg_result[0]['brand_id'];
						$field_array = array('sno', 'name');
						$where = " sno ='$c_id' AND status='1'";
						
						$brand = retrieve('master_brand', $c_id, $field_array, $where);
					
					echo $brand[0]['name'];
					?></td>
					
                    <td><?php $c_id = $pkg_result[0]['model_id'];
						$field_array = array('sno', 'name');
						$where = " sno ='$c_id' AND status='1'";
						
						$model = retrieve('master_model', $c_id, $field_array, $where);
					
					echo $model[0]['name'];;?></td>
					
					<td><?php $model_type = $pkg_result[0]['model_type'];
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
        </tr>
    </tbody>
</table>
</div>


</div>
</div>

</div>

</div>


			<?php }
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
				console.log(resultData);
				if(resultData == 2 || resultData == 0)
		    	{
		    		return false;
		    	}
		    	$("#summernote").html(resultData);
		    }
		});
		}
		$("#summernote").html('');
		
	});
</script>
</body>
</html>
