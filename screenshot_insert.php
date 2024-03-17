<?php
include_once 'session.php';
include_once 'db.php';

$id = $_POST['id'];
$description = $_POST['description'];
$target_dir = "slike/";
$target_file = $target_dir . date("YmdHisu"). basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $uploadOk = 0;
}

// Check if $uploadOk is set to 1
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //zapis v bazo
        $query = "INSERT INTO screenshots (url,description,rfc_id) VALUES(?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$target_file,$description, $id]);
    }
}

header("Location: view_rfc.php?id=$id");

?>