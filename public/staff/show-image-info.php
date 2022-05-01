<?php
require_once('../../private/initialize.php');
require_login();

// Get the value and assign it to a local variable
$id = $_GET['image_id'] ?? '1';
$images = find_all_images_and_employee_by_image_id($id);
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Remarkable Employee Info</title>
    <link href="../stylesheets/public-styles.css" rel="stylesheet">
    <script src="../js/public.js" defer></script>
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

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
        <!-- Main Body -->
        <article id="description">
          <div>
            <?php echo display_session_message(); ?>
            <h1>Image Information</h1>
            <div id="add-employee" id="action">
              <a class="action" href="<?php echo url_for('staff/images.php'); ?>">Back to List</a>
              <a class="action" href="<?php echo url_for('/staff/delete-image.php?image_id='. h(u($images['image_id']))); ?>">Delete</a>
            </div>
          </div>
          <div id="image-display"> 
            <p>IMAGE CAPTION: <?php echo h($images['caption']); ?></p>
            <p>UPLOADED BY: <?php echo h($images['first_name']) . " " .  h($images['last_name']); ?></p>
            <p>UPLOADED ON: <?php echo h(date_format(date_create($images['upload_date']), "g:ia \o\\n l F jS, Y")); ?></p>
            <img id="one-image" src="../upload-images/<?= $images['file_name'] ?>">
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
