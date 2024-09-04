<?php include "header.php";
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
        if(checkExists('feedback', $arrayData) == 1){
            $enqId = date('ymdhis');
        }
        // else
        // {
            $arrayData['enqId'] = $enqId;
            $arrayData['name'] = filter_values($_POST['name']);
            $arrayData['phone'] = filter_values($_POST['phone']);
            $arrayData['serviceId'] = filter_values($_POST['serviceId']);
            $arrayData['email'] = filter_values($_POST['email']);
            $arrayData['message'] = filter_values($_POST['message']);
            $arrayData['status'] = '0';
            if(save('feedback', $arrayData) == 1)
            {
                $servicename = "";
                $field_array = array('sno', 'name');
                $where = "master_service_category.status = '1' AND sno = '".$arrayData['serviceId']."'";
                $order_by = "name ASC";
                $service_list = retrieve('master_service_category', null, $field_array, $where, $order_by);
                if($service_list)
                {
                    $servicename = $service_list[0]['name'];
                }
                
                $msg="
                <b>Feedback :</b> <br/>
                \n #Id :- ".$enqId." <br/>  
                \nName :- ".$arrayData['name']." <br/>  
                \nE-mail :- ".$arrayData['email']." <br/>
                \nPhone :- ".$arrayData['phone']." <br/>
                \nSerive :- ".$servicename." <br/>
                \nMessage :- ".$arrayData['message']."";
                $msg.="<br/><br/><br/><br/>
                Thanks, <br/>
                Car AC Wale";

                $user_msg = "
            <html>
            <head>
                <title>Thank you for contacting Car AC Wale!</title>
            </head>
            <body>
                <p>Dear " . $arrayData['name'] . ",</p>
                <p>Thank you for reaching out to us. Here are the details of your inquiry:</p>
                <table>
                    <tr>
                        <th>Service Type:</th><td>" . $servicename . "</td>
                    </tr>
                    <tr>
                        <th>Phone:</th><td>" . $arrayData['phone'] . "</td>
                    </tr>
                    <tr>
                        <th>Message:</th><td>" . $arrayData['message'] . "</td>
                    </tr>
                </table>
                <p>We will get back to you shortly.</p>
                <p>Best regards,<br>Car AC Wale</p>
            </body>
            </html>
            ";
                
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
                
                $mail->Subject = '[ Car AC Wale ] Feedback Form';
                $mail->Body = $msg;
                $mail->send();
               echo "<script>location.href='contact-us.php?action=done'</script>";die;
            }
            else
            {
                echo "<script>location.href='contact-us.php?id=".base64_decode($getid)."&error=wrong'</script>";die;
            } 
        // }
    }
    else
    {
        echo "<script>location.href='contact-us.php?id=".base64_decode($getid)."&error=blank'</script>";die;
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
    <!-- Utilize Cart Menu Start -->
    <?php include "mobile-menu.php"; ?>
    <!-- Utilize Mobile Menu End -->

    <div class="ltn__utilize-overlay"></div>

    <!-- SLIDER AREA START (slider-1) -->
		
    <!-- BREADCRUMB AREA START -->
    <div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image" data-bs-bg="img/bg/6.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color">//  Welcome to Car AC Wale</h6>
                            <h1 class="section-title white-color">Contact Us</h1>
                        </div>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li>Contact</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->
	 <div class="ltn__contact-address-area mb-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                     <?php if(isset($_GET['action']) && $_GET['action'] == 'done'){?>
                         <h4 class="text-success"><b>Success! </b> Your appointment has been successfully submitted. We will get back to you soon...</h4>
                    <?php }?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'wrong'){?>
                          <h4 class="text-danger"><b>Error! </b> Something went wrong. Please try after some time.</h4>
                    <?php }?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'blank'){?>
                          <h4 class="text-danger"><b>Error! </b> Please fill all required fields.</h4>
                    <?php }?>
                </div>
                <div class="col-lg-4">
                    <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                        <div class="ltn__contact-address-icon">
                            <img src="img/icons/10.png" alt="Icon Image">
                        </div>
                        <h3>Email Address</h3>
                        <p>info@caracwale.com </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                        <div class="ltn__contact-address-icon">
                            <img src="img/icons/11.png" alt="Icon Image">
                        </div>
                        <h3>Phone Number</h3>
                        <p>+91 8057422227 <br> +91 8979324002</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                        <div class="ltn__contact-address-icon">
                            <img src="img/icons/12.png" alt="Icon Image">
                        </div>
                        <h3>Office Address</h3>
                        <p>15-B, Rajpur Road <br>
                            Dehradun, Uttarakhand</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<div class="ltn__contact-message-area mb-120 mb--100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__form-box contact-form-box box-shadow white-bg">
                        <h4 class="title-2">Get A Quote</h4>
                        <form id="contact-form" action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-item input-item-name ltn__custom-icon">
                                        <input type="text" name="name" placeholder="Enter your name*" required  onKeyPress="return isCharacterKey(event);">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-item-email ltn__custom-icon">
                                        <input type="email" name="email" placeholder="Enter email address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item">
                                        <select class="nice-select" name="serviceId" required>
                                            <option>Select Service Type</option>
                                            <?php
                                            $field_array = array('sno', 'name');
                                            $where = "master_service_category.status = '1'";
                                            $order_by = "name ASC";
                                            $service_list = retrieve('master_service_category', null, $field_array, $where, $order_by);
                                            if($service_list)
                                            {
                                                foreach ($service_list as $keys => $values) {
                                            ?>
                                            <option value="<?php echo $values['sno'];?>"><?php echo $values['name'];?> </option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-item-phone ltn__custom-icon">
                                        <input type="text" name="phone" placeholder="Enter phone number*" required minlength="10" maxlength="10" onKeyPress="return isNumberKey(event);">
                                    </div>
                                </div>
                            </div>
                            <div class="input-item input-item-textarea ltn__custom-icon">
                                <textarea name="message" placeholder="Enter message"></textarea>
                            </div>
                            <div class="btn-wrapper mt-0">
                                <button class="btn theme-btn-1 btn-effect-1 text-uppercase" name="subm" type="submit">get a Free service</button>
                            </div>
                            <p class="form-messege mb-0 mt-20"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- ABOUT US AREA START -->
    <div class="google-map">
       
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110202.944795124!2d77.9113614625!3d30.327011000000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390929e8811be1c5%3A0x8e24a4c66f0a96f5!2sCar%20AC%20Wale!5e0!3m2!1sen!2sin!4v1717827891562!5m2!1sen!2sin" width="100%" height="100%" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

    </div>

    <?php include "footer.php"; ?>
