<?php

session_start();

if ( !isset(  $_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()){
    header("Location:no_login.html");
    exit();
}

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

    <link rel="stylesheet" href="./css/audience.css" media="screen and (min-width:600px)">
    <link rel="stylesheet" href="./css/audience_small.css" media="screen and (max-width:600px)">
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
            <div class="shearing">
                <a href="shearing_date.html">SHARINGがあります</a>
            </div>
            <div class="btn-gNav">
                <span></span>
                <span></span>
            </div>
            <div class="header_text">
                <ul class="gnavi">
                    <li><a href="login_index.php">HOME</a></li>
                    <li><a href="calender02.html">CALENDER</a></li>
                    <li><a href="audience.html">AUDIENCE</a></li>
                    <li><a href="https://suzuri.jp/keitagsp" target="_blank" rel="noopener noreferrer">GOODS</a></li>
                    <li><a href="party_dj.html">PARTY & DJ's</a></li>
                    <li><a href="#access">ACCESS</a></li>
                </ul>
            </div>
        </div>

        <div class="main">
                <div class="border_anime">
                    <p>NEWS</p>
                </div>
            <div class="news">
                <p><a href="https://opensea.io/assets?locale=ja">
                2021.08.25のMelting PotをOpenseaに<br>出品しました！</a></p><br><br>
                <p><a href="https://opensea.io/assets?locale=ja">
                2021.03.15のBlok Partyが落札されました！</a></p>
            </div>
                <div class="border_anime">
                    <p>AUDIENCE</p>
                </div>
                
                
                <div class="horizontal_list">
                    <a href="party_detail.php" class="Party">
                        <div class="flyer">
                            <img src="./img/0429auditorylounge.jpg" alt="">
                        </div>
                
                        <div class="date">
                            <p class="Party_title">AUDITORY LOUNGE</p>
                            <div class="dj">
                                <p>YASU, GAKU</p>
                            </div>
                
                            <div class="time">
                                <p>04.29.THU</p>
                                <button class="by_ticket">Buy Ticket</button>
                            </div>
                        </div>
                    </a>
                
                    <a class="Party">
                        <div class="flyer">
                            <img src="./img/0402rondas.jpg" alt="">
                        </div>
                        <div class="date">
                            <p class="Party_title">ROMNDAS</p>
                
                            <div class="dj">
                                <p>TSUJI</p>
                            </div>
                            <div class="time">
                                <p>04.02.FRI</p>
                                <button class="by_ticket">Buy Ticket</button>
                            </div>
                        </div>
                    </a>
                    <a class="Party">
                        <div class="flyer">
                            <img src="./img/0418meltingpot.jpg" alt="">
                        </div>
                        <div class="date">
                            <p class="Party_title">MELTING POT</p>
                            <div class="dj">
                                <p>SEIJI, ONO</p>
                            </div>
                            <div class="time">
                                <p>04.18.SUN</p>
                                <button class="by_ticket">Buy Ticket</button>
                            </div>
                        </div>
                    </a>
                
                    <a class="Party">
                        <div class="flyer">
                            <img src="./img/0619cloud9.jpg" alt="">
                        </div>
                        <div class="date">
                            <p class="Party_title">CLOUD9</p>
                
                            <div class="dj">
                                <p>KANI</p>
                            </div>
                            <div class="time">
                                <p>06.19.SAT</p>
                                <button class="by_ticket">Buy Ticket</button>
                            </div>
                        </div>
                    </a>

                    <a class="Party">
                        <div class="flyer">
                            <img src="./img/anniversary_image.jpg" alt="">
                        </div>
                        <div class="date">
                            <p class="Party_title">28th ANNIVESARY PARTY</p>
                
                            <div class="dj">
                                <p>YORU ALL DJ'S</p>
                            </div>
                            <div class="time">
                                <p>7.10.SAT</p>
                                <button class="by_ticket">Buy Ticket</button>
                            </div>
                        </div>                
                    </a>
                </div>
        </div>
        
</div>



<script>

    $(function () {
        $('.btn-gNav').on("click", function () {

            $(this).toggleClass('open');
            $('.header_text').toggleClass('open');
        });
    });

</script>


    <script src="js/main.js"></script>
</body>
</html>