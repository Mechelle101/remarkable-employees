<?php
require_once('../../private/initialize.php');
require_login();

// Get the value and assign it to a local variable
$id = $_GET['image_id'] ?? '1';
$images = find_all_images_and_employee_by_image_id($id);

include('../../private/shared/employee_header.php');
?>

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
<?php include('../../private/shared/staff_footer.php'); ?>
