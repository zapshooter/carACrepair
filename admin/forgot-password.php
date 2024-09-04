<!DOCTYPE html>
<?php
session_start();
include("database.php");
include("function.php");
require 'includes/class.phpmailer.php';
require 'includes/class.smtp.php';
require 'includes/class.pop3.php';

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
  
  if($uname == '')
  {
    echo '<script>alert("Fill all required fields.");window.location.href="forgot-password.php";</script>';die();
  }
  $field_array = "";
  $wrongusername = "";
  $where = " (login.user_name = '$uname' OR login.email = '$uname') AND login.status = '1'";
  $result = retrieve('login', null, $field_array, $where);
  
  if($result){
    foreach ($result as $key => $data) {
      $userid=$data['sno'];
      $actualPassword = $data['actualPassword'];
      $user_name = $data['name'];
      $email = $data['email'];
     
      $subject = "HRM Password";
      $msg = "Dear $user_name, <br/> Your password request accepted.<br/><br/><h1>Your Password Is : <strong>$actualPassword</strong></h1>";

      $mail = new PHPMailer;

      // $mail->SMTPDebug = 3;                               // Enable verbose debug output

      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.hostinger.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'rohit@flickering.co.in';                 // SMTP username
      $mail->Password = '2*D$+Tb*';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      $mail->From = 'rohit@flickering.co.in';
      $mail->FromName = 'HRMS Module';
      $mail->addAddress($email); 
      $mail->addCC('dhnnik@gmail.com');

      $mail->WordWrap = 50;
      $mail->isHTML(true);                                  // Set email format to HTML

      $mail->Subject = $subject;
      $mail->Body    = $msg;
      $mail->AltBody = '';

      if(!$mail->send()) {
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
      } else {
          $wrongusername='
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> Alert <b class="alert-link">: </b>Your account password successfully sent to your email. Please check your email.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>';
      }      
    }
  }
  else
  {
    $wrongusername='
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Oh Snapp!😕</strong> Alert <b class="alert-link">UserName: </b> You entered a wrong UserName or Email ID.
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
  <link rel="stylesheet" href=".plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><img src="dist/img/<?php echo $logo;?>" style="width:100%;"></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="uname" class="form-control" placeholder="Email OR User Name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <?php if(isset($wrongusername)){echo $wrongusername;}?>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="sub" class="btn btn-primary btn-block">Request password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="index.php">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
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
