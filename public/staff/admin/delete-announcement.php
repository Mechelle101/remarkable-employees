<?php
require_once('../../../private/initialize.php');
require_login();
is_admin();

// Get the value and assign it to a local variable
$id = $_GET['announcement_id'];
$announcement = find_all_announcements_and_employee_by_announcement_id($id);

if(is_post_request()) {
  $result = delete_only_announcement_of_user($id);
  if($result === true) {
    $_SESSION['message'] = 'Announcement was deleted.';
    redirect_to(url_for('/staff/admin/announcements.php'));
  } else {
    $_SESSION['message'] = 'Sorry, you cannot delete this announcement.';
    redirect_to(url_for('/staff/admin/announcements.php'));
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Delete Announcement</title>
    <link href="../../stylesheets/public-styles.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="../../images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
    <div id="main-content">
      <header>
        <a href="<?php echo url_for( 'staff/admin/index.php'); ?>"><img src="../../images/ppl-logo.png" alt="circle logo" width="100" height="100"></a>
        <div id="header-content">
          <h1>Remarkable Employees</h1>
          <h4>Where We Come Together As A Team</h4>
        </div>
        <div id="user-info">
          <p>Welcome <?php echo $_SESSION['username']; ?></p>
          <p>You are logged in as - <?php echo $_SESSION['user_level']; ?></p>
        </div>
      </header>
      <!-- Navigation -->
      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <ul>
              <l1><a href="<?php echo url_for( '/staff/admin/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a></l1>
              <l1><a href="announcements.php">Announcements</a></l1>
              <l1><a href="images.php">Images</a></l1>
              <l1><a href="employee_list.php">Employees</a></l1>
              <l1><a href="<?php echo url_for('../public/logout.php'); ?>">Logout <?php echo $_SESSION['username']; ?></a></l1>
            </ul>
          </nav>
        </aside>
        <!-- Main Body -->
        <article id="description">
          <div>
            <?php echo display_session_message(); ?>
            <h1>Delete Announcement</h1>
            <div id="add-employee" id="action">
              <a class="action" href="<?php echo url_for('staff/admin/announcements.php'); ?>">Back to Announcements</a>
            </div>
          </div>
          <div id="delete">
            <div id="image-display"> 
              <h4>YOU MAY ONLY DELETE YOUR ANNOUNCEMENTS</h4>            
              <p>UPLOADED BY: <?php echo h($announcement['first_name']) . " " .  h($announcement['last_name']); ?></p>
              <p>ANNOUNCEMENT BODY</p>
              <p><?php echo h($announcement['announcement']); ?></p>
              <form action="<?php echo url_for('/staff/admin/delete-announcement.php?announcement_id=' . h(u($announcement['announcement_id']))); ?>" method="POST">
                <p>Are you sure you want to delete this announcement?<input type="submit" name="submit" id="delete-employee" value="Delete Announcement"></p>
              </form>
            </div>
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

