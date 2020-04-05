<!DOCTYPE html>
<meta charset="UTF-8">
<html lang="ja">

<h1>掲示板</h1>

<form action="mission_3-3-5.php" method="post">
<p>名前： <input type="text" name="name"></p>
<p>コメント： <input type="text" name="comment"></p>
<p><input type="submit" name="soshin" value="送信"></p>
</form>

<form action="mission_3-3-5.php" method="post">
<p>削除対象番号：<input tipe="text" name="number"></p>
<p><input type="submit" name="sakujo" value="削除"></p>
</form>

</html>

<?php
$filename="mission_3-3-5.txt";
//新規投稿の処理
if(isset($_POST["name"]) && isset($_POST["comment"])){
  $name=$_POST["name"];
  $comment=$_POST["comment"];
  $date=date("Y/m/d H:i:s");

//file関数→end関数→explolde関数→値を＋１ 
  if (!file_exists($filename)){
   $num=1;
  }else{
   $comment_array=file($filename);
   $END=end($comment_array);
   $lastarray=explode("<>",$END);
   $num=$lastarray[0]+1;
  }

 $fp=fopen($filename,"a");
  fwrite($fp,$num.'<>'.$name.'<>'.$comment.'<>'.$date.'<>'."\n");
  fclose($fp);
}

 $filename="mission_3-3-5.txt";
  if (file_exists($filename)){
    $delDate = file($filename);
     foreach ($delDate as $delCon){
     explode ("<>",$delCon);
        echo $delCon.'<br>';
     }
  }

//削除の処理 $_POST["name"]と$_POST["comment"]が空であることを確かめる
if(isset($_POST["number"]) && !isset($_POST["name"]) && !isset($_POST["comment"])){
 $kazu=$_POST["number"]; //削除対象番号送信
 $delete=$_POST["sakujo"];
 $lines = file($filename); //ファイルの読み込み（配列として）

  $fp=fopen($filename,"w"); //一旦消去
      foreach($lines as $line){
      $data = explode("<>", $line);
     if ($data[0] == $_POST["number"]){ //番号が一致しているなら
        fwrite($fp,"");
     }else{ //番号が一致していないなら
        fwrite($fp,$line); //元々のデータを書き込む
     }
   }
   fclose($fp);
}
?>