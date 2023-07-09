<?php
    $textfile = "mission_3-5.txt";
    $date = date("Y/m/d H:i:s");
    
    //編集＆投稿
    if (!empty($_POST["edit_number2"])) {
        $edit_number2 = $_POST["edit_number2"];    
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        $fp = fopen($textfile, "w");
        for ($i = 0; $i < count($lines); $i++) {
            $array = explode("<>", $lines[$i]);
            if ($array[0] == $edit_number2) {
                fwrite($fp, $edit_number2."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date."<>".$_POST["password"].PHP_EOL);
            } else {
                fwrite($fp, $lines[$i].PHP_EOL);
            }
        }
        fclose($fp);
    //新規投稿
    } elseif (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])) { 
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $password = $_POST["password"];
        $fp = fopen($textfile, "a");
        $items = file($textfile, FILE_IGNORE_NEW_LINES);
        if (count($items) > 0) {
            $item = explode("<>", array_pop($items));
            $num = $item[0] + 1;
        } else {
            $num = 1;
        }
        fwrite($fp, $num."<>".$name."<>".$comment."<>".$date."<>".$password.PHP_EOL);
        fclose($fp);
    }
    
    //削除
    if (!empty($_POST["delete_number"]) && !empty($_POST["password_del"])) { 
        $delete_number = $_POST["delete_number"];
        $password_del = $_POST["password_del"];
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        $fp = fopen($textfile, "w");
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
        fclose($fp);
    }  
    //編集情報送信
    if (!empty($_POST["edit_number"]) && !empty($_POST["password_edit"])) { 
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        for ($i = 0; $i < count($lines); $i++) {
            $array = explode("<>", $lines[$i]);
            if ($array[0] == $_POST["edit_number"] && $array[4] == $_POST["password_edit"]) {
                $edit_number = $_POST["edit_number"];
                $password_edit = $_POST["password_edit"];
                $edit_name = $array[1];
                $edit_comment = $array[2];
            } elseif ($array[0] == $_POST["edit_number"] && $array[4] != $_POST["password_edit"]) {
                echo "パスワードが一致しません";
            }
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
    <input type = "hidden" name = "edit_number2" value = "<?php if(isset($edit_number)) {echo $edit_number;} ?>"><br>
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
    if (file_exists($textfile)) {
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        foreach($lines as $line) {
            $array = explode("<>", $line);
            echo $array[0]." ".$array[1]." ".$array[2]."<br>パスワード：".$array[4]."<br>".$array[3]."<br><br>";
        }
    }
?>
</div>


