<?php

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

$sql = 'SELECT * FROM recordbag';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();



if ($status == false) {
    $error = $stmt->errorInfo();  // データ登録失敗次にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["nname"]}</td>";
        $output .= "<td>{$record["title"]}</td>";
        $output .= "<td>{$record["artist"]}</td>";
        $output .= "</tr>";
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=MuseoModerno:wght@100&display=swap');
    </style>
    <link rel="stylesheet" type="text/css" href="http://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/move02/5-9/css/reset.css">
    <link rel="stylesheet" type="text/css" href="http://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/move02/5-9/css/5-9.css">
    <link rel="stylesheet" type="text/css" href="http://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/move02/5-9/css/reset.css">
    <link rel="stylesheet" type="text/css" href="http://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/move02/5-9/css/5-9.css">
    <link rel="stylesheet" type="text/css" href="css/5-3-1.css">
    <link rel="stylesheet" type="text/css" href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css">
    <link rel="stylesheet" type="text/css" href="css/5-9.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Abel&family=Amatic+SC&family=Fira+Sans:wght@200;400&family=IBM+Plex+Sans&family=Montserrat:wght@100&family=Open+Sans:wght@300&family=Roboto:wght@100;300;400&family=Ropa+Sans&family=Yantramanav:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/7-1-7.css">



    <title>DB連携型todoリスト（一覧画面）</title>
</head>

<body>
    <fieldset>
        <legend>DB連携型todoリスト（一覧画面）</legend>
        <a href="recordbag_input.php">入力画面</a>
        <table>
            <thead>
                <tr>
                    <th>nname</th>
                    <th>title</th>
                    <th>artist</th>
                </tr>
            </thead>
            <tbody>
                <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
                <?= $output ?>
            </tbody>
        </table>
    </fieldset>
</body>

</html>