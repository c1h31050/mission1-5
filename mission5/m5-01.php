<?php
    //接続
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //テーブルを作成
    $sql = "CREATE TABLE IF NOT EXISTS five"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TIMESTAMP,"
    . "password TEXT"
    .");";
    $stmt = $pdo->query($sql);
    
    //編集＆投稿
    if (!empty($_POST["edit_number2"])) {
        $sql = 'UPDATE five SET name=:name,comment=:comment,date=now(),password=:password WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':id', $edit_number2, PDO::PARAM_INT);
        
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $password = $_POST["password"];
        $edit_number2 = $_POST["edit_number2"];
        
        $stmt->execute();
    
    //新規投稿
    } elseif (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])) { 
        $sql = $pdo -> prepare("INSERT INTO five (name, comment, date, password) VALUES (:name, :comment, now(), :password)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        //$sql -> bindParam(':date', $date, PDO::PARAM_STR);
        $sql -> bindParam(':password', $password, PDO::PARAM_STR);
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        //$date = time();
        //$date = date("Y/m/d H:i:s");
        $password = $_POST["password"];
        $sql -> execute();
    }
    
    //削除
    if (!empty($_POST["delete_number"]) && !empty($_POST["password_del"])) { 
        $delete_number = $_POST["delete_number"];
        $password_del = $_POST["password_del"];
        //削除したい番号のパスワードをデータベースから取得
        $sql = "SELECT password FROM five WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $delete_number, PDO::PARAM_INT);
        $stmt->execute();
        $password = $stmt->fetchColumn();
        
        if ($password == $password_del) {
            $sql = 'delete from five where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $delete_number, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            echo "パスワードが一致しません";
        }
        
        /*$fp = fopen($textfile, "w");
            for ($i = 0; $i < count($lines); $i++) {
                $array = explode("<>", $lines[$i]);
                if ($array[0] == $delete_number && $array[4] == $password_del) {
                    
                } elseif ($array[0] == $delete_number && $array[4] != $password_del) {
                    fwrite($fp, $lines[$i].PHP_EOL);
                    echo "パスワードが一致しません";
                } else {
                    fwrite($fp, $lines[$i].PHP_EOL);
                }
            }
        fclose($fp);*/
    }  
    
    //編集情報送信
    if (!empty($_POST["edit_number"]) && !empty($_POST["password_edit"])) { 
        $sql = 'SELECT * FROM five WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $edit_number, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $edit_number = $_POST["edit_number"];
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetch(PDO::FETCH_NUM); 
        
        if ($results[4] == $_POST["password_edit"]) {
            $edit_number2 = $edit_number;
            $password_edit = $_POST["password_edit"];
            $edit_name = $results[1];
            $edit_comment = $results[2];
        } else {
            echo "パスワードが一致しません";
        }
    }
    
?>
<style>
    .box1 {
        float:left;
        width:40%;
    }
    .box2 {
        float:left;
        width:50%;
    }
</style>
<div class = "box1">
<h2>好きなお菓子</h2>
<form action = "" method = "POST">
    <input type = "hidden" name = "edit_number2" value = "<?php if(isset($edit_number2)) {echo $edit_number2;} ?>"><br>
    <h3><投稿></h3>
    <input type = "text" name = "password" value = "<?php if(isset($password_edit)) {echo $password_edit;} ?>" placeholder = "パスワードを入力"><br>
    <input type = "text" name = "name" value = "<?php if(isset($edit_name)) {echo $edit_name;} ?>" placeholder = "名前を入力"><br>
    <input type = "text" name = "comment" value = "<?php if(isset($edit_comment)) {echo $edit_comment;} ?>" placeholder = "好きなお菓子の名前を入力">
    <input type = "submit" name = "submit" value = "保存"><br>
</form>
<hr width = "60%" align = "left">
    
<h3><削除></h3>
<form action = "" method = "POST">
    <input type = "number" name = "delete_number" placeholder = "削除したい番号を入力"><br>
    <input type = "text" name = "password_del" placeholder = "パスワードを入力">
    <input type = "submit" name = "submit" value = "削除"><br>
</form>
<hr width = "60%" align = "left">

<h3><編集></h3>
<form action = "" method = "POST">
    <input type = "number" name = "edit_number" placeholder = "編集したい番号を入力"><br>
    <input type = "text" name = "password_edit" placeholder = "パスワードを入力">
    <input type = "submit" name = "submit" value = "編集"><br>
</form>
<hr width = "60%" align = "left"><br>
</div>

<div class = "box2">
<h3>一覧</h3>
<?php
    $dsn = 'mysql:dbname=tb250139db;host=localhost';
    $user = 'tb-250139';
    $password = '7ewvTVf3ub';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    /*//レコードの数を取得
    $sql = "SELECT COUNT(*) FROM five";
    $stmt = $pdo->query($sql);
    $count = $stmt->fetchColumn();*/
    
    //テーブルのidを$ids配列に格納
    $sql = "SELECT id FROM five";
    $stmt = $pdo->query($sql);
    $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

    //$idをレコードの数だけループで取り出す
    foreach($ids as $id) {
        $sql = 'SELECT * FROM five WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date'].',';
            echo $row['password'].'<br>';
            echo "<hr>";
        }
    }
?>
</div>
    
    