<form action = "" method = "post">
    <input type = "name" name = "name">
    <input type = "comment" name = "comment">
    <input type = "submit" name = "submit" value = "保存"><br>
    <input type = "number" name = "number" spaceholder = "削除したい番号を入力してください">
    <input type = "submit" name = "submit" value = "削除">
</form>
<?php
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $date = date("Y/m/d H:i:s");
    $textfile = "mission_3-3.txt";
    
    if (!empty($name) && !empty($comment)) {
        $fp = fopen($textfile, "a");
        if (file_exists($textfile)) {
            $num = count(file($textfile)) + 1;
        } else {
            $num = 1;
        }
        fwrite($fp, $num."<>".$name."<>".$comment."<>".$date.PHP_EOL);
        fclose($fp);
    } elseif (!empty($_POST["number"])) {
        $delete_number = $_POST["number"];
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
    
    if (file_exists($textfile)) {
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        foreach($lines as $line) {
            echo $line."<br>";
        }
    }
?>