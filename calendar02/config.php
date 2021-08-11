<?php //error_reporting(E_ALL | E_STRICT);//デバッグ
if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//
$userid = array();$password = array();
###############################################################################################
##
#  PHP営業日カレンダー【Calendar02】　テキスト入力追加版　ver1.0.2 (最終更新日2021.05.20)
#
#  営業日カレンダープログラムです。
#　任意のページにiframeで埋め込んで営業日カレンダーとして運用できます。
#  改造や改変は自己責任で行ってください。
#	
#  不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#　■□ 設定時の注意点 □■　
#　1，値（=の右側）は数字以外の文字列の場合シングルクォーテーション（'）で囲んでいます。
#　2，これをを外したり削除しないでください。後ろのセミコロン「;」も削除しないください。
#　3，またドルマーク（$）が付いている文字列は絶対に変更しないでください。
#　4，数字で設定しているものは必ず「半角数字」。※シングルクォーテーション（'）では囲まない。
#　これらを間違えるとプログラムが正常に動作しませんので注意下さい。
##
###############################################################################################
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {//PHP5.1.0以上の場合のみタイムゾーンを定義
	date_default_timezone_set('Asia/Tokyo');//タイムゾーンの設定（日本以外の場合には適宜設定ください）
}

//----------------------------------------------------------------------
// 　必須設定項目 (START)
//----------------------------------------------------------------------

//管理画面ログイン用パスワード（半角英数字と記号のみ）※必ず変更してください

$userid[]   = 'yoru';   // ユーザーID
$password[] = '0815';   // パスワード

//GoogleAPIからの祝日の自動取得を行うか（0=しない、1=する）※要GoogleAPIキー
//無効化し、手動で祝日用のデータファイルをアップする方法もあります。データファイルは当サイトで配布しています。（ただ、年1回の更新が必要になります）
$autoHoliDay = 0;

// 祝日自動取得用にGoogleで取得したAPIキーを記述して下さい。例「AIzayaguWCFVDSpEGXQxAvI-oXBIcT6XJ1ck」 （あくまで例です。こんな形式という意味です。これをそのまま使用できません）
// https://code.google.com/apis/console/ にて「Calendar API」を有効にし、左メニュー「認証情報」の「公開 API へのアクセス」→「キーを作成」→「サーバーキー」で取得できます。
// 自動取得を行わない場合には、空のままにし、下記の「GoogleAPIからの祝日の自動取得を行うかどうか」もOFFとして下さい。
$apiKey = '';

//セッション名（半角英数字とアンダーバーの組み合わせで指定下さい）
//ログイン認証に利用するセッション名です。通常はそのままで構いません。
//たとえば1つのサイトに当サイトのプログラムを複数設置する場合で、それぞれ別々の人間で管理するような場合には変更して下さい。
$session_name = 'SessionCalendar02';

//----------------------------------------------------------------------
// 　必須設定項目 (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
// 　任意設定（必要に応じて設定してください） (START)
//----------------------------------------------------------------------

//本日の背景色を変更する（0=しない、1=する）
//※デフォルトでは黄色の背景色になります。CSSで変更可能です。（休業日が設定された場合はそちらの色が優先）
$todayFlag = 1;

//上記で「する」場合の背景色(カラーコードのみ可)　※ガラケーのbgcolorでも使用するので6桁で指定ください。
$todayFlagBg = '#FFFF99';

//カレンダーで当月から何ヶ月前、何ヶ月後まで表示するか（ユーザ閲覧ページ用）※今月のみ表示したい場合は「0」を指定
$dispMonth = 1;

//ユーザ閲覧側ページで当月の前月以降を表示する（0=しない、1=する）※管理画面では常に表示されます
$flagHiddenPrev = 0;

//カレンダーで当月から何ヶ月前、何ヶ月後まで表示するか（管理画面用）※今月のみ表示したい場合は「0」を指定
$adminDispMonth = 6;

//休業日の背景色(カラーコードのみ可)　※ガラケーのbgcolorでも使用するので6桁で指定ください。
$holidayBg = '#FFDDDD';


/*

その他htmlソースを見ると分かりますが、タグや各セル、各曜日にはそれぞれclassを振っていますので、
style.cssのCSSを変更して自由にデザイン下さい
class="youbi_0"が日曜日でそのまま曜日ごとに連番が振られclass="youbi_6"が土曜日となっています。
カレンダーのタグや「日」、「月」などのテキストを変更したい場合は以下該当箇所にて直接変更可能です
※管理画面用と閲覧者用があります

*/

//----------------------------------------------------------------------
// 　任意設定（必要に応じて設定してください） (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
// 　マニアック設定（必要に応じて設定してください） (START)
//----------------------------------------------------------------------

//定休日の背景色(カラーコードのみ可)　※デフォルトは休業日と同じ　※ガラケーのbgcolorでも使用するので6桁で指定ください。
//定休日と休業日で背景色を変えたい場合は指定して下さい（隔週では指定できません）
//たとえば毎週月曜日が定休日で、その他に月に何日か休業日があるような場合に最適です
$closedBg = '#FFDDDD';

//定休日と休業日の背景色が違う場合に追加表示する「色 定休日」テキスト。（html部、テキスト部は変更可）
//表示処理は自動で行われますのでページをブラウザで直接確認してみて下さい。
//※直接index.phpを書き換えてオリジナルのテキストでももちろんOKです。
//携帯（ガラケー）版はi.phpに直接記述しています。
$closedTextOrigin = '<span class="closedCube" style="background:'.$closedBg.'"></span>定休日　';


//曜日の配列（英語表記に変更などが可能です。順番は変更不可）
$weekArray = array('日','月','火','水','木','金','土');

//カレンダーを表形式（テーブル）、または縦長のリスト形式で表示（0=表形式、1=リスト形式）PCのみ
//※デフォルトは表形式（テーブル）
$dspCalendar = 0;


