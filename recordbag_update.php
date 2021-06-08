<?php

$title = $_POST['title'];
$artist = $_POST['artist'];
$id = $_POST['id'];

include('functions.php');
$pdo = connect_to_db();


$sql = 'UPDATE recordbag SET title=:title, artist=:artist, update_at=sysdate() WHERE id=id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':artist', $artist, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // $record = $stmt->fetch(PDO::FETCH_ASSOC);
    header("Location:recordbag_read.php");
    exit();
}


