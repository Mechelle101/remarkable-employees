<?php 
require_once('../../private/initialize.php'); 
require_login();

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
        <!-- Main body -->
        <article id="description">
          <div>
            <div>
              <?php echo display_session_message(); ?>
              <h2>A List of Your Fellow Employees</h2> 
              <p>You can view employees basic information.</p> 
            </div>
            <?php
              $employee_set = find_only_employees();
            ?>
          </div>
          <hr>
          <div class="list">
           <h3>Basic Contact Information</h3>
            <?php while($employee = mysqli_fetch_assoc($employee_set)) { ?>
              <div class="add-employee">
                <a href="<?php echo url_for('/staff/show.php?employee_id=' . h(u($employee['employee_id']))); ?>"> <?php echo h($employee['first_name']) ." ". h($employee['last_name']); ?></a>
              </div><br> 
            <?php } ?>
  	      </div>
          <?php
            mysqli_free_result($employee_set);
          ?>
        </article> 
      </main>
<?php include('../../private/shared/staff_footer.php'); ?>
