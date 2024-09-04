<?php 
session_start();
unset($_SESSION['PKG']);
include "header.php"; 
if(isset($_POST['subm']))
{
    // if(isset($_POST['brand_name']) && $_POST['brand_name'] != '' && isset($_POST['model_name']) && $_POST['model_name'] != '' && isset($_POST['model_type']) && $_POST['model_type'] != '' && isset($_POST['mobile']) && $_POST['mobile'] != '')
    if(isset($_POST['brand_name']) && $_POST['brand_name'] != '' && isset($_POST['model_type']) && $_POST['model_type'] != '' && isset($_POST['mobile']) && $_POST['mobile'] != '')
    {
       $_SESSION['PKG']['brand'] = filter_values($_POST['brand_name']);
       $_SESSION['PKG']['model'] = filter_values($_POST['model_name']);
       $_SESSION['PKG']['model_type'] = filter_values($_POST['model_type']);
       $_SESSION['PKG']['mobile'] = filter_values($_POST['mobile']); 
       echo "<script>location.href='shop.php'</script>";die;
    }
    else
    {
        echo "<script>location.href='index.php'</script>";die;
    }
}

?>
<style type="text/css">
    .select-style
    {
            margin: 0;
    height: 60px;
    line-height: 58px;
    padding-right: 40px;
    padding-left: 20px;
    border-radius: 0;
    min-width: 200px;
    font-size: 16px;
    font-weight: 700;
    font-family: var(--ltn__heading-font);
    width: 100%;

    -webkit-tap-highlight-color: transparent;
    background-color: #fff;
    border-radius: 5px;
    border: solid 1px #e8e8e8;
    box-sizing: border-box;
    clear: both;
    cursor: pointer;
    display: block;
    float: left;
word-wrap: normal;
    outline: 0;
    user-select: none;
    white-space: nowrap;
    }
</style>

<script type="text/javascript">
    function isNumberKey(evt)
    {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }
