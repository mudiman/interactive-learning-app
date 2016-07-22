$(document).bind("mobileinit", function() {
	
	$.mobile.orientationChangeEnabled = false;
	$.mobile.loader.prototype.options.text = "loading";
	$.mobile.loader.prototype.options.textVisible = false;
	$.mobile.loader.prototype.options.theme = "a";
	$.mobile.loader.prototype.options.html = "";

	$.mobile.ajaxEnabled = false;
	$.mobile.allowCrossDomainPages = true;
	$.mobile.changePage("#index", {
		transition : "slide",
		reverse : true,
		changeHash : false
	});
});

function loginPageCreate(){
	// $( "#index" ).on( "pagecreate", function( event ) {
		$('#logindiv').height($(window).height());
		$('#logindiv').width($(window).width());
		
		function login(){
			$.ajax({url: 'check.php',
	            data: {action : 'login', formData : $('#check-user').serialize()},
	            type: 'post',                   
	            async: 'true',
	            dataType: 'json',
	            beforeSend: function() {
	                // This callback function will trigger before data is sent
	            	$.mobile.loading('show'); // This will show ajax spinner
	            },
	            complete: function() {
	                // This callback function will trigger on data sent/received
					// complete
	            	$.mobile.loading('hide'); // This will hide ajax spinner
	            },
	            success: function (result) {
	                if(result.status) {
	                	$.mobile.changePage("#maindiv", {
	                		transition : "slidedown",
	                		reverse : true,
	                		changeHash : false
	                	});
	                } else {
	                   $('#loginmessage').html('Login unsuccessful!'); 
	                }
	            },
	            error: function (request,error) {
	                // This callback function will trigger on unsuccessful
					// action
	                alert('Network error has occurred please try again!');
	            }
	        });
		}
		
		$('#password,#username').on('keypress',function(e) {
		    if(e.which == 13) {
		    	login();
		    }
		});
		
		$('#loginbutton').on('click',login);
		
		
	// });
}

function bookpageinit(){
	
	// $('#maindiv').on( "pagecreate",function( event ) {
		// $('#slider-1').hide();
		
		
	// });
}


function resizeComponents(){
	if ($('#headerdiv').is(":visible")){
		$('#mybook').booklet("option","width",$(window).width()*.9);
		$('#mybook').booklet("option","height",$(window).height()*.79);
	}else{
		$('#mybook').booklet("option","width",$(window).width()*.8);
		$('#mybook').booklet("option","height",$(window).height() * .79);
	}
}

function bookpageShow(){
	$('#togglebarsbutton').on('click',function(){
		if ($('#headerdiv').is(":visible")){
			$('#headerdiv').hide();
			$('#footerdiv').hide();
			$('#mybook').booklet("option","width",$(window).width()*.9);
			$('#mybook').booklet("option","height",$(window).height()*.95);
		}else{
			$('#headerdiv').show();
			$('#footerdiv').show();
			$('#mybook').booklet("option","width",$(window).width()*.8);
			$('#mybook').booklet("option","height",$(window).height() * .8);
		}
	});
	
	$('#maindiv').on( "pageshow",function( event ) {
		//console.info("mainpage");
		$('#slider-1').hide();
		$('#slider-1').attr('max',$(".b-page").length-2);
		
		$('#slider-1').on( 'slidestop', function( event ) {
			$('#mybook').booklet("gotopage", $('#slider-1').val());
		});
		
		$( "#slider-1" ).on('change',function() {
			updatePagePreviewPosition();
					
		
		});
		
		$('.ui-slider-handle').on( 'mouseout', function( event ) {
			$.wait(1000).then(function() {
				$("#pagePreviewdiv").hide();
			});
		});
		
	});
	
}