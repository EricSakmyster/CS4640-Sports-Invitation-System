<?php 
    session_start();
    if($_SESSION["username"] == NULL) {
        header("Location: login.php");
    } 
    // Checks if the time inputted matches an accepted time format
    function isValidTime($time){
        return preg_match("/^(1[0-2]|0[1-9]|[1-9]):[0-5][0-9] (PM|AM|pm|am)+$/", $time);
    }
    // Checks if the date inputted matches an accepted date format
    function isValidDate($date){
        return preg_match("/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9][0-9][0-9][0-9]+$/", $date);
    }
    // Initializes all the error messages possible for each form element
    $sportErr = "";
    $genderErr = "";
    $numPlayersErr="";
    $descriptionErr="";
    $locationErr="";
    $timeErr="";
    $dateErr="";
    $success = 0;
    $error_present = 0;
    if (!empty($_POST)){
        include("database_credentials.php"); // define variables
        $db = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
        $stmt = $db->prepare("insert into invite (group_name, sport, gender, num_players, description, location, time, date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?); ");
        $stmt->bind_param("sssissss", $group_name, $sport, $gender, $num_players, $description, $location, $time, $date);
        $group_name = $_POST['group_name'];
        if (empty($_POST['sport'])){
            $sportErr = "Sport is required";
            $error_present = 1;
        }
        else{
            $sport = $_POST['sport'];
        }
        if (empty($_POST['gender'])){
            $genderErr = "Gender is required";
            $error_present = 1;
        }
        else{
            $gender = $_POST['gender'];
        }
        if (empty($_POST['num_players'])){
            $numPlayersErr = "Number of players is required";
            $error_present = 1;
        }
        else if (is_int($_POST['num_players'])){
            $numPlayersErr = "Must be number";
            $error_present = 1;
        }
        else{
            $num_players = $_POST['num_players'];
        }
        if (empty($_POST['description'])){
            $descriptionErr = "Description is required";
            $error_present = 1;
        }
        else{
            $description = $_POST['description'];
        }
        if (empty($_POST['location'])){
            $locationErr = "Location is required";
            $error_present = 1;
        }
        else{
            $location = $_POST['location'];
        }
        if (empty($_POST['time'])){
            $timeErr = "Time is required";
            $error_present = 1;
        }
        else if (!isValidTime($_POST['time'])){
            $timeErr = "Time must be in format DD:DD AM/PM";
            $error_present = 1;
        }
        else{
            $time = $_POST['time'];
        }
        if (empty($_POST['date'])){
            $dateErr = "Date is required";
            $error_present = 1;
        }
        else if (!isValidDate($_POST['date'])){
            $dateErr = "Date must be in format MM-DD-YYYY";
            $error_present = 1;
        }
        else{
            $date = $_POST['date'];
        }
        if (!$error_present){
            $stmt->execute();
            $success = 1;
        }
        $stmt->close();
        $db->close();
    } 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create Events</title>
        <link rel="stylesheet" href="main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Eric Sakmyster and Merron Tecleab">
        <meta name="description" content="Form to create a sports invite">
        <meta name="keywords" content="Eric Merron createinvite">    
    </head>
    <body>
        <div id='header-footer-container'>
            <header>
                <!-- Nav bar that collapses when screen gets small with tabs for each page and login-->
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php">UVA Sports Invitations</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link"  href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="publicEvents.php">Public Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style = "border-bottom: 3px solid rgb(47, 120, 255);" aria-current="page" href="createEvent.php">Create Event</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">User Search</a>
                                </li>
                            </ul>
                        </div>
                        <a class="btn btn-primary btn-md" id= "logout" href="logout.php" role="button">Logout</a>
                    </div>
                </nav>
            </header>
            <div id='body'>
                <div class = 'container'>
                    <div class="card" id="card-event-form"> 
                        <div class="card-body">
                            <!-- Form for creating a sports invitation that would go on the Public Events Hub -->
                            <form action="" method = "post" class="row g-3">
                                <h1 style="text-align: center; text-decoration: underline;"> Create an Event</h1>
                                <?php 
                                    // Creates a success alert if the invite form was valid, or an invalid alert if not
                                    if ($success){
                                ?>
                                        <div class="alert alert-success" style="text-align:center" role="alert">
                                            Invite Created!
                                        </div>
                                <?php
                                    }
                                    if ($error_present){
                                ?>
                                        <div class="alert alert-danger" style="text-align:center" role="alert">
                                            Invite Invalid!
                                        </div>
                                <?php
                                    }
                                ?>
                                <p style="color:red">* Required field</p>
                                <div class="col-md-6">
                                    <!-- If the sporting event is hosted by a certain group or sports team -->
                                    <label for="groupName" class="form-label">Group Name (if applicable)</label>
                                    <input type="text" class="form-control" name = "group_name" id="groupName">
                                </div>
                                <!-- Pick the sport being played -->
                                <div class='col-8'>
                                    <label class="form-label">Sport
                                    <p style="color:red; display:inline">*</p>
                                    </label>
                                    <select class="form-select" name = "sport" aria-label="Sports Select">
                                        <option selected disabled>Pick a Sport</option>
                                        <option value="Soccer">Soccer</option>
                                        <option value="Football">Football</option>
                                        <option value="Basketball">Basketball</option>
                                        <option value="Lacrosse">Lacrosse</option>
                                        <option value="Tennis">Tennis</option>
                                        <option value="Spikeball">Spikeball</option>
                                        <option value="Lacrosse">Lacrosse</option>
                                        <option value="Frisbee">Frisbee</option>
                                        <option value="Volleyball">Volleyball</option>
                                    </select>
                                    <p style="color:red"><?php echo $sportErr;?></p>
                                </div>
                                <!-- What gender you want to play, or both -->
                                <label class="form-label">Gender 
                                <p style="color:red; display:inline">*</p>
                                </label>
                                <div class="col-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="men" value="Men">
                                        <label class="form-check-label" for="men">Men</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="women" value="Women">
                                        <label class="form-check-label" for="women">Women</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="coed" value="Co-Ed">
                                        <label class="form-check-label" for="coed">Co-Ed</label>
                                    </div>
                                    <p style="color:red"><?php echo $genderErr;?></p>
                                </div>
                                <!-- Input number of players needed -->
                                <div class="col-md-6">
                                    <label for="number" class="form-label">Number of Players
                                    <p style="color:red; display:inline">*</p>
                                    </label>
                                    <input type="number" class="form-control" name="num_players" id="number" placeholder="1, 2, 3, etc.">
                                    <p style="color:red"><?php echo $numPlayersErr;?></p>
                                </div>
                                <!-- Any additional information to send out -->
                                <div class="col-12">
                                    <label for="description" class="form-label">Description
                                    <p style="color:red; display:inline">*</p>
                                    </label>
                                    <input type="text" class="form-control" name = "description" id="description" placeholder="Any additional information?">
                                    <p style="color:red"><?php echo $descriptionErr;?></p>
                                </div>
                                <!-- Input the location of the sporting event -->
                                <div class="col-12">
                                    <label for="location" class="form-label">Location
                                    <p style="color:red; display:inline">*</p>
                                    </label>
                                    <input type="text" class="form-control" name = "location" id="location" placeholder="Carr's Field, Ohill, etc.">
                                    <p style="color:red"><?php echo $locationErr;?></p>
                                </div>
                                <!-- Time of event -->
                                <div class="col-md-4">
                                    <label for="time" class="form-label">Time
                                    <p style="color:red; display:inline">*</p>
                                    </label>
                                    <input type="text" class="form-control" name = "time" id="time" placeholder="4:30 PM, 9:00 AM, etc.">
                                    <p style="color:red"><?php echo $timeErr;?></p>
                                </div>
                                <!-- Date of event -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Date
                                    <p style="color:red; display:inline">*</p>
                                    </label>
                                    <input type="text" class="form-control" name = "date" id="date" placeholder="Ex. 10-19-2021">
                                    <p style="color:red"><?php echo $dateErr;?></p>
                                </div>
                                <!-- When this button gets pressed, the invitation would then be put in the Hub -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <footer class = 'primary-footer'>
                <nav class = 'footer-nav'>
                    <a class="btn btn-primary btn-sm" href="index.php" role="button">Home
                    </a> |
                    <a class="btn btn-primary btn-sm" href="publicEvents.php" role="button">Public Events
                        <span class="badge bg-secondary">0</span>
                    </a> |
                    <a class="btn btn-primary btn-sm" href="createEvent.php" role="button">Create Event
                    </a> |
                    <a class="btn btn-primary btn-sm" href="#" role="button">User Search</a>
                </nav>
            </footer>
        </div>
    </body>
</html>