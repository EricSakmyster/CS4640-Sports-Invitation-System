<?php 
  session_start();
  if($_SESSION["username"] == NULL) {
    header("Location: login.php");
  }
  else {
    include("database_credentials.php"); 
    $db = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    // Gets user_id of current user using session
    $stmt_user_id = $db->prepare("select user_id from user where username=?");
    $stmt_user_id->bind_param("s", $_SESSION["username"]);
    $stmt_user_id->execute();
    $result = $stmt_user_id->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stmt_user_id->close();
    $user_id = $rows[0]['user_id'];
    if (!empty($_POST)){
      $invite_id = $_POST['invite_id'];
      $status = $_POST['status'];
      // See if the current user has updated their status for a particular invite or not
      $stmt_check = $db->prepare("select * from invite_users where user_id = ? AND invite_id = ?");
      $stmt_check->bind_param("ii", $user_id, $invite_id);
      $stmt_check->execute();
      $result2 = $stmt_check->get_result();
      $rows2 = $result2->fetch_all(MYSQLI_ASSOC);
      $stmt_check->close();
      if (empty($rows2)) { // If the user doesn't have a status for an invite, make a new entry in db
        $stmt = $db->prepare("insert into invite_users (invite_id, user_id, status) 
        VALUES (?, ?, ?); ");
        $stmt->bind_param("iis", $invite_id, $user_id, $status);
      }
      else{ // If the user does have a status for an invite, update the status in db
        $stmt = $db->prepare("update invite_users set status=? where user_id=? and invite_id=?");
        $stmt->bind_param("sii", $status, $user_id, $invite_id);
      }
      $stmt->execute();
      $stmt->close();
    }
    $db->close();
  }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="main.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <title>Public Events</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="author" content="Eric Sakmyster and Merron Tecleab">
        <meta name="description" content="Invitation page">
        <meta name="keywords" content="Merron Eric invitation">
    </head>

    <body>
      <div id='header-footer-container'>
        <header>
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
              <div class="container-fluid">
                  <a class="navbar-brand" href="index.php">UVA Sports Invitations</a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                      <ul class="navbar-nav">
                          <li class="nav-item active">
                              <a class="nav-link" href="index.php">Home</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" style = "border-bottom: 3px solid rgb(47, 120, 255);" aria-current="page" href="publicEvents.php">Public Events</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="createEvent.php">Create Event</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="invitations.php">Your Events</a>
                          </li>
                      </ul>
                  </div>
                  <a class="btn btn-primary btn-md" id= "logout" href="logout.php" role="button">Logout</a>
              </div>
          </nav>
        </header>
        <div id='body'>
          <h1 style="text-align: center; font-size: 70px;">Public Events Hub</h1>
          <div class="container" id = "filter-container" style = "margin-top: 100px; text-align: center;">
            <div class="input-group">
                    <input type="search" class="form-control rounded" style="margin-right: 5px;" placeholder="Search" aria-label="Search"/><!--Search bar-->
                    <button type="button" class="btn btn-outline-primary">Search</button> <!--Search button-->
                    <button type="button" class="btn btn-outline-primary">Filter</button> <!--Filter button-->
            </div>
          </div>  
          <div class="container" id="container-invitation">
              <?php
                // Get all invites from database to display in the hub
                include("database_credentials.php");
                $db = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
                mysqli_select_db($db, $dbdatabase);
                $invites = mysqli_query($db, "SELECT * FROM invite;");
                $invites_row = $invites->fetch_all(MYSQLI_ASSOC);
                foreach ($invites as $invite) { 
              ?>
                <div class="card text-center" id="card-invitation" style="border: 5px solid black;">
                    <?php 
                    // Gets the current user's status for a particular invite to display its
                    $user_status = mysqli_query($db, "SELECT status FROM invite_users;");
                    $status_check = $db->prepare("select status from invite_users where user_id = ? AND invite_id = ?");
                    $status_check->bind_param("ii", $user_id, $invite['invite_id']);
                    $status_check->execute();
                    $result_status = $status_check->get_result();
                    $rows_status = $result_status->fetch_all(MYSQLI_ASSOC);
                    $status_check->close();
                    if (!empty($rows_status)){
                      if(strcmp($rows_status[0]["status"], "Going") == 0){
                    ?>                       
                        <div class="card-header" style= "background-color: #00bfff">
                          You are going!
                        </div>
                      <?php
                      }
                      else if(strcmp($rows_status[0]["status"], "Unsure") == 0){
                      ?>  
                        <div class="card-header" style= "background-color: yellow">
                          You are unsure!
                        </div>
                      <?php 
                      }
                      else{
                      ?>
                        <div class="card-header" style= "background-color: red">
                          You are not going!
                        </div>
                    <?php
                      }
                    }
                    else{
                    ?>
                      <div class="card-header">
                        You have not responded!
                      </div>
                    <?php
                    }
                    ?>
                    <div class="card-body"> 
                      <h5 class="card-title"><?php echo $invite['gender'], " ", $invite['sport']; ?></h5> <!--gender and sport in header-->
                      <?php if ($invite['group_name']){ ?>
                        <p class="card-text">Run by <?php echo $invite['group_name']; ?></p> <!--Name of group hosting-->
                      <?php } ?>
                      <p class="card-text">@<?php echo $invite['location']; ?></p> <!--Location of event-->
                      <p class="card-text"><?php echo $invite['time'], " ", $invite['date']; ?></p> <!--Date/Time of event-->
                      <p class="card-text"><?php echo $invite['description']; ?></p> <!-- description of event -->
                      <?php
                        //Get how many users have said they are going to a particular invite
                        $num_check = $db->prepare("select COUNT(*) AS count from invite_users where invite_id = ? and status = 'Going'");
                        $num_check->bind_param("i",$invite['invite_id']);
                        $num_check->execute();
                        $result_num = $num_check->get_result();
                        $rows_num = $result_num->fetch_all(MYSQLI_ASSOC);
                        $num_check->close();
                        $count = $rows_num[0]["count"];
                      ?>
                      <p class="card-text">Spots Remaining: 
                        <?php 
                          echo $invite['num_players'] - $count; 
                        ?>
                      </p> <!--Amount of spots left-->
                      <form action="" method = "post">
                        <input type="hidden" name="invite_id" value=<?php echo $invite['invite_id']; ?>> <!-- Hidden field to send invite_id -->
                        <?php 
                          if(($invite['num_players'] - $count) == 0){
                        ?>
                            <button type="submit" name="status" value="Going" class="btn btn-primary" disabled>Going</a> <!--Going button disabled-->
                        <?php
                          }
                          else{
                        ?>
                            <button type="submit" name="status" value="Going" class="btn btn-primary" onclick= "statusMessage()">Going</a> <!--Going button-->
                        <?php
                          }
                        ?>
                        <button type="submit" name="status" value="Unsure" class="btn btn-warning">Unsure</a> <!--Unsure button-->
                        <button type="submit" name="status" value="Not Going" class="btn btn-danger" >Not going</a> <!--Not going button-->
                      </form>
                    </div>
                </div>
              <?php } 
                $invites->close();
                $db->close();
              ?>
          </div>
        </div>
        <footer class = 'primary-footer'>
          <nav class = 'footer-nav' style= "margin-top: 10px;">
              <a class="btn btn-primary btn-sm" href="index.php" role="button">Home
              </a> |
              <a class="btn btn-primary btn-sm" href="publicEvents.php" role="button">Public Events
                  <span class="badge bg-secondary">0</span>
              </a> |
              <a class="btn btn-primary btn-sm" href="createEvent.php" role="button">Create Event
              </a> |
              <a class="btn btn-primary btn-sm" href="invitations.php" role="button">Your Events</a>
          </nav>
        </footer>
      </div>
      <script>
        // If the user accepts an invite, an alert will pop up saying it will now show in the Your Events tab
        function statusMessage(){
          alert("Accepted invite will show in the Your Events tab.")
        }
      </script>
    </body>
</html>