//以下スマホ、ガラケーのみ

//ページ上部の「年月」部分の背景色　※ガラケーのbgcolorでも使用するので6桁で指定ください。
$headerBgColor = '#666666';

//ページ上部の「年月」部分の文字色　※ガラケーのbgcolorでも使用するので6桁で指定ください。
$headerColor = '#ffffff';

//----------------------------------------------------------------------
// 　マニアック設定（必要に応じて設定してください） (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
// 　変数定義,初期化(START)　※基本的に変更不可
//----------------------------------------------------------------------
	
	
//コメント保存用ファイルパス（変更不可）
$commentFilePath = dirname(__FILE__).'/data/comment_set.dat';

//定休日データファイルのパス（変更不可）
$filePath = dirname(__FILE__).'/data/holiday_set.dat';

//祝日データファイルのパス（変更不可）
$holidayFilePath = dirname(__FILE__).'/data/'.date('Y').'_holiday.dat';

//休業日データのパス（変更不可）
$closedFilePath = dirname(__FILE__).'/data/closed.dat';

//データ保存先ディレクトリ（変更不可）
$dataDir = dirname(__FILE__).'/data';//変更不可

//パラメータを取得
$ym = date("Y-m");	
if(isset($_GET['ym'])){
	$ym = $_GET['ym'];
}
//タイムスタンプを取得
$timeStamp = strtotime($ym ."-01");
if($timeStamp === false){
	$timeStamp = time();
}

//祝日データの保存とファイル生成（年が明けたら自動生成）
if($autoHoliDay == 1 && !file_exists($holidayFilePath) && is_writable($dataDir)){
	$messe = @buildHoliDay($holidayFilePath);
}

//定休日と休業日の背景色が違う場合に追加表示するテキストをセット
$closedText = '';
if($holidayBg != $closedBg){
	$closedText = $closedTextOrigin;
}

//パーミッションチェック用メッセージ
$perm_check01= " が書き込みできません。<br>パーミッションを書き込み可能なもの（「666」等<br>またはサーバのマニュアルなどを参照）に変更し、パーミッションチェックしてみてください。<br /><a href=\"admin.php?check=permission\">[変更したのでパーミッションチェックしてみる⇒]</a>";

$perm_check02= "<div align='center'>データ保存先ディレクトリのパーミッションが正しくありません。<br /><strong>data</strong>ディレクトリに書き込み可能なパーミッション（777等またはサーバのマニュアルなどを参照）を設定してください。<br /><a href=\"admin.php?check=permission\">[変更したのでパーミッションチェックしてみる⇒]</a></div>";

$perm_check03= "パーミッションはOKです！早速登録を行なってみてください。<a href=\"admin.php\">これを非表示にする</a>";

//----------------------------------------------------------------------
// 　変数定義,初期化 (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
// 　関数定義（基本的に変更不可） (START)
//----------------------------------------------------------------------
function h($string) {
  return htmlspecialchars($string, ENT_QUOTES,'utf-8');
}
//ログイン認証
function authAdmin($userid,$password){
	
	//ログアウト処理
	if(isset($_GET['logout'])){
		$_SESSION = array();
		session_destroy();//セッションを破棄
	}
	
	$error = '';
	# セッション変数を初期化
	if (!isset($_SESSION['auth'])) {
	  $_SESSION['auth'] = FALSE;
	}
	
	if (isset($_POST['userid']) && isset($_POST['password'])){
	  foreach ($userid as $key => $value) {
		if ($_POST['userid'] === $userid[$key] &&
			$_POST['password'] === $password[$key]) {
		  $oldSid = session_id();
		  session_regenerate_id(TRUE);
		  if (version_compare(PHP_VERSION, '5.1.0', '<')) {
			$path = session_save_path() != '' ? session_save_path() : '/tmp';
			$oldSessionFile = $path . '/sess_' . $oldSid;
			if (file_exists($oldSessionFile)) {
			  unlink($oldSessionFile);
			}
		  }
		  $_SESSION['auth'] = TRUE;
		  break;
		}
	  }
	  if ($_SESSION['auth'] === FALSE) {
		$error = '<div style="text-align:center;color:red">ユーザーIDかパスワードに誤りがあります。</div>';
	  }
	}
	if ($_SESSION['auth'] !== TRUE) {
echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理画面</title>
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body id="auth">{$error}
<div id="login_form">
<p class="taC">管理画面に入場するにはログインする必要があります。<br />管理者以外の入場は固くお断りします。</p>
<form action="admin.php" method="post">
<label for="userid">ユーザーID</label>
<input class="input" type="text" name="userid" id="userid" value="" style="ime-mode:disabled" />
<label for="password">パスワード</label>      
<input class="input" type="password" name="password" id="password" value="" size="30" />
<p class="taC">
<input class="button-primary" type="submit" name="login_submit" value="　ログイン　" />
</p>
</form>
</div>
</body>
</html>
EOF;
exit();
	}
}
//パーミッションチェック関数
function permissionCheck($filePath,$closedFilePath,$commentFilePath,$dataDir,$perm_check01,$perm_check02,$perm_check03){
	$messe = '';
	if(!is_writable($dataDir)){
		$messe = $perm_check02;
		exit($messe);
	}
	elseif (!is_writable($filePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$filePath).$perm_check01;
	}
	elseif(!is_writable($closedFilePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$closedFilePath).$perm_check01;
	}
	elseif(!is_writable($commentFilePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$commentFilePath).$perm_check01;
	}
	elseif(@$_GET['check']=='permission'){
		$messe = $perm_check03;
	}
	return $messe;
}

