<div class="contact-feature-area before-bg-bottom mb--30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="ltn__contact-feature-item">
                        <div class="ltn__contact-feature-icon">
                            <img src="img/icons/7.png" alt="Icon Image">
                        </div>
                        <div class="ltn__contact-feature-info">
                            <a href="tel:+91 8057422227">
                                <span class="h6">+91 8057422227</span><br>
                                <span class="h2">Make A Call</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="ltn__contact-feature-item">
                        <div class="ltn__contact-feature-icon">
                            <img src="img/icons/8.png" alt="Icon Image">
                        </div>
                        <div class="ltn__contact-feature-info">
                            <a href="mailto:info@caracwale.com">
                                <span class="h6">info@caracwale.com</span><br>
                                <span class="h2">Support Mail</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="ltn__contact-feature-item">
                        <div class="ltn__contact-feature-icon">
                            <img src="img/icons/9.png" alt="Icon Image">
                        </div>
                        <div class="ltn__contact-feature-info">
                            <a href="">
                                <span class="h6">15-B, Rajpur Road, Dehradun</span><br>
                                <span class="h2">Office Address</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER AREA START (ltn__footer-2 ltn__footer-color-1) -->
    <footer class="ltn__footer-area ltn__footer-2 ltn__footer-color-1">
        
        <div class="ltn__copyright-area ltn__copyright-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="site-logo-wrap">
                            <div class="site-logo">
                                <a href="index.php"><img src="img/footer-logo.png" alt="Logo"></a>
                            </div>
                            <div class="get-support ltn__copyright-design clearfix">
                                <div class="get-support-info">
                                    <h6>Powered & Design By</h6>
                                    <h4><a href="https://dbcpl.com/" target="_blank">Devbhoomi Consulting Pvt. Ltd.</a> - <span class="current-year"></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 align-self-center">
                        <div class="ltn__copyright-menu text-end">
                            <ul>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Claim</a></li>
                                <li><a href="#">Privacy & Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER AREA END -->
   

</div>
<!-- Body main wrapper end -->

    <!-- preloader area start -->
    <div class="preloader d-none" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>
    <!-- preloader area end -->

    <!-- All JS Plugins 
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>-->

<script src="js/jquery.js"></script>
    <script src="js/plugins.js"></script>
    
  
<!--
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <!-- Main JS -->
<!-- jQuery -->
    <script src="js/main.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    
    <script>   
         $(document).ready(function() {
          $('select').niceSelect();
          
        });
    
        $("#brand_id").change(function(){
            var id = $("#brand_id").val();
            if(id != '')
            {
                $.ajax({
                    type: 'POST',
                    url: "includes/ajax_request.php",
                     // dataType:'json', // add json datatype to get json
                    data: ({id : id, action: 'getModel' }),
                    success: function(resultData)
                    {
                        if(resultData == 2 || resultData == 0)
                        {
                            return false;
                        }
                        $("#model_id").html(resultData);
                        $("#model_id").niceSelect('update');
                        return false;
                    }
                });
            }
            $("#model_id").html('');
                        $("#model_id").niceSelect('update');
        });
    
        $("#model_id").change(function(){
            var id = $("#brand_id").val();
            var model_id = $("#model_id").val();
            if(id != '' && model_id != '')
            {
                $.ajax({
                    type: 'POST',
                    url: "includes/ajax_request.php",
                     // dataType:'json', // add json datatype to get json
                    data: ({id : id, model_id : model_id, action: 'getFuel' }),
                    success: function(resultData)
                    {
                        if(resultData == 2 || resultData == 0)
                        {
                            return false;
                        }
                        $("#model_type").html(resultData);
                        $("#model_type").niceSelect('update');
                        return false;
                    }
                });
            }
            $("#model_type").html('');
                        $("#model_type").niceSelect('update');
        });
        
        $("#model_type").change(function(){
            var id = $("#brand_id").val();
            var model_id = $("#model_id").val();
            var model_type = $("#model_type").val();
            if(id != '' && model_id != '' && model_type != '')
            {
                $.ajax({
                    type: 'POST',
                    url: "includes/ajax_request.php",
                     // dataType:'json', // add json datatype to get json
                    data: ({id : id, model_id : model_id, model_type : model_type, action: 'getservice' }),
                    success: function(resultData)
                    {
                        console.log(resultData);
                        if(resultData == 2 || resultData == 0)
                        {
                            return false;
                        }
                        $("#pkgId").html(resultData);
                        $("#pkgId").niceSelect('update');
                        return false;
                    }
                });
            }
            $("#pkgId").html('');
                        $("#pkgId").niceSelect('update');
        });
    </script>
</body>

</html>