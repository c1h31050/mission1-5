<form action = "" method = "post">
    <input type = "text" name = "text">
    <input type = "submit" name = "submit">
</form>
<?php
    if (!empty($_POST["text"])) {
        $text = $_POST["text"];
        $textfile = "mission_2-4.txt";
        $fp = fopen($textfile, "a");
        fwrite($fp, $text.PHP_EOL);
        fclose($fp);
    }
    if (!empty($textfile)) {
        $lines = file($textfile, FILE_IGNORE_NEW_LINES);
        foreach($lines as $line) {
            echo $line."<br>";
        }
    }
?>