<?php 
require_once('../../../private/initialize.php'); 
require_login();
is_admin();

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
    redirect_to(url_for('staff/admin/announcements.php'));
  } else {
    $errors = $result;
  }

} else {
  $announcement = find_announcement_by_id($id);
}

include('../../../private/shared/admin_header.php'); 
?>

      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <a href="<?php echo url_for('/staff/admin/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a>
            <a href="announcements.php">Announcements</a>
            <a href="images.php">Images</a>
            <a href="employee_list.php">Employees</a>
          </nav>
        </aside>
        <!-- Main body -->
        <article id="description">
          <div>
            <?php echo display_session_message(); ?>
            <h2>You Are Unable to Edit if You Are Not The Author</h2>
            <div id="add-employee">
              <a href="<?php echo url_for('staff/admin/announcements.php'); ?>">Back to Announcements</a>
            </div>
          </div>
          <hr>
          <div>
            <fieldset id="fieldset-form">
            <legend>Author: <?php echo $announcement_employee['first_name'] ?></legend> 
              <form action="<?php echo url_for('/staff/admin/edit-announcement.php?announcement_id=' . h(u($id))); ?>" method="post">
                <label for="announcement">Edit Announcement</label>
                <input type='hidden' name="announcement" value=""><br>
                <textarea id="announcement" name="announcement"  rows="5" cols="30"><?php echo h($announcement['announcement']); ?>" </textarea><br>
                <button type='submit' name='submit'>Edit</button>
              </form>
            </fieldset>
          </div>
        </article> 
      </main>
<?php include('../../../private/shared/staff_footer.php'); ?>
