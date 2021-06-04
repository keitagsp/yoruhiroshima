<?php
// var_dump($_POST);
// exit();

if (
    !isset($_POST['nname']) || $_POST['nname'] == '' ||
    !isset($_POST['title']) || $_POST['title'] == '' ||
    !isset($_POST['artist']) || $_POST['artist'] == ''
) {
    exit('ParamError');
}
// exit("ok");

$nname = $_POST['nname'];
$title = $_POST['title'];
$artist = $_POST['artist'];


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

$sql = 'INSERT INTO recordbag(id, nname, title, artist, created_at) VALUES(NULL, :nname,:title, :artist, sysdate())';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':nname', $nname, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':artist', $artist, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();  // データ登録失敗次にエラーを表示
    exit('sqlError:' . $error[2]);
} else {  // 登録ページへ移動
    header('Location:recordbag_input.php');

};
