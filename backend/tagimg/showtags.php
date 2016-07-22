<?php
include 'dbconfig.php';

$image_id = $_REQUEST['image_id'];
$html = "";
$sql = "select * from image_tages where image_id = $image_id";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)){
   
    $taging_id = $row['id'];
    $pos_x = $row['pos_x'];
    $pos_y = $row['pos_y'];
    $pos_h = $row['pos_h'];
    $pos_w = $row['pos_w'];
    $image_id = $row['image_id'];
    
    $item_name = $row['item_name'];
    
    $posp5 = $pos_h+5;
    
             $html .= "<div class='tagged' id='$taging_id' alt='$image_id' style='width:$pos_w;height:
                    $pos_h;left:$pos_x;top:$pos_y;'><div class='tagged_box' style='width:$pos_w;height:
                    $pos_h;display:none;' ></div><div class='tagged_title' style='top:$posp5;display:none;' >$item_name
                    </div></div>";
    
}

echo $html;

?>
