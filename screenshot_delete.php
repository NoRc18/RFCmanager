<?php

include_once 'session.php';
include_once 'db.php';

$id = $_GET['id'];
$user_id = $_SESSION['id'];


//preverim ali so vnešeni vsi obvezni podatki
if (!empty($id)) {
    $query = "SELECT * FROM screenshots WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $picture = $stmt->fetch();

    //vse ok
    $query = "DELETE FROM screenshots WHERE id = ? AND 
                           (rfc_id IN (SELECT id 
                                        FROM rfc 
                                        WHERE user_id=?))";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id, $user_id]);

    $deleted = $stmt->rowCount();
    //vrne nam št. izbrisanih vrstic
    if ($deleted > 0) {
        unlink($picture['url']);
    }
}

//preusmeri nazaj
header("Location: view_rfc.php?id=$id");