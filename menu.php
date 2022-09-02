<!-- HTMLコード -->
<DOCTYPE html>
<html lang="ja">
    <html>
        <head> 
        <meta charset="UTF-8">
        <!--スタイルシートの連携-->
    <link rel="stylesheet" href="style.css">
    
    <title>だれでも図書委員</title>
       </head>
        <body>
   
   <header>
     <p>だれでも図書委員</p>
     
     <?php
//ログインしているかどうかの表示機能
session_start();


//ログインしているときの処理
if (isset($_SESSION['id'])) {
    
$name = $_SESSION['name'];
//こんにちは、（名前）さん
    $msg = 'こんにちは、' . htmlspecialchars($name, \ENT_QUOTES, 'UTF-8') . 'さん ☺';
    $link = '<a href="logout.php">LOGOUT</a>';//リンク先にログアウト画面を指定
    } 

//ログインしていない時の処理
else {
    $msg = 'ログインしていません  ';
    $link = '<a href="login_form.php">LOGIN</a>';//リンク先にログイン画面を指定
}
?>


<?php echo $msg;?>
<?php echo $link; ?>

    <nav class="gnav">
        <ul class="menu">
            <li><a href="top.php">TOP</a></li>
           <li> <a href="library.php">LIBRARY</a></li>
            <li><a href="special.php">SPECIAL</a></li>
           
            
        </ul>
    </nav>
</header>


</body>
          </html>