<?php

$str = ''; // 出力用の空の文字列
$file = fopen('data/data.csv', 'r'); // ファイルを開く（読み取り専用）
flock($file, LOCK_EX); // ファイルをロック
if ($file) {
    while ($line = fgets($file)) { // fgets()で1行ずつ取得→$lineに格納
        $str .= "<tr>
    <td>{$line}</td>
</tr>"; // 取得したデータを$strに入れる
    }
}
flock($file, LOCK_UN); // ロック解除
fclose($file); // ファイル閉じる
// （$strに全部の情報が入る！）

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <a href="index.html"></a>
    <div><?= $str ?></div>
</body>

</html>