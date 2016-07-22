
<? $this -> load -> view('common/imageupload') ?>

<?php echo form_open_multipart('page/addImagePage', array("class" => "col-lg-6 col-lg-offset-1", "role" => "form")); ?>
<div class="form-group ">
    <?php echo validation_errors(); ?>
    <?php if (isset($error)) echo $error;?>
</div>
<div class="form-group top-buffer">
        <button class="btn btn-info glyphicon glyphicon-book" onclick="previewPage('IMAGE_PAGE')" type="button" data-toggle="modal" data-target="#myModal">
          Preview
        </button>
        <button type="submit" class="btn btn-default">Submit</button>
</div>
</form>

<?php $this->load->view("common/pagepreview"); ?>

