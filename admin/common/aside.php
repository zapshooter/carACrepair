  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <!-- <img src="dist/img/AdminLTELogo.png" alt="LOGO" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light"><b><?php echo $site_name;?></b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="profile.php" class="d-block"><?php echo $user_name;?></a>
		  <p id="dt" style="color:#fff;"></p>
		  <p id="tt" style="color:#fff;"></p>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?php if( $current_page == "dashboard.php"){?>menu-open<?php } ?>">
            <a href="dashboard.php" class="nav-link <?php if( $current_page == "dashboard.php"){?>active<?php } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header"></li>
          <?php 
          if($user_type == 'admin')
          {
          ?>
          <li class="nav-item  <?php if( $current_page == "theme-setting.php" || $current_page == "menu-setting.php"){?>menu-open<?php } ?>">
            <a href="#" class="nav-link <?php if( $current_page == "theme-setting.php" || $current_page == "menu-setting.php"){?>active<?php } ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">2</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="theme-setting.php" class="nav-link <?php if($current_page=="theme-setting.php") { ?>active<?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Theme</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="menu-setting.php" class="nav-link <?php if($current_page=="menu-setting.php") { ?>active<?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menus</p>
                </a>
              </li>
            </ul>
          </li>
          <?php
            }
          ?>

          <?php
          if($user_type == 'admin')
          {
            $total_count = 1;
            $totasl_sub = 1;
            $total_count_sub = 1;
          }
          
            $field_array = array('sno', 'name', 'fileName', 'type', 'menuUrl', 'icon');
            $where = "setting_menu.status = '1' AND setting_menu.parent_id = '0' AND setting_menu.is_show = '1'";
            $order_by = "sorder ASC";
            $menus = retrieve('setting_menu', null, $field_array, $where, $order_by);
            if($menus)
            {
              foreach ($menus as $key => $value) {
				        $total_sub_menus = 0;
                $id = $value['sno'];
                $type = $value['type'];

                if($user_type != 'admin')
                {
                  $total_count = getTotalCount("SELECT sno FROM user_access WHERE deleted = '0' AND status = 1 AND user_role_id = '$role_id' AND action_id = '$id'");

                  # @@ submenu is_show = No and access = no, then parent menu not show
                  $field_arraysub = array('sno');
                  $where_subs = "setting_menu.status = '1' AND setting_menu.parent_id = '$id' AND setting_menu.is_show = '1'";
                  $order_by_subs = "sorder ASC";
                  $sub_menusa = retrieve('setting_menu', null, $field_arraysub, $where_subs, $order_by_subs);
                  if($sub_menusa)
                  {
                    $sub_menusid = "'0'";
                    foreach ($sub_menusa as $key => $valuse) {
                      $sub_menusid .= ", '".$valuse['sno']."'";
                    } 
                    $totasl_sub = getTotalCount("SELECT sno FROM user_access WHERE deleted = '0' AND status = '1' AND user_role_id = '$role_id' AND action_id IN ($sub_menusid)");
                  }
                  else
                  {
                    $totasl_sub = 1;
                  }
                  # @@ end
                }
                
                if($total_count>0)
                {
                  $field_array_sub = array('sno', 'name', 'fileName', 'menuUrl', 'type', 'icon');
                  $where_sub = "setting_menu.status = '1' AND setting_menu.parent_id = '$id' AND setting_menu.is_show = '1'";
                  $order_by_sub = "sorder ASC";
                  $sub_menus = retrieve('setting_menu', null, $field_array_sub, $where_sub, $order_by_sub);
                  if($sub_menus)
                  {
                    $total_sub_menus = count($sub_menus);
                  }

                  $getParentMenuId = getParentMenuId($current_page);
                  if($totasl_sub>0)
                  {
                    if($user_type != 'admin')
                    {
                      $total_sub_menus = "";
                    }
				
          ?>
          <li class="nav-item <?php if($getParentMenuId){ if(($getParentMenuId['parent_id']==$id) || ($getParentMenuId['parent_id']=='0' && $getParentMenuId['sno']==$id)){?>menu-open<?php } }?>">
            <a href="#" class="nav-link <?php if($getParentMenuId){ if(($getParentMenuId['parent_id']==$id) || ($getParentMenuId['parent_id']=='0' && $getParentMenuId['sno']==$id)){?>active<?php } }?>">
              <i class="nav-icon <?=$value['icon']?>"></i>
              <p><?=$value['name'];?><i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"><?php echo $total_sub_menus;?></span>
              </p>
            </a>
            <?php if($sub_menus){?>
            <ul class="nav nav-treeview">
              <?php
              foreach ($sub_menus as $key => $value) {
                $sub_menus_id = $value['sno'];
                $sub_menus_type = $value['type'];
                if($user_type != 'admin')
                {                  
                  $total_count_sub = getTotalCount("SELECT sno FROM user_access WHERE deleted = '0' AND status = '1' AND user_role_id = '$role_id' AND action_id = '$sub_menus_id'");
                }
                if($total_count_sub>0)
                {
              ?>
              <li class="nav-item">
                <a href="panel.php?page=<?=$value['menuUrl'];?>" class="nav-link <?php if($current_page == $value['menuUrl']) { ?>active<?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?=$value['name'];?></p>
                </a>
              </li>
              <?php
                }
              }
              ?>
            </ul>
           <?php } ?>
          </li>
          <?php
                  } #totasl_sub
                }
              } 
            }
          ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>