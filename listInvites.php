<?php
    // Get all invites from database to display
    session_start();
    include("database_credentials.php");
    $db = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    mysqli_select_db($db, $dbdatabase);
    $invites = mysqli_query($db, "SELECT * FROM invite;");
    $invites_row = $invites->fetch_all(MYSQLI_ASSOC);
    $invites->close();
    echo json_encode($invites_row); //encoding invites as json
?>