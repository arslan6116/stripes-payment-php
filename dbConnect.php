<?php
// Connect with the database
$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Display error if failed tp connect
if ($db->connect_errno){
    printf("connect failed %s\n", $db->connect_error);
    exit();
}
