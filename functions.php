<?php

try {
    $db = new PDO('mysql:dbname=heroku_c1e6e970159724e;host=us-cdbr-east-04.cleardb.com;charset=utf8', 'baed42e817e38d', 'd14966da');
} catch (PDOException $e) {
    print('DB接続エラー:' . $e->getMessage());
}


function connect_to_db()
{
    $dbn = 'mysql:dbname=yoru;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        $db = new PDO('mysql:dbname=heroku_c1e6e970159724e;host=us-cdbr-east-04.cleardb.com;charset=utf8', 'baed42e817e38d', 'd14966da');
    } catch (PDOException $e) {
        print('DB接続エラー:' . $e->getMessage());
    }
}

function check_session_id()
{
    if (
        !isset($_SESSION["session_id"]) ||
        $_SESSION["session_id"] != session_id()
    ) {
        header("Location:login.php");
    } else {
        session_regenerate_id(true);
        $_SESSION["session_id"] = session_id();
    }
}
