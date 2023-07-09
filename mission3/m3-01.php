<form action = "" method = "post">
    <input type = "name" name = "name">
    <input type = "comment" name = "comment">
    <input type = "submit" name = "submit">
</form>
<?php
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $date = date("Y/m/d H:i:s");
    if (!empty($name) && !empty($comment)) {
        $textfile = "mission_3-1.txt";
        $fp = fopen($textfile, "a");
        if (file_exists($textfile)) {
            $num = count(file($textfile)) + 1;
        } else {
            $num = 1;
        }
        fwrite($fp, $num."<>".$name."<>".$comment."<>".$date.PHP_EOL);
        fclose($fp);
    }
?>
    