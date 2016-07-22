<script src="<?php echo base_url('assets/js/lib/jquery.form.min.js')?>" type="text/javascript"></script>
<div class="row">
	<?php echo form_open_multipart('page/imageUpload', array("id" => "MyUploadForm", "onSubmit" => 'return false', "class" => "", "role" => "form")); ?>
	<div class="form-group ">
		<?php echo validation_errors(); ?>
		<?php
        if (isset($error))
            echo $error;
		?>
	</div>
	<div class="form-group ">
		<input type="file" id="imageInput" name="userfile" size="20" />
		<p class="help-block">
			Please select image file for cover page. Image Type allowed: Jpeg, Jpg, Png and Gif. | Maximum Size 1 MB
		</p>
	</div>
	<div class="form-group ">
		<button type="submit" id="submit-btn" class="btn btn-default">
			upload
		</button>
		<img src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>" id="loading-img" style="display:none;" alt="Please Wait"/>
	</div>

	<div id="progressbox" style="display:none;">
		<div id="progressbar"></div >
		<div id="statustxt">
			0%
		</div>
	</div>
	<div id="output" class='hidden'></div>
	</form>
</div>

<style>
	#progressbox {
		border: 1px solid #0099CC;
		padding: 1px;
		position: relative;
		width: 400px;
		border-radius: 3px;
		margin: 10px;
		display: none;
		text-align: left;
	}
	#progressbar {
		height: 20px;
		border-radius: 3px;
		background-color: #003333;
		width: 1%;
	}
	#statustxt {
		top: 3px;
		left: 50%;
		position: absolute;
		display: inline-block;
		color: #000000;
	}
</style>