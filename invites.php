<?php
    // Get all invites from database to display in the hub
    session_start();
    include("database_credentials.php");
    $db = mysqli_connect($dbserver, $dbuser, $dbpass, $dbdatabase);
    $stmt_user_id = $db->prepare("select user_id from user where username=?");
    $stmt_user_id->bind_param("s", $_SESSION["username"]);
    $stmt_user_id->execute();
    $result = $stmt_user_id->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stmt_user_id->close();
    $user_id = $rows[0]['user_id'];
    $invites = $db->prepare("select * from invite_users i1 natural join invite i2 where i1.status = 'Going' and i1.user_id = ? ;");
    $invites->bind_param("i", $user_id);
    $invites->execute();
    $result2 = $invites->get_result();
    $invites_row = $result2->fetch_all(MYSQLI_ASSOC);
    $invites->close();
    echo json_encode($invites_row); //encoding invites as json
?>