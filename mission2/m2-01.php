<form action = "" method = "post">
    <input type = "text" name = "text" value = "コメント">
    <input type = "submit" name = "submit">
</form>
<?php
    $input = $_POST["text"];
    if (isset($_POST["text"])) {
        echo $input . "を受け付けました";
    }
?>