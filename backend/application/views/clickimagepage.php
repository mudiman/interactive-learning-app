<script src="<?php echo base_url('assets/js/lib/jquery-ui-1.10.4.custom.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/lib/angular.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/lib/ng-table.min.js')?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/imageclick.css')?>" />

<div class='container-fluid' id='main_panel'  ng-app="main" ng-controller="TagCtrl">
	<div>
		<div id='image_panel' class='row pull-left col-lg-6 col-lg-offset-1' >
			<img style="display:block"  id="loader_img" width="100%" height="100%" >
			<div id='mapper' >
				<button type="submit" class="glyphicon glyphicon-ok" ng-click='openDialog()'></button>
				<button type="submit" ng-click="removeTag()" class="glyphicon glyphicon-remove"></button>
			</div>

			<div id="planetmap">

			</div>
			<div id='form_panel'>
				<select class="btn btn-sm" id="tagtypeSelect">
					<option>Diamond</option>
					<option>Card</option>
				</select>

				<button type="submit" title="Save" class="btn btn-sm glyphicon glyphicon-bookmark" ng-click='addTag()'></button>
				<button type="submit" title="Cancel" class="btn btn-sm glyphicon glyphicon-remove-sign" ng-click='cancelTag()'></button>

			</div>
			<div class="form-group ">
				<?php echo validation_errors(); ?>
				<?php
                if (isset($error))
                    echo $error;
				?>
			</div>

		</div>
	</div>
	<div class="image_coordinates row pull-right col-lg-5">
		<? $this -> load -> view('common/imageupload'); ?>
		<div class="row">
			<button type="submit" class="btn  glyphicon glyphicon-plus" ng-click='newTag()'>
				Add tag
			</button>
		</div>
		<table ng-table class="table">
			<tr ng-repeat="tag in tags" ng-click="loadQA()">
				<td data-title="'#'">{{tag.id}}</td>
				<td data-title="'Item'">{{tag.tag_type}}</td>
				<td data-title="''"><button type="submit" data-id="{{tag.id}}" class="glyphicon glyphicon-picture" ng-click='showTag()'></button></td>
				<td data-title="''"><button type="submit" data-id="{{tag.id}}" class="glyphicon glyphicon-remove" ng-click='deleteTag()'></button></td>
			</tr>
		</table>
		<div class="row">
			<button type="submit" class="btn btn-lg  glyphicon glyphicon-phone" ng-click='previewClickImagePage()'>Preview</button>
			<button type="submit" class="btn btn-lg  glyphicon glyphicon-transfer" ng-click='saveQA()'>Save</button>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/js/imageclick.js')?>" type="text/javascript"></script>
