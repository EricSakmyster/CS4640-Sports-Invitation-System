<!-- Source: https://www.tutorialspoint.com/stop-making-form-to-reload-a-page-in-javascript -->
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
                            echo "You've been logged out.";
                        }
                    ?>
                </div>
                <div class="row justify-content-center">
                    <div class="col-2"> 
                        <label for="usr">Username:</label>
                    </div>
                    <div class="col-2">
                        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true" id="inputUsername"/>
                        <div id=userHelp class="form-text" style="color:red"></div>
                        <!-- <input type="text" class="form-control" id="usr"> input field -->
                    </div>
                </div>
                <div class="row justify-content-center"> <!--Password field-->
                    <div class="col-2">
                        <label for="pwd">Password:</label>
                    </div>
                    <div class="col-2">
                        <input type="password" class="login-input" name="password" placeholder="Password" id="inputPassword"/>
                        <div id=passHelp class="form-text" style="color:red"></div>
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
                        <input type="submit" value="Login" name="submit" class="login-button" onclick="loginUser();"/>
                        <!-- <a href="#" id="login" onclick="loginUser();">Login</a> -->
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



        <script type="text/javascript">


            let verifyUsername = () => { //arrow function
                let username = document.getElementById("inputUsername").value;

                if(username.length >= 5 && username.length <= 10) {
                    return true;
                }

                alert("Username error!");
                return false;
            }

            function userErrType() {
                var username = document.getElementById("inputPassword").value;

                if(username.length >= 5 && username.length <= 10) {
                    return true;
                }

                document.getElementById("userHelp").innerHTML = "Enter a username between 5-10 letters";
            }

            let verifyPassword = function() { //anonymous function
                var password = document.getElementById("inputPassword").value;
                // console.log(password);
                var isUpper = false;
                for (let i = 0; i < password.length; i++) {
                    var temp = password.charAt(i);
                    if(temp == temp.toUpperCase()) {
                        isUpper = true;
                        break;
                    }
                }

                var isLower = false;
                for (let i = 0; i < password.length; i++) {
                    var temp = password.charAt(i);
                    if(temp == temp.toLowerCase()) {
                        isLower = true;
                        break;
                    }
                }

                if(password.length > 5 && password.length < 10 && isUpper == true && isLower == true) {
                    return true;
                }
                alert("Password error!");

                return false;
            }

            function passErrType() {
                var password = document.getElementById("inputPassword").value;
                
                console.log(password[0]);
                var isUpper = false;
                for (let i = 0; i < password.length; i++) {
                    var temp = password.charAt(i);
                    if(temp == temp.toUpperCase()) {
                        isUpper = true;
                        break;
                    }
                }

                var isLower = false;
                for (let i = 0; i < password.length; i++) {
                    var temp = password.charAt(i);
                    if(temp == temp.toLowerCase()) {
                        isLower = true;
                        break;
                    }
                }

                if(password.length >= 5 && password.length <= 10 && isUpper == true && isLower == true) {
                    return true;
                }
                
                else if(password.length < 5 || password.length > 10) {
                    document.getElementById("passHelp").innerHTML = "Enter a password between 5-10 letters";
                }

                else if(isUpper == false) {
                    document.getElementById("passHelp").innerHTML = "Include at least one upper case letter";
                }

                else if(isLower == false) {
                    document.getElementById("passHelp").innerHTML = "Include at least one lower case letter";
                }


            }


            function loginUser() {
                var username = document.getElementById("inputUsername").value;
                var password = document.getElementById("inputPassword").value;

                var isValidName = verifyUsername();
                var isValidPassword = verifyPassword();
                if(isValidName == true && isValidPassword == true) {
                    window.location.href = "index.php";
                    return true;
                }

                // document.getElementById("login").addEventListener("click", event.preventDefault());
                event.preventDefault();

                userErrType();
                passErrType();

                return false;
            }


            </script>
    </body>
</html>