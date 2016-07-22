<h2>Pages</h2>
<?php      
    echo form_dropdown('name', $this -> session -> userdata('pages'), $this -> session -> userdata('selectedpage'),'id="pageselect" size="10" onChange="onPageSelect();"');
?>
<ul>
<li><a href="">Delete Page</a></li>
<li><a href="">Edit Page</a></li>
<li><a href="">Move Up</a></li>
<li><a href="">Move Down</a></li>
</ul>