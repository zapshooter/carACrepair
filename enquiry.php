<?php include "header.php";
require 'phpMailer/class.phpmailer.php';
require 'phpMailer/class.smtp.php';
require 'phpMailer/class.pop3.php';

if(!isset($_GET['id']) || $_GET['id'] == '')
{
    echo "<script>location.href='index.php'</script>";die;
}
$getid = filter_values(base64_decode($_GET['id']));

if(isset($_POST['subm']))
{
    if($_POST['name'] != '' && $_POST['phone'] != '' && $_POST['pkgId'] != '')
    {
        $enqId = date('ymdhis');
        $arrayData = array();
        $arrayData['enqId'] = $enqId;
        if(checkExists('enquiries', $arrayData) == 1){
            $enqId = date('ymdhis');
        }
        // else
        // {
            $arrayData['enqId'] = $enqId;
            $arrayData['name'] = filter_values($_POST['name']);
            $arrayData['phone'] = filter_values($_POST['phone']);
            $arrayData['pkgId'] = filter_values($_POST['pkgId']);
            $arrayData['email'] = filter_values($_POST['email']);
            $arrayData['address'] = filter_values($_POST['address']);
            $arrayData['message'] = filter_values($_POST['message']);
            $arrayData['status'] = '0';
            if(save('enquiries', $arrayData) == 1)
            {
                $service = filter_values(base64_decode($_POST['frmd']));
                $price = filter_values(base64_decode($_POST['frmp']));
                $msg="
                <b>Enquiry :</b> <br/>
                \nOrder Id :- ".$enqId." <br/>	
                \nName :- ".$arrayData['name']." <br/>	
                \nE-mail :- ".$arrayData['email']." <br/>
                \nPhone :- ".$arrayData['phone']." <br/>
                \nSerive :- ".$service." <br/>
                \nPrice  :- ".$price." <br/>
                \nAddress  :- ".$arrayData['address']." <br/>
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
                
                $mail->Subject = '[ Car AC Wale ] Website Enquiry';
                $mail->Body = $msg;
                $mail->send();
                
                if($arrayData['email'] != "")
                {
                    $custmsg = "Dear ".$arrayData['name'] .",<br/>";
                    $custmsg .= " Your Order has been placed. Order Id : $enqId <b></b>" ;
                    $mail->addAddress($arrayData['email'], 'Car AC Wale');
                    $mail->addBcc('urvashiarya47@gmail.com', 'Car AC Wale');
                    
                    $mail->WordWrap = 50;  
                    $mail->isHTML(true);
                    
                    $mail->Subject = '[ Car AC Wale ] Order Placed';
                    $mail->Body = $custmsg;
                    $mail->send();
                }
               echo "<script>location.href='thankyou.php?orderId=".$enqId."'</script>";die;
            }
            else
            {
                echo "<script>location.href='enquiry.php?id=".base64_decode($getid)."&error=wrong'</script>";die;
            } 
        // }
    }
    else
    {
        echo "<script>location.href='enquiry.php?id=".base64_decode($getid)."&error=blank'</script>";die;
    } 
}

$field_array2 = array('sno', 'name', 'package_price', 'sales_price', 'labour_price', 'description', 'service_duration', 'packagePhoto', 'service_type', 'brand_id', 'model_type', 'model_id');
$where2 = " status = '1' AND sno = '$getid' ";
$order_by2 = "sno ASC";
$pkglist = retrieve('new_package', null, $field_array2, $where2, $order_by2);
if($pkglist)
{
    foreach ($pkglist as $key => $value) {
        $pkg_img = "img/product/1.png";
        if($value['packagePhoto'] != '' && file_exists("product-img/".$value['packagePhoto']))
        {
           $pkg_img = "product-img/" .$value['packagePhoto'];
        }
        $pkg_name ="";
        $field_array3 = array('name');
        $where3 = "master_services.status = '1'";
        $order_by3 = "name ASC";
        $service_list2 = retrieve('master_services', $value['name'], $field_array3, $where3, $order_by3);
        if($service_list2)
        {
           $pkg_name = $service_list2[0]['name'];
        }
        $package_price = $value['package_price'];
        $sales_price = $value['sales_price'];
        $pkg_desc = $value['description'];
        $service_duration = $value['service_duration'];
        $labour_price = $value['labour_price'];

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

        $model_type = ($value['model_type']);

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
                            <h6 class="section-subtitle ltn__secondary-color">//  Welcome to our company</h6>
                            <h1 class="section-title white-color">Enquiry Now</h1>
                        </div>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li>Enquiry Now</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->	
	<div class="ltn__contact-message-area mb-120 mb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                     <?php if(isset($_GET['error']) && $_GET['error'] == 'wrong'){?>
                        <h4> <b>Error! </b> Something went wrong. Please try after some time.</h4>
                    <?php }?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'blank'){?>
                         <h4> <b>Error! </b> Please fill all required fields.</h4>
                    <?php }?>
                </div>
                <div class="col-lg-8">
                    <div class="ltn__form-box contact-form-box box-shadow white-bg">
                        <h4 class="title-2">Enquiry Now</h4>
                        <form id="contact-form" action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-item input-item-name ltn__custom-icon">
                                        <input type="text" name="name" placeholder="Enter your name" onKeyPress="return isCharacterKey(event);" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-item-email ltn__custom-icon">
                                        <input type="email" name="email" placeholder="Enter email address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item">
                                        <select class="nice-select" name="pkgId" required>
                                            <option value="<?php echo $getid;?>"><?php echo $pkg_name;?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-item-phone ltn__custom-icon">
                                        <input type="text" name="phone" placeholder="Enter phone number" required minlength="10" maxlength="10" onKeyPress="return isNumberKey(event);">
                                    </div>
                                </div>
                            </div>
                            <div class="input-item input-item-address ltn__custom-icon">
                                <input type="text" name="address" placeholder="Enter your address">
                            </div>
                            <div class="input-item input-item-textarea ltn__custom-icon">
                                <textarea name="message" placeholder="Enter message"></textarea>
                            </div>
                            <div class="btn-wrapper mt-0">
                                <input type="hidden" value="<?php echo base64_encode($pkg_name.' ('. $servicename .')'.' - '.$brandname." " .$modelname.", " .$fueltypename) ;?>" name="frmd" />
                                <input type="hidden" value="<?php echo base64_encode($sales_price);?>" name="frmp" />
                                <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit" name="subm">Submit</button>
                            </div>
                            <p class="form-messege mb-0 mt-20"></p>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                        <div class="ltn__contact-address-icon">
                            <img src="<?php echo $pkg_img;?>" alt="<?php echo $pkg_name;?>" title="<?php echo $pkg_name;?>">
                        </div>
                        <h3><?php echo $pkg_name;?></h3>
                        <p><small>(<?php echo $servicename;?>)</small>
                            <br/>Car : <?php echo $brandname." " .$modelname.", " .$fueltypename;?>
                            <br/>Price : Rs.<?php echo $sales_price;?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- ABOUT US AREA START -->
    

    <?php include "footer.php"; ?>

