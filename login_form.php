<DOCTYPE html>
<html lang="ja">
     <!--スタイルシートの連携-->
    <link rel="stylesheet" href="style.css">
      <title>ログイン</title>
    <p>だれでも図書委員 ver.1.1</p> 
    
<div class="fadeIn">
    
<form action="login.php" method="post">
<div>
    <label>
       
        <input type="text" name="mail" placeholder="メールアドレス"required>
    </label>
</div>
<div>
    <label>
        
        <input type="password" name="pass" placeholder="パスワード"required>
    </label>
</div>
<input type="submit" value="ログイン">
</form>
<br>アカウントをお持ちでない方は<a href="signup.php">新規登録</a>

</div>