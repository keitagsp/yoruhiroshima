<!DOCTYPE html>
<html lang="ja">

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
  <div class="wrapper">

    <div class="form_parent">
      <form action="login_register_act.php" method="post">

        <div class="border_anime">
          <p>SIGN UP</p>
        </div>


        <div class="form_group">
          <p class="item_label">アカウント名</p>
          <p class="item_label_en">Acount Name</p>
        </div>
        <input class="input" type="text" class="touroku_input" id="username" name="username" maxlength="20" validate="required blacklist" required>


        <div class="form_group">
          <p class="item_label">メール</p>
          <p class="item_label_en">Mail</p>
        </div>
        <input class="input" type="email" class="touroku_input" id="email" name="email" validate="required blacklist" required>


        <div class="form_group">
          <p class="item_label">パスワード</p>
          <p class="item_label_en">password</p>
        </div>
        <input class="input" type="text" class="touroku_input" id="password" name="password" validate="required blacklist" required>


        <div class="form_group">
          <p class="item_label">住所</p>
          <p class="item_label_en">Address</p>
        </div>
        <input class="input" type="text" class="touroku_input" id="address" name="address" validate="required blacklist" required>


        <div class="form_group">
          <p class="item_label">携帯電話番号</p>
          <p class="item_label_en">Mobile Telephone</p>
        </div>
        <input class="input" type="tel" class="touroku_input" id="mobile" name="mobile" validate="required blacklist" required>


        <div>
          <button class="button send">登録</button>
        </div>
        <div class="home">
          <a href="index.php">[ HOME ]</a>
        </div>


        <!-- <div class="for_register">
            <a href="login_register.php">[メンバー登録されていない方はこちら]</a>
          </div> -->

      </form>
    </div>
  </div>


  <div>
    <button>登録</button>
  </div>

  <a href="login.php">ログイン</a>

  </form>

  </div>
  </div>

  <script>
    $(document).ready(function() {
      /* 各フォームからフォーカスアウトしたときに実行 */
      $(":text,textarea,:password,#email").blur(function() {

        if ($(this).attr('validate').match("required")) {
          if ($(this).val() == "") {
            if ($(this).next().text() === "") {
              $(this).css("background-color", "#ffe8e8");

              $(this).after("<div class='vErrorMsg'>入力必須項目です</div>");
            }
            return true;
          } else {
            $(this).css("background-color", "#fff");

            if ($(this).next().text() !== "") $(this).next().remove();
          }
        }

        if ($(this).attr('validate').match("alpNumeric")) {
          if (!$(this).val().match(/^[a-zA-Z0-9]+$/g)) {
            if ($(this).next().text() === "") {
              $(this).after("<div class='vErrorMsg'>半角英数字のみで入力してください</div>");
            }
            return true;
          } else {
            if ($(this).next().text() !== "") $(this).next().remove();
          }
        }

        if ($(this).attr('validate').match("mailadd")) {
          if (!$(this).val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/g)) {
            if ($(this).next().text() === "") {
              $(this).after("<div class='vErrorMsg'>メールアドレスの形式で入力してください</div>");
            }
            return true;
          } else {
            if ($(this).next().text() !== "") $(this).next().remove();
          }
        }
      });

      /* 送信ボタンを押したときにエラーがあれば表示する */
      $('form').submit(function(e) {
        /* エラー表示時は送信不可 */
        if ($('div').hasClass('vErrorMsg') == true) {
          e.preventDefault();
          alert('すまない！入力エラーです。確認求む');
        }
      });
    });
  </script>

</body>

</html>