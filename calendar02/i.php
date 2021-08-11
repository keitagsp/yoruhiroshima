<?php 
$agent = $_SERVER['HTTP_USER_AGENT'];
if(preg_match("/^DoCoMo/i", $agent)){
	header('Content-type: application/xhtml+xml');//docomoの場合のみ出力（CSS対応化のため）
}
?>
<?php echo"<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title>カレンダー</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
</head>
<body>
<?php 
require_once('config.php');//設定ファイルインクルード
if(!$copyright) exit($warningMesse); else {$scheduleCalendar = scheduleCalendarMb($ym,$timeStamp);
?>
<table width="100%" bgcolor="<?php echo $headerBgColor;?>" style="color:<?php echo $headerColor;?>;font-size:large;background-color:<?php echo $headerBgColor;?>;"><tr><td align="center"><font color="<?php echo $headerColor;?>"><?php echo $scheduleCalendar['calnderHeaderYm'];?></font></td></tr></table>

<table width="100%">
<tr>
<?php if(!empty($scheduleCalendar['dspPrev'])){ ?>
<td align="left"><a href="?ym=<?php echo $scheduleCalendar['dspPrev'];?>">&laquo; 前月へ</a></td>
<?php } ?>

<?php if(!empty($scheduleCalendar['dspNext'])){ ?>
<td align="right"><a href="?ym=<?php echo $scheduleCalendar['dspNext'];?>">翌月へ &raquo;</a></td>
<?php } ?>
</tr>
</table>

<!--　▼以下休業日、定休日テキスト箇所。すべて削除してしまってオリジナルでももちろんOKです▼　-->
<table>
  <tr>
<?php if($closedText) { //定休日テキストを表示（背景色が休業日と違ったら） ?>
    <td bgcolor="<?php echo $closedBg; ?>" width="10">&nbsp;&nbsp;</td>
    <td><font size="2">定休日</font></td>
<?php } ?>
    <td bgcolor="<?php echo $holidayBg;//休業日のテキスト ?>" width="10">&nbsp;&nbsp;</td>
    <td><font size="2">休業日</font></td>
  </tr>
</table>
<!--　▲休業日、定休日テキスト箇所ここまで▲　-->
<hr />

<?php echo $scheduleCalendar['body'];//カレンダー出力（カレンダー自体のタグ等を変更したい場合はconfig.php内を変更下さい）?>

<table width="100%">
<tr>
<?php if(!empty($scheduleCalendar['dspPrev'])){ ?>
<td align="left"><a href="?ym=<?php echo $scheduleCalendar['dspPrev'];?>">&laquo; 前月へ</a></td>
<?php } ?>

<?php if(!empty($scheduleCalendar['dspNext'])){ ?>
<td align="right"><a href="?ym=<?php echo $scheduleCalendar['dspNext'];?>">翌月へ &raquo;</a></td>
<?php } ?>
</tr>
</table>

<?php echo $copyright;}//著作権表記リンク無断削除禁止（削除すると全機能、または一部機能が失われます）?>
</body>
</html>
