<?php


$delete_name = (isset($_POST['delete_name'])) ? htmlspecialchars($_POST['delete_name'], ENT_QUOTES, 'utf-8') : '';

session_start();

!isset($_SESSION["username"]);
!isset($_SESSION["email"]);

if ($delete_name != '') unset($_SESSION['products'][$delete_name]);

//合計の初期値は0
$total = 0;

$products = isset($_SESSION['products']) ? $_SESSION['products'] : [];

foreach ($products as $name => $product) {
    //各商品の小計を取得
    $subtotal = (int)$product['price'] * (int)$product['count'];
    //各商品の小計を$totalに足す
    $total += $subtotal;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- フォント--------------------------------------------------------------------------------------------------- -->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/yakuhanjp@3.2.0/dist/css/yakuhanjp.min.css">

    <link rel="stylesheet" href="https://use.typekit.net/opa4ojb.css">

    <!-- css--------------------------------------------------------------------------------------------------- -->

    <link rel="stylesheet" href="./css/buy_main.css" media="screen and (min-width:600px)">
    <link rel="stylesheet" href="./css/buy_small.css" media="screen and (max-width:600px)">

    <title>支払い内容確認</title>
</head>

<body>
    <?php
    echo ($_SESSION["username"]);
    echo ($_SESSION["email"]);
    ?>

    <div class="cartlist">
        <table class="cart-table">
            <tbody>
                <?php foreach ($products as $name => $product) : ?>
                    <tr>
                        <td label="商品名："><?php echo $name; ?></td>
                        <td label="価格：" class="text-right">¥<?php echo $product['price']; ?></td>
                        <td label="個数：" class="text-right"><?php echo $product['count']; ?></td>
                        <td label="小計：" class="text-right">¥<?php echo $product['price'] * $product['count']; ?></td>
                        <td>
                            <form action="buy.php" method="post">
                                <input type="hidden" name="delete_name" value="<?php echo $name; ?>">
                                <button type="submit" class="btn btn-red">削除</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total">
                    <th colspan="3">合計</th>
                    <td colspan="2">¥<?php echo $total; ?></td>
                </tr>
            </tbody>
        </table>
        <div class="cart-btn">
            <button type="button" class="btn btn-blue">購入手続きへ</button>
            <button type="button" class="btn btn-gray">戻る</button>
        </div>
    </div>

</body>

</html>