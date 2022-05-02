<?php
require_once('../private/initialize.php');

if(is_post_request()) {
  $employee = [];
  $employee['first_name'] = $_POST['first_name'] ?? '';
  $employee['last_name'] = $_POST['last_name'] ?? '';
  $employee['email'] = $_POST['email'] ?? '';
  $employee['username'] = $_POST['username'] ?? '';
  $employee['password'] = $_POST['password'] ?? '';
  $employee['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = create_user_account($employee);
  if($result === true) {
    $new_employee = find_employee_by_username($employee['username']);
    log_in_employee($new_employee);
    $new_id = mysqli_insert_id($db);
    redirect_to(url_for('staff/index.php'));
  } else {
    $employee = [];
    $employee['first_name'] = $_POST['first_name'] ?? '';
    $employee['last_name'] = $_POST['last_name'] ?? '';
    $employee['email'] = $_POST['email'] ?? '';
    $employee['username'] = $_POST['username'] ?? '';
    $errors = $result;
  }

} else {
  // DISPLAY THE BLANK FORM
  $employee = [];
  $employee['first_name'] = '';
  $employee['last_name'] = '';
  $employee['email'] = '';
  $employee['username'] = '';
  $employee['password'] = '';
  $employee['confirm_password'] = '';

}

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Remarkable Employees: Employee Home Page</title>
    <link href="stylesheets/public-styles.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
    <div id="main-content">
      <header>
        <a href="<?php echo url_for('index.php'); ?>"><img src="images/ppl-logo.png" alt="circle logo" width="100" height="100"></a>
        <div id="header-content">
          <h1>Remarkable Employees</h1>
          <p>Where We Come Together As A Team</p>
        </div>
      </header>

      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <ul>
              <l1><a href="index.php">Home</a></l1>
              <l1><a href="login.php">Login</a></l1>
            </ul>
          </nav>
        </aside>

        <article id="description">
          <div>
            <h2>Employees May Create An Account</h2>
            <p>You may <a href="login.php">login</a> if you have already created an account </p>
          </div>
          <hr>
          <div>
          <?php echo display_errors($errors); ?>
          <fieldset id="fieldset-form">
          <legend>Create an Account</legend>
          <form action="<?php echo url_for('create_account.php'); ?>" method="post">
            <label for="first_name">First Name</label><br>
            <input type="text" id="first_name" name="first_name" value="<?php echo $employee['first_name'];  ?>"><br>
            <br>
            <label for="last_name">Last Name</label><br>
            <input type="text" id="last_name" name="last_name" value="<?php echo $employee['last_name'];  ?>"><br>
            <br>
            <label for="email">Email</label><br>
            <input type="text" id="email" name="email" value="<?php echo $employee['email'];  ?>"><br>
            <br>
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" value="<?php echo $employee['username'];  ?>"><br>
            <p>Password should be at least 8 characters, 
            <br>include at least one uppercase, lowercase, number, and symbol.</p>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" value=""><br>
            <br>
            <label for="confirm_password">Confirm Password</label><br>
            <input type="password" id="confirm_password" name="confirm_password" value=""><br>
            <br>
            <div id="operations">
              <input type="submit" name="submit" value="Create Account">
            </div>
          </form>
          </fieldset>
          </div>
        </article> 
      </main>
<?php include('../private/shared/staff_footer.php'); ?>
