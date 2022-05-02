<?php 
require_once('../../private/initialize.php'); 
require_login();

$id = $_SESSION['logged_employee_id'];

if(is_post_request()) {
  // Handle form values sent by new.php
  $employee = [];
  $employee['first_name'] = $_POST['first_name'] ?? '';
  $employee['last_name'] = $_POST['last_name'] ?? '';
  $employee['email'] = $_POST['email'] ?? '';
  $employee['phone'] = $_POST['phone'] ?? '';
  $employee['department_initial'] = $_POST['department_initial'] ?? '';
  $employee['username'] = $_POST['username'] ?? '';
  $employee['password'] = $_POST['password'] ?? '';
  $employee['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = update_user_profile($employee, $id);
  if($result === true) {
    $_SESSION['message'] = 'Your account was updated successfully.';
    redirect_to(url_for('staff/index.php'));
  } else {
    $employee = [];
    $employee['first_name'] = $_POST['first_name'] ?? '';
    $employee['last_name'] = $_POST['last_name'] ?? '';
    $employee['email'] = $_POST['email'] ?? '';
    $employee['phone'] = $_POST['phone'] ?? '';
    $employee['department_initial'] = $_POST['department_initial'] ?? '';
    $employee['username'] = $_POST['username'] ?? '';
    $employee['password'] = $_POST['password'] ?? '';
    $employee['confirm_password'] = $_POST['confirm_password'] ?? '';
    $errors = $result;
  }

} else {
  // DISPLAY THE BLANK FORM
  $employee = find_employee_by_id($id);
  
}

include('../../private/shared/employee_header.php');
?>

      <!-- Navigation -->
      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <ul>
              <l1><a href="<?php echo url_for( '/staff/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a></l1>
              <l1><a href="announcements.php">Announcements</a></l1>
              <l1><a href="images.php">Images</a></l1>
              <l1><a href="employee_list.php">Employees</a></l1>
            </ul>
          </nav>
        </aside> 
        <!-- Main body -->
        <article id="description">
        <div>
          <?php echo display_session_message(); ?>
          <h1>Account Information</h1>
          <p>Here is your account information, you may edit your account below.</p>
            <div class="attributes">
            <p><?php echo h($employee['first_name']) . " " .  h($employee['last_name']); ?></p>
              <p>Phone:<br> <?php echo h($employee['phone']); ?></p>
              <p>Email:<br> <?php echo h($employee['email']); ?></p>
              <p>Username:<br> <?php echo h($employee['username']); ?></p>
              <p>Department:<br> <?php echo h($employee['department_initial']); ?></p>
            </div>
          </div>
          <hr>
          <div>
            <fieldset id="fieldset-form">
              <legend>Update Account Information</legend>
              <form action="<?php echo url_for('staff/index.php'); ?>" method="post">
              <label for="first_name">First Name</label><br>
              <input type="text" id="first_name" name="first_name" value="<?php echo h($employee['first_name']); ?>"><br>
              <br>
              <label for="last_name">Last Name</label><br>
              <input type="text" id="last_name" name="last_name" value="<?php echo h($employee['last_name']); ?>"><br>
              <br>
              <label for="department_initial">Department</label><br>
              <input type="text" id="department_initial" name="department_initial" value="<?php echo h($employee['department_initial']); ?>"><br>
              <br>
              <label for="phone">Phone</label><br>
              <input type="text" id="phone" name="phone" value="<?php echo h($employee['phone']); ?>"><br>
              <br>
              <label for="email">Email</label><br>
              <input type="text" id="email" name="email" value="<?php echo h($employee['email']); ?>"><br>
              <br>
              <label for="username">Username</label><br>
              <input type="text" id="username" name="username" value=""><br>
              <p>Password should be at least 8 characters, 
              <br>include at least one uppercase, lowercase, number, and symbol.</p>
              <label for="password">Password</label><br>
              <input type="password" id="password" name="password" value=""><br>
              <br>
              <label for="confirm-password">Confirm Password</label><br>
              <input type="password" id="confirm-password" name="confirm_password" value=""><br>
              <br>
              <div id="operations">
                <input type="submit" name="submit" value="Edit Account">
              </div>
            </form>
          </fieldset>
      </div>
    </article> 
  </main>
<?php include('../../private/shared/staff_footer.php'); ?>
