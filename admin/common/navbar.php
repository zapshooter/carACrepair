 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home </a>
      </li>
     <!--  <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->

      <!-- Messages Dropdown Menu -->
     <!--  <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item"> -->
            <!-- Message Start -->
           <!--  <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> -->
            <!-- Message End -->
        <!--   </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> -->
            <!-- Message Start -->
            <!-- <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> -->
            <!-- Message End -->
          
      <!-- Notifications Dropdown Menu -->
		<?php
			$cur_date = date("Y-m-d");
			
			$dob_field_array = array('sno', 'name');
			$dob_where = "login.status = '1' AND login.sno!=1 AND DATE_FORMAT(dob,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')";
			$dob_order_by = "name ASC";
			$dob = retrieve('login', null, $dob_field_array, $dob_where, $dob_order_by);
			
			$doa_field_array = array('sno', 'name');
			$doa_where = "login.status = '1' AND login.sno!=1 AND DATE_FORMAT(anniversary_date,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')";
			$doa_order_by = "name ASC";
			$doa = retrieve('login', null, $doa_field_array, $doa_where, $doa_order_by);
			if($doa){
				$cdoa = count($doa);
			}else {
				$cdoa = 0;
			}
			if($dob){
				$cdob = count($dob);
			}else {
				$cdob = 0;
			}
			$count_notification = $cdoa + $cdob;
			
		?>
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
			<i class="far fa-bell"></i>
			<span class="badge badge-warning navbar-badge"> <?php echo $count_notification; ?></span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
			<span class="dropdown-item dropdown-header"><b>Today Birthdays</b></span>
			<div class="dropdown-divider"></div>
			<?php 
			if($dob){
				foreach($dob as $key => $value){ ?>
					<a href="#" class="dropdown-item">
						<i class="fas fa-users mr-2"></i> <?php echo $value['name']; ?>
					</a>
					<div class="dropdown-divider"></div>
				<?php }
			}
			?>
			
			<span class="dropdown-item dropdown-header"><b>Today Anniversary</b></span>
			<div class="dropdown-divider"></div>
			
			<?php 
			if($doa){
				foreach($doa as $key => $dvalue){ ?>
					<a href="#" class="dropdown-item">
						<i class="fas fa-users mr-2"></i> <?php echo $dvalue['name']; ?>
					</a>
					<div class="dropdown-divider"></div>
				<?php }
			}
			?>
			
			</div>
		</li>
	  
	  <!-- eND nOTIFICATION mENU-->

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     <!--  <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" data-widget="contsrol-sidebar" href="logout.php" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>