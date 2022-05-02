<?php 
require_once('../private/initialize.php'); 

$errors = [];
$username = '';
$password = '';
$user_level = '';
$login_failure_msg = "Log in was unsuccessful.";

if(is_post_request()) {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // VALIDATIONS
  if(is_blank($username)) {
    $error[] = "Username cannot be blank";
  }
  if(is_blank($password)) {
    $error[] = "Password cannot be blank";
  }

  // IF NO ERRORS, LOGIN
  if(empty($errors)) {
    $login_failure_msg;

    $employee = find_employee_by_username($username);
    if($employee) {
      if(password_verify($password, $employee['hashed_password'])) {
        // PASSWORD MATCHES
        log_in_employee($employee);
        if($_SESSION['user_level'] == 'employee') {
          redirect_to(url_for('staff/index.php'));
        } else {
          redirect_to(url_for('staff/admin/index.php'));
        }
      } else {
        // USERNAME FOUND BUT PASSWORD DID NOT MATCH
        $errors[] = 'Password does not match';
      }
    } else {
      // NO USERNAME WAS FOUND
      $errors[] = 'Username not found';
    }
  }
  $_SESSION['username'] = $username;
  $_SESSION['user_level'] = $user_level;
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Remarkable Employees: Login</title>
    <link href="stylesheets/public-styles.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
    <div id="main-content">
      <header>
        <a href="index.php"><img src="images/ppl-logo.png" alt="circle logo" width="100" height="100"></a>
        <div id="header-content">
          <h1>Remarkable Employees</h1>
          <p>Where We Come Together As A Team</p>
        </div>
      </header>

      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <ul>
            <l1><a href="<?php echo url_for('index.php'); ?>">Home</a></l1>
              <l1><a href="<?php echo url_for('create_account.php'); ?>">Create Account</a></l1>
            </ul>
          </nav>
        </aside>

        <article id="description">
          <div>
            <h2>Please Login To Access Your Employee Page</h2>
            <p>You must be an employee and have already <a href="create_account.php">created an account</a> to login.</p>
          <hr>
          <div>

          <?php echo display_errors($errors); ?>

            <form action="login.php" method="post">
              <label for="username">User Name</label><br>
              <input type="text" id="username" name="username" value="<?php echo h($username); ?>"><br>
              <br>
              <label for="password">Password</label><br>
              <input type="password" id="password" name="password" value=""><br>
              <br>
              <input type="submit" name="submit" value="Login"><br>
            </form>
          </div>
        </article> 
      </main>
<?php include('../private/shared/staff_footer.php'); ?>