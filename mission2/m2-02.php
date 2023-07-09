<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_2-2</title>
    </head>
    <body>
        <form action = "" method = "post">
            <input type = "text" name = "text">
            <input type = "submit" name = "submit">
        </form>
        <?php
        if (!empty($_POST["text"])) {
            $text = $_POST["text"];
            $textfile = "mission_2-2.txt";
            $fp = fopen($textfile, "a");
            fwrite($fp, $text.PHP_EOL);
            fclose($fp);
            
            if ($_POST["text"] == "完成！") {
                echo "おめでとう！";
            }
        }
        ?>
    </body>
</html>
