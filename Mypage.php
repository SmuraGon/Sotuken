<html>
<head>
<title>マイページ</title>
<link rel="stylesheet" type="text/css" href="Mypage.css">
</head>
<!--  <body background="img/sakura.png">背景画像-->
<h3>学生専用WEBサイト  マイページ</h3>
<div align="center">
<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["name"])) {
	header("Location: Logout.php");
	exit;
}
?><p>ようこそ
<?php
if (isset($_SESSION['name'])) {
echo $_SESSION['name'];} ?>さん</p>
<?php
if (isset($_SESSION['gakuseki'])) {
echo $_SESSION['gakuseki'];} ?></p>
<?php
date_default_timezone_set('Asia/Tokyo');

$w = date("w");
$week_name = array("日", "月", "火", "水", "木", "金", "土");

echo date("Y/m/d") . "($week_name[$w])\n"; //「2015/03/10(火)」
?>
<br><br><br>
</div>
<div align="center">

<input type="button"id="top" name="top" value="ヘルプ"style="WIDTH: 100px; HEIGHT: 30px" onclick="location.href='Mypage.php'">
<input type="button"id="top" name="top" value="ログアウト"style="WIDTH: 100px; HEIGHT: 30px" onclick="location.href='Logout.php'">
<br><br><br>

<input type="button"id="top" name="top" value="トップ"style="WIDTH: 250px; HEIGHT: 30px" onclick="location.href='Mypage.php'">
<input type="button"id="Chien" name="Chien" value="遅延報告"style="WIDTH: 250px; HEIGHT: 30px" onclick="location.href='Chien.php'">
<input type="button"id="Soudan" name="Soudan" value="相談"style="WIDTH: 250px; HEIGHT: 30px" onclick="location.href='Soudan.php'">
</div>
<br>
<h3>現在の遅延情報</h3>

</body>
</html>