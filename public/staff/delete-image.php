<?php
require_once('../../private/initialize.php');
require_login();

// Get the value and assign it to a local variable
$id = $_GET['image_id'];
$image = find_all_images_and_employee_by_image_id($id);

if(is_post_request()) {

  $result = delete_only_image_of_user($id);
  // $result  = delete_image($id);
  if($result === true) {
    if($image['employee_id'] === $_SESSION['logged_employee_id']) {
      $_SESSION['message'] = 'The image was deleted successfully';
    } else {
      $_SESSION['message'] = 'Sorry you cannot delete this image.';
    }
    redirect_to(url_for('/staff/images.php'));
  } 
  
}
include('../../private/shared/employee_header.php');
?>

      <!-- Navigation -->
      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <a href="<?php echo url_for('/staff/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a>
            <a href="announcements.php">Announcements</a>
            <a href="images.php">Images</a>
            <a href="employee_list.php">Employees</a>
          </nav>
        </aside>
        <!-- Main Body -->
        <article id="description">
          <div>
            <?php echo display_session_message(); ?>
            <h2>Delete Image</h2>
            <div id="add-employee">
              <a href="<?php echo url_for('staff/images.php'); ?>">Back to Images</a><br><br>
            </div>
          </div>
          <hr>
          <div id="delete">
            <div id="image-display"> 
              <strong>YOU MAY ONLY DELETE IMAGES YOU UPLOADED</strong>
              <p>IMAGE CAPTION:<br> <?php echo h($image['caption']); ?></p>
              <p>UPLOADED BY:<br> <?php echo h($image['first_name']) . " " .  h($image['last_name']); ?></p>
              <form action="<?php echo url_for('/staff/delete-image.php?image_id=' . h(u($image['image_id']))); ?>" method="POST">
                <p>Are you sure you want to delete this image?<input type="submit" name="submit" id="delete-employee" value="Delete Image"></p>
              </form>
              <img id="one-image" src="../upload-images/<?= $image['file_name'] ?>" alt="<?php echo h($image['caption']); ?>">
            </div>
          </div>
        </article> 
      </main>
<?php include('../../private/shared/staff_footer.php'); ?>
