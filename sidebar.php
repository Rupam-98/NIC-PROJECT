<div class="sidebar">
    <div class="sidebar-header">
        <img src="image/system.png" alt="System Logo" class="sidebar-logo">
        <h2>System Admin</h2>
    </div>
    <ul>
        <li><a href="system_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>

        <li class="dropdown">
            <a onclick="toggledropdown(event)">
                <i class="fas fa-users"></i> Department <i class="fa fa-plus"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="dept_entry.php">Dept. Entry Form</a></li>
                <li><a href="add_dept_admin.php">Admin Entry</a></li>
                <li><a href="dept_admin_list.php">Dept. Admin List</a></li>
                <li><a href="dept_info.php">Dept. Info List</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a onclick="toggledropdown(event)">
                <i class="fas fa-users"></i> Central And PSU <i class="fa fa-plus"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="cp_employee.php">Employee Entry Form</a></li>
                <li><a href="cp_employee_list.php">Employee List</a></li>

            </ul>
        </li>

        <!-- <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users"></i> PSU <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="cp_employee.php">Employee Entry Form</a></li>
          <li><a href="#cp_employee_list.php">Employee List</a></li>
  
        </ul>
      </li> -->

        <li class="dropdown">
            <a onclick="toggledropdown(event)">
                <i class="fas fa-users"></i> Branch <i class="fa fa-plus"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="branch_admin_list.php">Branch Admin List</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a onclick="toggledropdown(event)">
                <i class="fas fa-cog"></i> Settings <i class="fa fa-plus"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="openIframeModal('edit_user.php')">Update Profile</a></li>


                <li><a href="#" onclick="openIframeModal('cng_user_pass.php')">Change Password</a></li>
            </ul>
        </li>

        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>