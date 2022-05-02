<?php 
require_once('../../../private/initialize.php'); 
require_login();
is_admin();

if(is_post_request()) {
  $employee = [];
  $employee['first_name'] = $_POST['first_name'] ?? '';
  $employee['last_name'] = $_POST['last_name'] ?? '';
  $employee['user_level'] = $_POST['user_level'] ?? '';
  $employee['department_initial'] = $_POST['department_initial'] ?? '';
  $employee['email'] = $_POST['email'] ?? '';
  $employee['username'] = $_POST['username'] ?? '';
  $employee['password'] = $_POST['password'] ?? '';
  $employee['confirm_password'] = $_POST['confirm_password'] ?? '';

  // EDIT THE QUERY TO ADD THE USER CREDENTIALS
  $result = insert_employee($employee);
  if($result === true) {
  $new_id = mysqli_insert_id($db);
  $_SESSION['message'] = 'The employee was created successfully.';
  redirect_to(url_for('staff/admin/show.php?employee_id=' . $new_id));
  } else {
    $errors = $result;
  }

} 
//$employee = find_employee_by_id($new_id);
include('../../../private/shared/admin_header.php'); 
?>

      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <a href="<?php echo url_for( '/staff/admin/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a>
            <a href="announcements.php">Announcements</a>
            <a href="images.php">Images</a>
            <a href="employee_list.php">Employees</a>
          </nav>
        </aside>
        <!-- Main body -->
        <article id="description">
          <div>
            <?php echo display_session_message(); ?>
            <h2>Create A New Account</h2>
            <p>Admin page for adding a new employee</p>
            <div id="add-employee">
              <a href="<?php echo url_for('staff/admin/employee_list.php'); ?>">Back to List</a>
            </div>
          </div>
          <hr>
          <div>
            <?php echo display_errors($errors); ?>
            <fieldset id="fieldset-form">
            <legend>Add New Account</legend>
            <form action="<?php echo url_for('/staff/admin/new.php');  ?>" method="post">
              <label for="first_name">First Name</label><br>
              <input type="text" id="first_name" name="first_name" value="<?php //echo h($employee['first_name']); ?>"><br>
              <br>
              <label for="last_name">Last Name</label><br>
              <input type="text" id="last_name" name="last_name" value="<?php //echo h($employee['last_name']); ?>"><br>
              <br>
              <label for="user_level">Account Type (admin or employee)</label><br>
              <input type="text" id="user_level" name="user_level" value="<?php //echo h($employee['user_level']); ?>"><br>
              <br>
              <label for="department_initial">Department (initial)</label><br>
              <input type="text" id="department_initial" name="department_initial" value="<?php //echo h($employee['department_initial']); ?>"><br>
              <br>
              <label for="email">Email</label><br>
              <input type="text" id="email" name="email" value="<?php //echo h($employee['email']); ?>"><br>
              <br>
              <label for="username">Username</label><br>
              <input type="text" id="username" name="username" value="<?php //echo h($employee['username']); ?>"><br>
              <p>Password should be at least 8 characters, 
              <br>include at least one uppercase, lowercase, number, and symbol.</p>
              <label for="password">Password</label><br>
              <input type="password" id="password" name="password" value=""><br>
              <br>
              <label for="confirm-password">Confirm Password</label><br>
              <input type="password" id="confirm-password" name="confirm_password" value=""><br>
              <br>
              <div id="operations">
                <input type="submit" name="submit" value="Add Employee">
              </div>
            </form>
            </fieldset>
          </div>
        </article> 
      </main>

<?php include('../../../private/shared/staff_footer.php'); ?>
