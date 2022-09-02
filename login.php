<!--スタイルシートの連携-->
<link rel="stylesheet" href="style.css">
<title>ログイン</title>
<?php

//このログインフォームについて、8/27　パスワードをデータベースにうまく保存できなかった、その点をもう一度考える
//8/28 パスワードを文字列として普通に保存したら成功した
  

session_start();
//データベース接続設定
$mail = $_POST['mail'];
$dsn = "mysql:host=localhost; dbname=データベース名; charset=utf8";
$username = "ユーザ名";
$password = "パスワード";

try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

//テーブルusersからメールアドレスを取得し、比較する。
$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
//指定したハッシュがパスワードにマッチしているかチェック
if ($_POST['pass']==$member['pass']) {
    
    //DBのユーザー情報をセッションに保存
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['name'];
    $msg = 'ログインしました。';
    $link = '<a href="top.php">TOP</a>';
    $link2='';
} else {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="login_form.php">戻る</a>';
    $link2='<br>アカウントをお持ちでない方は<a href="signup.php">新規登録</a>';
}
?>


<p class="fadeIn"><?php echo $msg; ?></p>
<?php echo "$link <br>";
echo $link2;
?>
