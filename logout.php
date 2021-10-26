
<?php
// Source: https://www.tutorialspoint.com/php/php_login_example.htm
    
    // // /** DATABASE SETUP **/
    include("database_credentials.php"); // define variables
    // $conn = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    
    $db = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
    session_start();

    $error_msg = "";
    if(isset($_SESSION["username"])){
        header("Location: login.php?loggedout=true");
    }
    else{
        header("Location: login.php");
    }
    session_destroy();
   ?>