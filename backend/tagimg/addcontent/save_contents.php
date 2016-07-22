<?php
$text = $_REQUEST['pagebody'];

$text = stripcslashes($text);

file_put_contents('pagecontents.html', $text);

header('location:index.php');
?>
