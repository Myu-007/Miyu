<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset= "UTF-8">
<title>Mission_5-01</title>
</head>
<body>
<?php
//データベースに接続//
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成//
$sql = "CREATE TABLE IF NOT EXISTS test3"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date TEXT,"
."password TEXT"
.");";
$stmt = $pdo -> query($sql);




//データーを入力//
if(!empty($_POST['name'])&&!empty($_POST['comment'])&& empty($_POST['edtxt'])&& !empty($_POST['password'])) {
  $sql = $pdo -> prepare("INSERT INTO test3 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
  $sql -> bindParam(':name', $name, PDO::PARAM_STR);
  $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
  $sql -> bindParam(':date', $date, PDO::PARAM_STR);
  $sql -> bindParam(':password', $password, PDO::PARAM_STR);
  $name = $_POST['name'];
  $comment = $_POST['comment'];
  $date = date("Y/m/d h:i:s");
  $password = $_POST['password'];
  $sql -> execute();
  $sql = 'SELECT * FROM test3';
  $stmt = $pdo -> query($sql);
  $results = $stmt -> fetchAll();
}


//削除//
if(!empty($_POST['deleteNo']) && $_POST['delPassword']) {
  $delete = $_POST['deleteNo'];
  $id = $delete; 
  $delPassword = $_POST['delPassword'];
  $password = $delPassword;
  $sql = 'delete from test3 where id=:id AND password=:password';
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
  $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
  $stmt ->execute();
  $sql = 'SELECT * FROM test3';
  $stmt = $pdo -> query($sql);
  $results = $stmt -> fetchAll();
} 

//編集//
if(!empty($_POST['editNo']) && !empty($_POST['ediPassword'])) {
  $editNo = $_POST['editNo'];
  $id = $editNo;
  $ediPassword = $_POST['ediPassword'];
  $password = $ediPassword;
  $sql = 'SELECT * FROM test3 WHERE id = :id AND password = :password';
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
  $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
  $stmt -> execute();
  $results = $stmt -> fetchAll();
  foreach($results as $row) {
    $ediNum = $row['id'];
    $ediname = $row['name'];
    $edicomment = $row['comment'];
  }
}

if(!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['edtxt'])&& !empty($_POST['password'])){
  $num = $_POST['edtxt'];
  $name = $_POST['name'];
  $comment = $_POST['comment'];
  $pass = $_POST['password'];
  $id = $num;
  $password = $pass;
  $sql = 'UPDATE test3 SET name = :name, comment = :comment WHERE id = :id AND password = :password';
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
  $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
  $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
  $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
  $stmt -> execute();
  $sql = 'SELECT * FROM test3';
  $stmt = $pdo -> query($sql);
  $results = $stmt -> fetchAll();
}

//テーブルを表示//
$sql = 'SELECT * FROM test3';
$stmt = $pdo -> query($sql);
$results = $stmt -> fetchAll();
foreach ($results as $row) {
  echo $row['id']. '';
  echo $row['name']. '';
  echo $row['comment']. ' ';
  echo $row['date'].'<br>';
echo "<hr>";
}

   
?>
<form action = "" method = "post">
  <p>入力用フォーム</p>
  <p><input type = "text" name = "name" placeholder = "名前" value = "<?php echo $ediname ?? "";?>"></p>
  <p><input type = "text" name = "comment" placeholder = "コメント" value = "<?php echo $edicomment ?? "";?>"></p>
  <p><input type = "hidden" name = "edtxt" placeholder = "編集内容" value = "<?php echo $ediNum ?? "";?>"></p>
  <p><input type = "password" name = "password" placeholder = "パスワード" value = "<?php echo $editPass ?? "";?>"></p>
  <p><input type = "submit" name = "submit" value = "送信" ></p>
  <p>削除番号指定用フォーム</p>
  <p><input type = "text" name = "deleteNo" placeholder = "数字"></p>
  <p><input type = "password" name = "delPassword" placeholder = "パスワード"></p>
  <p><input type = "submit" name = "delete" value = "削除"></p>
  <p>編集番号指定用フォーム</p>
  <p><input type = "number" name = "editNo" placeholder = "編集対象番号"></p>
  <p><input type = "password" name = "ediPassword" placeholder = "パスワード"></p>
  <p><input type = "submit" name = "edit" value = "編集"></p>
</form>
</body>
</html> 