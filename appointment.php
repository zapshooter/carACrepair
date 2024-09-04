<?php
include "header.php";
require 'phpMailer/class.phpmailer.php';
require 'phpMailer/class.smtp.php';
require 'phpMailer/class.pop3.php';

if(isset($_POST['subm']))
{
    if($_POST['name'] != '' && $_POST['phone'] != '')
    {
        $enqId = date('ymdhis');
        $arrayData = array();
        $arrayData['enqId'] = $enqId;
        if(checkExists('appointment', $arrayData) == 1){
            $enqId = date('ymdhis');
        }        
        $arrayData['enqId'] = $enqId;
        $arrayData['name'] = filter_values($_POST['name']);
        $arrayData['lastname'] = filter_values($_POST['lastname']);
        $arrayData['pkgId'] = filter_values($_POST['pkgId']);
        $arrayData['phone'] = filter_values($_POST['phone']);
        if(isset($_POST['appDate']) && $_POST['appDate'] != '')
        {
         $arrayData['appDate'] = date("Y-m-d", strtotime(filter_values($_POST['appDate'])));
        }
        $arrayData['appTime'] = filter_values($_POST['appTime']);
        $arrayData['email'] = filter_values($_POST['email']);
        $arrayData['address'] = filter_values($_POST['address']);
        $arrayData['message'] = filter_values($_POST['message']);
        $arrayData['status'] = '0';
        if(save('appointment', $arrayData) == 1)
        {
            $vehicleInfo = '';            
            $field_array2 = array('sno', 'name', 'service_type', 'brand_id', 'model_type', 'model_id');
            $where2 = " status = '1' AND sno = '".$arrayData['pkgId']."' ";
            $order_by2 = "sno ASC";
            $pkglist = retrieve('new_package', null, $field_array2, $where2, $order_by2);
            if($pkglist)
            {
                foreach ($pkglist as $key => $value) {
                    $field_array3 = array('name');
                    $where3 = "master_services.status = '1'";
                    $order_by3 = "name ASC";
                    $service_list2 = retrieve('master_services', $value['name'], $field_array3, $where3, $order_by3);
                    if($service_list2)
                    {
                       $pkg_name .= $service_list2[0]['name'];
                    }

                    $field_array = array('sno', 'name');
                    $where = "master_service_category.status = '1' AND sno = '".$value['service_type']."'";
                    $order_by = "name ASC";
                    $service_list = retrieve('master_service_category', null, $field_array, $where, $order_by);
                    if($service_list)
                    {
                        $servicename = $service_list[0]['name'];
                    }

                    $field_array4 = array('name');
                    $where4 = "master_brand.status = '1'  AND sno = '".$value['brand_id']."'"; 
                    $order_by4 = "name ASC";
                    $brand_list4 = retrieve('master_brand', null, $field_array4, $where4, $order_by4);
                    if($brand_list4)
                    {
                        $brandname = $brand_list4[0]['name'];
                    }

                    $field_array5 = array('name');
                    $where5 = "master_model.status = '1'  AND sno = '".$value['model_id']."'"; 
                    $order_by5 = "name ASC";
                    $modal_list5 = retrieve('master_model', null, $field_array5, $where5, $order_by5);
                    if($modal_list5)
                    {
                        $modelname = $modal_list5[0]['name'];
                    }

                    $model_type = $value['model_type'];
                    if($model_type == 1)
                    {
                        $fueltypename = "Diesel";
                    }
                    else if($model_type == 2)
                    {
                        $fueltypename = "Petrol";
                    }
                    else if($model_type == 3)
                    {
                        $fueltypename = "CNG";
                    }
                }
                $vehicleInfo = $pkg_name.' ('. $servicename .')'.' - '.$brandname." " .$modelname.", " .$fueltypename;
            }
            $msg="
            <b>Appointment Details :</b> <br/>
            \nAppointment Id :- ".$enqId." <br/>  
            \nName :- ".$arrayData['name'].' '.$arrayData['lastname']." <br/>  
            \nE-mail :- ".$arrayData['email']." <br/>
            \nPhone :- ".$arrayData['phone']." <br/>
            \nVehicles Information :- ".$vehicleInfo." <br/>";
             if(isset($_POST['appDate']) && $_POST['appDate'] != '')
            {
             $dates = date("d-m-Y", strtotime(filter_values($_POST['appDate'])));
             $msg.="\nDate & Time  :- ".$dates." & ".filter_values($_POST['appTime'])." <br/>";
            }            
            $msg.="\nAddress  :- ".$arrayData['address']." <br/>
            \nMessage :- ".$arrayData['message']."";
            $msg.="<br/><br/><br/><br/>
            Thanks, <br/>
            Car AC Wale";
            
            $mail = new PHPMailer;
            $mail->isSMTP(); 
            $mail->Host = 'mail.caracwale.com';
            $mail->SMTPAuth = true; 
            $mail->Username = 'info@caracwale.com'; 
            $mail->Password = '*cjLGXjqTr8p';  
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;          
            
            $mail->From = 'info@caracwale.com';
            $mail->FromName = 'Car AC Wale';
            $mail->addAddress('dhnnik@gmail.com', 'Car AC Wale');
            $mail->addBcc('urvashiarya47@gmail.com', 'Car AC Wale');
            
            $mail->WordWrap = 50;  
            $mail->isHTML(true);
            
            $mail->Subject = '[ Car AC Wale ] Appointment';
            $mail->Body = $msg;
            $mail->send();
           echo "<script>location.href='appointment.php?action=done'</script>";die;
        }
        else
        {
            echo "<script>location.href='appointment.php?id=".base64_decode($getid)."&error=wrong'</script>";die;
        }
    }
    else
    {
        echo "<script>location.href='appointment.php?id=".base64_decode($getid)."&error=blank'</script>";die;
    } 
}
?>
<script type="text/javascript">
    function isNumberKey(evt)
    {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }

    function isCharacterKey(evt)
    {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode == 32 || charCode == 8 || charCode == 44 || charCode == 46 || charCode == 45 || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122))
        return true;
      return false;
    }
