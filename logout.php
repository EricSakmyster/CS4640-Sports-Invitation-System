
<?php
// Source: https://www.tutorialspoint.com/php/php_login_example.htm
    
    // // /** DATABASE SETUP **/
    include("database_credentials.php"); // define variables
    // $conn = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    
    $db = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
    session_start();

    $error_msg = "";
    session_destroy();
    header("Location: login.php");


    // if(isset($_SESSION["username"])) {
    //     unset($_SESSION["username"]);
    //     unset($_SESSION["password"]);
    // }
    // else {
    //     $error_msg = "Didn't log out properly";
    // }
   ?>