<?php
include_once 'session.php';
include_once 'db.php';

$description = $_POST['comment'];
$id = $_POST['id'];
$user_id = $_SESSION['id'];

//preverim ali so vnešeni vsi obvezni podatki
if (!empty($id) && !empty($description)) {
    //vse ok
    $query = "INSERT INTO comments(description,date_add, user_id,rfc_id) 
                    VALUES (?,NOW(),?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$description,$user_id,$id]);
}
//preusmeri nazaj na rfc
header("Location: view_rfc.php?id=$id");

