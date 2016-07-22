<?php

include 'dbconfig.php';

$taging_id = $_REQUEST['taging_id'];
$html = "";
$sql = "delete from image_tages where id = $taging_id";
$result = mysql_query($sql);

?>
