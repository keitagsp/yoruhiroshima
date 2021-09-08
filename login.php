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

    <!-- css--------------------------------------------------------------------------------------------------- -->

    <link rel="stylesheet" href="./css/login_main.css" media="screen and (min-width:600px)">
    <link rel="stylesheet" href="./css/login_small.css" media="screen and (max-width:600px)">
    <link rel="stylesheet" type="text/css" href="slick-1.8.1/slick/slick-theme.css" media="screen and (min-width:600px)">
    <link rel="stylesheet" type="text/css" href="slick-1.8.1/slick/small-slick-theme.css" media="screen and (max-width:600px)">
    <link rel="stylesheet" type="text/css" href="slick-1.8.1/slick/slick.css">


    <title>yoru</title>
</head>


<body>


    <div class="wrapper open_animation">

        <!-- ヘッダー -->
        <div class="header">
            <div class="minitsuki">
                <a href="index.html"><img src="./img/tsukikuro.png" alt=""></a>
            </div>
            <div class="btn-gNav">
                <span></span>
                <span></span>
            </div>
            <div class="header_text">
                <ul class="gnavi">
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="calender02.html">CALENDER</a></li>
                    <li><a href="audience.php">AUDIENCE</a></li>
                    <li><a href="https://suzuri.jp/keitagsp" target="_blank" rel="noopener noreferrer">GOODS</a></li>
                    <li><a href="party_dj.html">PARTY & DJ's</a></li>
                    <li><a href="#access">ACCESS</a></li>
                    <li><a href="login.php">LOGIN</a></li>
                </ul>
            </div>
        </div>


        <div class="form_parent">
            <form action="login_act.php" method="post">

                <div class="border_anime">
                    <p>LOGIN</p>
                </div>

                <div class="form_group">
                    <p class="item_label">アカウント名</p>
                    <p class="item_label_en">Acount Name</p>
                </div>
                <input class="input" type="text" name="username">


                <div class="form_group">
                    <p class="item_label">パスワード</p>
                    <p class="item_label_en">password</p>
                </div>
                <input class="input" type="text" name="password">

                <div>
                    <button class="button send">ログインする</button>
                </div>

                <div class="for_register">
                    <a href="login_register.php">[メンバー登録されていない方はこちら]</a>
                </div>

            </form>
        </div>
    </div>



    <script>
        $(function() {
            $('.btn-gNav').on("click", function() {

                $(this).toggleClass('open');
                $('.header_text').toggleClass('open');
            });

        });

        $(function() {
            $(window).on('load scroll', function() {
                $('.open_animation').each(function() {
                    //ターゲットの位置を取得
                    var target = $(this).offset().top;
                    //スクロール量を取得
                    var scroll = $(window).scrollTop();
                    //ウィンドウの高さを取得
                    var height = $(window).height();
                    //ターゲットまでスクロールするとフェードインする
                    if (scroll > target - height) {
                        //クラスを付与
                        $(this).addClass('open_active');
                    }
                });
            });
        });


        $(function() {
            $(window).on('load scroll', function() {
                $('.animation').each(function() {
                    //ターゲットの位置を取得
                    var target = $(this).offset().top;
                    //スクロール量を取得
                    var scroll = $(window).scrollTop();
                    //ウィンドウの高さを取得
                    var height = $(window).height();
                    //ターゲットまでスクロールするとフェードインする
                    if (scroll > target - height) {
                        //クラスを付与
                        $(this).addClass('active');
                    }
                });
            });
        });



        $(function() {
            $('.gNav-menu li a').on("click", function() {
                $('.header_text').removeClass('open');
            });
        });



        $('.slider').slick({
            dots: true, //スライドしたのドット
            arrows: false, //左右の矢印
            infinite: true, //スライドのループ
            pauseOnHover: false, //ホバーしたときにスライドを一時停止しない
            slidesToShow: 5,
            slidesToScroll: 5,
            responsive: [{
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }]
        });
    </script>

    <script src="js/main.js"></script>

</body>




</html>