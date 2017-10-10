<?php

// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "loginmanagement";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
	// 1. ユーザIDの入力チェック
	if (empty($_POST["gakuseki"])) {  // emptyは値が空のとき
		$errorMessage = '学籍番号が未入力です。';
	} else if (empty($_POST["password"])) {
		$errorMessage = 'パスワードが未入力です。';
	}

	if (!empty($_POST["gakuseki"]) && !empty($_POST["password"])) {
		// 入力したユーザIDを格納
		$gakuseki = $_POST["gakuseki"];

		}
		$_SESSION['name'] = $_POST['name'];
		// 2. ユーザIDとパスワードが入力されていたら認証する
		$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

		// 3. エラー処理
		try {
			$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

			$stmt = $pdo->prepare('SELECT * FROM userdata WHERE gakuseki = ?');
			$stmt->execute(array($gakuseki));

			$password = $_POST["password"];

			if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
echo password_hash($password, PASSWORD_DEFAULT)."<br>";
echo $row["password"]."<br>";
				if (password_verify($password, $row['password'])) {
					session_regenerate_id(true);

					// 入力したIDのユーザー名を取得
					$gakuseki = $row['gakuseki'];
					$sql = "SELECT * FROM userdata WHERE gakuseki = $gakuseki";  //入力したIDからユーザー名を取得
					$stmt = $pdo->query($sql);
					foreach ($stmt as $row) {
						$row['name'];  // ユーザー名
					}
					$_SESSION["gakuseki"] = $row['gakuseki'];
					$_SESSION["name"] = $row['name'];
					header("Location: Mypage.php");  // メイン画面へ遷移
					exit();  // 処理終了
				} else {
					// 認証失敗
					$errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
				}
			} else {
				// 4. 認証成功なら、セッションIDを新規に発行する
				// 該当データなし
				$errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
			}
		} catch (PDOException $e) {
			$errorMessage = 'データベースエラー'.$e->getMessage();
			//$errorMessage = $sql;
			// $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
			 echo $e->getMessage();
		}
	}


?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>
            <link rel="stylesheet" type="text/css" href="Login.css">
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
        <div class="main">
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <label for="gakuseki">学籍番号</label><input type="text" id="gakuseki" name="gakuseki" placeholder="学籍番号を入力" value="<?php if (!empty($_POST["gakuseki"])) {echo htmlspecialchars($_POST["gakuseki"], ENT_QUOTES);} ?>">
                <br><br><br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br><br><br>
                <input type="submit" id="login" name="login" value="ログイン">
                </div>
        </form>
        <br><br>
        <form action="SignUp.php">
        <div class="main">
                <input type="submit" value="新規登録">
			</div>
        </form>
    </body>
</html>