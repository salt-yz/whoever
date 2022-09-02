<?php
session_start();
$_SESSION = array();//セッションの中身をすべて削除
session_destroy();//セッションを破壊
?>

 <!--スタイルシートの連携-->
 <title>ログアウト</title>
    <link rel="stylesheet" href="style.css">
<p class="fadeIn">ログアウトしました。</p>
<a href="login_form.php">ログイン</a>