<?php
// var_dump($_POST);
// exit();

$name = $_POST["name"]; //データを受け取り
$email = $_POST["email"];
$posi = $_POST["posi"];
$question = $_POST["question"];
$write_data = "{$name},{$email},{$posi},{$question}\n";//$write_dataはnameとemail
$file = fopen('data/data.csv','a');// ファイルを開く 引数はa
flock($file,LOCK_EX); //ファイルをロック
fwrite($file, $write_data);// データに書き込み，
flock($file, LOCK_UN);
fclose($file);
header("Location:index.html");