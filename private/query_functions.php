<?php
// BELOW ARE THE EMPLOYEE QUERIES

//server completes processing for an operation, 
//it sends a response message back to the client 
//with information about that operation.
use LDAP\Result;

/**
 * Method find_all_employees
 *
 * @return void
 */
function find_all_employees() {
  global $db;
  $sql = "SELECT * FROM employee ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

/**
 * Method find_only_employees
 *
 * @return void
 */
function find_only_employees() {
  global $db;
  $sql = "SELECT * FROM employee ";
  $sql .= "WHERE user_level='employee' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

/**
 * Method find_employee_by_id
 *
 * @param $id finds the employee by their id
 *
 * @return void
 */
function find_employee_by_id($id) {
  global $db;
  $sql = "SELECT * FROM employee ";
  $sql .= "WHERE employee_id='" . db_escape($db, (int)$id) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject;
}

/**
 * Method find_employee_by_username
 *
 * @param $username finds the employee by their username
 *
 * @return void
 */
function find_employee_by_username($username) {
  global $db;
  $sql = "SELECT * FROM employee ";
  $sql .= "WHERE username='" . db_escape($db, $username) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $employee = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $employee;
}


/**
 * Method validate_updated_employee
 *
 * @param $employee validates the employee information through their array of information
 *
 * @return void
 */
function validate_updated_employee($employee) {
  $errors = [];
  
  if(is_blank($employee['first_name'])) {
    $errors[] = "First name cannot be blank.";
  } 

  if(is_blank($employee['last_name'])) {
    $errors[] = "Last name cannot be blank.";
  }

  if(is_blank($employee['email'])) {
    $errors[] = "Email cannot be blank.";
  } elseif (!has_length($employee['email'], array('max' => 255))) {
    $errors[] = "Email must be less than 255 characters.";
  } elseif (!has_valid_email_format($employee['email'])) {
    $errors[] = "Email must be a valid format.";
  }

  return $errors;
}


/**
 * Method validate_employee
 *
 * @param $employee validates the employee information through their array of information
 * @param $options=[] this is the errors in array format
 *
 * @return void
 */
function validate_employee($employee, $options=[]) {
  $errors = [];
  $password_required = $options['password_required'] ?? true;
  $username_required = $options['username_required'] ?? true;
  
  if(is_blank($employee['first_name'])) {
    $errors[] = "First name cannot be blank.";
  } 

  if(is_blank($employee['last_name'])) {
    $errors[] = "Last name cannot be blank.";
  }

  if(is_blank($employee['email'])) {
    $errors[] = "Email cannot be blank.";
  } elseif (!has_length($employee['email'], array('max' => 255))) {
    $errors[] = "Email must be less than 255 characters.";
  } elseif (!has_valid_email_format($employee['email'])) {
    $errors[] = "Email must be a valid format.";
  }

  if($username_required) {
  if(is_blank($employee['username'])) {
    $errors[] = "Username cannot be blank.";
  } elseif (!has_length($employee['username'], array('min' => 8, 'max' => 255))) {
    $errors[] = "Username must be between 8 and 255 characters.";
  } elseif (!has_unique_username($employee['username'], $employee['id'] ?? 0)) {
    $errors[] = "Username not allowed. Try another.";
  }
 }

  if($password_required) {
    if(is_blank($employee['password'])) {
      $errors[] = "Password cannot be blank.";
    } elseif (!has_length($employee['password'], array('min' => 8))) {
      $errors[] = "Password must contain 8 or more characters";
    } elseif (!preg_match('/[A-Z]/', $employee['password'])) {
      $errors[] = "Password must contain at least 1 uppercase letter";
    } elseif (!preg_match('/[a-z]/', $employee['password'])) {
      $errors[] = "Password must contain at least 1 lowercase letter";
    } elseif (!preg_match('/[0-9]/', $employee['password'])) {
      $errors[] = "Password must contain at least 1 number";
    } elseif (!preg_match('/[^A-Za-z0-9\s]/', $employee['password'])) {
      $errors[] = "Password must contain at least 1 symbol";
    }

    if(is_blank($employee['confirm_password'])) {
      $errors[] = "Confirm password cannot be blank.";
    } elseif ($employee['password'] !== $employee['confirm_password']) {
      $errors[] = "Password and confirm password must match.";
    }
  }
  return $errors;
}


/**
 * Method insert_employee
 *
 * @param $employee array of employee information
 *
 * @return void
 */
function insert_employee($employee) {
  global $db;

  $errors = validate_employee($employee);
  if(!empty($errors)) {
    return $errors;
  }

  $hashed_password = password_hash($employee['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO employee ";
  $sql .= "(first_name, last_name, user_level, department_initial, email, username, hashed_password) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $employee['first_name']) . "',";
  $sql .= "'" . db_escape($db, $employee['last_name']) . "',";
  $sql .= "'" . db_escape($db, $employee['user_level']) . "',";
  $sql .= "'" . db_escape($db, $employee['department_initial']) . "',";
  $sql .= "'" . db_escape($db, $employee['email']) . "',";
  $sql .= "'" . db_escape($db, $employee['username']) . "',";
  $sql .= "'" . $hashed_password . "'";

  $sql .= ")";
  $result = mysqli_query($db, $sql);
  // FOR INSERT STATEMENTS INSERT RETURNS TRUE/FALSE
  if($result)  {
    return true;
  } else {
    // IF THE INSERT FAILED
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}


/**
 * Method create_user_account
 *
 * @param $employee array of employee information
 *
 * @return void
 */
function create_user_account($employee) {
  global $db;
  $errors = validate_employee($employee);
  if(!empty($errors)) {
    return $errors;
  }
  $hashed_password = password_hash($employee['password'], PASSWORD_DEFAULT);
  $sql = "INSERT INTO employee ";
  $sql .= "(first_name, last_name, email,  username, hashed_password) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $employee['first_name']) . "',";
  $sql .= "'" . db_escape($db, $employee['last_name']) . "',";
  $sql .= "'" . db_escape($db, $employee['email']) . "',";
  $sql .= "'" . db_escape($db, $employee['username']) . "',";
  $sql .= "'" . $hashed_password . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);
  // FOR INSERT STATEMENTS INSERT RETURNS TRUE/FALSE
  if($result === true) {
    $_SESSION['message'] = 'The account was created successfully.';
    return true;
  } else {
    $errors = $result;
  }
}


/**
 * Method update_employee
 *
 * @param $employee array of employee information
 * @param $id updating employee based on the given id
 *
 * @return void
 */
function update_employee($employee, $id) {
  global $db;

  //$errors = validate_updated_employee($employee);

  $password_sent = !is_blank($employee['password']);
  $username_sent = !is_blank($employee['username']);

  $errors = validate_employee($employee, ['password_required' => $password_sent, 'username_required' => $username_sent]);
  if(!empty($errors)) {
    return $errors;
  }
  $sql = "UPDATE employee SET ";
  $sql .= "first_name='" . db_escape($db, $employee['first_name']) . "',";
  $sql .= "last_name='" . db_escape($db, $employee['last_name']) . "',";
  $sql .= "user_level='" . db_escape($db, $employee['user_level']) . "',";
  $sql .= "department_initial='" . db_escape($db, $employee['department_initial']) . "',";
  if($password_sent) {
    $sql .= "hashed_password='" . db_escape($db, $employee['hashed_password']) . "',";
  }
  if($username_sent) {
   $sql .= "username='" . db_escape($db, $employee['username']) . "',"; 
  }
  $sql .= "email='" . db_escape($db, $employee['email']) . "' ";
  $sql .= "WHERE employee_id='" . db_escape($db, (int)$id) . "' ";
  $sql .= "LIMIT 1";
  
  $result = mysqli_query($db, $sql);
  return $result;

}


/**
 * Method delete_employee
 *
 * @param $id admin deletes an employee based on given id
 *
 * @return void
 */
function delete_employee($id) {
  global $db;

  $sql = "DELETE FROM employee ";
  $sql .= "WHERE employee_id=' " . db_escape($db, (int)$id) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);

  return $result;
}

// THIS IS THE ANNOUNCEMENT QUERIES --may delete this query
function find_all_announcements() {
  global $db;
  $sql = "SELECT * FROM announcement ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

// FINDING ANNOUNCEMENTS AND EMPLOYEE NAME
function find_announcement_and_employee_name() {
  global $db;
  $sql = "SELECT announcement.*, ";
  $sql .= "employee.employee_id, employee.first_name, ";
  $sql .= "employee.last_name FROM announcement ";
  $sql .= "JOIN employee USING(employee_id)";
  $sql .= "ORDER BY announcement.date DESC ";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_announcement_by_id($id) {
  global $db;
  $sql = "SELECT * FROM announcement ";
  $sql .= "WHERE announcement_id='" . db_escape($db, (int)$id) . "' ";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $subject = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $subject; // return the assoc. array
}

function insert_announcement($announcement) {
  global $db; 
  $sql = "INSERT INTO announcement ";
  $sql .= "(announcement, employee_id) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $announcement['announcement']) . "',";
  $sql .= "'" . db_escape($db, $announcement['employee_id']) . "'";
  $sql .= ")";

  $result = mysqli_query($db, $sql);
  // FOR INSERT STATEMENTS INSERT RETURNS TRUE/FALSE
  if($result)  {
    return true;
  } else {
    // IF THE INSERT FAILED
    echo mysqli_error($db);
    var_dump($sql);
    db_disconnect($db);
    exit;
  }
}

/**
 * Method find_all_announcements_and_employee_by_announcement_id
 *
 * @param $id the announcement id pasted by current user
 *
 * @return void
 */
function find_all_announcements_and_employee_by_announcement_id($id) {
  global $db;
  $sql = "SELECT announcement.announcement_id, announcement.announcement, announcement.date, ";
  $sql .= "employee.employee_id, employee.first_name, ";
  $sql .= "employee.last_name FROM announcement ";
  $sql .= "JOIN employee USING(employee_id) ";
  $sql .= "WHERE announcement_id='" . db_escape($db, (int)$id) . "'";
  $result = mysqli_query($db, $sql);

  confirm_result_set($result);
  $image = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $image; 
}

/**
 * Method update_only_announcement_of_user
 *
 * @param $announcement announcement body
 * @param $id $id announcement id
 *
 * @return void
 */
function update_only_announcement_of_user($announcement, $id) {
  global $db;
 
  $sql = "UPDATE announcement SET ";
  $sql .= "announcement.announcement='" . $announcement['announcement'] . "' ";
  $sql .= "WHERE announcement_id='" . db_escape($db, (int)$id) . "' ";
  $sql .= "AND announcement.employee_id='" . $_SESSION['logged_employee_id'] . "' ";
  $sql .= "LIMIT 1";
  
  $result = mysqli_query($db, $sql);
  return $result;
}

// THIS IS FOR DELETING ANNOUNCEMENTS POSTED BY CURRENT USER
/**
 * Method delete_only_announcement_of_user
 *
 * @param $id announcement id
 *
 * @return void
 */
function delete_only_announcement_of_user($id) {
  global $db;
  $sql = "DELETE FROM announcement ";
  $sql .= "WHERE announcement_id='" . db_escape($db, (int)$id) . "' ";
  $sql .= "AND employee_id='" . $_SESSION['logged_employee_id'] . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  return $result;
  
}


/**
 * Method find_image_by_id
 *
 * @param $id image id
 *
 * @return void
 */
function find_image_by_id($id) {
  global $db;
  $sql = "SELECT * FROM image ";
  $sql .= "WHERE image_id='" . db_escape($db, (int)$id) . "'";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $image = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $image; // return the assoc. array
}

/**
 * Method find_all_images
 *
 * @return void
 */
function find_all_images() {
  global $db;
  $sql = "SELECT * FROM image ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

/**
 * Method find_all_images_and_employee_names
 *
 * @return void
 */
function find_all_images_and_employee_names() {
  global $db;
  $sql = "SELECT image.*, ";
  $sql .= "employee.employee_id, employee.first_name, ";
  $sql .= "employee.last_name FROM image ";
  $sql .= "JOIN employee USING(employee_id)";
  $sql .= "ORDER BY image.upload_date DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}


/**
 * Method find_all_images_and_employee_by_image_id
 *
 * @param $id image id
 *
 * @return void
 */
function find_all_images_and_employee_by_image_id($id) {
  global $db;
  $sql = "SELECT image.image_id, image.caption, image.file_name, image.upload_date, ";
  $sql .= "employee.employee_id, employee.first_name, ";
  $sql .= "employee.last_name FROM image ";
  $sql .= "JOIN employee USING(employee_id) ";
  $sql .= "WHERE image_id='" . db_escape($db, (int)$id) . "'";
  $result = mysqli_query($db, $sql);

  confirm_result_set($result);
  $image = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $image; 
}

/**
 * Method insert_image
 *
 * @param $new_image_file_name generated image file name
 * @param $image image array
 *
 * @return void
 */
function insert_image($new_image_file_name, $image) {
  global $db;
  $sql = "INSERT INTO image ";
  $sql .= "(file_name, caption, employee_id) ";
  $sql .= "VALUES (";
  $sql .= "'" . $new_image_file_name . "',"; 
  $sql .= "'" . db_escape($db, $image['caption']) . "',";
  $sql .= "'" . db_escape($db, $image['employee_id']) . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);

  confirm_result_set($result);
  return $result;
}


/**
 * Method delete_only_image_of_user
 *
 * @param $id deleting the image id based on the logged in user id
 *
 * @return void
 */
function delete_only_image_of_user($id) {
  global $db;
  $sql = "DELETE FROM image ";
  $sql .= "WHERE image_id='" . db_escape($db, (int)$id) . "' ";
  $sql .= "AND employee_id='" . $_SESSION['logged_employee_id'] . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);
  return $result;
}

/**
 * Method update_only_image_of_user
 *
 * @param $image image array information
 * @param $id image id associated with logged in user id
 *
 * @return void
 */
function update_only_image_of_user($image, $id) {
  global $db;
 
  $sql = "UPDATE image SET ";
  $sql .= "image.caption='" . $image['caption'] . "' ";
  $sql .= "WHERE image_id='" . db_escape($db, (int)$id) . "' ";
  $sql .= "AND image.employee_id='" . $_SESSION['logged_employee_id'] . "' ";
  $sql .= "LIMIT 1";
  
  $result = mysqli_query($db, $sql);
  return $result;
}


/**
 * Method update_user_profile
 *
 * @param $employee array of logged in employee information
 * @param $id logged in employee id
 *
 * @return void
 */
function update_user_profile($employee, $id) {
  global $db;

  $password_sent = !is_blank($employee['password']);
  $username_sent = !is_blank($employee['username']);

  $errors = validate_employee($employee, ['password_required' => $password_sent, 'username_required' => $username_sent]);
  if(!empty($errors)) {
    return $errors;
  }
 
  $sql = "UPDATE employee SET ";
  $sql .= "first_name='" . db_escape($db, $employee['first_name']) . "',";
  $sql .= "last_name='" . db_escape($db, $employee['last_name']) . "',";
  $sql .= "phone='" . db_escape($db, $employee['phone']) . "',";
  $sql .= "department_initial='" . db_escape($db, $employee['department_initial']) . "',";
  if($password_sent) {
    $sql .= "hashed_password='" . db_escape($db, $employee['hashed_password']) . "',";
  }
  if($username_sent) {
   $sql .= "username='" . db_escape($db, $employee['username']) . "',"; 
  }
  $sql .= "email='" . db_escape($db, $employee['email']) . "' ";
  $sql .= "WHERE employee_id='" . db_escape($db, (int)$id) . "' ";
  $sql .= "LIMIT 1";
  
  $result = mysqli_query($db, $sql);
  return $result;
}



?>