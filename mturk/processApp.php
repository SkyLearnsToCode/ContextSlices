<?php

// get POST data from form
$description = $_POST['description'];
$location = $_POST['location'];
$confidence = $_POST['confidence'];
$why = $_POST['why'];
$assignmentID = $_POST['assignmentId'];
$workerID = $_POST['workerId'];
$img_id=$_POST['img'];
$endpoint = $_POST['endpoint'];

// connect to database
require_once './mysql.php';

// insert into database
$q = sprintf(" INSERT INTO app_db (worker_id, assignment_id, description, location, confidence, why, img_id, endpoint) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ",
    $workerID,
    $assignmentID,
    $description,
    $location,
    $confidence,
    $why,
	$img_id,
    $endpoint
    );
mysql_query($q);

// fetch number of entries in database
// see if we have enough to push worker to review page
// otherwise they're done

$minNumEntries = 1; // should correspond to num shown on review page

$q = sprintf(" SELECT * FROM app_db
    WHERE img_id = '%s'
    AND assignment_id != '%s' ",
    $img_id,
    $assignmentID
    );
$result = mysql_query($q);
if(mysql_num_rows($result) >= $minNumEntries) {
    // we have enough entries
    // redirect us to review page
    header('Location: app_db_2.php?img_id='.$img_id.'&assignment_Id='.$assignmentID.'&workerId='.$workerID);
} else {
    // redirect us to submit to MTurk
    header('Location: completed.php?assignmentId='.$assignmentID);  
}
