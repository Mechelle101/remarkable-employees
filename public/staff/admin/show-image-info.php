<?php
require_once('../../../private/initialize.php');
require_login();
is_admin();

// Get the value and assign it to a local variable
$id = $_GET['image_id'] ?? '1';
$images = find_all_images_and_employee_by_image_id($id);

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
            <h2>Image Information</h2>
            <div id="add-employee">
              <a href="<?php echo url_for('staff/admin/images.php'); ?>">Back to List</a>
              <a href="<?php echo url_for('/staff/admin/delete-image.php?image_id='. h(u($images['image_id']))); ?>">Delete</a>
              <a href="<?php echo url_for('/staff/admin/edit-image.php?image_id='. h(u($images['image_id']))); ?>">Edit Caption</a>
            </div>
          </div>
          <hr>
          <div id="image-display"> 
            <p>IMAGE CAPTION:<br> <?php echo h($images['caption']); ?></p>
            <p>UPLOADED BY:<br> <?php echo h($images['first_name']) . " " .  h($images['last_name']); ?></p>
            <p>UPLOADED ON:<br> <?php echo h(date_format(date_create($images['upload_date']), "g:ia \o\\n l F jS, Y")); ?></p>
            <img id="one-image" src="../../upload-images/<?= $images['file_name'] ?>" alt="<?php echo h($images['caption']); ?>">
          </div>
        </article> 
      </main>
<?php include('../../../private/shared/staff_footer.php'); ?>
