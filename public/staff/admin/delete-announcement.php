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
    if($announcement['employee_id'] === $_SESSION['logged_employee_id']) {
      $_SESSION['message'] = 'Announcement was deleted.';
    } else {
      $_SESSION['message'] = 'Sorry, you cannot delete this announcement.';
    }
    redirect_to(url_for('/staff/admin/announcements.php'));
  } else {
    redirect_to(url_for('/staff/admin/announcements.php'));
    echo mysqli_error($db);
  }

}

include('../../../private/shared/admin_header.php'); 
?>

      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <ul>
              <l1><a href="<?php echo url_for( '/staff/admin/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a></l1>
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
            <h1>Delete Announcement</h1>
            <div id="add-employee" id="action">
              <a class="action" href="<?php echo url_for('staff/admin/announcements.php'); ?>">Back to Announcements</a>
            </div>
          </div>
          <div id="delete">
            <div id="image-display"> 
              <strong>YOU MAY ONLY DELETE YOUR ANNOUNCEMENTS</strong>            
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
<?php include('../../../private/shared/staff_footer.php'); ?>
