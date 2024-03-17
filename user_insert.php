<?php
include_once 'db.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$pass = $_POST['pass'];

//preverim ali so vnešeni vsi obvezni podatki
if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($pass)) {
    //vse ok
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $query = "INSERT INTO users(first_name, last_name, email, password, telephone) 
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$first_name,$last_name,$email,$pass,$telephone]);
    //preusmeri na login
    header("Location: login.php");
}
else {
    //preusmeri nazaj na registracijo
    header("Location: registration.php");
}
