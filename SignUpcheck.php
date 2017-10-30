<?php
session_start();
$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "loginmanagement";  // データベース名
$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

$gakuseki = mb_convert_kana($_POST["gakuseki"],"n","utf-8");
$name = $_POST["name"];
$password =$_POST["password"];
$password2 =$_POST["password2"];
$gakunen = mb_convert_kana($_POST["gakunen"],"n","utf-8");
$number = mb_convert_kana($_POST["number"],"n","utf-8");
$class =mb_convert_kana($_POST["class"],"n","utf-8");

$_SESSION['gakuseki'] = $gakuseki;
$_SESSION['name'] = $name;
$_SESSION['password']=$password;
$_SESSION['password2']=$password2;
$_SESSION['gakunen']=$gakunen;
$_SESSION['number']=$number;
$_SESSION['class']=$class;

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = array();

// 1. ユーザIDの入力チェック
if (empty($_POST["gakuseki"])) {  // 値が空のとき
	$errorMessage[] = '学籍番号が未入力です。';
}
if (empty($_POST["name"])) {
	$errorMessage[] = '名前が未入力です。';
}
if (empty($_POST["password"])) {
	$errorMessage[] = 'パスワードが未入力です。';
}
if (empty($_POST["password2"])) {
	$errorMessage[] = 'パスワードが未入力です。';
}
if (empty($_POST["gakunen"])) {
	$errorMessage[] = '学年が未入力です。';
}
if (empty($_POST["number"])) {
	$errorMessage[] = '出席番号が未入力です。';
}
if (!empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] !== $_POST["password2"]) {
	$errorMessage[] = 'パスワードが一致しません';
}

if (empty($errorMessage)) {
	$sql = sprintf('SELECT COUNT(*) AS cnt FROM userData WHERE gakuseki="%s"',
			mysqli_real_escape_string($db, $_POST['gakuseki'])
			);
	$record = mysqli_query($db, $sql) or die(mysqli_error($db));
	$table = mysqli_fetch_assoc($record);
	if ($table['cnt'] > 0) {
		$errorMessage[] = 'この学籍番号は使われています';
	}
}


$_SESSION["errorMessage"]=$errorMessage;
if(!empty($errorMessage)){
	header("Location: SignUp.php?err");
}

// 入力したユーザIDとパスワードを格納

?>
<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>確認画面</title>
            <link href="../css/SignUp.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>確認画面</h1>
        <form id="loginForm" name="loginForm" action="touroku.php" method="POST" >
            <fieldset>
                <legend>確認してください</legend>

		<div>
               <label>学籍番号  :</label><?php echo $gakuseki?>
		</div>

		<div>
                 <label>名前   :</label><?php echo $name?>
		</div>
		<div>
                 <label>学年   :</label><?php echo $gakunen?>
		<div>
                 <label>クラス   :</label><?php echo $class?>
		</div>
		<div>
                <label>出席番号   :</label><?php echo $number ?>
		</div>

               <label>上記に間違いがなければ新規登録ボタンを押してください</label> <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="SignUp.php">
        	<input type="hidden" name="back" value="back">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>