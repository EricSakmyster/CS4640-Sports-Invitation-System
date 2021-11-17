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
      echo "success";
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
        <title>Invitations</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="author" content="Eric Sakmyster and Merron Tecleab">
        <meta name="description" content="User Invitations">
        <meta name="keywords" content="Merron Eric user invitations">
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
                              <a class="nav-link" href="publicEvents.php">Public Events</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="createEvent.php">Create Event</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" style = "border-bottom: 3px solid rgb(47, 120, 255);" aria-current="page" href="invitations.php">Your Events</a>
                          </li>
                      </ul>
                  </div>
                  <a class="btn btn-primary btn-md" id= "logout" href="logout.php" role="button">Logout</a>
              </div>
          </nav>
        </header>
        <div id='body'>
          <h1 style="text-align: center; font-size: 70px;">Your Accepted Invitations</h1>
          <div class="container" id="container-invitation">
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
          // JS object for an accepted invite with the desired fields
          function AcceptedInvite(invite_id, gender, sport, location, time, date, description){
              this.invite_id = invite_id;
              this.gender = gender;
              this.sport = sport;
              this.location = location;
              this.time = time;
              this.date = date;
              this.description = description;
          }
          // When the document is ready, this ajax query will get all the users accepted invites and display them on the DOM
          $(document).ready(function(){
              $.ajax({
                  async : true,
                  url:'invites.php',
                  type: 'get',
                  dataType: 'JSON',
                  success: function(response){
                      var responseLength = response.length;
                      // If no accepted invites exist, display an alert that shows they need to accept somes
                      if (!responseLength){
                          var noInvitesStr = "<div class='alert alert-primary' role='alert'>" + "You have no accepted invites. Go accept some in the " +  "<a href='publicEvents.php' class='alert-link'>" + "public events" + "</a>" + " tab."+ "</div>";
                          $("#container-invitation").append(noInvitesStr);
                      }
                      for(var i =0; i<responseLength; i++){
                        var acceptInv = new AcceptedInvite(response[i].invite_id, response[i].gender, response[i].sport, response[i].location, response[i].time, response[i].date, response[i].description);
                        var invite_card = "<div class='card text-center' id=" + acceptInv.invite_id + " style='border: 5px solid black; padding: 10px; margin-top: 50px;'>" +
                        "<div class='card-body'>" +
                        "<h5 class='card-title'>" + acceptInv.gender + " " + acceptInv.sport + "</h5>" +
                        "<p class='card-text'>" + "@" + acceptInv.location + "</p>" +
                        "<p class='card-text'>" + acceptInv.time + " " + acceptInv.date + "</p>" +
                        "<p class='card-text'>" + acceptInv.description + "</p>" + 
                        "<button type='button' name='notGoing' id=" + acceptInv.invite_id + " value='Not Going' class='btn btn-danger' onclick = 'updateInvites(" + acceptInv.invite_id + ")'>" + "Not Going Anymore" + "</button>" +
                        "</div>" + 
                        "</div>";
                        $("#container-invitation").append(invite_card);
                      }
                  }
              });
          });
          // If the user clicks they don't want to come to an accepted invite anymore, the database will be updated
          // and the card will be deleted from the DOM
          function updateInvites(id){
            $.ajax({
                  async : true,
                  type: "POST",
                  url:'invitations.php',
                  data: {
                    invite_id: parseInt(id),
                    status: "Not Going",
                  },
                  dataType: 'application/x-www-form-urlencoded',
            });
            $("#" + id).remove();
            $.ajax({
                  async : true,
                  url:'invites.php',
                  type: 'get',
                  dataType: 'JSON',
                  success: function(response){
                      var responseLength = response.length;
                      if (!responseLength){
                          var noInvitesStr = "<div class='alert alert-primary' role='alert'>" + "You have no accepted invites. Go accept some in the " +  "<a href='publicEvents.php' class='alert-link'>" + "public events" + "</a>" + " tab."+ "</div>";
                          $("#container-invitation").append(noInvitesStr);
                      }
                  }
            });
          }
      </script>
    </body>
</html>