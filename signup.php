
<DOCTYPE html>
<html lang="ja">
 <!--スタイルシートの連携-->
    <link rel="stylesheet" href="style.css">
    
<title>新規会員登録</title>    
<p>だれでも図書委員　新規会員登録</p>

<div class="fadeIn">
<form action="register.php" method="post"><!--処理を行う宛先を指定-->
<div>
    <label>
    
        <input type="text" name="name" placeholder="名前"required>
    </label>
</div>
<div>
    <label>
        
        <input type="text" name="mail" placeholder="メールアドレス" required>
    </label>
</div>
<div>
    <label>
       
        <input type="password" name="pass"  placeholder="パスワード"required>
    </label>
</div>
<input type="submit" value="新規登録">
</form>
すでに登録済みの方は<a href="login_form.php">ログイン</a>

</div>

</html>