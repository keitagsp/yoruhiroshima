<?php
session_start();
include("functions.php");
check_session_id();


// ログイン状態チェック
if (!isset($_SESSION["username"])) {
    header("Location: Logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>支払い内容確認</title>
</head>

<body>
    <?php echo htmlspecialchars($_SESSION["username"]); ?>
</body>

</html>