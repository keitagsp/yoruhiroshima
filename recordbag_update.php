<?php

$todo = $_POST['todo'];
$deadline = $_POST['deadline'];
$id = $_POST['id'];

include('functions.php');
$pdo = connect_to_db();


$sql = 'UPDATE todo_table SET todo=:todo, deadline=:deadline, update_at=sysdate() WHERE id=id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // $record = $stmt->fetch(PDO::FETCH_ASSOC);
    header("Location:todo_read.php");
    exit();
}


