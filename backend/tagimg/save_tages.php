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


$sql = "insert into image_tages 
    (image_id,item_name,min_x,min_y,max_x,max_y,pos_x,pos_y,pos_w,pos_h) 
    values 
    ('$image_id','$item_name','$min_x','$min_y','$max_x','$max_y','$pos_x','$pos_y','$pos_w','$pos_h')";

mysql_query($sql);
?>
