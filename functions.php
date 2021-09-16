<?php

// try {
//     $db = new PDO('mysql:dbname=heroku_11606bd7c89837a;host=us-cdbr-east-04.cleardb.com;charset=utf8', 'b090d986427bac', '188cdc2c');
// } catch (PDOException $e) {
//     print('DB接続エラー:' . $e->getMessage());
// }


// function connect_to_db()
// {
//     $dbn = 'mysql:dbname=yoru;charset=utf8;port=3306;host=localhost';
//     $user = 'root';
//     $pwd = '';

//     try {
//         return new PDO($dbn, $user, $pwd);
//     } catch (PDOException $e) {
//         echo json_encode(["db error" => "{$e->getMessage()}"]);
//         exit();
//     }
// }



function connect_to_db()
{
    $dbn = 'mysql:dbname=heroku_11606bd7c89837a;host=us-cdbr-east-04.cleardb.com;charset=utf8';
    $user = 'b090d986427bac';
    $pwd = '188cdc2c';

    try {
        return new PDO($dbn, $user, $pwd);
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
