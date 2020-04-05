<?php
$dsn='データベース名'; //MySQLへの接続
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
$editNumber="";
$editName="";
$editComment="";

//新規投稿
  if((!empty($_POST['name']))&&(!empty($_POST['comment']))&&(!empty($_POST['password']))&&empty($_POST['edit_post'])){
   $name=$_POST['name'];
   $comment=$_POST['comment'];
   $date=date("Y/m/d H:i:s");
   $pass=$_POST['password'];
   $sql="CREATE TABLE IF NOT EXISTS keijiban" //CREATE TABLEはテーブルの作成
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."post_date datetime,"
."password TEXT"
.");";
   $stmt=$pdo->query($sql); //INSERT構文はデータを挿入する
   $stmt=$pdo->prepare("INSERT INTO keijiban(name,comment,post_date,password)VALUES(:name,:comment,:post_date,:password)");
   $stmt->bindParam(':name',$name,PDO::PARAM_STR);
   $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
   $stmt->bindParam(':post_date',$date,PDO::PARAM_STR);
   $stmt->bindParam(':password',$pass,PDO::PARAM_STR);
   $stmt->execute();
  }
?>

<?php
//削除機能
if(!empty($_POST['deletenumber'])){
$id=$_POST['deletenumber'];
$pass=$_POST['password'];
$sql='delete from keijiban where id=:id and password=:password';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->bindParam(':password',$pass,PDO::PARAM_STR);
$stmt->execute();
}
?>

<?php
//編集機能
if(!empty($_POST['edit_number'])){
$editNumber=$_POST['edit_number']; //変更する投稿番号
$pass=$_POST['password'];
$sql='select name,comment from keijiban where id=:id and password=:password';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':id',$editNumber,PDO::PARAM_INT);
$stmt->bindParam(':password',$pass,PDO::PARAM_STR);
$stmt->execute();
$results=$stmt->fetch();
$editName=$results['name'];
$editComment=$results['comment'];
}
?>

<?php
if((!empty($_POST['edit_post']))&&(!empty($_POST['name']))&&(!empty($_POST['comment']))&&(!empty($_POST['password']))){
$id=$_POST['edit_post'];
$name=$_POST['name'];
$comment=$_POST['comment'];
$pass=$_POST['password'];
$sql='update keijiban set name=:name,comment=:comment where id=:id and password=:password';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->bindParam(':password',$pass,PDO::PARAM_STR);
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
$stmt->execute();
}
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<html lang="ja">

<h1>掲示板</h1>

<body>
<form action="mission_5-1.php" method="post">
<p>名前： <input type="text" name="name" value="<?php echo $editName; ?>"></p>
<p>コメント： <input type="text" name="comment" value="<?php echo $editComment; ?>"></p>
<p><input type="hidden" name="edit_post" value="<?php echo $editNumber; ?>"></p>
<p>パスワード：<input type="password" name="password"></p>
<p><input type="submit" name="submit" value="送信"></p>
</form>

<form action="mission_5-1.php" method="post">
<p>削除対象番号：<input type="text" name="deletenumber"></p>
<p>パスワード：<input type="password" name="password"></p>
<p><input type="submit" name="sakujo" value="削除"></p>
</form>

<form action="mission_5-1.php" method="post">
<p>編集対象番号：<input type="text" name="edit_number"></p>
<p>パスワード：<input type="password" name="password"></p>
<p><input type="submit" name="edit" value="編集"></p>
</form>
</body>
</html>

<?php
//表示フォーム
$sql='SELECT * FROM keijiban'; //keijibanの全データを取得する
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
//$rowの中にはテーブルのカラム名が入る
echo $row['id'].' '.$row['name'].' '.$row['comment'].' '.$row['post_date'].'<br>';
echo"<hr>";
}
?>