<?php 
require_once('../../private/initialize.php'); 
require_login();

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
            <div class="action">
            <?php echo display_session_message(); ?>
            <h1>A List of Employees</h1> 
            <p>You can view employees basic information.</p> 
            </div>
            <?php
              $employee_set = find_only_employees();
            ?>
          </div>
          <hr>
          <div>
          <div class="list">
           <h2>Basic Employee Information</h2>
            <?php while($employee = mysqli_fetch_assoc($employee_set)) { ?>
              <div id="add-employee">
                <a class="action" href="<?php echo url_for('/staff/show.php?employee_id=' . h(u($employee['employee_id']))); ?>"> <?php echo h($employee['first_name']) ." ". h($employee['last_name']); ?></a>
              </div><br> 
            <?php } ?>
  	      </div>
          <?php
            mysqli_free_result($employee_set);
          ?>
        </article> 
      </main>
<?php include('../../private/shared/staff_footer.php'); ?>
