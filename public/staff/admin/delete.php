<?php
require_once('../../../private/initialize.php');
require_login();
is_admin();

// Get the value and assign it to a local variable
$id = $_GET['employee_id'];
$employee = find_employee_by_id($id);

if(is_post_request()) {

  $result = delete_employee($id);
  if($result === true) {
    $_SESSION['message'] = 'Employees was deleted.';
    redirect_to(url_for('/staff/admin/employee_list.php'));
  } else {
    // the delete failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

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
        <!-- Main Body -->
        <article id="description">
          <div>
            <?php echo display_session_message(); ?>
            <h2>Delete Employee</h2>
            <div id="add-employee">
              <a href="<?php echo url_for('staff/admin/employee_list.php'); ?>">Back to Employee List</a>
            </div>
          </div>
          <hr>
          <div id="delete">
            <strong>ARE YOU SURE YOU WANT TO DELETE THIS EMPLOYEE</strong>
            <p>NAME:<br> <?php echo h($employee['first_name']) . " " .  h($employee['last_name']); ?></p>
            
            <form action="<?php echo url_for('/staff/admin/delete.php?employee_id=' . h(u($employee['employee_id']))); ?>" method="POST">
            <div>
              <input type="submit" name="submit" id="delete-employee" value="Delete Employee">
            </div>
          </form>
          </div>
        </article> 
      </main>
<?php include('../../../private/shared/staff_footer.php'); ?>