</script>
    <!-- Utilize Cart Menu Start -->
    <?php include "mobile-menu.php"; ?>
    <!-- Utilize Mobile Menu End -->

    <div class="ltn__utilize-overlay"></div>

    <!-- SLIDER AREA START (slider-1) -->
    <div class="ltn__slider-area ltn__slider-6 mb-120---">
        <div class="ltn__slide-one-active slick-slide-arrow-1 slick-slide-dots-1">
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item--- ltn__slide-item-9 section-bg-1 bg-image" data-bs-bg="img/slider/52.jpg">
                <div class="ltn__slide-item-inner">
                    <div class="slide-item-info bg-overlay-white-90 text-center">
                        <div class="slide-item-info-inner slide-item-info-line-no  ltn__slide-animation">
                            
                            <div class="slide-item-car-dealer-form">
                                <!-- <div class="section-title-area ltn__section-title-2 text-center">
                                    <h1 class="section-title  text-color-white">Find Your <span class="ltn__secondary-color-3">Perfect</span> Car</h1>
                                </div> -->
                                <h3 class="text-color-white--- text-center mb-30">Find Your <span class="ltn__secondary-color-3">Perfect</span> Car Service</h3>
                                <div class="ltn__car-dealer-form-tab">
                                    
                                    <div class="tab-content pb-10">
                                        <div class="tab-pane fade active show" id="ltn__form_tab_1_1">
                                            <div class="car-dealer-form-inner">
                                                <form action="" class="ltn__car-dealer-form-box row" method="POST"> 
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-car col-lg-12 col-md-12">
                                                        <select class="nice-select" name="brand_name" id="brand_id" required>
                                                            <option>Select Brands</option>
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
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-meter col-lg-12 col-md-12">
                                                        <select class="nice-select" name="model_name" id="model_id" required>
                                                            <option>Select Models</option>
                                                        </select>
                                                    </div> 
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-calendar col-lg-12 col-md-12">
                                                        <select class="nice-select" name="model_type" id="model_type" required>
                                                            <option>Select Fuel Type</option>
                                                        </select>
                                                    </div>
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-calendar col-lg-12 col-md-12">
                                                        <input type="text" minlength="10" maxlength="10" placeholder="Enter Mobile Number" name = "mobile" required onKeyPress="return isNumberKey(event);">
                                                    </div>
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-calendar col-lg-12 col-md-12">
                                                        <div class="btn-wrapper text-center mt-0">
                                                            <!-- <button type="submit" class="btn theme-btn-1 btn-effect-1 text-uppercase">Search Inventory</button> -->
                                                            <button type="submit" name="subm" class="btn theme-btn-1 btn-effect-1 text-uppercase">Search</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="ltn__form_tab_1_2">
                                            <div class="car-dealer-form-inner">
                                                <form action="#" class="ltn__car-dealer-form-box row"> 
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-car col-lg-12 col-md-12">
                                                        <select class="nice-select">
                                                            <option>All Makes</option>
                                                            <option>Audi</option>
                                                            <option>BMW</option>
                                                            <option>Honda</option>
                                                            <option>Nissan</option>
                                                        </select>
                                                    </div> 
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-meter col-lg-12 col-md-12">
                                                        <select class="nice-select">
                                                            <option>All Models</option>
                                                            <option>Any</option>
                                                            <option>6 Series (1)</option>
                                                            <option>7 Series (1)</option>
                                                            <option>8 Series (1)</option>
                                                        </select>
                                                    </div> 
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-calendar col-lg-12 col-md-12">
                                                        <select class="nice-select">
                                                            <option>Select Year</option>
                                                            <option>2015</option>
                                                            <option>2016</option>
                                                            <option>2017</option>
                                                            <option>2018</option>
                                                            <option>2019</option>
                                                            <option>2020</option>
                                                        </select>
                                                    </div>
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-calendar col-lg-12 col-md-12">
                                                        <div class="btn-wrapper text-center mt-0">
                                                            <!-- <button type="submit" class="btn theme-btn-1 btn-effect-1 text-uppercase">Search Inventory</button> -->
                                                            <a href="shop-car-right-sidebar.html" class="btn theme-btn-1 btn-effect-1 text-uppercase">Search</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="ltn__form_tab_1_3">
                                            <div class="car-dealer-form-inner">
                                                <form action="#" class="ltn__car-dealer-form-box row"> 
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-car col-lg-12 col-md-12">
                                                        <select class="nice-select">
                                                            <option>All Makes</option>
                                                            <option>Audi</option>
                                                            <option>BMW</option>
                                                            <option>Honda</option>
                                                            <option>Nissan</option>
                                                        </select>
                                                    </div> 
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-meter col-lg-12 col-md-12">
                                                        <select class="nice-select">
                                                            <option>All Models</option>
                                                            <option>Any</option>
                                                            <option>6 Series (1)</option>
                                                            <option>7 Series (1)</option>
                                                            <option>8 Series (1)</option>
                                                        </select>
                                                    </div> 
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-calendar col-lg-12 col-md-12">
                                                        <select class="nice-select">
                                                            <option>Select Year</option>
                                                            <option>2015</option>
                                                            <option>2016</option>
                                                            <option>2017</option>
                                                            <option>2018</option>
                                                            <option>2019</option>
                                                            <option>2020</option>
                                                        </select>
                                                    </div>
                                                    <div class="ltn__car-dealer-form-item ltn__custom-icon ltn__icon-calendar col-lg-12 col-md-12">
                                                        <div class="btn-wrapper text-center mt-0">
                                                            <!-- <button type="submit" class="btn theme-btn-1 btn-effect-1 text-uppercase">Search Inventory</button> -->
                                                            <a href="shop-car-right-sidebar.html" class="btn theme-btn-1 btn-effect-1 text-uppercase">Search</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
    <!-- SLIDER AREA END -->

    <!-- PRODUCT TAB AREA START (product-item-3) -->
    
    <!-- PRODUCT TAB AREA END -->
    <!-- BANNER AREA START -->
    <div class="ltn__banner-area pb-90 mt-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="contact-us.php"><img src="img/banner/1.jpg" alt="Banner Image"></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="contact-us.php"><img src="img/banner/2.jpg" alt="Banner Image"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER AREA END -->

    <!-- CALL TO ACTION START (call-to-action-4) -->
    <div class="ltn__call-to-action-area ltn__call-to-action-4 bg-image pt-115 pb-120" data-bs-bg="img/bg/6.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="call-to-action-inner call-to-action-inner-4 text-center">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color">Any Question you have</h6>
                            <h1 class="section-title white-color">8057-4222-27</h1>
                        </div>
                        <div class="btn-wrapper">
                            <a href="tel:+91 8057422227" class="theme-btn-1 btn btn-effect-1">MAKE A CALL</a>
                            <a href="contact-us.php" class="btn btn-transparent btn-effect-4 white-color">CONTACT US</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ltn__call-to-4-img-1">
            <img src="img/bg/12.png" alt="#">
        </div>
        <div class="ltn__call-to-4-img-2">
            <img src="img/bg/11.png" alt="#">
        </div>
    </div>
    <!-- CALL TO ACTION END -->
    <!-- TESTIMONIAL AREA START (testimonial-3) -->
    <div class="ltn__testimonial-area bg-image pt-115 pb-70" data-bs-bg="img/bg/8.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2">
                        
                        <h1 class="section-title">Clients Feedbacks<span></span></h1>
                    </div>
                </div>
            </div>
            <div class="row ltn__testimonial-slider-2-active slick-arrow-3">
                <div class="col-lg-12">
                    <div class="ltn__testimonial-item ltn__testimonial-item-3">
                        <div class="ltn__testimonial-img">
                            <img src="img/blog/4.jpg" alt="#">
                        </div>
                        <div class="ltn__testimoni-info">
                            <p>I got the compressor of my wagan r changed at a reasonable price
