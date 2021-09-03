<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>todoリストユーザ登録画面</title>
</head>

<body>

  <form action="login_register_act.php" method="POST">

    <h1>メンバー登録</h1>

    <div>
      お名前: <input type="text" class="touroku_input" id="username" name="username" maxlength="20" validate="required blacklist" required>
    </div>

    <div>
      emailアドレス: <input type="email" class="touroku_input" id="email" name="email" validate="required blacklist mailadd" required>
    </div>

    <div>
      パスワード: <input type="password" class="touroku_input" id="password" name="password" validate="required blacklist alpNumeric" required>
    </div>

    <div>
      住所: <input type="text" class="touroku_input" id="address" name="address" validate="required blacklist" required>
    </div>

    <div>
      電話番号: <input type="text" class="touroku_input" id="tel" name="tel" validate="required blacklist alpNumeric" required>
    </div>

    <div>
      <button>登録</button>
    </div>

    <a href="login.php">ログイン</a>

  </form>


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