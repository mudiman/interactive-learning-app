function updatePagePreviewPosition(){
		// Odd no position like 5 page is 2 thumbnail
		var temp=Math.floor($('#slider-1').val()/2);
		// 101 is image thumbanil two page preview width
		temp=temp*101;
		temp="-"+temp+"px";
		var widthofpreviewdiv=$("#pagePreviewdiv").width();
		$('#pagePreviewdiv').css('background-position-x',temp);			
		if ($('#slider-1').attr('max')==$('#slider-1').val())
			$('.ui-slider-handle').css('left','96%');
		var previewdivleft=$('.ui-slider-handle').offset().left-30;
		$('#pagePreviewdiv').css("left",previewdivleft+"px");
		$("#pagePreviewdiv").show();

}


function addPage(page){
	//$('#mybook').booklet("add","start",page);
}


function testAddPage(){
	console.info("testAddpage");
	var page="<div class='contentpage'><h1 style='text-align:center'>Test</h1><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p></div>";
	addPage(page);
}


$.wait = function(time) {
	return $.Deferred(function(dfd) {
		setTimeout(dfd.resolve, time); // use setTimeout internally.
	}).promise();
}

$(function() {
	loginPageCreate();
	bookpageinit();
	bookpageShow();
	window.pageNumber=1;
	//single book
	$('#mybook').booklet({
		width : $(window).width()*.8,
		height : $(window).height() * .79,
		closed : true,
		covers: true,
		keyboard: true,
		pagePadding: 2,
		shadows : true,
		arrows: true,
		hovers: false,
		speed: 200,
		pageBorder : 0,
		hoverWidth:-1000,
		change: function(event, data) {
			$('#slider-1').val(data.index).slider('refresh');
			$("#pagePreviewdiv").hide();
			window.pageNumber=data.index;
		}

	});

	$('.b-wrap-left').parent('.b-page').each(function(){
		//$(this).addClass( "shadowleftdiv");
	});
	$('.b-wrap-right').parent('.b-page').each(function(){
		//$(this).addClass( "shadowrightdiv");
	});
	
	$('.b-arrow').on('click',function(){
		$(this).css('background-color','background-color:rgba(255,0,0,0.6);');
		$(this).find('div').css('opacity','1');
		var context=this;
		$.wait(200).then(function() {
			if (window.bookletarrowmouseover){
				$(context).css('background-color','background-color:rgba(255,0,0,0.8);');
				$(context).find('div').css('opacity','0.8');
			}
		});
	});
	$('.b-arrow').on('mouseover',function(){
		window.bookletarrowmouseover=true;
		$(this).css('background-color','background-color:rgba(255,0,0,0.8);');
		$(this).find('div').css('opacity','0.8');
	});
	$('.b-arrow').on('mouseout',function(){
		window.bookletarrowmouseover=false;
		$(this).css('background-color','background-color:rgba(255,0,0,0.4);');
		$(this).find('div').css('opacity','0.5');
	});
	
//	$('.b-wrap-right').parent('.b-page').css('box-shadow','0px 0px 10px 3px #70686a');
	
//	$('.b-arrow-next>div').on('mouseover',function(){
//		var rightOnlypageno=(window.pageNumber/2)-1;
//		$($('.b-wrap-right >:first-child').get(rightOnlypageno)).css("border-right","2px solid grey");
//		console.info(rightOnlypageno);
//	});
//	
//	$('.b-arrow-next>div').on('mouseout',function(){
//		var rightOnlypageno=(window.pageNumber/2)-1;
//		$($('.b-wrap-right >:first-child').get(rightOnlypageno)).css("border-right","none");
//	});
	
	//$('#mybook').booklet("remove", "end");
	
	//testAddPage();
	
	$( window ).resize(function() {
		  $( "#log" ).append( "<div>Handler for .resize() called.</div>" );
		  	var windowwidth = $(window).width();
			var fontSize = (15/1366)*windowwidth;
			$('.headerfont').css('font-size', fontSize + 'px');
			
			
			var bookfontSize = (12/1366)*windowwidth;
			$('.contentpage').css('font-size', bookfontSize + 'px');
			
			resizeComponents();
		});

	var audio=new Audio('DING.WAV');
	
	$("#clickableimage").bind("tap", tapHandler);
		
	function tapHandler(event) {
				
		
		var width = $(this).width();
		var height = $(this).height();

		var tapx = event.offsetX==undefined?event.layerX:event.offsetX;
		var tapy = event.offsetY==undefined?event.layerY:event.offsetY;
		var tapx  = (event.offsetX || event.clientX - $(event.target).offset().left);
		var tapy  = (event.offsetY || event.clientY - $(event.target).offset().top);
		
		var tapXratio = tapx / width;
		var tapYratio = tapy / height;

		var minx = 0.335, maxx = 0.4183, miny = 0.7288, maxy = 0.8559;

		if (tapXratio > minx && tapXratio < maxx && tapYratio > miny && tapYratio < maxy) {
			audio.play();
			console.info(event.clientX-$("#sparkle").width()/2+"  "+event.clientY-$("#sparkle").height()/2);
			$("#sparkle").css({'left':event.clientX-$("#sparkle").width()/2,'top':event.clientY-$("#sparkle").height()/2});
			$("#sparkle").show();
			$.wait(500).then(function() {
				$("#sparkle").hide();
			});
		}

	}

    
});