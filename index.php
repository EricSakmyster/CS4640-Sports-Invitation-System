<?php
// URL: https://cs4640.cs.virginia.edu/ems5fa/CS4640-Sports-Invitation-System-Sprint-3

// Sources: https://www.quora.com/How-can-I-continue-a-session-through-PHP-pages-after-I-login
// // /** DATABASE SETUP **/
include("database_credentials.php"); // define variables
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);

// Creating the user database
$db->query("create table if not exists user (
    user_id int not null primary key auto_increment,
    username text not null,
    password text not null);");

// Creating the invite database
$db->query("create table if not exists invite (
    invite_id int not null primary key auto_increment,
    group_name text not null,
    sport text not null,
    gender text not null,
    num_players text not null,
    description text not null,
    location text not null,
    time text not null,
    date text not null);");

// Creating the invite_user database
$db->query("create table if not exists invite_users (
    invite_id int not null,
    user_id int not null,
    status text not null,
    CONSTRAINT PK_invite_users primary key (invite_id,user_id));");
$db->close(); //Close the database
?>

<!DOCTYPE html>
<!-- 
URL: https://cs4640.cs.virginia.edu/ems5fa/CS4640-Sports-Invitation-System
-->
<html lang="en">
    <head>
        <title>UVA Sports Invitations</title>
        <link rel="stylesheet" href="main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Eric Sakmyster and Merron Tecleab">
        <meta name="description" content="Home page of website">
        <meta name="keywords" content="Eric Merron Home">    
    </head>
    <body>

    <?php
        session_start();
        if($_SESSION["username"] == NULL) {
            echo '<script type="text/javascript">
                alert("You are not logged in");
            </script>';
            }
        ?>

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
                                    <a class="nav-link" style = "border-bottom: 3px solid rgb(47, 120, 255);" aria-current="page" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="publicEvents.php">Public Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="createEvent.php">Create Event</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="invitations.php">Your Events</a>
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
                    <div class='row'>
                        <div class = 'col-6'>
                            <!-- Description of website purpose-->
                            <section>
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="card-title">Looking for a pickup game?</h1>
                                        <p class="card-text">This webpage strives to connect UVA students with the sports they want to play and get the number of players needed.</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class = 'col-6'>
                            <!-- Description of Public Events Hub and a strectched link for the whole card to direct to it-->
                            <section class="description">
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="card-title">Public Events Hub</h1>
                                        <p class="card-text">See what sports people need players for and accept or decline the invites.</p>
                                        <a href="publicEvents.php" class="btn btn-primary stretched-link">View Public Hub</a>
                                    </div>
                                </div>
                            </section>
                            <!-- Description of creating an event and a strectched link for the whole card to direct to it-->
                            <section class="description">
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="card-title">Create an Event</h1>
                                        <p class="card-text">Make an invite for a sport and specify logistics of it.</p>
                                        <a href="createEvent.php" class="btn btn-primary stretched-link">Create an Event</a>
                                    </div>
                                </div>
                            </section>
                            <!-- Description of searching for users and a strectched link for the whole card to direct to it-->
                            <section class="description">
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="card-title">Search for Users</h1>
                                        <p class="card-text">Search for different players you have met or want to invite privately to a sport.</p>
                                        <a href="#" class="btn btn-primary stretched-link">Search for a User</a>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer with button links to each tab in the navbar-->
            <footer class = 'primary-footer'>
                <nav class = 'footer-nav'>
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
    </body>
</html>