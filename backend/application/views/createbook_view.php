<?php echo validation_errors(); ?>
<?php echo form_open('book/register', array("class" => "col-lg-6 col-lg-offset-2", "role" => "form")); ?>
<legend>Add new Book</legend>
<div class="form-group top-buffer">
	<label class="control-label" for="name">Book name:</label>
	<input type="text" class="col-lg-4 form-control" name="name" value="<?php echo set_value('name', $this -> session -> flashdata('name')); ?>" size="40" />
</div>
<div class="form-group top-buffer">
	<label class="control-label" for="name">Author name:</label>
	<input type="text" class="col-lg-4 form-control" name="author_name" value="<?php echo set_value('author_name', $this -> session -> flashdata('author_name')); ?>" size="40" />
</div>
<div class="control-group top-buffer">
	<button class="btn col-lg-2  btn-primary" type="submit">
		Create
	</button>
</div>
<?php echo form_close(); ?>

