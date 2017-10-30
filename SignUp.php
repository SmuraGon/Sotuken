<?php
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "loginManagement";  // データベース名
$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

if(isset($_SESSION['gakuseki'])){ $gakuseki=$_SESSION["gakuseki"]; }else{ $gakuseki=""; }
if(isset($_SESSION['name'])){ $name=$_SESSION["name"]; }else{ $name=""; }

?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
            <link href="../css/SignUp.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>新規登録画面</h1>

        <form id="loginForm" name="loginForm" action="SignUpcheck.php" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
<div style="color:#ff0000;">
<?php
if(isset($_GET["err"])){
	print implode("<br>",$_SESSION["errorMessage"]);
	unset($_SESSION["errorMessage"]);
}
?>
</div>
<ul>
               <li> <label for="gakuseki">学籍番号</label><input type="text" id="gakuseki" name="gakuseki" placeholder="学籍番号を入力" value="<?php echo htmlspecialchars($gakuseki, ENT_QUOTES); ?>"></li>
                <br>
                 <li><label for="password2">名前</label><input type="text" id="name" name="name" value="<?php print $name; ?>" placeholder="名前を入力"></li>
                <br>
               <li> <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力"></li>
                <br>
               <li> <label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力"></li>大文字.小文字区別します
                <br>
                 <li><label for="password2">学年</label><input type="text" id="gakunen" name="gakunen" value="" placeholder="学年を入力"></li>
                <br>
                <li> <label for="class">クラス</label><input type="text" id="class" name="class" placeholder="クラスを入力" value="" placeholder="クラスを入力"></li>
                <br>
                <li> <label for="number">出席番号</label><input type="number" id="number" name="number" value="" placeholder="出席番号を入力"></li>
                <br>
</ul>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="Login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>