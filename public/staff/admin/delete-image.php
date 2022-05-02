<?php
require_once('../../../private/initialize.php');
require_login();
is_admin();

// Get the value and assign it to a local variable
$id = $_GET['image_id'];
$image = find_all_images_and_employee_by_image_id($id);

if(is_post_request()) {

  $result = delete_only_image_of_user($id);
  if($result === true) {
    if($image['employee_id'] === $_SESSION['logged_employee_id']) {
      $_SESSION['message'] = 'The image was deleted successfully';
    } else {
      $_SESSION['message'] = 'Sorry you cannot delete this image.';
    }
    //echo display_session_message(); 
    redirect_to(url_for('/staff/admin/images.php'));
  } else {
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
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
            <h1>Delete Image</h1>
            <div id="add-employee" id="action">
              <a class="action" href="<?php echo url_for('staff/admin/images.php'); ?>">Back to Images</a>
            </div>
          </div>
          <div id="delete">
            <div id="image-display"> 
              <strong>YOU MAY ONLY DELETE IMAGES YOU UPLOADED</strong>            
              <p>IMAGE CAPTION: <?php echo h($image['caption']); ?></p>
              <p>UPLOADED BY: <?php echo h($image['first_name']) . " " .  h($image['last_name']); ?></p>
              <form action="<?php echo url_for('/staff/admin/delete-image.php?image_id=' . h(u($image['image_id']))); ?>" method="POST">
                <p>Are you sure you want to delete this image?<input type="submit" name="submit" id="delete-employee" value="Delete Image"></p>
              </form>
              <img id="one-image" src="../../upload-images/<?= $image['file_name'] ?>">
            </div>
          </div>
        </article> 
      </main>
<?php include('../../../private/shared/staff_footer.php'); ?>
