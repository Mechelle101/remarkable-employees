<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Remarkable Employees Admin Page</title>
    <link href="../../stylesheets/public-styles.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="../../images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
    <!-- Main header -->
    <div id="main-content">
      <header>
        <a href="<?php echo url_for( 'staff/admin/index.php'); ?>"><img src="../../images/ppl-logo.png" alt="circle logo" width="100" height="100"></a>
        <div id="header-content">
          <h1>Remarkable Employees</h1>
          <p>Where we come together as a team.</p>
        </div>
        <div id="user-info">
          <p>Welcome <?php echo $_SESSION['first_name']; ?></p>
          <p>You are logged in as - <?php echo $_SESSION['user_level']; ?></p>
          <l1 id="logout"><a href="<?php echo url_for('../public/logout.php'); ?>">Logout <?php echo $_SESSION['username']; ?></a></l1>
        </div>
      </header>