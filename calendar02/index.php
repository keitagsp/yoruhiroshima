<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>カレンダー</title>
<!-- 任意のページに直接埋め込む場合にはCSSもコピペ下さい（オリジナルでももちろんOK）-->
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body id="index">

<!-- ▼▼▼ 任意のページに埋め込んで表示させたい場合（iframeを使わない）はここからコピペ ▼▼▼ -->
<?php require_once('config.php');//設定ファイルインクルード（config.phpへの相対パス）※設置箇所が変わる場合は要変更?>
<?php if(!$copyright) exit($warningMesse); else{ echo scheduleCalendarPc($ym,$timeStamp,$copyright);//カレンダー出力（カレンダー自体のタグ等を変更したい場合はconfig.php内を変更下さい）?>

<!--　▼以下休業日、定休日テキスト箇所。すべて削除してしまってオリジナルでももちろんOKです▼　-->
<p class="small"><?php if($closedText) echo $closedText ;//定休日テキスト（オリジナルも可）?><span class="holidayCube" style="background:<?php echo $holidayBg ;?>"></span>休業日</p>
<!--　▲休業日、定休日テキスト箇所ここまで▲　-->

<?php echo $copyright;}//著作権表記リンク無断削除禁止（削除すると全機能、または一部機能が失われます）?>
<!-- ▲▲▲ コピペここまで ▲▲▲ -->

</body>
</html>
