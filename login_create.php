<?php
// var_dump($_POST);
// exit();

if (
    !isset($_POST['acount']) || $_POST['acount'] == '' ||
    !isset($_POST['password']) || $_POST['password'] == '' 
) {
    exit('ParamError');
}
// exit("ok");

$acount = $_POST['acount'];
$password = $_POST['password'];


// DB接続情報
$dbn = 'mysql:dbname=gsacf_l05_08;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
}

$sql =
'INSERT INTO users_table(id, acount, password, is_admin, is_deleted, created_at, updated_at) VALUES(NULL, :acount, :password,0,0, sysdate(), sysdate())';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':acount', $acount, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();  // データ登録失敗次にエラーを表示
    exit('sqlError:' . $error[2]);
} else {  // 登録ページへ移動
    header('Location:index.html');
};
