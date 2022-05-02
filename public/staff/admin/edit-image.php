<?php
require_once('../../../private/initialize.php');
require_login();
is_admin();

// Get the value and assign it to a local variable
$id = $_GET['image_id'];
$images = find_all_images_and_employee_by_image_id($id);

if(is_post_request()) {
  $image = [];
  $image['caption'] = $_POST['caption'] ?? '';

  $result = update_only_image_of_user($image, $id);

  if($image['caption'] !== "") {

    if($result === true) {
      if($images['employee_id'] == $_SESSION['logged_employee_id']) {
        $_SESSION['message'] = 'The image was updated successfully';
      } else {
        $_SESSION['message'] = 'Sorry you cannot edit this image';
      }
        redirect_to(url_for('/staff/admin/images.php'));
    } 
    
  } else {
    $_SESSION['message'] = 'Please make your edit';

  }

}

include('../../../private/shared/admin_header.php'); 
?>

      <main id="page-content">
        <aside id="navigation">
          <nav id="main-nav">
            <a href="<?php echo url_for( '/staff/admin/index.php'); ?>"><?php echo $_SESSION['username']; ?> Home</a>
            <a href="announcements.php">Announcements</a>
            <a href="images.php">Images</a>
            <a href="employee_list.php">Employees</a>
          </nav>
        </aside>
        <!-- Main Body -->
        <article id="description">
          <div>
            <?php echo display_session_message(); ?>
            <h2>Edit Image Caption</h2>
            <div id="add-employee">
              <a href="<?php echo url_for('staff/admin/images.php'); ?>">Back to Images</a>
              <a href="<?php echo url_for('/staff/admin/edit-image.php?image_id='. h(u($images['image_id']))); ?>">Edit</a>
            </div>
          </div>
          <hr>
          <div id="delete">
            <div id="image-display"> 
              <strong>YOU MAY ONLY EDIT IMAGES YOU UPLOADED</strong>         
              <fieldset id="fieldset-form">
              <legend>Edit</legend>
              <p>UPLOADED BY:<br> <?php echo h($images['first_name']) . " " .  h($images['last_name']); ?></p>
              <p>IMAGE CAPTION:<br> <?php echo h($images['caption']); ?></p> 
              <form action="<?php echo url_for('/staff/admin/edit-image.php?image_id=' . h(u($id))); ?>" method="post">
                <label for="caption">Edit Caption</label>
                <input type='text' id="caption" name="caption" value=""><br>
                <button type='submit' name='submit'>Edit</button>
              </form>
            </fieldset><br>
              <img id="one-image" src="../../upload-images/<?= $images['file_name'] ?>" alt="<?php echo h($images['caption']); ?>">
            </div>
          </div>
        </article> 
      </main>
<?php include('../../../private/shared/staff_footer.php'); ?>
