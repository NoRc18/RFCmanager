<?php
include_once 'session.php';
include_once 'db.php';


$short_description = $_POST['short_description'];
$long_description = $_POST['long_description'];
$date_end = $_POST['date_end'];
$priority = $_POST['priority'];
$reasons = $_POST['reasons'];
$risks = $_POST['risks'];
$status = $_POST['status'];
$contractor_id = $_POST['contractor_id'];
$application_id = $_POST['application_id'];

$fileToUpload  = $_POST['fileToUpload'];
$description = $_POST['description'];

$user_id = $_SESSION['id'];
//preverim ali so vnešeni vsi obvezni podatki
if (!empty($short_description) && !empty($long_description) && !empty($date_end) && !empty($risks)) {
    //vse ok
    $query = "INSERT INTO rfc(short_description, long_description, date_add, date_end, priority, reasons, risks, status, contractor_id, application_id, user_id) 
                    VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$short_description,$long_description, $date_end, $priority, $reasons, $risks, $status, $contractor_id, $application_id, $user_id]);
    $rfc_id = $pdo->lastInsertId();

if (!empty($fileToUpload) && !empty($description)){
    $query = "INSERT INTO screenshots (url, description, rfc_id)
                    VALUES (?,?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$url, $description, $rfc_id]);
}
    //preusmeri na seznam
    header("Location: index.php");
die();
}
else {
    //preusmeri nazaj na dodajanje
    header("Location: add_rfc.php");
    die();
}
