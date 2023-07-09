<?php
    $textfile = "mission_3-4.txt";
    $date = date("Y/m/d H:i:s");
    
    //編集機能
    if (!empty($_POST["edit_number2"])) {
        $edit_number2 = $_POST["edit_number2"];    
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        $fp = fopen($textfile, "w");
        for ($i = 0; $i < count($lines); $i++) {
            $array = explode("<>", $lines[$i]);
            if ($array[0] == $edit_number2) {
                fwrite($fp, $edit_number2."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date.PHP_EOL);
            } else {
                fwrite($fp, $lines[$i].PHP_EOL);
            }
        }
        fclose($fp);
    //新規投稿機能
    } elseif (!empty($_POST["name"]) && !empty($_POST["comment"])) { 
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $fp = fopen($textfile, "a");
        if (file_exists($textfile)) {
            $num = count(file($textfile)) + 1;
        } else {
            $num = 1;
        }
        fwrite($fp, $num."<>".$name."<>".$comment."<>".$date.PHP_EOL);
        fclose($fp);
    }
    
    //削除機能
    if (!empty($_POST["delete_number"])) { 
        $delete_number = $_POST["delete_number"];
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        $fp = fopen($textfile, "w");
            for ($i = 0; $i < count($lines); $i++) {
                $array = explode("<>", $lines[$i]);
                if ($array[0] != $delete_number) {
                    fwrite($fp, $lines[$i].PHP_EOL);
                } else {
                    fwrite($fp, "".PHP_EOL);
                }
            }
        fclose($fp);
    }  
    //編集番号送信後
    if (!empty($_POST["edit_number"])) { 
        $edit_number = $_POST["edit_number"];
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        for ($i = 0; $i < count($lines); $i++) {
            $array = explode("<>", $lines[$i]);
            if ($array[0] == $edit_number) {
                $edit_name = $array[1];
                $edit_comment = $array[2];
            }
        }
    }
    
?>

<h3><投稿></h3>
<form action = "" method = "POST">
    <input type = "hidden" name = "edit_number2" value = "<?php if(isset($edit_number)) {echo $edit_number;} ?>"><br>
    <input type = "text" name = "name" value = "<?php if(isset($edit_name)) {echo $edit_name;} ?>" placeholder = "名前を入力"><br>
    <input type = "text" name = "comment" value = "<?php if(isset($edit_comment)) {echo $edit_comment;} ?>" placeholder = "コメントを入力">
    <input type = "submit" name = "submit" value = "保存"><br><br>
    
<h3><削除></h3>
    <input type = "number" name = "delete_number" placeholder = "削除したい番号を入力">
    <input type = "submit" name = "submit" value = "削除"><br><br>

<h3><編集></h3>
    <input type = "number" name = "edit_number" placeholder = "編集したい番号を入力">
    <input type = "submit" name = "submit" value = "編集"><br><br>
</form>

<?php
    if (file_exists($textfile)) {
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        foreach($lines as $line) {
            echo $line."<br>";
        }
    }
?>