//カレンダー生成（一般ユーザー向け表示用）PC用表形式　※デフォルト
function scheduleCalendarTable($ym,$timeStamp){
global $todayFlag,$todayFlagBg,$filePath,$dispMonth,$holidayFilePath,$flagHiddenPrev,$closedFilePath,$closedBg,$holidayBg,$commentFilePath,$weekArray;

	$scheduleCalendar = '<table id="calendarTable">';

	//休業日データ取得
	$holidayArray = file($filePath);
	//祝日データを読み込み
	$shukujituArray = file_exists($holidayFilePath) ? file($holidayFilePath) : array();
	//定休日データの取得
	$closedArray = file($closedFilePath);
	
	//----------------------------------------------------------------------
	// 　コメントデータを取得 (START)
	//----------------------------------------------------------------------
	$commentArray = file($commentFilePath);
	//----------------------------------------------------------------------
	// 　コメントデータを取得 (END)
	//----------------------------------------------------------------------
	
	
	//今月、来月
	$prev = date("Y-m",mktime(0,0,0,date("m",$timeStamp)-1,1,date("Y",$timeStamp)));
	$next = date("Y-m",mktime(0,0,0,date("m",$timeStamp)+1,1,date("Y",$timeStamp)));
	
	$dspPrev = '<a href="?ym='.$prev.'">&laquo;</a>';//前月へのナビ
	
	if((strtotime($prev.'-01') < strtotime(date("Y-m-01",mktime(0,0,0,date("m")-$dispMonth,1,date("Y"))))) || ($flagHiddenPrev == 0 && strtotime($ym.'-01') <= strtotime(date('Y-m-01')))){
		$dspPrev = '';
	}
	
	$dspNext = '<a href="?ym='.$next.'">&raquo;</a>';//翌月へのナビ
	
	if(strtotime($next.'-01') > strtotime(date("Y-m-01",mktime(0,0,0,date("m")+$dispMonth,1,date("Y"))))){
		$dspNext = '';
	}
	
	$scheduleCalendar .= '
	<tr><th class="calendarHeader">'.$dspPrev.'</th><th colspan="5" class="calendarHeader">'.date("Y",$timeStamp) . "年" . date("n",$timeStamp). "月" .'</th><th class="calendarHeader">'.$dspNext.'</th></tr>
	<tr><th class="youbi_0">'.$weekArray[0].'</th><th>'.$weekArray[1].'</th><th>'.$weekArray[2].'</th><th>'.$weekArray[3].'</th><th>'.$weekArray[4].'</th><th>'.$weekArray[5].'</th><th class="youbi_6">'.$weekArray[6].'</th></tr>
	<tr>
	';
	
	//月末
	$lastDay = date("t", $timeStamp);
	
	//1日の曜日
	$youbi = date("w",mktime(0,0,0,date("m",$timeStamp),1,date("Y",$timeStamp)));
	
	//最終日の曜日
	$lastYoubi = date("w",mktime(0,0,0,date("m",$timeStamp)+1,0,date("Y",$timeStamp)));
	
	$scheduleCalendar .= str_repeat('<td></td>',$youbi);
	
	for($day = 1; $day <= $lastDay; $day++,$youbi++){
		
		
		//----------------------------------------------------------------------
		// 　コメント用タグ生成 (START)
		//----------------------------------------------------------------------
		$commentTag = '';
		if(count($commentArray) > 0){
			foreach($commentArray as $commentArrayVal){
				$commentArrayExp = explode(',',$commentArrayVal);
				if(strtotime($ym."-".$day) == strtotime($commentArrayExp[0]) ){
					$commentTag = '<div class="scheduleComment">'.rtrim($commentArrayExp[1]).'</div>';
					break;
				}
			}
		}
		//----------------------------------------------------------------------
		// 　コメント用タグ生成 (END)
		//----------------------------------------------------------------------
		
		//祝日の判定
		$shukujituClass = '';
		foreach($shukujituArray as $val){
			if(strtotime($ym."-".$day) == strtotime($val)){
				$shukujituClass = ' shukujitu';
				break;
			}
		}
		
		//定休日の場合はclassを付与し指定背景色を反映
		$holidayFlag = '';
		foreach($closedArray as $val){
			if($youbi % 7 == $val){
				$scheduleCalendar .= sprintf('<td class="closed youbi_%d'.$shukujituClass.'" style="background:'.$closedBg.'">%d'.$commentTag.'</td>',$youbi % 7, $day);
				$holidayFlag = 1;
				break;
			}
		}
		
		//休業日の場合はclassを付与し指定背景色を反映
		if($holidayFlag != 1){
			foreach($holidayArray as $val){
				if(strtotime($ym."-".$day) == strtotime($val)){
					$scheduleCalendar .= sprintf('<td class="holiday youbi_%d'.$shukujituClass.'" style="background:'.$holidayBg.'">%d'.$commentTag.'</td>',$youbi % 7, $day);
					$holidayFlag = 1;
					break;
				}
			}
		}
		
		if($holidayFlag != 1){
			//本日の場合はclassを付与
			if(strtotime($ym."-".$day) == strtotime(date("Y-m-d")) && $todayFlag == 1){
				$scheduleCalendar .= sprintf('<td class="today youbi_%d'.$shukujituClass.'" style="background:'.$todayFlagBg.'">%d'.$commentTag.'</td>',$youbi % 7, $day);
			}
			//デフォルト
			else{
				$scheduleCalendar .= sprintf('<td class="youbi_%d'.$shukujituClass.'">%d'.$commentTag.'</td>',$youbi % 7, $day);
			}
		}
		//土曜で行を変える
		if($youbi % 7 == 6){
			$scheduleCalendar .= "</tr><tr>";
		}
		//最終日以降空セル埋め
		if($day == $lastDay){
			$scheduleCalendar .= str_repeat('<td class="blankCell"></td>',(6 - $lastYoubi));
		}
	}
	$scheduleCalendar .= "</tr>\n";
	$scheduleCalendar .= "</table>\n";
	$scheduleCalendar = str_replace('<tr></tr>','',$scheduleCalendar);
	
	return $scheduleCalendar;
}
//カレンダー生成（一般ユーザー向け表示用）PC用リスト形式
function scheduleCalendarList($ym,$timeStamp){
global $todayFlag,$todayFlagBg,$filePath,$dispMonth,$holidayFilePath,$flagHiddenPrev,$closedFilePath,$closedBg,$holidayBg,$commentFilePath,$weekArray,$closedText;
	$scheduleCalendar = '';
	
	//休業日データ取得
	$holidayArray = file($filePath);
	//祝日データを読み込み
	$shukujituArray = file_exists($holidayFilePath) ? file($holidayFilePath) : array();
	//定休日データの取得
	$closedArray = file($closedFilePath);
	//コメントデータを取得
	$commentArray = file($commentFilePath);
	
	//今月、来月
	$prev = date("Y-m",mktime(0,0,0,date("m",$timeStamp)-1,1,date("Y",$timeStamp)));
	$next = date("Y-m",mktime(0,0,0,date("m",$timeStamp)+1,1,date("Y",$timeStamp)));
	
	$dspPrev = '<a href="?ym='.$prev.'">&laquo;前月</a>';//前月へのナビ
	
	if((strtotime($prev.'-01') < strtotime(date("Y-m-01",mktime(0,0,0,date("m")-$dispMonth,1,date("Y"))))) || ($flagHiddenPrev == 0 && strtotime($ym.'-01') <= strtotime(date('Y-m-01')))){
		$dspPrev = '';
	}
	
	$dspNext = '<a href="?ym='.$next.'">翌月&raquo;</a>';//翌月へのナビ
	
	if(strtotime($next.'-01') > strtotime(date("Y-m-01",mktime(0,0,0,date("m")+$dispMonth,1,date("Y"))))){
		$dspNext = '';
	}
	
	//NextPrevナビセット
	$navNextPrev = '
	<table class="navNextPrev">
	<tr><td class="dspPrev">'.$dspPrev.'</td><td class="dspNext">'.$dspNext.'</td></tr>
	</table>
	';
	
	//ヘッダ部の年月
	$scheduleCalendar .= '<h2 id="headerYm">'.date("Y",$timeStamp) . "年" . date("n",$timeStamp). "月".'</h2>';
	
	//NextPrevナビセットを出力
	$scheduleCalendar .= $navNextPrev;
	
	//リスト形式の場合には休業日テキストを上部にも表示
	$scheduleCalendar .= '<p class="small">';
	if($closedText){
		$scheduleCalendar .= $closedText;
	}
	$scheduleCalendar .= '<span class="holidayCube" style="background:'.$holidayBg.'"></span>休業日</p>';

	//月末
	$lastDay = date("t", $timeStamp);
	
	//1日の曜日
	$youbi = date("w",mktime(0,0,0,date("m",$timeStamp),1,date("Y",$timeStamp)));
	
	//最終日の曜日
	$lastYoubi = date("w",mktime(0,0,0,date("m",$timeStamp)+1,0,date("Y",$timeStamp)));
	
	$scheduleCalendar .= '<ul id="calendarList">';
	
	for($day = 1; $day <= $lastDay; $day++,$youbi++){
		
		$weeekText = '（'.$weekArray[($youbi % 7)].'）';
		//----------------------------------------------------------------------
		// 　コメント用タグ生成 (START)
		//----------------------------------------------------------------------
		$commentTag = '';
		if(count($commentArray) > 0){
			foreach($commentArray as $commentArrayVal){
				$commentArrayExp = explode(',',$commentArrayVal);
				if(strtotime($ym."-".$day) == strtotime($commentArrayExp[0]) ){
					$commentTag = '<div class="scheduleComment">'.rtrim($commentArrayExp[1]).'</div>';
					break;
				}
			}
		}
		//----------------------------------------------------------------------
		// 　コメント用タグ生成 (END)
		//----------------------------------------------------------------------
		//1日にclass追加
		$addClass = '';
		if($day == 1){
			$addClass = ' first-child';
		}
		
		//祝日の判定
		$shukujituClass = '';
		foreach($shukujituArray as $val){
			if(strtotime($ym."-".$day) == strtotime($val)){
				$shukujituClass = ' shukujitu';
				break;
			}
		}
		
		//定休日の場合はclassを付与し指定背景色を反映
		$holidayFlag = '';
		foreach($closedArray as $val){
			if($youbi % 7 == $val){
				$scheduleCalendar .= sprintf('<li class="closed youbi_%d'.$shukujituClass.$addClass.'" style="background:'.$closedBg.'">%d'.$weeekText.$commentTag.'</li>',$youbi % 7, $day);
				$holidayFlag = 1;
				break;
			}
		}
		
		//休業日の場合はclassを付与し指定背景色を反映
		if($holidayFlag != 1){
			foreach($holidayArray as $val){
				if(strtotime($ym."-".$day) == strtotime($val)){
					$scheduleCalendar .= sprintf('<li class="holiday youbi_%d'.$shukujituClass.$addClass.'" style="background:'.$holidayBg.'">%d'.$weeekText.$commentTag.'</li>',$youbi % 7, $day);
					$holidayFlag = 1;
					break;
				}
			}
		}
		
		if($holidayFlag != 1){
			//本日の場合はclassを付与
			if(strtotime($ym."-".$day) == strtotime(date("Y-m-d")) && $todayFlag == 1){
				$scheduleCalendar .= sprintf('<li class="today youbi_%d'.$shukujituClass.$addClass.'" style="background:'.$todayFlagBg.'">%d'.$weeekText.$commentTag.'</li>',$youbi % 7, $day);
			}
			//デフォルト
			else{
				$scheduleCalendar .= sprintf('<li class="youbi_%d'.$shukujituClass.$addClass.'">%d'.$weeekText.$commentTag.'</li>',$youbi % 7, $day);
			}
		}
	}
	$scheduleCalendar .= '</ul>';
	
	//NextPrevナビセットを出力
	$scheduleCalendar .= $navNextPrev;
	
	return $scheduleCalendar;
}

