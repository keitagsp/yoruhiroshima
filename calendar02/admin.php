<?php
#######################################################################################
##
#  PHP営業日カレンダー【Calendar02】　テキスト入力追加版　
#
#  営業日カレンダープログラムです。
#　任意のページにiframeで埋め込んで営業日カレンダーとして運用できます。
#  改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
##
#######################################################################################

header("Content-Type: text/html;charset=UTF-8");
header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
header("Last-Modified: ". gmdate("D, d M Y H:i:s"). " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

#設定ファイルインクルード
require_once('./config.php');
//----------------------------------------------------------------------
//  ログイン処理 (START)
//----------------------------------------------------------------------
session_name($session_name);
session_start();
authAdmin($userid,$password);
//----------------------------------------------------------------------
//  ログイン処理 (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
//  データ保存用ファイル、画像保存ディレクトリのパーミッションチェック (START)
//----------------------------------------------------------------------
$messe = permissionCheck($filePath,$closedFilePath,$commentFilePath,$dataDir,$perm_check01,$perm_check02,$perm_check03);
//----------------------------------------------------------------------
//  データ保存用ファイルのパーミッションチェック (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
//  書き込み・編集処理 (START)
//----------------------------------------------------------------------

if (isset($_POST['holiday_submit'])){
	
	//トークンチェック(CSRF対策のため追記 2020/07/20)
	if(empty($_SESSION['token']) || ($_SESSION['token'] !== $_POST['token'])){
		exit('ページ遷移エラー(トークン)');
	}
	$_SESSION['token'] = '';//トークン破棄
	
	$holidayWriteData = '';
	if(is_array($_POST['holiday_set'])){
		
		foreach($_POST['holiday_set'] as $val){
			  $holidayWriteData .= $val."\n";
		}
		
	}else{
		$holidayWriteData = '';
	}
		$fp = fopen($filePath, "r+b") or die("fopen Error!!");
		// 俳他的ロック
		if (flock($fp, LOCK_EX)) {
			ftruncate($fp,0);
			rewind($fp);
			fwrite($fp, $holidayWriteData);// 書き込み
		}
			fclose($fp);
			
	//コメントの登録
	$commentWriteData = '';
	if(is_array($_POST['comment'])){
		foreach($_POST['comment'] as $key => $val){
			  if(!empty($val)){
				$val = str_replace(array("\n","\r",",",'%'),array("<br />",'','、','％'),$val);
			  	$commentWriteData .= $key.','.$val."\n";
			  }
		}
	}
		$fp = fopen($commentFilePath, "r+b") or die("fopen Error!!");
		// 俳他的ロック
		if (flock($fp, LOCK_EX)) {
			ftruncate($fp,0);
			rewind($fp);
			fwrite($fp, $commentWriteData);// 書き込み
		}
			fclose($fp);
	
	
			
			
	$getYm = date('Y-m');
	if(isset($_GET['ym'])){
		$getYm = $_GET['ym'];
	}
	
	//定休日保存処理
	$closedWriteData = '';
	if(isset($_POST['closed'])){
		foreach($_POST['closed'] as $val){
			  $closedWriteData .= $val."\n";
		}
	}else{
			  $closedWriteData = '';
	}
		$fp = fopen($closedFilePath, "r+b") or die("fopen Error!!");
		// 俳他的ロック
		if (flock($fp, LOCK_EX)) {
			ftruncate($fp,0);
			rewind($fp);
			fwrite($fp, $closedWriteData);// 書き込み
		}
			fclose($fp);
	
	
	//再送信防止リダイレクト
	header("Location: ./complete.php?ym=$getYm");
	exit();
}
//----------------------------------------------------------------------
//  書き込み・編集処理 (END)
//----------------------------------------------------------------------


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>営業カレンダー管理画面</title>
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>
//トークンセット(CSRF対策のため追記 2020/07/20)
<?php $token = sha1(uniqid(mt_rand(), true)); $_SESSION['token'] = $token;?>
$(function(){	$('form').append('<input type="hidden" name="token" value="<?php echo $token;?>" />');	 });
</script>
</head>
<body id="admin">
<div id="wrapper">
<?php if(!$copyright){echo $warningMesse; exit;}else{ ?>
<?php if(!empty($messe))echo "<p class=\"fc_red api_error\">{$messe}</p>"; ?>
<?php if(@$_GET['mode'] == 'complete') echo '<p class="fc_red message_com">登録が完了しました</p>'; ?>
<div class="logout_btn"><a href="?logout=true">ログアウト</a></div>
<h1>営業カレンダー 管理画面</h1>
<h2>休業日設定</h2>
<p>休業日に設定したい日にチェックを入れて「登録」ボタンを押して下さい。<br />
コメントも入力可能です。（改行は維持されます。文字数があまり多いと見づらくなる場合があります）<br />
※登録は月ごとに行なってください（複数月を同時に更新することはできません）<br />
※一般的なHTMLタグも使用可能ですが記述間違いに注意下さい。</p>
<p><?php if($closedText) echo $closedText ;//定休日テキスト（オリジナルも可）?><span class="holidayCube" style="background:<?php echo $holidayBg;?>"></span>休業日</p>
<?php echo @scheduleCalendarAdmin();?>
<?php echo $copyright;}//著作権表記リンク無断削除禁止?>
</div>
</body>
</html>