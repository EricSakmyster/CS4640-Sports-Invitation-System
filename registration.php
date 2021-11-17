<!-- Source: https://www.tutorialspoint.com/javascript/javascript_page_redirect.htm -->
<!-- Source: https://www.tutorialspoint.com/stop-making-form-to-reload-a-page-in-javascript -->

<?php

// /** DATABASE SETUP **/
include("database_credentials.php"); // define variables
// $conn = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
$db = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);

$error_msg = "";

// Check if the user submitted the form 
// Check for form data and determine whether to re-show this form with a message

if (isset($_REQUEST["username"])) { // validate the email coming in
$stmt = $db->prepare("select * from user where username = ?;");
$stmt->bind_param("s", $_REQUEST["username"]);
if (!$stmt->execute()) {
    $error_msg = "Error checking for user";
} else { 
    // result succeeded
    $res = $stmt->get_result();
    $data = $res->fetch_all(MYSQLI_ASSOC);
    
    if (!empty($data)) {
        // User was found
        header("Location: login.php?username={$data[0]["username"]}");
        exit();
    } else {
        // User was not found
        $insert = $db->prepare("insert into user (username, password) values (?, ?);");
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $insert->bind_param("ss", $_POST["username"], $password);
        if (!$insert->execute()) {
            $error_msg = "Error creating new user";
        } 

        // User was found! Send them to the login page
        header("Location: login.php?username={$_POST["username"]}");
        exit();
    }
}

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
                    <div class="col-2"> 
                        <label for="usr">New Username:</label>
                    </div>
                    <div class="col-2">
                        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true" id="inputUsername"/>
                        <div id=userHelp class="form-text" style="color:red"></div>
                    </div>
                </div>
                <div class="row justify-content-center"> <!--Password field-->
                    <div class="col-2">
                        <label for="pwd">New Password:</label>
                    </div>
                    <div class="col-2">
                        <input type="password" class="login-input" name="password" placeholder="Password" id="inputPassword"/>
                        <div id=passHelp class="form-text" style="color:red"></div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col">
                        <!-- <a href="index.php" class="btn btn-primary btn-sm">Login</a> Login button -->
                        <input type="submit" value="Register" name="submit" class="login-button" id="login" onclick="addAccount();"/>
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

                if(username.length >= 5 && username.length <= 10) { // Returns true if the username field is within 5-10 letters
                    return true;
                }

                alert("Username error!");
                return false;
            }

            function userErrType() {
                var username = document.getElementById("inputUsername").value;

                if(username.length >= 5 && username.length <= 10) { // Returns true if the username field is within 5-10 letters
                    return true;
                }

                document.getElementById("userHelp").innerHTML = "Enter a username between 5-10 letters";
            }

            let verifyPassword = function() { //anonymous function
                var password = document.getElementById("inputPassword").value;
                
                var isUpper = false;
                for (let i = 0; i < password.length; i++) { // Check if any upper case letters exist in the input
                    var temp = password.charAt(i);
                    if(temp == temp.toUpperCase()) {
                        isUpper = true;
                        break;
                    }
                }

                var isLower = false;
                for (let i = 0; i < password.length; i++) { // Check if any lower case letters exist in the input
                    var temp = password.charAt(i);
                    if(temp == temp.toLowerCase()) {
                        isLower = true;
                        break;
                    }
                }

                if(password.length >= 5 && password.length <= 10 && isUpper == true && isLower == true) {
                    return true;
                }
                alert("Password error!");

                return false;
            }

            function passErrType() {
                var password = document.getElementById("inputPassword").value;
                
                var isUpper = false;
                for (let i = 0; i < password.length; i++) { // Check if any upper case letters exist in the input
                    var temp = password.charAt(i);
                    if(temp == temp.toUpperCase()) {
                        isUpper = true;
                        break;
                    }
                }

                var isLower = false;
                for (let i = 0; i < password.length; i++) { // Check if any lower case letters exist in the input
                    var temp = password.charAt(i);
                    if(temp == temp.toLowerCase()) {
                        isLower = true;
                        break;
                    }
                }

                if(password.length >= 5 && password.length <= 10 && isUpper == true && isLower == true) {
                    return true;
                }
                
                else if(password.length < 5 || password.length > 10) { // If the password is out of the 5-10 letter range
                    document.getElementById("passHelp").innerHTML = "Enter a password between 5-10 letters";
                }

                else if(isUpper == false) { // If the password does not have any upper case letters
                    document.getElementById("passHelp").innerHTML = "Include at least one upper case letter";
                }

                else if(isLower == false) { // If the password does not have any lower case letters
                    document.getElementById("passHelp").innerHTML = "Include at least one lower case letter";
                }


            }


            function addAccount() {
                var isValidName = verifyUsername();
                var isValidPassword = verifyPassword();

                if(isValidName == true && isValidPassword == true) { // If the username and the password are typed in properly
                    window.location.href = "login.php";
                    return true;
                }

                else if(isValidName == true && isValidPassword == false) { // If the username is typed in properly
                    event.preventDefault(); // Stops the page from logging in
                    passErrType(); // Display the password error message
                    document.getElementById("userHelp").innerHTML = "";
                    return false;
                }

                else if(isValidName == false && isValidPassword == true) { // If the password is typed in properly
                    event.preventDefault(); // Stops the page from logging in
                    userErrType(); // Display the username error message
                    document.getElementById("passHelp").innerHTML = "";
                    return false;
                }

                else { // If both the username and the password isn't typed in properly
                    userErrType(); // Display the username error message
                    passErrType(); // Display the password error message
                    event.preventDefault(); // Stops the page from logging in
                    return false;
                }
                
            }


        </script>


    </body>
</html>
