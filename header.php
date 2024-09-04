<?php
include("admin/database.php");
$con=db_connect();
include("admin/function.php");
$filename = basename($_SERVER['REQUEST_URI']);

$where_meta= " status=1 AND page_name='$filename'";
$retrieve_tag = retrieve('meta_tag',null,null,$where_meta);
if($retrieve_tag){
    $meta_title = $retrieve_tag[0]['meta_title'];
    $meta_keyword = $retrieve_tag[0]['meta_keyword'];
    $meta_description = $retrieve_tag[0]['meta_description'];
}else{
    $meta_title = "Car AC Wale";
    $meta_keyword = "Car AC Wale";
    $meta_description = "At Car AC Wale , we pride ourselves on our extensive expertise in repairing car air conditioners. Our workshop is equipped with state-of-the-art machinery and tools.";
}


?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $meta_title;?></title>
    <!-- this line was removed on the live server -->
    <meta name="robots" content="noindex, follow" />
   
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="keyword" content="<?php echo $meta_keyword;?>">
      <meta name="description" content="<?php echo $meta_description;?>">
    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="nice-select2/dist/css/nice-select2.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"> -->
   <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
   <meta name="google-site-verification" content="ntO89sFMKz74s4BNVlGgAn5GPDScZTva-ak2EPGazR4" />
   
   <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5ZCD7HKHR3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5ZCD7HKHR3');
</script>
   
</head>

<body>
  
<!-- Body main wrapper start -->
<div class="body-wrapper">

    <!-- HEADER AREA START (header-4) -->
    <header class="ltn__header-area ltn__header-4 ltn__header-6 ltn__header-transparent--- gradient-color-2---">
        <!-- ltn__header-top-area start -->
        <div class="ltn__header-top-area top-area-color-white plr--9">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <div class="ltn__top-bar-menu">
                            <ul>
                                <li><a href="mailto:info@caracwale.com><i class="icon-mail"></i> info@caracwale.com</a></li>
                                <li><a href=""><i class="icon-placeholder"></i> 15-B, Rajpur Road, Dehradun</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="top-bar-right text-end">
                            <div class="ltn__top-bar-menu">
                                <ul>
                                    
                                    <li>
                                        <!-- ltn__social-media -->
                                        <div class="ltn__social-media">
                                            <ul>
                                                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                                
                                                <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                                <li><a href="#" title="Dribbble"><i class="fab fa-dribbble"></i></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-top-area end -->
        
        <!-- ltn__header-middle-area start -->
        <div class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white ltn__logo-right-menu-option plr--9">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="site-logo-wrap">
                            <div class="site-logo">
                                <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
                            </div>
                            <div class="get-support clearfix">
                                <div class="get-support-icon">
                                    <i class="icon-call"></i>
                                </div>
                                <div class="get-support-info">
                                    <h6>Get Support</h6>
                                    <h4><a href="tel:+91 8057422227">+91 8057422227</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col header-menu-column">
                        <div class="header-menu d-none d-xl-block">
                            <nav>
                                <div class="ltn__main-menu">
                                    <ul>
                                        <li class="menu-icon"><a href="index.php">Home</a>
                                           
                                        </li>
                                        <li class="menu-icon"><a href="about-us.php">About</a>
                                           
                                        </li>
                                        
                                        <li class="menu-icon"><a href="service.php">Services</a>
                                            
                                        </li>
                                        
                                        <li><a href="contact-us.php">Contact</a></li>
                                        <li class="special-link"><a href="appointment.php">GET APPOINTMENT</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- Mobile Menu Button -->
                    <div class="mobile-menu-toggle d-xl-none">
                        <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
                            <svg viewBox="0 0 800 600">
                                <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                <path d="M300,320 L540,320" id="middle"></path>
                                <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-middle-area end -->
    </header>
    <!-- HEADER AREA END -->