I sugest car ac wale for car ac work i am satisfied </p>
                            <div class="ltn__testimoni-info-inner">
                                <div class="ltn__testimoni-img">
                                    <img src="img/testimonial/1.jpg" alt="#">
                                </div>
                                <div class="ltn__testimoni-name-designation">
                                    <h4>Sampurna nand Nautiyal</h4>
                                    <h6>Founder, Browni Co.</h6>
                                </div>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ltn__testimonial-item ltn__testimonial-item-3">
                        <div class="ltn__testimonial-img">
                            <img src="img/blog/5.jpg" alt="#">
                        </div>
                        <div class="ltn__testimoni-info">
                            <p>I m happy with my innova crysta air conditioning after repair</p>
                            <div class="ltn__testimoni-info-inner">
                                <div class="ltn__testimoni-img">
                                    <img src="img/testimonial/1.jpg" alt="#">
                                </div>
                                <div class="ltn__testimoni-name-designation">
                                    <h4>Arjun yadav</h4>
                                    <h6>Admin</h6>
                                </div>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ltn__testimonial-item ltn__testimonial-item-3">
                        <div class="ltn__testimonial-img">
                            <img src="img/blog/6.jpg" alt="#">
                        </div>
                        <div class="ltn__testimoni-info">
                            <p>Very experienced and cooperative mechanics,
                            I suggest pls go to this garage for any work related with ac </p>
                            <div class="ltn__testimoni-info-inner">
                                <div class="ltn__testimoni-img">
                                    <img src="img/testimonial/1.jpg" alt="#">
                                </div>
                                <div class="ltn__testimoni-name-designation">
                                    <h4>Sandeep Taneja</h4>
                                    <h6>Founder, Browni Co.</h6>
                                </div>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ltn__testimonial-item ltn__testimonial-item-3">
                        <div class="ltn__testimonial-img">
                            <img src="img/blog/1.jpg" alt="#">
                        </div>
                        <div class="ltn__testimoni-info">
                            <p>Best car AC repair and AC parts services in Dehradun… affordable price and timely service… keep on going… </p>
                            <div class="ltn__testimoni-info-inner">
                                <div class="ltn__testimoni-img">
                                    <img src="img/testimonial/1.jpg" alt="#">
                                </div>
                                <div class="ltn__testimoni-name-designation">
                                    <h4>Amit Jain</h4>
                                    <h6>Officer</h6>
                                </div>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ltn__testimonial-item ltn__testimonial-item-3">
                        <div class="ltn__testimonial-img">
                            <img src="img/blog/2.jpg" alt="#">
                        </div>
                        <div class="ltn__testimoni-info">
                            <p>My grand i10 air conditioning system repair now I m satisfied with my cooling
                            They. Also do some thing with ozone machine for bad smells </p>
                            <div class="ltn__testimoni-info-inner">
                                <div class="ltn__testimoni-img">
                                    <img src="img/testimonial/1.jpg" alt="#">
                                </div>
                                <div class="ltn__testimoni-name-designation">
                                    <h4>Waseem Ahmed</h4>
                                    <h6>Professor</h6>
                                </div>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>
    </div>
    <!-- TESTIMONIAL AREA END -->

    <!-- IMAGE SLIDER AREA START (img-slider-3) -->
    <div class="ltn__img-slider-area">
        <div class="container-fluid">
            <div class="row ltn__image-slider-4-active slick-arrow-1 slick-arrow-1-inner ltn__no-gutter-all">
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="img/img-slide/21.jpg" data-rel="lightcase:myCollection">
                            <img src="img/img-slide/21.jpg" alt="Image">
                        </a>
                        <div class="ltn__img-slide-info">
                            <div class="ltn__img-slide-info-brief">
                                <h6>Sports Car</h6>
                                <h1><a href="contact-us.php">BMW Pro Street Car</a></h1>
                            </div>
                            <div class="btn-wrapper">
                                <a href="dosdonts.php" class="btn theme-btn-1 btn-effect-1 text-uppercase">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="img/img-slide/22.jpg" data-rel="lightcase:myCollection">
                            <img src="img/img-slide/22.jpg" alt="Image">
                        </a>
                        <div class="ltn__img-slide-info">
                            <div class="ltn__img-slide-info-brief">
                                <h6>Sports Car</h6>
                                <h1><a href="contact-us.php">BMW Pro Street Car</a></h1>
                            </div>
                            <div class="btn-wrapper">
                                <a href="dosdonts.php" class="btn theme-btn-1 btn-effect-1 text-uppercase">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="img/img-slide/23.jpg" data-rel="lightcase:myCollection">
                            <img src="img/img-slide/23.jpg" alt="Image">
                        </a>
                        <div class="ltn__img-slide-info">
                            <div class="ltn__img-slide-info-brief">
                                <h6>Sports Car</h6>
                                <h1><a href="contact-us.php">BMW Pro Street Car</a></h1>
                            </div>
                            <div class="btn-wrapper">
                                <a href="contact-us.php" class="btn theme-btn-1 btn-effect-1 text-uppercase">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="img/img-slide/24.jpg" data-rel="lightcase:myCollection">
                            <img src="img/img-slide/24.jpg" alt="Image">
                        </a>
                        <div class="ltn__img-slide-info">
                            <div class="ltn__img-slide-info-brief">
                                <h6>Sports Car</h6>
                                <h1><a href="contact-us.php">BMW Pro Street Car</a></h1>
                            </div>
                            <div class="btn-wrapper">
                                <a href="contact-us.php" class="btn theme-btn-1 btn-effect-1 text-uppercase">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="img/img-slide/22.jpg" data-rel="lightcase:myCollection">
                            <img src="img/img-slide/22.jpg" alt="Image">
                        </a>
                        <div class="ltn__img-slide-info">
                            <div class="ltn__img-slide-info-brief">
                                <h6>Sports Car</h6>
                                <h1><a href="contact-us.php">BMW Pro Street Car</a></h1>
                            </div>
                            <div class="btn-wrapper">
                                <a href="contact-us.php" class="btn theme-btn-1 btn-effect-1 text-uppercase">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- IMAGE SLIDER AREA END -->
<?php include "footer.php"; ?>
    

