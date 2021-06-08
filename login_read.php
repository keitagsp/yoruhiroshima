<?php

include('functions.php');
$pdo = connect_to_db();



$sql = 'SELECT * FROM login WHERE is_deleted=0';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["acount"]}</td>";
        $output .= "<td>{$record["password"]}</td>";
        $output .= "<td>{$record["created_at"]}</td>";
        $output .= "<td>{$record["updated_at"]}</td>";
        // edit deleteリンクを追加
        $output .= "<td>
                  <a href='./users_edit.php?id={$record["id"]}'>edit</a>
                </td>";
        $output .= "<td>
                  <a href='./users_delete.php?id={$record["id"]}'>delete</a>
                </td>";
        $output .= "</tr>";
    }
    // $recordの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($record);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理画面（一覧画面）</title>
</head>

<body>
    <fieldset>
        <legend>ユーザー管理画面（一覧画面）</legend>
        <a href="users_input.php">入力画面</a>
        <table>
            <thead>
                <tr>
                    <th>username</th>
                    <th>password</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                </tr>
            </thead>
            <tbody>
                <?= $output ?>
            </tbody>
        </table>
    </fieldset>
</body>

</html>