<?php
session_start();
include("functions.php");

try {
  $db = new PDO('mysql:dbname=heroku_c1e6e970159724e;host=us-cdbr-east-04.cleardb.com;charset=utf8', 'baed42e817e38d', 'd14966da');
} catch (PDOException $e) {
  print('DB接続エラー:' . $e->getMessage());
}


$username = $_POST["username"];
$password = $_POST["password"];

$sql = 'SELECT * FROM users_table WHERE username=:username AND password=:password AND is_deleted=0';

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
  $_SESSION["is_admin"] = $val["is_admin"];
  $_SESSION["username"] = $val["username"];
  $_SESSION["id"] = $val["id"];
  header("Location:login_index.php");
  exit();
}
