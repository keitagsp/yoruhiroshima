<?php
include('functions.php');

if (
  !isset($_POST['username']) || $_POST['username'] == ''||
  !isset($_POST['email']) || $_POST['email'] == ''||
  !isset($_POST['password']) || $_POST['password'] == ''||
  !isset($_POST['address']) || $_POST['address'] == ''||
  !isset($_POST['mobile']) || $_POST['mobile'] == ''

) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$address = $_POST["address"];
$mobile = $_POST["mobile"];


$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM users_table WHERE email=:email';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

if ($stmt->fetchColumn() > 0) {
  echo "<p>このメールアドレスは既に登録されています．</p>";
  echo '<a href="login.php">login</a>';
  exit();
}

$sql = 'INSERT INTO users_table(id, username, email, password, address, mobile, created_at, updated_at) VALUES(NULL, :username, :email, :password, :address, :mobile, sysdate(), sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':mobile', $mobile, PDO::PARAM_STR);

$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:login.php");
  exit();
}
