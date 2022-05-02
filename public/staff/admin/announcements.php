<?php 
require_once('../../../private/initialize.php'); 
require_login();
is_admin();

$logged_in_employee = $_SESSION['logged_employee_id'];

//CREATING A NEW ANNOUNCEMENT
if(is_post_request()) {
  $announcement = [];
  $announcement['announcement_id'] = $_POST['announcement_id'] ?? '';
  $announcement['announcement'] = $_POST['announcement'] ?? '';
  $announcement['employee_id'] = $logged_in_employee ?? '';

  $result = insert_announcement($announcement);

  if($result == true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'You have created your announcement successfully.';
    redirect_to(url_for('staff/admin/announcements.php'));
  } else {
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }

}

$id = $_GET['announcement_id'] ?? '1';
$announcement = find_announcement_by_id($id);

include('../../../private/shared/admin_header.php'); 
?>

      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <ul>
              <l1><a href="index.php"><?php echo $_SESSION['username']; ?> Home</a></l1>
              <l1><a href="announcements.php">Announcements</a></l1>
              <l1><a href="images.php">Images</a></l1>
              <l1><a href="employee_list.php">Employees</a></l1>
            </ul>
          </nav>
        </aside>
        
        <!--  Main body -->  
        <article id="description">
          <div id="announcement-form">
            <form action="<?php echo url_for('/staff/admin/announcements.php'); ?>" method="post">
              <input type='hidden' id="date" name='date' value=""><br>
              <label for="announcement">Post Announcement Here</label>
              <input type='hidden' name="announcement" value=""><br>
              <textarea id="announcement" name='announcement' rows="5" cols="30"></textarea><br>
              <button type='submit' name='submit'>Add to Forum</button>
            </form>
            <hr>
            <?php echo display_session_message(); ?>
            <div id="display-announcement">
              <h1>Announcements &amp; Reminders</h1>
              <fieldset>
              <legend>Forum Posts</legend>  
              <?php
              $result = find_announcement_and_employee_name();
              if(mysqli_num_rows($result) > 0) {
                while($announcements = mysqli_fetch_assoc($result)) { ?>
                <div>
                  <p><?= $announcements['first_name'] . " " . $announcements['last_name'] . "<br>" . date_format(date_create($announcements['date']), "g:ia \o\\n l F jS, Y"); ?></p>
                  <p><?= $announcements['announcement']; ?></p>
                  <div id="add-employee">
                    <a class="action" href="<?php echo url_for('/staff/admin/delete-announcement.php?announcement_id='. h(u($announcements['announcement_id']))); ?>">Delete</a>
                    <a class="action" href="<?php echo url_for('/staff/admin/edit-announcement.php?announcement_id='. h(u($announcements['announcement_id']))); ?>">Edit</a>
                  </div>
                </div>
                <hr>
                <hr>
                <?php }
              } ?>
              </fieldset>

            </div>
          </div>
        </article> 
      </main>
<?php include('../../../private/shared/staff_footer.php'); ?>