//PCの表示形式の判定（関数切り替え処理）
function scheduleCalendarPc($ym,$timeStamp,$copyright =''){
	global $dspCalendar,$warningMesse;
	if(empty($copyright)) {
		exit($warningMesse);
	}elseif($dspCalendar == 1){
		$res = scheduleCalendarList($ym,$timeStamp);
	}else{
		$res = scheduleCalendarTable($ym,$timeStamp);
	}
	return $res;
}

//カレンダー生成（一般ユーザー向け表示用）スマホ用
function scheduleCalendarSp($ym,$timeStamp){
global $todayFlag,$todayFlagBg,$filePath,$dispMonth,$holidayFilePath,$flagHiddenPrev,$closedFilePath,$closedBg,$holidayBg,$commentFilePath,$weekArray;
	$scheduleCalendar['body'] = '';
	
	//休業日データ取得
	$holidayArray = file($filePath);
	//祝日データを読み込み
	$shukujituArray = file_exists($holidayFilePath) ? file($holidayFilePath) : array();
	//定休日データの取得
	$closedArray = file($closedFilePath);
	//コメントデータを取得
	$commentArray = file($commentFilePath);
	
	//今月、来月
	$prev = date("Y-m",mktime(0,0,0,date("m",$timeStamp)-1,1,date("Y",$timeStamp)));
	$next = date("Y-m",mktime(0,0,0,date("m",$timeStamp)+1,1,date("Y",$timeStamp)));
	
	$scheduleCalendar['dspPrev'] = $prev;//前月へのナビ
	
	if((strtotime($prev.'-01') < strtotime(date("Y-m-01",mktime(0,0,0,date("m")-$dispMonth,1,date("Y"))))) || ($flagHiddenPrev == 0 && strtotime($ym.'-01') <= strtotime(date('Y-m-01')))){
		$scheduleCalendar['dspPrev'] = '';
	}
	
	$scheduleCalendar['dspNext'] = $next;//翌月へのナビ
	
	if(strtotime($next.'-01') > strtotime(date("Y-m-01",mktime(0,0,0,date("m")+$dispMonth,1,date("Y"))))){
		$scheduleCalendar['dspNext'] = '';
	}
	
	//ヘッダ部の年月
	$scheduleCalendar['calnderHeaderYm'] = date("Y",$timeStamp) . "年" . date("n",$timeStamp). "月";

	//月末
	$lastDay = date("t", $timeStamp);
	
	//1日の曜日
	$youbi = date("w",mktime(0,0,0,date("m",$timeStamp),1,date("Y",$timeStamp)));
	
	//最終日の曜日
	$lastYoubi = date("w",mktime(0,0,0,date("m",$timeStamp)+1,0,date("Y",$timeStamp)));
	
	for($day = 1; $day <= $lastDay; $day++,$youbi++){
		
		$weeekText = '（'.$weekArray[($youbi % 7)].'）';
		//----------------------------------------------------------------------
		// 　コメント用タグ生成 (START)
		//----------------------------------------------------------------------
		$commentTag = '';
		if(count($commentArray) > 0){
			foreach($commentArray as $commentArrayVal){
				$commentArrayExp = explode(',',$commentArrayVal);
				if(strtotime($ym."-".$day) == strtotime($commentArrayExp[0]) ){
					$commentTag = '<div class="scheduleComment">'.rtrim($commentArrayExp[1]).'</div>';
					break;
				}
			}
		}
		//----------------------------------------------------------------------
		// 　コメント用タグ生成 (END)
		//----------------------------------------------------------------------
		
		//祝日の判定
		$shukujituClass = '';
		foreach($shukujituArray as $val){
			if(strtotime($ym."-".$day) == strtotime($val)){
				$shukujituClass = ' shukujitu';
				break;
			}
		}
		
		//定休日の場合はclassを付与し指定背景色を反映
		$holidayFlag = '';
		foreach($closedArray as $val){
			if($youbi % 7 == $val){
				$scheduleCalendar['body'] .= sprintf('<li class="closed youbi_%d'.$shukujituClass.'" style="background:'.$closedBg.'">%d'.$weeekText.$commentTag.'</li>',$youbi % 7, $day);
				$holidayFlag = 1;
				break;
			}
		}
		
		//休業日の場合はclassを付与し指定背景色を反映
		if($holidayFlag != 1){
			foreach($holidayArray as $val){
				if(strtotime($ym."-".$day) == strtotime($val)){
					$scheduleCalendar['body'] .= sprintf('<li class="holiday youbi_%d'.$shukujituClass.'" style="background:'.$holidayBg.'">%d'.$weeekText.$commentTag.'</li>',$youbi % 7, $day);
					$holidayFlag = 1;
					break;
				}
			}
		}
		
		if($holidayFlag != 1){
			//本日の場合はclassを付与
			if(strtotime($ym."-".$day) == strtotime(date("Y-m-d")) && $todayFlag == 1){
				$scheduleCalendar['body'] .= sprintf('<li class="today youbi_%d'.$shukujituClass.'" style="background:'.$todayFlagBg.'">%d'.$weeekText.$commentTag.'</li>',$youbi % 7, $day);
			}
			//デフォルト
			else{
				$scheduleCalendar['body'] .= sprintf('<li class="youbi_%d'.$shukujituClass.'">%d'.$weeekText.$commentTag.'</li>',$youbi % 7, $day);
			}
		}
	}
	
	return $scheduleCalendar;
}
//カレンダー生成（一般ユーザー向け表示用）ガラケー用
function scheduleCalendarMb($ym,$timeStamp){
global $todayFlag,$todayFlagBg,$filePath,$dispMonth,$holidayFilePath,$flagHiddenPrev,$closedFilePath,$closedBg,$holidayBg,$commentFilePath,$weekArray;
	$scheduleCalendar['body'] = '';
	
	//休業日データ取得
	$holidayArray = file($filePath);
	//祝日データを読み込み
	$shukujituArray = file_exists($holidayFilePath) ? file($holidayFilePath) : array();
	//定休日データの取得
	$closedArray = file($closedFilePath);
	//コメントデータを取得
	$commentArray = file($commentFilePath);
	
	//今月、来月
	$prev = date("Y-m",mktime(0,0,0,date("m",$timeStamp)-1,1,date("Y",$timeStamp)));
	$next = date("Y-m",mktime(0,0,0,date("m",$timeStamp)+1,1,date("Y",$timeStamp)));
	
	$scheduleCalendar['dspPrev'] = $prev;//前月へのナビ
	
	if((strtotime($prev.'-01') < strtotime(date("Y-m-01",mktime(0,0,0,date("m")-$dispMonth,1,date("Y"))))) || ($flagHiddenPrev == 0 && strtotime($ym.'-01') <= strtotime(date('Y-m-01')))){
		$scheduleCalendar['dspPrev'] = '';
	}
	
	$scheduleCalendar['dspNext'] = $next;//翌月へのナビ
	
	if(strtotime($next.'-01') > strtotime(date("Y-m-01",mktime(0,0,0,date("m")+$dispMonth,1,date("Y"))))){
		$scheduleCalendar['dspNext'] = '';
	}
	
	//ヘッダ部の年月
	$scheduleCalendar['calnderHeaderYm'] = date("Y",$timeStamp) . "年" . date("n",$timeStamp). "月";

	//月末
	$lastDay = date("t", $timeStamp);
	
	//1日の曜日
	$youbi = date("w",mktime(0,0,0,date("m",$timeStamp),1,date("Y",$timeStamp)));
	
	//最終日の曜日
	$lastYoubi = date("w",mktime(0,0,0,date("m",$timeStamp)+1,0,date("Y",$timeStamp)));
	
	for($day = 1; $day <= $lastDay; $day++,$youbi++){
		
		$weeekText = '（'.$weekArray[($youbi % 7)].'）';
		//----------------------------------------------------------------------
		// 　コメント用タグ生成 (START)
		//----------------------------------------------------------------------
		$commentTag = '';
		if(count($commentArray) > 0){
			foreach($commentArray as $commentArrayVal){
				$commentArrayExp = explode(',',$commentArrayVal);
				if(strtotime($ym."-".$day) == strtotime($commentArrayExp[0]) ){
					$commentTag = '<div style="font-size:xx-small;text-align:left;color:#555555">'.rtrim($commentArrayExp[1]).'</div>';
					break;
				}
			}
		}
		//----------------------------------------------------------------------
		// 　コメント用タグ生成 (END)
		//----------------------------------------------------------------------
		
		//祝日の判定
		$shukujituClass = '';
		foreach($shukujituArray as $val){
			if(strtotime($ym."-".$day) == strtotime($val)){
				$shukujituClass = ' shukujitu';
				break;
			}
		}
		
		//----------------------------------------------------------------------
		// 　携帯版独自処理 (START)
		//----------------------------------------------------------------------
		//文字色をセット
		$mobileTextColor = '';
		
		if($youbi % 7 == 0 || $shukujituClass == ' shukujitu'){
			$mobileTextColor = 'red';
		}elseif($youbi % 7 == 6){
			$mobileTextColor = '#3366FF';
		}
		//----------------------------------------------------------------------
		// 　携帯版独自処理 (END)
		//----------------------------------------------------------------------
		
		//定休日の場合はclassを付与し指定背景色を反映
		$holidayFlag = '';
		foreach($closedArray as $val){
			if($youbi % 7 == $val){
				$scheduleCalendar['body'] .= sprintf('<div class="youbi_%d" bgcolor="'.$closedBg.'" style="background:'.$closedBg.'"><font color="'.$mobileTextColor.'">%d'.$weeekText.$commentTag.'</font></div><hr />',$youbi % 7, $day);
				$holidayFlag = 1;
				break;
			}
		}
		
		//休業日の場合はclassを付与し指定背景色を反映
		if($holidayFlag != 1){
			foreach($holidayArray as $val){
				if(strtotime($ym."-".$day) == strtotime($val)){
					$scheduleCalendar['body'] .= sprintf('<div class="youbi_%d" bgcolor="'.$holidayBg.'" style="background:'.$holidayBg.'"><font color="'.$mobileTextColor.'">%d'.$weeekText.$commentTag.'</font></div><hr />',$youbi % 7, $day);
					$holidayFlag = 1;
					break;
				}
			}
		}
		
		if($holidayFlag != 1){
			//本日の場合はclassを付与
			if(strtotime($ym."-".$day) == strtotime(date("Y-m-d")) && $todayFlag == 1){
				$scheduleCalendar['body'] .= sprintf('<div class="youbi_%d" bgcolor="'.$todayFlagBg.'" style="background:'.$todayFlagBg.'"><font color="'.$mobileTextColor.'">%d'.$weeekText.$commentTag.'</font></div><hr />',$youbi % 7, $day);
			}
			//デフォルト
			else{
				$scheduleCalendar['body'] .= sprintf('<div class="youbi_%d"><font color="'.$mobileTextColor.'">%d'.$weeekText.$commentTag.'</font></div><hr />',$youbi % 7, $day);
			}
		}
	}
	
	return $scheduleCalendar;
}

