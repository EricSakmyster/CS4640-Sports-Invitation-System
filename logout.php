
<?php
// Source: https://www.tutorialspoint.com/php/php_login_example.htm
    
    // // /** DATABASE SETUP **/
    include("database_credentials.php"); // define variables
    
    $db = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
    session_start(); // Start the session to make the data available to the webpage
    session_destroy(); // Destroy the data with the current session
    header("Location: login.php"); // Redirect back to the login page once you log out

   ?>