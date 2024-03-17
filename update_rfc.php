<?php
include_once 'session.php';
include_once 'db.php';

$id = $_POST['id'];
$short_description = $_POST['short_description'];
$long_description = $_POST['long_description'];
$date_end = $_POST['date_end'];
$priority = $_POST['priority'];
$reasons = $_POST['reasons'];
$risks = $_POST['risks'];
$status = $_POST['status'];
$contractor_id = $_POST['contractor_id'];
$application_id= $_POST['application_id'];

$user_id = $_SESSION['id'];


//preverim ali so vnešeni vsi obvezni podatki
if (!empty($short_description) && !empty($long_description) && !empty($priority) && !empty($date_end) && !empty($reasons)
    && !empty($risks) && !empty($status) && !empty($contractor_id) && !empty($application_id)) {
    //vse ok
    $query = "UPDATE rfc SET short_description=?, long_description=?, date_end=?, priority=?, reasons=?, risks=?, status=?, contractor_id=?, 
               application_id=? WHERE id=? AND user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$short_description,$long_description, $date_end, $priority,$reasons, $risks, $status, $contractor_id, $application_id, $id, $user_id]);

    //preusmeri na pogled rfcja
    header("Location: view_rfc.php?id=$id");
    die();
}
else {
    //preusmeri nazaj na domačo stran
    header("Location: index.php");
}
