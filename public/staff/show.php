<?php

  require_once('../../private/initialize.php');

  require_login();

  // Get the value and assign it to a local variable
  $id = $_GET['employee_id'] ?? '1';
  $employee = find_employee_by_id($id);

  include('../../private/shared/employee_header.php');
?>

      <!-- Navigation -->
      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <a href="<?php echo url_for( '/staff/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a>
            <a href="announcements.php">Announcements</a>
            <a href="images.php">Images</a>
            <a href="employee_list.php">Employees</a>
          </nav>
        </aside>
        <!-- Main Body -->
        <article id="description">
          <div>
          <?php echo display_session_message(); ?>
            <h2>Employee Information</h2>
            <div id="add-employee">
              <a href="<?php echo url_for('staff/employee_list.php'); ?>">Back to List</a>
            </div>
          </div>
          <hr>
          <div class="attributes">
            <p>Name:<br> <?php echo h($employee['first_name']) . " " .  h($employee['last_name']); ?></p>
            <p>Account Type:<br> <?php echo h($employee['user_level']); ?></p>
            <p>Department:<br> <?php echo h($employee['department_initial']); ?></p>
            <p>Email:<br> <?php echo h($employee['email']); ?></p>
            <p>Username:<br> <?php echo h($employee['username']); ?></p>
          </div>
        </article> 
      </main>
<?php include('../../private/shared/staff_footer.php'); ?>