//カレンダー生成（管理画面用）
function scheduleCalendarAdmin(){
global $todayFlag,$todayFlagBg,$filePath,$adminDispMonth,$holidayFilePath,$holidayBg,$closedFilePath,$closedBg,$holidayBg,$commentFilePath,$weekArray;

	//パラメータをセット
	$getYm = date('Y-m');
	if(isset($_GET['ym'])){
		$getYm = $_GET['ym'];
	}
	
	//休日データ取得
	$holidayArray = file($filePath);
	
	//祝日データの取得
	$shukujituArray = file_exists($holidayFilePath) ? file($holidayFilePath) : array();
		
	//定休日データの取得
	$closedArray = file($closedFilePath);
	
	//----------------------------------------------------------------------
	// 　コメントデータを取得 (START)
	//----------------------------------------------------------------------
	$commentArray = file($commentFilePath);
	//----------------------------------------------------------------------
	// 　コメントデータを取得 (END)
	//----------------------------------------------------------------------
	
	$scheduleCalendar = '<form action="?ym='.h($getYm).'" method="post">';
	
	//スタート年月をセット
	$startYmd = date("Y-m-d",mktime(0,0,0,date("m")-$adminDispMonth,1,date("Y")));
	
	//カレンダーのループ（当月分があるので+1とした）
	$dispMonthLoop = $adminDispMonth * 2 + 1;
	for($i = 0;$i < $dispMonthLoop;$i++){
	
		$timeStamp = strtotime("+$i month",strtotime($startYmd));
		
		$ym = date("Y-m",$timeStamp);
		
		//今月、来月
		$prev = date("Y-m",mktime(0,0,0,date("m",$timeStamp)-1,1,date("Y",$timeStamp)));
		$next = date("Y-m",mktime(0,0,0,date("m",$timeStamp)+1,1,date("Y",$timeStamp)));
		
		$calendarClass = 'hidden';
		if($getYm == $ym){
			$calendarClass = 'calendarClassAdmin';
		}
		
		$nextClass = '';	
		if($i == ($adminDispMonth * 2)  ){
			$nextClass = 'hidden';
		}
		
		$prevClass = '';
		if($i == 0 ){
			$prevClass = 'hidden';
		}

$scheduleCalendar .= '<table id="calendarTableAdmin-'.$ym.'" class="'.$calendarClass.'">
<tr><th><a href="?ym='.$prev.'" class="'.$prevClass.'">&laquo;'.date("n",strtotime($prev.'-01')).'月</a></th><th colspan="5">'.date("Y",$timeStamp) . "年" . date("n",$timeStamp). "月" .'</th><th><a href="?ym='.$next.'" class="'.$nextClass.'">&raquo;'.date("n",strtotime($next.'-01')).'月</a></th></tr><tr><th class="youbi_0">'.$weekArray[0].'</th><th>'.$weekArray[1].'</th><th>'.$weekArray[2].'</th><th>'.$weekArray[3].'</th><th>'.$weekArray[4].'</th><th>'.$weekArray[5].'</th><th class="youbi_6">'.$weekArray[6].'</th></tr><tr>';
		
		//今月末
		$lastDay = date("t", $timeStamp);
		
		//1日の曜日
		$youbi = date("w",mktime(0,0,0,date("m",$timeStamp),1,date("Y",$timeStamp)));
		
		//最終日の曜日
		$lastYoubi = date("w",mktime(0,0,0,date("m",$timeStamp)+1,0,date("Y",$timeStamp)));
		
		$scheduleCalendar .= str_repeat('<td></td>',$youbi);
		
		for($day = 1; $day <= $lastDay; $day++,$youbi++){
			
			//----------------------------------------------------------------------
			// 　コメント用タグ生成 (START)
			//----------------------------------------------------------------------
			$commentTag = '<div class="adminTextArea"><textarea name="comment['.date("Y-m-d",strtotime($ym."-".$day)).']" rows="2" cols="5"></textarea></div>';
			
			if(count($commentArray) > 0){
				foreach($commentArray as $commentArrayVal){
					$commentArrayExp = explode(',',$commentArrayVal);
					if(strtotime($ym."-".$day) == strtotime($commentArrayExp[0]) ){
						$commentTag = '<div class="adminTextArea"><textarea name="comment['.date("Y-m-d",strtotime($ym."-".$day)).']" rows="2" cols="5">'.str_replace(array('<br />','<br>'),"\n",rtrim($commentArrayExp[1])).'</textarea></div>';
					}
				}
			}
			//----------------------------------------------------------------------
			// 　コメント用タグ生成 (END)
			//----------------------------------------------------------------------
			
			
			$inputText01 = '<br /><input type="checkbox" name="holiday_set[]" value="'.date("Y-m-d",strtotime($ym."-".$day)).'" checked />'.$commentTag;
			$inputText02 = '<br /><input type="checkbox" name="holiday_set[]" value="'.date("Y-m-d",strtotime($ym."-".$day)).'" />'.$commentTag;
			
			//祝日の判定
			$shukujituClass = '';
			foreach($shukujituArray as $val){
				if(strtotime($ym."-".$day) == strtotime($val)){
					$shukujituClass = ' shukujitu';
					break;
				}
			}
			
			//定休日の場合はclassを付与し背景色を反映
			$holidayFlag = '';
			foreach($closedArray as $val){
				if($youbi % 7 == $val){
					$scheduleCalendar .= sprintf('<td class="closed youbi_%d'.$shukujituClass.'" style="background:'.$closedBg.'">%d'.$inputText02.'</td>',$youbi % 7, $day);
					$holidayFlag = 1;
					break;
				}
			}
			
			//休業日の場合はclassを付与し背景色を反映＆checked付与
			if($holidayFlag != 1){
				foreach($holidayArray as $val){
					if(strtotime($ym."-".$day) == strtotime($val)){
						$scheduleCalendar .= sprintf('<td class="holiday youbi_%d'.$shukujituClass.'" style="background:'.$holidayBg.'">%d'.$inputText01.'</td>',$youbi % 7, $day);
						$holidayFlag = 1;
						break;
					}
				}
			}
			
			if($holidayFlag != 1){
			
				//本日の場合はclassを付与
				if(strtotime($ym."-".$day) == strtotime(date("Y-m-d")) && $todayFlag == 1){
					$scheduleCalendar .= sprintf('<td class="today youbi_%d'.$shukujituClass.'" style="background:'.$todayFlagBg.'">%d'.$inputText02.'</td>',$youbi % 7, $day);
				}
				//デフォルト
				else{
					$scheduleCalendar .= sprintf('<td class="youbi_%d'.$shukujituClass.'">%d'.$inputText02.'</td>',$youbi % 7, $day);
				}
			}
			//土曜で行を変える
			if($youbi % 7 == 6){
				$scheduleCalendar .= "</tr><tr>";
			}
			//最終日以降空セル埋め
			if($day == $lastDay){
				$scheduleCalendar .= str_repeat('<td class="blankCell"></td>',(6 - $lastYoubi));
			}
		}
		$scheduleCalendar .= "</tr>";
		$scheduleCalendar .= "</table>";
	}
		//定休日処理
		$scheduleCalendar .= "<h2>定休日設定</h2><p>毎週定休日が決まっている場合には該当する曜日にチェックを入れれば全期間で有効になります。（隔週の場合は↑でチェックして下さい）<br>";
		$youbi_array = array('日','月','火','水','木','金','土');
		$lines = file($closedFilePath);
		
		for($i = 0;$i<7;$i++){
			
			$chekedFlag = '';
			foreach($lines as $val){
				if($val == $i){
					$chekedFlag = ' checked';
				}
			}
			
			$scheduleCalendar .= '<input type="checkbox" name="closed[]" id="closed'.$i.'" value="'.$i.'"'.$chekedFlag.' /><label for="closed'.$i.'"> '.$youbi_array[$i].'</label>　';
		}
		
		$scheduleCalendar .= "<p align=\"center\"><input type=\"submit\" class=\"submitBtn\" value=\"　登録　\" name=\"holiday_submit\"></p>\n";
		$scheduleCalendar .= "</form>\n";
		$scheduleCalendar = str_replace('<tr></tr>','',$scheduleCalendar);
		
		return $scheduleCalendar;
}


