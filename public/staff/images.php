<?php 
require_once('../../private/initialize.php'); 
require_login();

if(isset($_POST['submit']) && isset($_FILES['file_name'])) {
  $image = [];
  $image['caption'] = $_POST['caption'] ?? '';
  $image['employee_id'] = $_SESSION['logged_employee_id'] ?? '';

  $img_file_name = $_FILES['file_name']['name'];
  $img_size = $_FILES['file_name']['size'];
  $tmp_name = $_FILES['file_name']['tmp_name'];
  $error = $_FILES['file_name']['error'];
    
  if ($error === 0) {
    // checking for the image size
    if ($img_size > 2000000) {
      $_SESSION['message'] = "Sorry, your file is too large.";
      redirect_to(url_for('staff/images.php'));

    // checking for correct format
    } else {
      $img_ex = pathinfo($img_file_name, PATHINFO_EXTENSION);
      $img_ex_lc = strtolower($img_ex);
      $allowed_exs = ['jpg', 'jpeg', 'png', 'tiff', 'jpg'];

      // all is good sending image to the file
      if (in_array($img_ex_lc, $allowed_exs)) {
        $new_image_file_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
        $image_upload_path = '../upload-images/' . $new_image_file_name;
        move_uploaded_file($tmp_name, $image_upload_path);

        // inserting image name into the database table
        $result = insert_image($new_image_file_name, $image);
        if($result === true) {
          $_SESSION['message'] = "Your image was uploaded successfully.";
          redirect_to(url_for('staff/images.php'));
        }
        
      } else {
        $_SESSION['message'] = "You cannot upload $img_ex_lc files";
        redirect_to(url_for('staff/images.php'));
      }
      
    } 
  } else {
    $_SESSION['message'] = "unknown error occurred";
    redirect_to(url_for('staff/images.php'));
  }
  
} 

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
       <!-- Main body -->
        <article id="description">
          <div>
            <h1>Great Place For Sharing Memories</h1>
            <?php 
            // This is not displaying my confirmation message
            echo display_session_message(); 
            if (isset($_GET['error'])): ?>
              <p><?= $_GET['error']; ?></p>
            <?php endif ?>

            <fieldset id="fieldset-form">
              <legend>Add Your Image</legend>
              <form action="images.php" method="post" enctype="multipart/form-data">
                <label for="caption">Image Caption</label>
                <input type="text" id="caption" name="caption"><br>
                <br>
                <label for="file_name">Image Upload</label>
                <input type="file" id="file_name" name="file_name" required><br>
                <br>
                <input type="submit" name="submit" value="upload">
              </form>
            </fieldset>

          </div>
          <hr>
          <h2>Employee Image Display</h2>
          <div id="images">
            <?php
              $image_set = find_all_images_and_employee_names();

              if(mysqli_num_rows($image_set) > 0) {
                while($images = mysqli_fetch_assoc($image_set)) { ?>
                <!-- PUT THIS ON A GRID TO EVEN THE BUTTONS OUT -->
                <fieldset>
                <legend><?php echo $images['caption']; ?></legend>
                    <img id="image1" src="../upload-images/<?= $images['file_name'] ?>">
                    <div  id="add-employee">
                      <a class="action" href="<?php echo url_for('/staff/show-image-info.php?image_id=' . h(u($images['image_id']))); ?>">View Image Information</a>
                    </div>
                </fieldset>
                
              <?php }
                  } 
            ?>
          </div>

        </article> 
      </main>
<?php include('../../private/shared/staff_footer.php'); ?>
