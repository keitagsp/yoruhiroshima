<?php
include("functions.php");

$pdo = connect_to_db();

session_start();

!isset($_SESSION["email"]);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jquery--------------------------------------------------------------------------------------------------- -->

    <script type="text/javascript" src="jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="slick-1.8.1/slick/slick.min.js"></script>
    <!-- フォント--------------------------------------------------------------------------------------------------- -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/yakuhanjp@3.2.0/dist/css/yakuhanjp.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/opa4ojb.css">
    <link rel="stylesheet" href="./css/shearing_pay.css" media="screen and (min-width:600px)">
    <link rel="stylesheet" href="./css/shearing_pay_small.css" media="screen and (max-width:600px)">

    <title>PAY</title>
</head>

<body>

    <div class="border_anime">
        <p>[ 受取り情報を入力して下さい ]</p>
    </div>

    <div class="form_parent">
        <form action="pay_act.php" method="POST">

            <div class="select_area">
                <div class="form_group">
                    <p class="item_label">受取り方法</p>
                </div>
                <select id="pay" onchange="viewChange();" name="posi">
                    <option value="select1">選んでください</option>
                    <option value="select2">LINE PAY</option>
                    <option value="select3">銀行振込</option>
                </select>
            </div>

            <input type="hidden" name="email" value="<?= ($_SESSION["email"]); ?> ">

            <div class="change_area">


                <div id="Box1">
                </div>

                <div id="Box2" style="display:none;">
                    <div class="form_group">
                        <p class="item_label">LINE PAY ナンバー</p>
                    </div>
                    <input class="input" type="text" name="name">
                </div>

                <div id="Box3" style="display:none;">

                    <div class="form_group">
                        <p class="item_label">金融機関名</p>
                    </div>
                    <input class="input" type="text" name="bank">
                    <div class="form_group">
                        <p class="item_label">口座名義</p>
                    </div>
                    <input class="input" type="text" name="name">
                    <div class="form_group">
                        <p class="item_label">支店名</p>
                    </div>
                    <input class="input" type="text" name="branch">
                    <div class="form_group">
                        <p class="item_label">口座番号</p>
                    </div>
                    <input class="input" type="text" name="number">

                </div>

            </div>
            <button class="button send">送信</button>

        </form>

    </div>



    <script>
        function viewChange() {
            if (document.getElementById('pay')) {
                id = document.getElementById('pay').value;
                if (id == 'select1') {
                    document.getElementById('Box1').style.display = "";
                    document.getElementById('Box2').style.display = "none";
                    document.getElementById('Box3').style.display = "none";
                } else if (id == 'select2') {
                    document.getElementById('Box1').style.display = "none";
                    document.getElementById('Box2').style.display = "";
                    document.getElementById('Box3').style.display = "none";
                } else if (id == 'select3') {
                    document.getElementById('Box1').style.display = "none";
                    document.getElementById('Box2').style.display = "none";
                    document.getElementById('Box3').style.display = "";
                }
            }

            window.onload = viewChange;
        }
    </script>


</body>

</html>