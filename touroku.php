<?php
// 3. エラー処理
session_start();
$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "loginmanagement";  // データベース名

$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);




$gakuseki =$_SESSION["gakuseki"];
$name    =$_SESSION["name"];
$gakunen=$_SESSION["gakunen"];
$number=$_SESSION["number"];
$class=	$_SESSION["class"];
$password=$_SESSION["password"];

try {
	$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

	$stmt = $pdo->prepare("INSERT INTO userData(gakuseki, name,password,gakunen,class,number) VALUES (?, ?, ?, ?, ?, ?)");

	$stmt->execute(array($gakuseki, $name, password_hash($password, PASSWORD_DEFAULT),$gakunen,$class,$number));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
	$userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

	$signUpMessage = '登録が完了しました。あなたの登録IDは '. $gakuseki. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
} catch (PDOException $e) {
	$errorMessage = 'データベースエラー';
	// $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
	echo $e->getMessage();


}
?>
<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>登録</title>
            <link href="../css/SignUp.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>登録しました</h1>
<form action="Login.php">
<input type="submit" value="ログイン画面に戻る">
          </form>

          </body>
</html>