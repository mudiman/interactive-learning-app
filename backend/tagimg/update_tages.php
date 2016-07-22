<?php

include 'dbconfig.php';

$min_x = $_REQUEST['min_x'];
$min_y = $_REQUEST['min_y'];
$max_x = $_REQUEST['max_x'];
$max_y = $_REQUEST['max_y'];
$item_name = $_REQUEST['item_name'];
$image_id = $_REQUEST['image_id'];

$pos_x = $_REQUEST['pos_x'];
$pos_y = $_REQUEST['pos_y'];
$pos_w = $_REQUEST['pos_w'];
$pos_h = $_REQUEST['pos_h'];
$taging_id = $_REQUEST['taging_id'];


$sql = "update image_tages set min_x = '$min_x',min_y='$min_y',max_x='$max_x',max_y='$max_y',pos_x='$pos_x',pos_y='$pos_y',pos_w='$pos_w',pos_h='$pos_h' where id = $taging_id";

mysql_query($sql);


?>
