<?php
    // Get all invites from database to display
    // Authors: Eric Sakmyster and Merron Tecleab
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
    header("Access-Control-Max-Age: 1000");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");
    session_start();
    include("database_credentials.php");
    $db = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    mysqli_select_db($db, $dbdatabase);
    $invites = mysqli_query($db, "SELECT * FROM invite;");
    $invites_row = $invites->fetch_all(MYSQLI_ASSOC);
    $invites->close();
    echo json_encode($invites_row); //encoding invites as json
?>