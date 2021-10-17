<?php
include('functions.php');
// var_dump($_POST);
// exit("ok");

if (
  !isset($_POST['email']) || $_POST['email'] == ''||
  !isset($_POST['name']) || $_POST['name'] == ''||
  !isset($_POST['count']) || $_POST['count'] == ''
) {
    echo json_encode(["error_msg" => "no input"]);
    exit();
}

$email = $_POST["email"];
$name = $_POST["name"];
$count = $_POST["count"];

$pdo = connect_to_db();

$sql = 'INSERT INTO ticket(id, email, name, count, created_at) VALUES(NULL,:email, :name, :count, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':count', $count, PDO::PARAM_STR);

$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    header("Location:buy_complet.html");
    exit();
}
