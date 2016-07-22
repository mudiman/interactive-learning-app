<ul id="siderbarmenu">
    <li><a href="<?php echo base_url('page/createbook')?>">Create Book</a></li>
    <li>Select Book to Edit</br>
        <?php 
        
        echo form_dropdown('name', $this -> session -> userdata('books'), $this -> session -> userdata('selectbook'),'id="bookselect" onChange="onBookSelect();"');
        ?>
    </li>
    <li>Add page to Book
            <ul>
                <li><a href="<?php echo base_url('page/cover');?>">Cover Page</a>
                <li><a href="<?php echo base_url('page/content');?>">Content Page</a></option>
                <li><a href="<?php echo base_url('page/clickimage');?>">Click Image Page</a></option>
                <li><a href="<?php echo base_url('page/image');?>">Image Page</a></option>
                <li><a href="<?php echo base_url('page/quiz');?>">Quiz Page</a></option>
                <li><a href="<?php echo base_url('page/preview');?>">Preview Book</a></option>
            </ul>
    </li>
</ul>
     