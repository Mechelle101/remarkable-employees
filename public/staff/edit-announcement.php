<?php 
require_once('../../private/initialize.php'); 
require_login();

$id = $_GET['announcement_id'];
$announcement_employee = find_all_announcements_and_employee_by_announcement_id($id);

if(is_post_request()) {
  // Handle form values sent by new.php
  $announcement = [];
  $announcement['announcement'] = $_POST['announcement'] ?? '';

  $result = update_only_announcement_of_user($announcement, $id);
  if($result === true) {
    if($announcement_employee['employee_id'] === $_SESSION['logged_employee_id']) {
      $_SESSION['message'] = 'The announcement was updated successfully.';
    } else {
      $_SESSION['message'] = 'Sorry you cannot update this announcement.';
    }
    redirect_to(url_for('staff/announcements.php'));
  } else {
    $errors = $result;
  }

} else {
  $announcement = find_announcement_by_id($id);
}


?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Edit Announcement</title>
    <link href="../stylesheets/public-styles.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <!-- Header -->
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
              <l1><a href="<?php echo url_for('/staff/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a></l1>
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
            <h1>Edit Announcement</h1>
          </div>
          <hr>
          <div>
            <?php echo display_errors($errors); ?>
            <form action="<?php echo url_for('/staff/edit-announcement.php?announcement_id=' . h(u($id))); ?>" method="post">
              <label for="announcement">Edit Your Announcement Here</label>
              <input type='hidden' name="announcement" value=""><br>
              <textarea id="announcement" name="announcement"  rows="5" cols="30"><?php echo h($announcement['announcement']); ?>" </textarea><br>
              <button type='submit' name='submit'>Edit Announcement</button>
            </form>
          </div>
        </article> 
      </main>
      <!-- PAGE FOOTER -->
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

