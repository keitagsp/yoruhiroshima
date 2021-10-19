<?php
include('functions.php');
// var_dump($_POST);
// exit("ok");

if (
    !isset($_POST['email']) || $_POST['email'] == '' ||
    !isset($_POST['bank']) || $_POST['bank'] == '' ||
    !isset($_POST['name']) || $_POST['name'] == '' ||
    !isset($_POST['branch']) || $_POST['branch'] == '' ||
    !isset($_POST['number']) || $_POST['number'] == ''
) {
    echo json_encode(["error_msg" => "no input"]);
    exit();
}

$email = $_POST["email"];
$bank = $_POST["bank"];
$name = $_POST["name"];
$branch = $_POST["branch"];
$number = $_POST["number"];

$pdo = connect_to_db();

$sql = 'INSERT INTO pay(id, email, bank, name, branch, number, created_at) VALUES(NULL,:email, :bank, :name, :branch, :number, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $bank, PDO::PARAM_STR);
$stmt->bindValue(':bank', $bank, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':branch', $branch, PDO::PARAM_STR);
$stmt->bindValue(':number', $number, PDO::PARAM_STR);

$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    header("Location:complet.html");
}
