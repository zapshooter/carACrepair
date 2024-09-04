<?php
session_start();
include "header.php";
if(!isset($_GET['orderId']) || $_GET['orderId'] == '')
{
    echo "<script>location.href='index.php'</script>";die;
}
$orderId = filter_values($_GET['orderId']);
unset($_SESSION['PKG']);
?>

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
                            <h1 class="section-title white-color">Success</h1>
                        </div>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li>Success</li>
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
                <!-- <div class="col-lg-3"></div> -->
                <div class="col-lg-12">
                    <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                        <div class="ltn__contact-address-icon">
                            <img src="img/icons/check.png" alt="Icon Image">
                        </div>
                        <h3>Thank you!</h3>
                        <p>
                            Your enquiry has been successfully submitted. We will get back to you soon.<br/> Your order ID is : <b class="text-danger"><?php echo $orderId;?></b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- ABOUT US AREA START -->
    <?php include "footer.php"; ?>

