<?php

include 'dbconfig.php';
$html = "";
$image_id = $_REQUEST['image_id'];
$sql = "select * from image_tages where image_id = $image_id";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)){
    $html .= "<tr class='min_max_tr'>
              <td>{$row['item_name']}</td> 
              <td><img src='del.png' class='openDialog' value='Delete' onclick='deleteTag({$row['id']},{$row['image_id']})' /></td>
            </tr>";
}

echo $html;

?>
