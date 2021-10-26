<?php 
    // // /** DATABASE SETUP **/
    include("database_credentials.php"); // define variables
    // $conn = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    $db = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);

    session_start();


    if($_SESSION["username"] == NULL) {
        header("Location: login.php");
    }

    




    if (!empty($_POST)){
        include("database_credentials.php"); // define variables
        $db = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
        $stmt = $db->prepare("insert into invite (group_name, sport, gender, num_players, description, location, time, date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?); ");
        $stmt->bind_param("sssissss", $group_name, $sport, $gender, $num_players, $description, $location, $time, $date);
        $group_name = $_POST['group_name'];
        $sport = $_POST['sport'];
        $gender = $_POST['gender'];
        $num_players = $_POST['num_players'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $time = $_POST['time'];
        $date = $_POST['date'];
        $stmt->execute();
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
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Eric Sakmyster and Merron Tecleab">
        <meta name="description" content="Home page of website">
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
                        <a class="btn btn-primary btn-md" id= "login" href="login.php" role="button">Login</a>
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
                                <div class="col-md-6">
                                    <!-- If the sporting event is hosted by a certain group or sports team -->
                                    <label for="groupName" class="form-label">Group Name (if applicable)</label>
                                    <input type="text" class="form-control" name = "group_name" id="groupName">
                                </div>
                                <!-- Pick the sport being played -->
                                <div class='col-8'>
                                    <label class="form-label">Sport</label>
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
                                </div>
                                <!-- What gender you want to play, or both -->
                                <label class="form-label">Gender</label>
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
                                </div>
                                <!-- Input number of players needed -->
                                <div class="col-md-6">
                                    <label for="number" class="form-label">Number of Players</label>
                                    <input type="number" class="form-control" name="num_players" id="number" placeholder="1, 2, 3, etc.">
                                </div>
                                <!-- Any additional information to send out -->
                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" class="form-control" name = "description" id="description" placeholder="Any additional information?">
                                </div>
                                <!-- Input the location of the sporting event -->
                                <div class="col-12">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" name = "location" id="location" placeholder="Carr's Field, Ohill, etc.">
                                </div>
                                <!-- Time of event -->
                                <div class="col-4">
                                    <label for="time" class="form-label">Time</label>
                                    <input type="text" class="form-control" name = "time" id="time" placeholder="4:30 PM, 9:00 AM, etc.">
                                </div>
                                <!-- Date of event -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="text" class="form-control" name = "date" id="date" placeholder="Ex. 10/19/2021">
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