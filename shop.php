<?php
session_start();
include "header.php";    
if(isset($_POST['subm']))
{
    if(isset($_POST['brand_name']) && $_POST['brand_name'] != '' && isset($_POST['model_type']) && $_POST['model_type'] != '' && isset($_POST['model_name']) && $_POST['model_name'] != '')
    {   
       $_SESSION['PKG']['brand'] = filter_values($_POST['brand_name']);
       $_SESSION['PKG']['model'] = filter_values($_POST['model_name']);
       $_SESSION['PKG']['model_type'] = filter_values($_POST['model_type']);
        echo "<script>location.href='shop.php'</script>";die;
    }
    else
    {
        echo "<script>location.href='index.php'</script>";die;
    }
}
if(isset($_SESSION) && isset($_SESSION['PKG']['mobile']) && isset($_SESSION['PKG']['model']) && isset($_SESSION['PKG']['brand']) && isset($_SESSION['PKG']['model_type']) && $_SESSION['PKG']['model_type'] != '' && $_SESSION['PKG']['mobile'] != '' && $_SESSION['PKG']['model'] != '' && $_SESSION['PKG']['brand'] != '' )
{
?>
    <!-- Utilize Cart Menu Start -->
    <?php include "mobile-menu.php"; ?>
    <!-- Utilize Mobile Menu End -->

    <div class="ltn__utilize-overlay"></div>

    <!-- SLIDER AREA START (slider-1) -->
		
    <!-- BREADCRUMB AREA START -->
    <div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image plr--9" data-bs-bg="img/bg/9.jpg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color">//  Welcome to Car AC Wale</h6>
                            <h1 class="section-title white-color">Our Best Services</h1>
                        </div>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li>Our Best Services</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->
    
    <!-- PRODUCT DETAILS AREA START -->
    <div class="ltn__product-area ltn__product-gutter mb-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                  
                </div>
                <hr/>
                <div class="col-lg-8">
                  <!--   <div class="ltn__shop-options">
                        <ul>
                            <li>
                                <div class="ltn__grid-list-tab-menu ">
                                    <div class="nav">
                                        <a class="active show" data-bs-toggle ="tab" href="#liton_product_grid"><i class="fas fa-th-large"></i></a>
                                        <a data-bs-toggle ="tab" href="#liton_product_list"><i class="fas fa-list"></i></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div> -->
                    <div class="tab-content">
                        <!-- <div class="tab-pane fade" id="liton_product_grid">asdasd
                        </div> -->
                        <div class="tab-pane fade active show" id="liton_product_list">
                            <div class="ltn__product-tab-content-inner ltn__product-list-view">
                            <?php
                            $field_array = array('sno', 'name','description');
                            $where = "master_service_category.status = '1' AND sno IN (SELECT service_type FROM new_package WHERE deleted = 0 AND status = '1' AND brand_id = '".$_SESSION['PKG']['brand']."' AND model_type = '".$_SESSION['PKG']['model_type']."' AND model_id = '".$_SESSION['PKG']['model']."' )";
                            $order_by = "display_order ASC";
                            $service_list = retrieve('master_service_category', null, $field_array, $where, $order_by);
                            
                            if($service_list)
                            {
                                foreach ($service_list as $keys => $values) {
                            ?>
                                <div class="row">
                                    <!-- ltn__product-item -->
                                    <div class="col-lg-12 mb-2">
                                       <h1 class="section-title"><?php echo $values['name'];?></h1>
                                    </div>
                                    <!-- ltn__product-title -->
                                    <?php
                                    $field_array2 = array('sno', 'name', 'package_price', 'sales_price', 'labour_price', 'description', 'service_duration', 'packagePhoto', 'labour_price');
                                    $where2 = " status = '1' AND service_type = '".$values['sno']."' AND brand_id = '".$_SESSION['PKG']['brand']."' AND model_type = '".$_SESSION['PKG']['model_type']."' AND model_id = '".$_SESSION['PKG']['model']."' ";
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
                                            $labour_price = $value['package_price'];
                                            $package_price = $value['package_price'];
                                            $sales_price = $value['sales_price'];
                                            if($value['description']){
                                                $pkg_desc = $value['description'];
                                            }
                                            
                                            $service_duration = $value['service_duration'];
                                            $labour_price = $value['labour_price'];
                                    ?>
                                    <div class="col-lg-12">
                                        <div class="ltn__product-item ltn__product-item-3">
                                            <div class="product-img">
                                                <a href="#"><img src="<?php echo $pkg_img;?>" alt="<?php echo $pkg_name;?> Car-AC-details" title="<?php echo $pkg_name;?>"></a>
                                                <?php if($service_duration != ''){?>
                                                
                                                <?php } ?> 
                                            </div>
                                            <div class="product-info">
                                                <h2 class="product-title"><a href="#"><?php echo $pkg_name;?></a></h2>
                                                <div class="product-price">
                                                     <?php if($package_price != 0 && $package_price != '' ){?>
                                                    <span><i class="fas fa-inr"></i> <?php echo $package_price;?></span>
                                        <?php }else{ ?>
                                        <span><i class="fas fa-inr"></i> <?php echo $sales_price;?></span>
                                        <?php } ?>
                                                   
                                                </div>
                                                 <?php if($labour_price != 0 && $labour_price != '' ){?>
                                                <small>Labour Charge : <i class="fas fa-inr"></i> <?php echo $labour_price;?></small>
                                                <?php } ?>
                                                <div class="product-brief">
                                                    <?php echo $pkg_desc;?>
                                                </div>
                                                <div class="product-hover-action">
                                                    <div class="btn-wrapper mt-0" style="text-align:right;">
                                                        <a href="enquiry.php?id=<?php echo base64_encode($value['sno']);?>" class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit">Enquiry Now</a>
                                                    </div>                                            
                                                </div>
                                                <div class="product-badge">
                                                    <ul>
                                                        <li class="sale-badge"><i class="fas fa-clock"></i>&nbsp; Takes <?php echo $service_duration;?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <!-- ltn__product-item -->                                    
                                </div>
                            <?php
                                }
                            }else { echo '<div class="text-center"><img src="img/no-product.png" class="text-center"></div>';}
                            ?>
                            </div>
                        </div>
                    </div>
                    
                </div>


                <!-- code prior to this displays the array of elements -->
                <?php

                
                    $model_id = $_SESSION['PKG']['model'];
                    $brand_id = $_SESSION['PKG']['brand'];
                    
                    $model_name = retrieve('master_model',$model_id,null,null);
                    $brand_name = retrieve('master_brand',$brand_id,null,null);
                    if($model_name){
                        $model_new_name = $model_name[0]['name'];
                    }
                    if($brand_name){
                        $brand_name_new = $brand_name[0]['name'];
                    }
                    
                   $where_model_pic = " status=1 AND brand_id=$brand_id AND name='$model_new_name'";
                    $retrieve_photo = retrieve('master_model',null,null,$where_model_pic);
                    if($retrieve_photo){
                       $modelPhoto = $retrieve_photo[0]['modelPhoto'];
                    }
                ?>





                <div class="col-lg-4">
                    <aside class="sidebar ltn__shop-sidebar ltn__right-sidebar">
                        <!-- Category Widget -->
                        <div class="widget ltn__menu-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border">Your Model</h4>
                            <?php 
                                if($modelPhoto){ ?>
                                <img src="admin/brand-model/<?php echo $modelPhoto; ?> "
                                <?php } else { ?>
                                <img src="admin/brand-model/dummy-car.png "
                           <?php  } ?>
                           
                            <br>
                            <h3 class="text-center"><?php echo $brand_name_new.' - '.$model_new_name; ?></h3>
                            
                            <hr>
                            <form action="" class="ltn__car-dealer-form-box row" method="POST"> 
                    <div class="col-lg-6 col-md-6">
                        <div class="input-item">
                            <select class="nice-select" name="brand_name" id="brand_id" required>
                                <option>Make</option>
                                <?php 
                                    $field_array = array('sno', 'name');
                                    $where = "master_brand.status = '1' AND sno IN (SELECT brand_id FROM new_package WHERE deleted = 0 AND status = '1')";
                                    $order_by = "name ASC";
                                    $brand_list = retrieve('master_brand', null, $field_array, $where, $order_by);
                                    foreach ($brand_list as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['sno'];?>" <?php if($value['sno'] == $_SESSION['PKG']['brand']){ echo "selected";}?>><?php echo $value['name'];?></option>
                                    <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="input-item">
                            <select class="nice-select" name="model_name" id="model_id" required>
                                <option>Model</option>
                                <?php 
                                    $field_array5 = array('sno', 'name');
                                    $where5 = "master_model.status = '1' AND sno IN (SELECT model_id FROM new_package WHERE deleted = 0 AND status = '1' AND brand_id = '".$_SESSION['PKG']['brand']."')";
                                    $order_by5 = "name ASC";
                                    $monl_list5 = retrieve('master_model', null, $field_array5, $where5, $order_by5);
                                    if($modal_list5)
                                    {
                                        foreach ($modal_list5 as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['sno'];?>" <?php if($value['sno'] == $_SESSION['PKG']['model']){ echo "selected";}?>><?php echo $value['name'];?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>


                        
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6" style="margin-top:10px;">
                        <div class="input-item">
                            <select class="nice-select" name="model_type" id="model_type" required>
                                <option>Model Type</option> 
                                <option value="1" <?php if($_SESSION['PKG']['model_type'] == '1'){ echo "selected";}?>>Diesel</option> 
                                <option value="2" <?php if($_SESSION['PKG']['model_type'] == '2'){ echo "selected";}?>>Petrol</option> 
                                <option value="3" <?php if($_SESSION['PKG']['model_type'] == '3'){ echo "selected";}?>>CNG</option> 
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6" style="margin-top:10px;">
                        <div class="input-item">
                            <button type="submit" name="subm" class="btn theme-btn-1 btn-effect-1 text-uppercase">Change</button>
                        </div>
                    </div>
                  </form>
                        </div>
                       
                        
                       
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT DETAILS AREA END -->
<?php 
include "footer.php";
}
else
{
    echo "<script>location.href='index.php'</script>";die;
}
?>
