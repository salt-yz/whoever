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

<?php 
         
// DB接続設定【入力しないと動作しません】
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザ名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
//存在していない場合、テーブル「ライブラリ」を作成
    $sql = "CREATE TABLE IF NOT EXISTS library"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name TEXT,"//名前
    . "title TEXT,"//蔵書タイトル
    . "deadline DATE,"//返却期限
    . "comment TEXT,"//コメント
    . "pass TEXT"//パスワード
    .");";
//$sqlに格納したSQL文が実行される
    $stmt = $pdo->query($sql);
    
    
//【パスワードをここで一括管理！！！】
if (isset($_SESSION['id'])) {
//テーブルusersからパスワードを取得し、比較する。
$sql = "SELECT * FROM users WHERE name = :name";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name);//$nameについては、上記にincludeされているmenu.php内に定義されているため新たに定義しない。
$stmt->execute();
$member = $stmt->fetch();

$managedpass=$member['pass'];}

//条件分岐開始
//入力フォームに値があり隠しテキストボックスが空のとき＝新規投稿を実行
if(!empty($_POST["name"])&&!empty($_POST["title"])&&!empty($_POST["deadline"])&&!empty($_POST["comment"])&&$_POST["pass"]==$managedpass&&empty($_POST["hidden"]))
{
        
        $sql = $pdo -> prepare("INSERT INTO library (name, title, deadline, comment, pass) VALUES (:name, :title, :deadline, :comment, :pass)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':title', $title, PDO::PARAM_STR);
        $sql -> bindParam(':deadline', $deadline, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    

        $name=$_POST["name"];//氏名
        $title=$_POST["title"];//蔵書タイトル
        $deadline=$_POST["deadline"];//  返却期限
        $comment=$_POST["comment"];//コメント
        $pass=$_POST["pass"];//パスワード
        $sql -> execute();}
       
       
       
       
 //編集番号と正しいパスワードが入力されたときに、フォームに名前とコメントを戻す。
if(!empty($_POST["enum"]))

{$enum=$_POST["enum"];
             
$sql = "SELECT * FROM library WHERE id=$enum";
$stmt = $pdo->query($sql);
$result=$stmt->fetchAll();

foreach ($result as $row){
 if($_POST["epass"]==$row["pass"])
            {
            
            $ename=$row["name"];
            $etitle=$row["title"];
            $edeadline=$row["deadline"];
            $ecomment=$row["comment"];
              
            }}}

          
//隠しボックスに数字があるとき、編集を実行
if(!empty($_POST["name"])&&!empty($_POST["title"])&&!empty($_POST["deadline"])&&!empty($_POST["comment"])&&$_POST["pass"]==$managedpass&&!empty($_POST["hidden"]))
        {
       
        $hidden=$_POST["hidden"];
       
         $id = $hidden; //変更する投稿番号
               
               $name =$_POST["name"];//編集後の名前
               $title = $_POST["title"]; //編集後のタイトル
              $deadline=$_POST["deadline"];//編集後の返却期限
               $comment=$_POST["comment"];//編集後のコメント
               $pass=$_POST["pass"];//パスワード
               
               $sql = 'UPDATE library SET name=:name,title=:title,deadline=:deadline,comment=:comment,pass=:pass WHERE id=:id';
               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':name', $name, PDO::PARAM_STR);
               $stmt->bindParam(':title', $title, PDO::PARAM_STR);
               $stmt->bindParam(':deadline', $deadline, PDO::PARAM_STR);
               $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
               $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
               $stmt->bindParam(':id', $id, PDO::PARAM_INT);
               $stmt->execute();
        }
 

    
  
//削除フォームに値がある場合削除を実行 
if(!empty($_POST["dnum"]))
{
    
    //削除番号の定義
    $dnum=$_POST["dnum"];
   $sql = "SELECT * FROM library WHERE id=$dnum";
   $stmt = $pdo->query($sql);
   $result=$stmt->fetchAll();

foreach ($result as $row){
 
if($_POST["dpass"]==$row["pass"])
{
   
    //dnumと一致するデータを削除
    $id = $dnum;
    $sql = 'delete from library where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

}}}?>




 <div class="lib">
    
<center><p>LIBRARY</p>ここは図書室です。借りたい本がみつかったら図書委員さんに連絡してみましょう。借りた人は返却期限を守りましょう。</center>
   
  
<?php
//すべての処理の後、テーブルの中身をブラウザに表示
//テーブルを選択
    $sql = 'SELECT * FROM library';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();//すべて取ってくるという意味
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        
        echo '<br><br>'.$row['id'].'. ';
        echo $row['name'].'さんの';
        echo "『".$row['title'].'』';
        echo "返却は";
        echo $row['deadline'].'まで。';
        echo $row['comment'].'';
       if(date($row['deadline'])<date("Y-m-d"))
       {echo'<FONT COLOR="BLACK"><b><br>※返却期限が過ぎています！借りている人は早めに返却しましょう</b></FONT>' ; }}  
      
    ?>   
    
</div>
      
   
   <p>FORM</p>図書委員さんは、ここでご自身の蔵書について書き込んでください。自分の投稿のみ、削除や編集ができます。
    <div class="flex">
        <div>
            投稿フォーム
            <form action=""method="post">
            <input type="text"name="name"placeholder="図書委員のお名前"
            value="<?php if(!empty($_POST["enum"])&&$_POST["epass"]==$row["pass"]){echo "$ename";}?>"><br>
            
            <input type="text"name="title"placeholder="蔵書タイトル"
            value="<?php if (!empty($_POST["enum"])&&$_POST["epass"]==$row["pass"]){echo "$etitle";}?>"><br>
            
             <input type="text" name="deadline" onfocus="this.type='date'" onfocusout="this.type='text'" placeholder="返却期限"
            value="<?php if (!empty($_POST["enum"])&&$_POST["epass"]==$row["pass"]){echo "$edeadline";}?>"><br>
            
            <input type="text"name="comment"placeholder="コメント(貸出可否など)"
            value="<?php if (!empty($_POST["enum"])&&$_POST["epass"]==$row["pass"]){echo "$ecomment";}?>"><br>
            
            
            <input type="password"name="pass"placeholder="パスワード"
            value=""><br>
            
             <input type="hidden"name="hidden"
            value="<?php if (!empty($_POST["enum"])&&$_POST["epass"]==$row["pass"]){echo ($_POST["enum"]);}?>"><br><!--編集番号を反映する隠しテキストボックス-->
           
             <input type="submit"name="submit">
        </form> <!--送信フォーム設置完了-->
          </div> 
          
          <div>
              削除フォーム
         <form action=""method="post">
            <input type="text"name="dnum"placeholder="削除対象番号(半角)"><br>
             <input type="password"name="dpass"placeholder="パスワード"
            value=""><br><br>
            <input type="submit"name="delete"value="削除">
        </form> <!--削除フォーム設置完了-->
        </div>
        
        <div>
            編集フォーム
         <form action=""method="post">
            <input type="text"name="enum"placeholder="編集対象番号(半角)"><br>
             <input type="password"name="epass"placeholder="パスワード"
            value=""><br><br>
            <input type="submit"name="edit"value="編集">
        </form>
     </div></div> </div><!--編集フォーム設置完了-->
     
     <br><br><br><br><br><br><br><br><br><br>
      <?php include "footer.php" ?>
      
    </body>
    </html>
