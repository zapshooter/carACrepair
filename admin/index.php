<!DOCTYPE html>
<?php
session_start();
include("database.php");
include("function.php");
$con=db_connect();


$themeFields = array('name', 'logo', 'favicon', 'companyName', 'companyLink', 'title');
$whereFields = "";
$setting_theme = retrieve('setting_theme', null, $themeFields, $whereFields);

if($setting_theme){
  foreach($setting_theme as $data)
  {
    $site_name = $data['name'];
    $logo = $data['logo'];
    $favicon = $data['favicon'];
    $companyName = $data['companyName'];
    $companyLink = $data['companyLink'];
    $title_name = $data['title'];
  }
}


 extract($_POST);
 if(isset($sub))
 {
  $uname = "";
  $password = "";
  if(isset($_POST['uname']) && !empty($_POST['uname']) && $_POST['uname'] != '')
  {
    $uname = $_POST['uname'];
  }
  if(isset($_POST['password']) && !empty($_POST['password']) && $_POST['password'] != '')
  {
    $password = $_POST['password'];
  }
  
  if($uname == '' && $password == '')
  {
    echo '<script>alert("Fill all required fields.");window.location.href="login.php";</script>';die();
  }  
  $pass = md5($password);
  $field_array = "";
  $wrongpassword = "";
  $wrongusername = "";
  //$where = " login.user_name = '$uname' AND login.password = '$pass' AND login.status = '1'";
  $where = " login.user_name = '$uname' AND login.status = '1'";
  $result = retrieve('login', null, $field_array, $where);
  
  if($result){
    foreach ($result as $key => $data) {
		$userid=$data['sno'];
		$upass = $data['password'];
		$user_name = $data['name'];
		$user_type = $data['type'];
		$username = $data['user_name'];
    $user_role = $data['role'];
	}
	
	if($upass == $pass){
		$_SESSION['userid']=$userid;
		$_SESSION['spass']=$upass;
		$_SESSION['user_name']=$user_name;
		$_SESSION['user_type']=$user_type;
		$_SESSION['username']=$username;	
    $_SESSION['user_role']=$user_role;  
		echo '<script>window.location.href="dashboard.php"</script>';
	}else 
	{
		$wrongpassword='
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Oh Snapp!😕</strong> Alert <b class="alert-link">Password: </b>You entered wrong password.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>';
	}
   }
  else
  {
    //echo '<script language="javascript">alert("name or password is not correct")</script>';
	$wrongusername='
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Oh Snapp!😕</strong> Alert <b class="alert-link">UserName: </b> You entered a wrong UserName.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>';
  }
 }
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title_name; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition animatedBackground login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
   <!-- <div class="card-header text-center">
      <a href="#" class="h1"><img src="dist/img/<?php echo $logo;?>"></a>
    </div> -->
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="uname" required="required">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
		<?php if(isset($wrongusername)){echo $wrongusername;}?>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required="required">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
		<?php if(isset($wrongpassword)){echo $wrongpassword;}?>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="sub" class="btn btn-primary btn-block">Sign In</button>
          </div>
		  <div class="col-8" style="text-align:right;">
			<a href="forgot-password.php" class="btn btn-danger">I forgot my password</a>
		  </div>
          <!-- /.col -->
        </div>
      </form>

    <!--   <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

     
     <!--  <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
