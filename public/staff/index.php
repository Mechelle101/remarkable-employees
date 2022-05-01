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

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Remarkable Employee Page</title>
    <link href="../stylesheets/public-styles.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <!-- Main header -->
  <body>
    <div id="main-content">
      <header>
        <a href="<?php echo url_for('staff/index.php'); ?>"><img src="../images/ppl-logo.png" alt="circle logo" width="100" height="100"></a>
        <div id="header-content">
          <h1>Remarkable Employees</h1>
          <h4>Where We Come Together As A Team</h4>
        </div>
        <div id="user-info">
          <p>Welcome <?php echo $_SESSION['username']; ?></p>
          <p>You are logged in as - <?php echo $_SESSION['user_level']; ?></p>
          <l1 id="logout"><a href="<?php echo url_for('../public/logout.php'); ?>">Logout <?php echo $_SESSION['username']; ?></a></l1>
        </div>
      </header>
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
          <h1>Update Account Information</h1>
            <fieldset id="fieldset-form">
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
              <label for="password">Confirm Password</label><br>
              <input type="password" id="password" name="confirm_password" value=""><br>
              <br>
              <div id="operations">
                <input type="submit" name="submit" value="Edit Account">
              </div>
            </form>
          </fieldset>
        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.</p>
        <p>Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
        <p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.</p>
      </div>
      </article> 
      </main>
      <footer id="footer">
        <div id="my-info">
          <h4>Created By</h4>
          &copy; <?php echo date('Y'); ?> Mechelle &#9774; Presnell &hearts;
        </div>
        <div id="chamber">
          <h4>Chamber of Commerce Links</h4>
          <p><a href="https://www.ashevillechamber.org/news-events/events/wnc-career-expo/?gclid=EAIaIQobChMI--vY9Jfk9gIVBLLICh1_2gFFEAAYASAAEgJtifD_BwE" target="_blank">Asheville Chamber of Commerce</a></p>
          <p><a href="https://www.uschamber.com/" target="_blank">US Chamber of Commerce</a></p>
        </div>  
      </footer>
    </div>
  </body>
</html>
<?php //db_disconnect($db); ?>
