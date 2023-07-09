<?php
    $str = "ようこう";
    $filename="mission_1-25-w.txt";
    $fp = fopen($filename,"w");
    fwrite($fp, $str.PHP_EOL);
    fclose($fp);
    echo "書き込み成功！";
?>