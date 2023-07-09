<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_1-27</title>
    </head>
    <body>
        <!-- フォームに入力された数値 -->
        <form action = "" method = "post">
            <input type = "number" name = "num" placeholder = "数字を入力してください">
            <input type = "submit" name = "submit">
        </form>
        <?php
        //ファイルに追記で記録（数字のまま・改行）
        if (isset($_POST["num"])) {
            $str = $_POST["num"];
            $file = "mission_1-27.txt";
            $fp = fopen($file, "a");
            fwrite($fp, $str.PHP_EOL);
            fclose($fp);
            echo "書き込み成功！". "<br>";
        }
        //内容を画面に表示（FizzBuzz）
        if (file_exists($file)) {
            $lines = file($file, FILE_IGNORE_NEW_LINES);
            foreach ($lines as $line) {
                if ($line % 3 == 0 && $line % 5 == 0) {
                    echo "FizzBuzz";
                } elseif ($line % 3 == 0) {
                    echo "Fizz";
                } elseif ($line % 5 == 0) {
                    echo "Buzz";
                } else {
                    echo $line;
                }
                echo " ";
            }
        }
        ?>
    </body>
</html>