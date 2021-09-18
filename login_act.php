<?php
session_start();
include("functions.php");

$pdo = connect_to_db();

$username = $_POST["username"];
$password = $_POST["password"];

$sql = 'SELECT * FROM users_table WHERE username=:username AND password=:password';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

$val = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$val) {
  echo "<p>ログイン情報に誤りがあります．</p>";
  echo '<a href="login.php">login</a>';
  exit();
} else {
  $_SESSION = array();
  $_SESSION["session_id"] = session_id();
  $_SESSION["username"] = $val["username"];
  $_SESSION["email"] = $val["email"];
  header("Location:login_index.php");
  exit();
}
