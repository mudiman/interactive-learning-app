<style>
	.screenupper {
		width: 100%;
		margin-bottom: 10px;
	}
	.screenlower {
		width: 1160px;
		background-image: url('story-book.png');
		height: 616px;
	}
	.pagebox {
		/*        background-color: red;*/
		width: 500px;
		height: 550px;
		margin-left: 55px;
		padding-top: 50px;
		float: left;
	}
	.imagebox {
		/*        background-color: red;*/
		width: 500px;
		height: 550px;
		float: left;
		padding-top: 50px;
		margin-left: 55px;
	}
	.clear {
		clear: both;
	}

</style>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<?php $contents = file_get_contents('pagecontents.html'); ?>
<div class="menubar">
	<h4><a href="../index.php">Tag image</a></h4>
</div>
<div class="screenupper">
	<form action="save_contents.php" method="POST">
		<textarea class="ckeditor" name="pagebody"><?php echo $contents; ?></textarea>
		<br/>
		<input type="submit" value="Save"/>
	</form>
</div>
<div class="clear"></div>
<div class="screenlower">
	<div class="pagebox">
		<?php
        echo $contents;
		?>
	</div>

	<div class="imagebox">
		<img src="sleep.png" width="500" height="550" />
	</div>

</div>