<?php
include_once 'db.php';
include_once 'session.php';

$email = $_POST['email'];
$pass = $_POST['password'];

//print_r($_POST);

//preverim ali je user vnesel email in pass
if (!empty($email) && !empty($pass)) {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();


    if ($user && password_verify($pass, $user['password'])) {
        //podatki so pravilni
        msg("Uspešna prijava","success");
        $_SESSION['id'] = $user['id'];
        $_SESSION['it'] = $user['it'];
        header("Location: index.php");
    }
    else {
        msg("Napaka v podatkih.","danger");
        header("Location: login.php");
    }
}