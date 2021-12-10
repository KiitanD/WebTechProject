<?php
require 'database_credentials.php';
//Connect to database   

$conn = new mysqli(servername, username, password, database);

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pword = password_hash($_POST['pword'], PASSWORD_ARGON2I);
    $job_title = $_POST['job_title'];
    $org_name = $_POST['org_name'];

    if (empty($_POST['job_title'])) {
        $job_title = "";
    }
    if (empty($_POST['org_name'])) {
        $org_name = "";
    }

    $register_query = "INSERT INTO People (fname, lname, email, pword, job_title, org_name) 
                        VALUES ('".$fname."', '". $lname . "', '" . $email . "', '" . $pword . "' , '" . $job_title . "' , '" . $org_name."')";
    //echo($register_query);
    $register_user = $conn->query($register_query);
    // if ($register_user) {
    //     echo ("Successfully added");
    // }
    // else {
    //     echo("Yikes");
    // }


?>

