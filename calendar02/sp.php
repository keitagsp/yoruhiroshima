<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>カレンダー</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
<style>
h2{
	background:#333;
	border-radius:6px;
	color:#fff;
	text-align:center;
	padding:2px;
	text-shadow:none;
	font-size:120%;
	margin:3px;
}
/*土曜の文字色*/
.youbi_6{
	color:#36F;
}
/*祝日と日曜の文字色*/
.youbi_0,.shukujitu{
	color:red;
}
/*本日の背景色　※ただし設定ファイルでの設定が優先されます*/
.today{
	background:#FF9;
}
/*休業日設定した日の背景色　※ただし設定ファイルでの設定が優先されます*/
.holiday{
	background:#FDD;	
}
/*定休日設定した日の背景色　※ただし設定ファイルでの設定が優先されます*/
.closed{
	background:#FDD;	
}
.hidden{
	display:none;	
}
/*休業日テキスト部の左側の四角*/
.holidayCube{
	display:inline-block;
	width:13px;
	height:13px;
	margin:3px 3px 0 3px;
	position:relative;
	top:2px;
}
/*定休日テキスト部の左側の四角*/
.closedCube{
	display:inline-block;
	width:13px;
	height:13px;
	margin:3px 3px 0 3px;
	position:relative;
	top:2px;
}
.scheduleComment{
	font-size:80%;
	font-weight:normal;
	color:#333;
}
</style>
</head>
<body>
<div id="index" data-role="page" data-theme="d">
<?php 
require_once('config.php');//設定ファイルインクルード
if(!$copyright) exit($warningMesse); else {$scheduleCalendar = scheduleCalendarSp($ym,$timeStamp);
?>
<h2 style="background:<?php echo $headerBgColor;?>;color:<?php echo $headerColor;?>"><?php echo $scheduleCalendar['calnderHeaderYm'];?></h2>

<div data-role="controlgroup" data-type="horizontal" style="text-align:center">
<?php if(!empty($scheduleCalendar['dspPrev'])){ ?>
<a data-ajax="false" data-role="button" href="?ym=<?php echo $scheduleCalendar['dspPrev'];?>">&laquo; 前月へ</a>
<?php } ?>

<?php if(!empty($scheduleCalendar['dspNext'])){ ?>
<a data-ajax="false" data-role="button" href="?ym=<?php echo $scheduleCalendar['dspNext'];?>">翌月へ &raquo;</a>
<?php } ?>
</div><!-- /controlgroup -->

<!--　▼以下休業日、定休日テキスト箇所。すべて削除してしまってオリジナルでももちろんOKです▼　-->
<p class="small"><?php if($closedText) echo $closedText ;//定休日テキスト（オリジナルも可）?><span class="holidayCube" style="background:<?php echo $holidayBg ;?>"></span>休業日</p>
<!--　▲休業日、定休日テキスト箇所ここまで▲　-->

<ul data-role="listview" data-theme="d">
<?php echo $scheduleCalendar['body'];//カレンダー出力（カレンダー自体のタグ等を変更したい場合はconfig.php内を変更下さい）?>
</ul>

<div data-role="controlgroup" data-type="horizontal" style="text-align:center">
<?php if(!empty($scheduleCalendar['dspPrev'])){ ?>
<a data-ajax="false" data-role="button" href="?ym=<?php echo $scheduleCalendar['dspPrev'];?>">&laquo; 前月へ</a>
<?php } ?>

<?php if(!empty($scheduleCalendar['dspNext'])){ ?>
<a data-ajax="false" data-role="button" href="?ym=<?php echo $scheduleCalendar['dspNext'];?>">翌月へ &raquo;</a>
<?php } ?>
</div><!-- /controlgroup -->

<?php echo $copyright;}//著作権表記リンク無断削除禁止（削除すると全機能、または一部機能が失われます）?>
</div>
</body>
</html>
