<script src="<?php echo base_url('assets/js/lib/ckeditor.js')?>" type="text/javascript"></script>
<?php echo form_open('page/addContentPage', array("class" => "col-lg-6 ", "role" => "form")); ?>
<div class="form-group ">
    <?php echo validation_errors(); ?>
    <?php if (isset($error)) echo $error;?>
</div>

<div class="form-group ">
        <legend>Add content page</legend>
        <div class="form-group">
            <input type="text" class="col-lg-2 form-control" placeholder="Enter page title" name="title" value="<?php echo set_value('name', $this -> session -> flashdata('title')); ?>" size="40" />
        </div>
         <div class="form-group">
            <label class="control-label" for="name">Content:</label>
            <? echo form_textarea(array("id"=>"body","name"=>"body","rows"=>"10","col"=>"500")); ?>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'body' );
            </script>
            </div>
</div>
<div class="form-group">
        <button class="btn btn-info" onclick="previewPage('CONTENT_PAGE')" type="button" data-toggle="modal" data-target="#myModal">
          Preview
        </button>
        <button  type="submit" class="btn btn-default">Submit</button>
</div>
</form>

<?php $this->load->view("common/pagepreview"); ?>