</script>
    <?php include "mobile-menu.php"; ?>
    <div class="ltn__utilize-overlay"></div>
    <!-- BREADCRUMB AREA START -->
    <div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image" data-bs-bg="img/bg/9.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color">//  Welcome to our company</h6>
                            <h1 class="section-title white-color">Schedule Appointment</h1>
                        </div>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li>Appointment</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->

    <!-- APPOINTMENT AREA START -->
    <div class="ltn__appointment-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if(isset($_GET['action']) && $_GET['action'] == 'done'){?>
                        <h4 class="text-success"><b>Success! </b> Your appointment has been successfully submitted. We will get back to you soon...</h4>
                        <br/>
                    <?php }?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'wrong'){?>
                         <h4 class="text-danger"><b>Error! </b> Something went wrong. Please try after some time.</h4>
                        <br/>
                    <?php }?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'blank'){?>
                         <h4 class="text-danger"><b>Error! </b> Please fill all required fields.</h4>
                        <br/>
                    <?php }?>
                    <div class="ltn__appointment-inner">
                        <form action="" method="post">
                            <h6>Personal Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-item input-item-name ltn__custom-icon">
                                        <input type="text" name="name" onKeyPress="return isCharacterKey(event);" placeholder="First name*" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-item-name ltn__custom-icon">
                                        <input type="text" name="lastname" onKeyPress="return isCharacterKey(event);" placeholder="Last name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-item-email ltn__custom-icon">
                                        <input type="email" name="email" placeholder="Email address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-item-phone ltn__custom-icon">
                                        <input type="text" name="phone" onKeyPress="return isNumberKey(event);" placeholder="Phone number*" minlength="10" maxlength="10" required>
                                    </div>
                                </div>
                            </div>
                            <h6>Vehicles Information</h6>
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="input-item">
                                        <select class="nice-select" name="brandName" id="brand_id">
                                            <option>Make</option>
                                            <?php 
                                                            $field_array = array('sno', 'name');
                                                            $where = "master_brand.status = '1' AND sno IN (SELECT brand_id FROM new_package WHERE deleted = 0 AND status = '1')";
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
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="input-item">
                                        <select class="nice-select" name="modalName" id="model_id">
                                            <option>Model</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="input-item">
                                        <select class="nice-select" name="modalType" id="model_type">
                                            <option>Modal Type</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="input-item">
                                        <select class="nice-select" name="pkgId" id="pkgId">
                                            <option>Service</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h6>Message</h6>
                            <div class="input-item input-item-textarea ltn__custom-icon">
                                <textarea name="message" placeholder="Enter message"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h6>Appointment Time</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-item ltn__datepicker">
                                                <div class="input-group date" data-provide="datepicker">
                                                    <input type="text" class="form-control" name="appDate" placeholder="Select Date">
                                                    <div class="input-group-addon">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-time">
                                                <select class="nice-select" name="appTime">
                                                    <option>HH:MM</option>
                                                    <option>9:00 AM - 11:00 AM</option>
                                                    <option>11:00 AM - 13:00 PM</option>
                                                    <option>13:00 PM - 15:00 PM</option>
                                                    <option>15:00 PM - 17:00 PM</option>
                                                    <option>17:00 PM - 19:00 PM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h6>Address</h6>
                                    <div class="row">
                                        <div class="col-md-12">
                                           <input type="text" name="address" placeholder="Enter address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-warning" role="alert">
                                Please note that the date and time you requested may not be available. We will contact you to confirm your actual appointment details.
                            </div>
                              <div class="btn-wrapper text-center mt-0">
                                <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit" name="subm">Submit Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- APPOINTMENT AREA END -->
    <?php include "footer.php"; ?>