<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <style>
        @import url('https://fonts.googleapis.com/css2?family=MuseoModerno:wght@100&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: black;
            font-weight: 100;
            color: white;
        }

        .header {
            width: 100%;
            display: flex;
            align-items: center;
            color: white;
            font-size: 20px;
        }

        .minitsuki {
            padding-left: 20px;
        }

        .header_text {
            margin: 10px 0 0 auto;
            display: flex;
            justify-content: space-between;
        }

        .gnavi {
            display: flex;
            list-style: none;
        }

        .gnavi li a {
            display: block;
            padding: 10px 30px;
            text-decoration: none;
        }

        .gnavi li {
            margin-bottom: 20px;
        }


        .gnavi li a {
            /*線の基点とするためrelativeを指定*/
            position: relative;
        }

        .gnavi li.current a,
        .gnavi li a:hover {
            color: white;
        }

        .gnavi li a::after {
            content: '';
            /*絶対配置で線の位置を決める*/
            position: absolute;
            bottom: 0;
            left: 10%;
            /*線の形状*/
            width: 80%;
            height: 2px;
            background: white;
            /*アニメーションの指定*/
            transition: all .6s;
            transform: scale(0, 1);
            /*X方向0、Y方向1*/
            transform-origin: center top;
            /*上部中央基点*/
        }


        .gnavi li.current a::after,
        .gnavi li a:hover::after {
            transform: scale(1, 1);
            /*X方向にスケール拡大*/
        }

        .main {
            margin-top: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
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
    <title>yoru</title>
</head>


<body>

    <div class="header">
        <div>
            <a href="index.html" class="minitsuki"><img src="../yoruHP/img/minitsukikuro.jpg" alt=""></a>
        </div>

        <div class="header_text">
            <ul class="gnavi">
                <li><a href="#">Home</a></li>
                <li><a href="#">News</a></li>
                <li><a href="#">Goods</a></li>
                <li><a href="recordbag_input.php">Record Bag</a></li>
                <li><a href="#">Access</a></li>
                <li><a href="login_input.php">Login</a></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <form action="login_create.php" method="post">

            <div class="contact_form">
                <table class="contact_form_table">
                    <tr>
                        <td>アカウント名</td>
                        <td class="form_text">
                            <input type="text" name="acount">
                        </td>
                    </tr>
                    <tr>
                        <td>パスワード</td>
                        <td class="form_text">
                            <input type="text" name="password">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="underlinecome"></div>
                            <button class="中央から外 bgcenterout 送信">送信</button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>

</body>


</html>