<?php
    // Get all invites from database to display in the hub
    // Authors: Eric Sakmyster and Merron Tecleab
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
    header("Access-Control-Max-Age: 1000");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");
    session_start();
    include("database_credentials.php");
    $db = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    $jsonBody = file_get_contents('php://input');

    $data = json_decode($jsonBody, true);
    $stmt_user_id = $db->prepare("select user_id from invite_users where invite_id=? and status='Going';");
    $stmt_user_id->bind_param("i", $data['invite_id']);
    $stmt_user_id->execute();
    $result = $stmt_user_id->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stmt_user_id->close();
    echo json_encode($rows); //encoding users as json
?>