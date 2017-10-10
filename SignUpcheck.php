<?php
session_start();
$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "loginmanagement";  // データベース名
// ログイン状態チェック
if (!isset($_SESSION["name"])) {
	header("Location: Logout.php");
	exit;
}

if (empty($_POST["gakuseki"])) {  // 値が空のとき
	$errorMessage = '学籍番号が未入力です。';
}else if (empty($_POST["name"])) {
	$errorMessage = '名前が未入力です。';
} else if (empty($_POST["password"])) {
	$errorMessage = 'パスワードが未入力です。';
} else if (empty($_POST["password2"])) {
	$errorMessage = 'パスワードが未入力です。';
} else if (empty($_POST["gakunen"])) {
	$errorMessage = '学年が未入力です。';
}else if (empty($_POST["number"])) {
	$errorMessage = '出席番号が未入力です。';
}else if (empty($_POST["class"])) {
	$errorMessage = 'クラスが未入力です。';
}
if (!empty($_POST["gakuseki"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
if (isset($_SESSION["gakusekicheck"])) {
echo $_SESSION['namecheck'];}
if (isset($_SESSION['gakunencheck'])) {
echo $_SESSION['numbercheck'];echo $_SESSION['claddcheck'];}

$gakuseki =$_SESSION["gakusekicheck"];
$name    =$_SESSION["namecheck"];
$gakunen=$_SESSION["gakunencheck"];
$number=$_SESSION["numbercheck"];
$class=	$_SESSION["classcheck"];

	// 2. ユーザIDとパスワードが入力されていたら認証する
		$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

		// 3. エラー処理
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
}
else if($_POST["password"] != $_POST["password2"]) {
		$errorMessage = 'パスワードに誤りがあります。';
	}

?><!doctype html>

<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
            <link href="../css/SignUp.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>新規登録画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>

               <label for="gakuseki">学籍番号</label><input type="text" id="gakuseki" name="gakuseki" placeholder="学籍番号を入力" value="<?php  $gakuseki?>">
<br>
                 <label for="password2">名前</label><input type="text" id="name" name="name" value="<?php $name?>" placeholder="名前を入力">
<br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
<br>
               <label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
<br>
                 <label for="password2">学年</label><input type="text" id="gakunen" name="gakunen" value="<?php $gakunen?>" placeholder="学年を入力">
<br>
                 <label for="class">クラス</label><input type="text" id="class" name="class" placeholder="クラスを入力" value="<?php $class?>" placeholder="クラスを入力">
<br>
                <label for="number">出席番号</label><input type="number" id="number" name="number" value="" placeholder="出席番号を入力">
<br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="SignUp.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>