//GoogleカレンダーAPIから祝日を取得
function getHolidays($year) {
	global $apiKey;
	if(empty($apiKey)) exit('Googleから祝日取得用のGoogleカレンダーAPIキーがconfig.phpで設定されていません。Googleにて取得し、設定下さい。または設定ファイルでこの機能をOFFにするか、<a href="http://www.php-factory.net/calendar_form/01.php" target="_blank">当サイト</a>から祝日用のデータファイルをダウンロード下さい。');
	
	if(!function_exists('json_decode')) exit('json_decode関数が見当たらないため祝日自動取得が出来ません。json_decodeはPHP5.2以上である必要があります。PHPのバージョアップを行うか、祝日自動取得を設定ファイルでOFFに設定下さい。');
	
	$holidays = array();
	$holidays_id = 'outid3el0qkcrsuf89fltf7a4qbacgt9@import.calendar.google.com'; // mozilla.org版
	//$holidays_id = 'japanese__ja@holiday.calendar.google.com'; // Google 公式版日本語
	//$holidays_id = 'japanese@holiday.calendar.google.com'; // Google 公式版英語
	$url = sprintf(
		'https://www.googleapis.com/calendar/v3/calendars/%s/events?'.
		'key=%s&timeMin=%s&timeMax=%s&maxResults=%d&orderBy=startTime&singleEvents=true',
		$holidays_id,
		$apiKey,
		$year.'-01-01T00:00:00Z' , // 取得開始日
		$year.'-12-31T00:00:00Z' , // 取得終了日
		150 // 最大取得数
	);
 
	if ( $results = file_get_contents($url, true )) {
		//JSON形式で取得した情報を配列に格納
		$results = json_decode($results);
		//年月日をキー、祝日名を配列に格納
		foreach ($results->items as $item ) {
			$date = strtotime((string) $item->start->date);
			$title = (string) $item->summary;
			$holidays[date('Y-m-d', $date)] = $title;
		}
		//祝日の配列を並び替え
		ksort($holidays);
	}
	return $holidays; 
}


