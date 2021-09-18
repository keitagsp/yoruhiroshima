<?php

$name = (isset($_POST['name'])) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
$price = (isset($_POST['price'])) ? htmlspecialchars($_POST['price'], ENT_QUOTES, 'utf-8') : '';
$count = (isset($_POST['count'])) ? htmlspecialchars($_POST['count'], ENT_QUOTES, 'utf-8') : '';

session_start();

//もし、sessionにproductsがあったら
if (isset($_SESSION['products'])) {
    //$_SESSION['products']を$productsという変数にいれる
    $products = $_SESSION['products'];
    //$proeuctsをforeachで回し、キー(商品名)と値（金額・個数）取得
    foreach ($products as $key => $product) {
        //もし、キーとPOSTで受け取った商品名が一致したら、
        if ($key == $name) {
            //既に商品がカートに入っているので、個数を足し算する     
            $count = (int)$count + (int)$product['count'];
        }
    }
}
//配列に入れるには、$name,$count,$priceの値が取得できていることが前提なのでif文で空のデータを排除する
if ($name != '' && $count != '' && $price != '') {
    $_SESSION['products'][$name] = [
        'count' => $count,
        'price' => $price
    ];
    header("Location:buy.php");
    exit();

}
$products = isset($_SESSION['products']) ? $_SESSION['products'] : [];
?>


<!DOCTYPE html>
<html lang="en">
<html>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jquery--------------------------------------------------------------------------------------------------- -->

    <script type="text/javascript" src="./js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="slick-1.8.1/slick/slick.min.js"></script>

    <!-- フォント--------------------------------------------------------------------------------------------------- -->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/yakuhanjp@3.2.0/dist/css/yakuhanjp.min.css">

    <link rel="stylesheet" href="https://use.typekit.net/opa4ojb.css">

    <!-- css--------------------------------------------------------------------------------------------------- -->

    <link rel="stylesheet" href="./css/party_detail.css" media="screen and (min-width:600px)">
    <link rel="stylesheet" href="./css/party_detail_small.css" media="screen and (max-width:600px)">
    <link rel="stylesheet" type="text/css" href="slick-1.8.1/slick/slick-theme.css" media="screen and (min-width:600px)">
    <link rel="stylesheet" type="text/css" href="slick-1.8.1/slick/small-slick-theme.css" media="screen and (max-width:600px)">
    <link rel="stylesheet" type="text/css" href="slick-1.8.1/slick/slick.css">


    <title>yoru</title>

</head>

</html>

<body>


    <div class="wrapper open_animation">

        <!-- ヘッダー -->
        <div class="header">
            <div class="btn-gNav">
                <span></span>
                <span></span>
            </div>
            <div class="header_text">
                <ul class="gnavi">
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="calender02.html">CALENDER</a></li>
                    <li><a href="no_login.html">AUDIENCE</a></li>
                    <li><a href="https://suzuri.jp/keitagsp" target="_blank" rel="noopener noreferrer">GOODS</a></li>
                    <li><a href="party_dj.html">PARTY & DJ's</a></li>
                    <li><a href="#access">ACCESS</a></li>
                    <li><a href="login.php">LOGIN</a></li>
                </ul>
            </div>
        </div>
        <form action="party_detail.php" method="POST" class="Party">

            <div class="flyer">
                <img src="./img/0429auditorylounge.jpg" alt="">
            </div>

            <div class="date">
                <p class="Party_title">AUDITORY LOUNGE</p>
                <div class="dj">
                    <p>YASU, GAKU</p>
                </div>

                <div class="time_price_ticket">
                    <div class="time_price">
                        <p>2021.04.29.THU</p>
                        <p>Open　22:00</p>
                        <p><br>Entrance　2000yen</p>
                    </div>

                    <div class="ticket">
                        <p>数量</p>
                        <input type="text" name="count" value="1">
                        <input type="hidden" name="name" value="AUDITORY_LOUNGE">
                        <input type="hidden" name="price" value="2000">
                        <!-- <button class="btn-sm btn-blue">カートに入れる</button> -->
                    </div>
                </div>
            </div>
            <button type="submit" class="by_ticket">BUY TICKET</button>
        </form>

    </div>



    <script>
        $(function() {
            $('.gNav-menu li a').on("click", function() {
                $('.header_text').removeClass('open');
            });
        });
    </script>


    <script src="js/main.js"></script>
</body>

</html>