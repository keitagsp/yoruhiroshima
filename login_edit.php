<?php
// var_dump($_GET);
// exit();
$id = $_GET['id'];

include('functions.php');
$pdo = connect_to_db();

$sql = 'SELECT * FROM login WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($record);
    // exit();
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携型todoリスト（編集画面）</title>
</head>

<body>
    <form action="recoredbag_update.php" method="POST">
        <fieldset>
            <legend>DB連携型todoリスト（編集画面）</legend>
            <a href="recoredbag_read.php">一覧画面</a>
            <div>
                nname: <select name="nname" value="<?= $record['nname'] ?>">
                    <option>keita</option>
                    <option>はっしー(小4)</option>
                    <option>ひげの波動拳</option>
                    <option>さやパス</option>
                    <option>たろ様</option>
                    <option>あべちゃん</option>
                    <option>わかまつさん</option>
                </select>
            </div>
            <div>
                title: <input type="text" name="title" value="<?= $record['title'] ?>">
            </div>
            <div>
                artist: <input type="text" name="artist" value="<?= $record['artist'] ?>">
            </div>
            <div>
                id: <input type="text" name="id" value="<?= $record['id'] ?>">
            </div>

            <div>
                <button>submit</button>
            </div>

        </fieldset>
    </form>

</body>

</html>