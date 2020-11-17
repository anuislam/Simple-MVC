    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo url('index'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <img class="img-profile rounded-circle" src="<?php echo user()->profile_pic; ?>" alt="<?php echo user()->fname . ' '. user()->lname; ?>" style="width:40px; height:40px;">
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo user()->fname . ' '. user()->lname; ?> <sup>2</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo url('index'); ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>


        <hr class="sidebar-divider">
<?php if (Role::can(User()->role, 'edith_user')): ?>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#worker-one" aria-expanded="true" aria-controls="worker-one">
          <i class="fas fa-fw fa-users"></i>
          <span>Users</span>
        </a>
        <div id="worker-one" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php Html::a(url('edit-profile'), 'My profile', [
              'class' => 'collapse-item',
            ] ); ?>
            <?php if (Role::can(User()->role, 'edith_other_user')): ?>
              
            <?php Html::a(url('all_users'), 'All users', [
              'class' => 'collapse-item',
            ] ); ?>

            <?php endif ?>

            <?php if (Role::can(User()->role, 'add_new_user')): ?>

            <?php Html::a(url('add_new_user'), 'Add new user', [
              'class' => 'collapse-item',
            ] ); ?>
              
            <?php endif ?>

            <?php Html::a(url('change_password'), 'Change password', [
              'class' => 'collapse-item',
            ] ); ?>
            
          </div>
        </div>
      </li>
<?php endif ?> 
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->