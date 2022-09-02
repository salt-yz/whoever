<DOCTYPE html>
<html lang="ja">
    
   <head>
        <meta charset="UTF-8">
        <!--スタイルシートの連携-->
    <link rel="stylesheet" href="style.css">
       
        <title>だれでも図書委員</title>
    </head>
    <body>
       <?php include "menu.php" ?>
    <div class="fadeIn">
    
    

<br><p>SPECIAL</p>
こちらは書店に置いてあるような、本を紹介する「ポップ」を図書委員のみなさんから匿名で募集する掲示板です。<br>
(匿名投稿のため、お問い合わせや誹謗中傷があったときのみ管理人の判断で削除・編集致します)<br>


<br><br>


<?php 
         
// DB接続設定
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザ名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
//存在していない場合、テーブル「ポップ」を作成
    $sql = "CREATE TABLE IF NOT EXISTS pop"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "headline TEXT,"//ポップ見出し
    . "contents TEXT,"//ポップ内容
    . "date DATE"//日付
    .");";
//$sqlに格納したSQL文が実行される
    $stmt = $pdo->query($sql);
    //条件分岐開始
//入力フォームに値があり隠しテキストボックスが空のとき＝新規投稿を実行
if(!empty($_POST["headline"])&&!empty($_POST["contents"]))
{
        
        $sql = $pdo -> prepare("INSERT INTO pop (headline, contents, date) VALUES (:headline, :contents, :date)");
        $sql -> bindParam(':headline', $headline, PDO::PARAM_STR);
        $sql -> bindParam(':contents', $contents, PDO::PARAM_STR);
        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
       

        $headline=$_POST["headline"];//ポップ見出し
        $contents=$_POST["contents"];//ポップ内容
        $date=date("Y-m-d");//  日付
        $sql -> execute();}
    ?>
    



<div class="pop">
 <?php
//すべての処理の後、テーブルの中身をブラウザに表示
//テーブルを選択
    $sql = 'SELECT * FROM pop';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();//すべて取ってくるという意味
    foreach ($results as $row)
    {
        //$rowの中にはテーブルのカラム名が入る
    
    if($row['id']%2==0){
    echo '<div class="kakomi-tape1">'.'<h3>'.$row["headline"].'</h3>';
    echo "<br>";
    echo $row['contents'];
    echo "<br>";
    echo $row['date'].'</div>';  }
    else{
        
    echo '<div class="kakomi-tape2">'.'<h3>'.$row["headline"].'</h3>';
    echo "<br>";
    echo $row['contents'];
    echo "<br>";
    echo $row['date'].'</div>'; 
        
    
    }}
      
    ?>   
    </div>
    

<br>投稿はこちらから！ご応募お待ちしております。お問い合わせはyuzu@st.go.tuat.ac.jpまで
<br><br>
<form method="POST" action="">
<textarea name="headline"rows="1"cols="30"placeholder="ポップの見出し"></textarea><br>
<textarea name="contents" rows="7" cols="30"placeholder="ポップの内容">
</textarea><br>
<input type="submit" name="btn1" value="投稿">
</form>


 </div>
   <?php include "footer.php" ?>
    </body>
    </html>
