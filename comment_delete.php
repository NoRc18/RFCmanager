<?php
include_once 'session.php';
include_once 'db.php';

$id = $_GET['id'];
$user_id = $_SESSION['id'];
$it = $_SESSION['it'];

//preverim ali so vnešeni vsi obvezni podatki
if (!empty($id)) {
    //vse ok
    $query = "DELETE FROM comments WHERE id = ? AND 
                           (user_id =? OR 1=?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id, $user_id,$it]);
    if ($stmt->rowCount()>0) {
        msg('Uspešno izbrisan komentar','success');
    }
    else {
        msg('Napaka','danger');
    }
}

//preusmeri nazaj
header("Location: view_rfc.php?id=$id");