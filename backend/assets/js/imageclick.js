$(document)
		.ready(
				function() {
					// // test start
					$('#loader_img').show();
					$('#imageMap').load(function() {
						$('#loader_img').hide();
					});

					$('#loader_imgs').show();

				});

$(".tagged")
		.on("click",
				function() {

					var taging_id = $(this).attr("id");
					var image_id = $(this).attr("alt");
					$(this)
							.find(".tagged_box")
							.html(
									"<img src='del.png' class='openDialog' value='Delete' onclick='deleteTag("
											+ taging_id
											+ ","
											+ image_id
											+ ")' />\n\
                    <img src='save.png' onclick='editTag("
											+ taging_id + "," + image_id
											+ ");' value='Save' />");

					var img_scope_top = $("#imageMap").offset().top
							+ $("#imageMap").height()
							- $(this).find(".tagged_box").height();
					var img_scope_left = $("#imageMap").offset().left
							+ $("#imageMap").width()
							- $(this).find(".tagged_box").width();

					$(this).draggable(
							{
								containment : [ $("#imageMap").offset().left,
										$("#imageMap").offset().top,
										img_scope_left, img_scope_top ]
							});
					$(this).resizable({
						containment : "#imageMap",
					});
				});





var app = angular.module('main', ['ngTable']).controller('TagCtrl', function($scope) {
    $scope.pos=1;
    $scope.tags = [
        ];
    $scope.newTag=function(){
    	$('#mapper').css('top','0px');
    	$('#mapper').css('left','15px');
    	$('#mapper').show();
    }
    $scope.openDialog = function() {
    	var position = $('#mapper').position();
    	var pos_t = position.top;

    	$("#form_panel").css({
    		"top" : pos_t + "px"
    	});
    	$("#form_panel").fadeIn("slow");
    };
    $scope.cancelTag = function() {
    	$("#title").val('');
    	$("#form_panel").hide();
    }
    
    $scope.addTag = function() {
    	var position = $('#mapper').position();
    	var index=$('#mapper').data('index');
    	console.info(index+" aaaa");
    	console.info($scope.tags[index]+" aaaa");
    	var pos_x = position.left;
    	var pos_y = position.top;
    	var pos_width = $('#mapper').width();
    	var pos_height = $('#mapper').height();

    	// // asghar's code start

    	var start_x = pos_x;
    	var start_y = pos_y;
    	var end_x = pos_x + pos_width;
    	var end_y = pos_y + pos_height;
    	var image_width = $('#loader_img').width();
    	var image_height = $('#loader_img').height();

    	var min_x = start_x / image_width;
    	var max_x = end_x / image_width;
    	var min_y = start_y / image_height;
    	var max_y = end_y / image_height;
    	var tag_type = $("#tagtypeSelect").val();
    	
    	var obj={
    			"min_x" : min_x,
    			"max_x" : max_x,
    			"min_y" : min_y,
    			"max_y" : max_y,
    			"tag_type" : tag_type,
    			"pos_x" : pos_x,
    			"pos_y" : pos_y,
    			"pos_w" : pos_width,
    			"pos_h" : pos_height
    		};
    	if (typeof(index) != "undefined"){
    		console.info("inside");
    		obj["id"]=$scope.tags[index]['id'];
    		console.info(obj);
    		$scope.tags[index]=obj;
    		$('#mapper').data('index',null);
    	}else{
    		obj["id"]=$scope.pos;
    		$scope.tags.push(obj);
    	}
    	$scope.pos++;
    	$("#mapper").hide();
    	$("#form_panel").hide();

    }
    
    $scope.showTag=function(){
    	console.info(this.$index);
    	var tag=$scope.tags[this.$index];
    	console.info(tag);
    	
    	$('#mapper').css('top',tag['pos_y']);
    	$('#mapper').css('left',tag['pos_x']);
    	$('#mapper').css('width',tag['pos_w']);
    	$('#mapper').css('height',tag['pos_height']);
    	$('#mapper').data('index',this.$index);
    	$('#mapper').show();
    }
    
    $scope.deleteTag = function() {
    	$scope.tags.splice(this.$index,1);
    }
    $scope.removeTag = function() {
    	$("#mapper").hide();
    }
    
    $scope.previewClickImagePage=function(){
        window.tags=$scope.tags;
        previewPage('CLICKIMAGE_PAGE')
   }
   
   $scope.saveQA=function(){

       $.ajax({
           url: window.baseurl+"page/addClickImagePage",
           data: "tags="+JSON.stringify($scope.tags),
           method:"POST",
           contentType: 'application/x-www-form-urlencoded',
       }).done(function() {
          window.location=window.baseurl+"page/managepage#pageadded";
           $('.page_order_alert').removeClass('hidden');
       });
   }
})