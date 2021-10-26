<?php
    

    // // /** DATABASE SETUP **/
    include("database_credentials.php"); // define variables
    // $conn = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    $db = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);

    session_start();

    $error_msg = "";
    $usernameErr = "";
    $passwordErr = "";
    // Check if the user submitted the form (the form in the HTML below
// submits back to this page, which is okay for now.  We will check for
// form data and determine whether to re-show this form with a message

if (isset($_POST["username"])) { // validate the email coming in
    $stmt = $db->prepare("select password from user where username = ?;");
    $stmt->bind_param("s", $_POST["username"]);
    if (!$stmt->execute()) {
        $error_msg = "Error checking for user";
    } else { 
        // result succeeded
        $res = $stmt->get_result();
        $data = $res->fetch_all(MYSQLI_ASSOC);

        if (empty($data)) {
            $usernameErr = "Incorrect username.";
            // header("Location: login.php");
        }

        else if(!password_verify($_POST["password"], $data[0]["password"])) {
                $passwordErr = "Incorrect password.";
        }
        else {
            // User was found!  Send to the home page
            $_SESSION["username"] = $_POST["username"];
            echo "Session variables are set.";
            header("Location: index.php");
            exit();
        } 
    }
    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="main.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <title>Login</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="author" content="Eric Sakmyster and Merron Tecleab">
        <meta name="description" content="Login page">
        <meta name="keywords" content="Merron Eric login">
    </head>

    <style>
        .row {
            width: 100%;
        }

        .col-25 {
            float: left;
            width: 25%;
        }

        .col-75 {
            float: left;
            width: 75%;
        }

        @media screen and (max-width: 600px) {
            .col-25, .col-75, .col-2, input[type=submit] { 
                width: 100%; /*If the width of the screen is 600 px or less, make text and the text box on separate rows of the website*/
                margin-top: 0;
            }
        }
    </style>

    <body>
        <div class="container" id="container-login">
            <h1>Welcome to UVA Sports Invitations</h1>
            <form class="form" method="post" name="login">
                <div class="row justify-content-center" style="margin-bottom: 5px; margin-top:200px;"> <!--Username field-->
                    <?php 
                        if (isset($_GET["username"])) {
                            echo "Registration success for " . $_GET["username"];
                        }
                        if (isset($_GET['loggedout'])){
                            echo "You've been logged out."
                        }
                    ?>
                </div>
                <div class="row justify-content-center">
                    <div class="col-2"> 
                        <label for="usr">Username:</label>
                    </div>
                    <div class="col-2">
                        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
                        <!-- <input type="text" class="form-control" id="usr"> input field -->
                    </div>
                </div>
                <div class="row justify-content-center"> <!--Password field-->
                    <div class="col-2">
                        <label for="pwd">Password:</label>
                    </div>
                    <div class="col-2">
                        <input type="password" class="login-input" name="password" placeholder="Password"/>
                        <!-- <input type="password" class="form-control" id="pwd"> input field -->
                    </div>
                </div>
                <?php if (! empty($usernameErr) || ! empty($passwordErr)){
                ?>
                    <div class="row justify-content-center"> <!--For displaying errors -->
                        <div class="col-4">
                            <p style="color:red"><?php echo $usernameErr;?></p>
                            <p style="color:red"><?php echo $passwordErr;?></p>
                        </div>
                    </div>
                <?php 
                        }
                ?>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <!-- <a href="index.php" class="btn btn-primary btn-sm">Login</a> Login button -->
                        <input type="submit" value="Login" name="submit" class="login-button"/>
                        <p class="link"><a href="registration.php">New user?</a></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col">
                        <!-- <a href="#" class="text-decoration-none">Forgot Password?</a> "Forgot Password button" -->
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>