//祝日取得、保存
function buildHoliDay($holidayFilePath){
		$messe ='';
		if($res = getHolidays(date("Y"))){
			//去年、今年、来年の祝日をGoogleから取得
			$holidaysPrevYear = getHolidays(date("Y",strtotime("-1 year")));
			$holidays = getHolidays(date("Y"));
			$holidaysNextYear = getHolidays(date("Y",strtotime("+1 year")));
			
			$fp = fopen($holidayFilePath, "w+b") or die("fopen Error!!");
			$holidaysWriteData = '';
			if (flock($fp, LOCK_EX)) {
				ftruncate($fp,0);
				rewind($fp);
				// 書き込み
				foreach($holidaysPrevYear as $key => $val){
					$holidaysWriteData .= $key."\n";
				}
				foreach($holidays as $key => $val){
					$holidaysWriteData .= $key."\n";
				}
				foreach($holidaysNextYear as $key => $val){
					$holidaysWriteData .= $key."\n";
				}
				
				fwrite($fp, $holidaysWriteData);
			}
			    fclose($fp);
		}else{
				$messe = 'GoogleカレンダーAPIから祝日データが取得できません。<br>Googleの仕様が変更になった可能性がありますので管理者にお問い合わせください。';
		}
	
	return $messe;
}

//NULLバイト除去//
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}

//----------------------------------------------------------------------
// 　関数定義（基本的に変更不可） (END)
//----------------------------------------------------------------------


$warningMesse = '<center>著作権表記がありません。削除するには著作権表記削除料金（\2,000）のお支払いが必要です。<br />削除ご希望の際は下記アドレスまでご連絡をお願いします。<br />info@php-factory.net</center>';
require_once('copy.inc');
?>