/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function onBookSelect() {
	alert($(this).val());
}

function addpage(page,no) {
    console.info(page);
    console.info(no);
    $('#mybook').booklet("add", no, page);
    $("#mybook").booklet("option", "arrows", true);
}

function addDummyPages(end){
	var div='<div title="dummypage" class="contentpage"><p style="vertical-align: middle;text-align: center;height:100%">Dummy page</p></div>';
	var div2='<div class="contentpage"><p style="vertical-align: middle;text-align: center;height:100%">Your Page will be preview here</p></div>';
	if (end!=null){
		addpage(div,"end");
		addpage(div,"end");	
	}else{
		addpage(div,1);
		addpage(div,2);
	}
	
}

function initializeBooklet(){
	$( "#mybook" ).empty();
	var div='<div title="dummypage" class="contentpage"><p style="vertical-align: middle;text-align: center;height:100%">Dummy page</p></div>';
	$( "#mybook" ).html(div);
	$('#mybook').booklet({
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
		});
	
}


function previewPageFromBack(id){
    initializeBooklet();
    addDummyPages();
    $.getJSON(window.baseurl+"page/preview/"+id,function(page){
        console.info(page);
        previewBookPage(page,2,1);
      });
      addDummyPages("end");
}

function quizPages(quizdata,pagno){
	var pg=pagno;
	for (var i = 0; i < quizdata.length; i += 3) {
		createQuizPage(quizdata.slice(i,i+4),pg,i);
		pg++;
	}
}

function clickImagePage(){
    $("#clickableimage").bind("tap", clickImageTapHandler);
}

function clickImageTapHandler(event) {
    //[{"min_x":0.3404255319148936,"max_x":0.4765957446808511,"min_y":0.678,"max_y":0.87,
    //"tag_type":"Diamond","pos_x":160,"pos_y":339,"pos_w":64,"pos_h":96,"id":1,"$$hashKey":"00U"}]
        var specs=eval$(this).data('specs');
        var width = $(this).width();
        var height = $(this).height();

        var tapx = event.offsetX==undefined?event.layerX:event.offsetX;
        var tapy = event.offsetY==undefined?event.layerY:event.offsetY;
        var tapx  = (event.offsetX || event.clientX - $(event.target).offset().left);
        var tapy  = (event.offsetY || event.clientY - $(event.target).offset().top);

        var tapXratio = tapx / width;
        var tapYratio = tapy / height;
        for (pos in specs){
            var objspec=specs[pos];
        var minx = objspec['min_x'], maxx = objspec['max_x'], miny =objspec['min_y'], maxy = objspec['max_y'];

        if (tapXratio > minx && tapXratio < maxx && tapYratio > miny
                        && tapYratio < maxy) {


                audio.play();
                console.info(event.clientY+"  "+$("#sparkle").height()/2);
                $("#sparkle").css({'left':event.clientX-$("#sparkle").width()/2,'top':event.clientY-$("#sparkle").height()/2});
                $("#sparkle").show();



                $.wait(500).then(function() {
                        $("#sparkle").hide();
                });

        }
    }

}
function createQuizPage(qas,no,first){
	console.info(qas+"  "+no);
	var alphabets="abcdefghijklmnopqrstuvwxyz";
	var div='<div title="quiz page" class="quizpage">';
	div+='<h4 style="width:100%;text-align:center">Quiz</h4>';
	for (qa in qas){
		var quesans=qas[qa];
		div+='<div class="row quizClass"><label><b>'+qa+") "+quesans['question']+'?</b></label>';
		for (ans in quesans['answers']){
			var answer=quesans['answers'][ans];
                        var intVal = answer['status'] ? 1 : 0;
                        var temp=qa+intVal+ans;
			div+='<div class="input-group quizAnswersShow" data-ck='+temp+'><label data-qno="'+qa+'" data-ans="'+ans+'" class="quizAnswerText">'+alphabets[ans]+" -- "+answer['answer']+'</label></div>';
		}
		div+='</div>';
	}
	div+='</div>';
	console.info(div);
	addpage(div,no);
        
        $('.quizAnswerText').on('click',function(){
            var context=this;
            var temp=$(this).data('qno')+"1"+$(this).data('ans');
            console.info(temp+"=="+$(this).parent('.quizAnswersShow').data('ck'));
            if (temp==$(this).parent('.quizAnswersShow').data('ck')){
                $(context).parent('.quizAnswersShow').append('<label>&nbsp;&nbsp;(CORRECT!)<label>');
            }else
                $(context).parent('.quizAnswersShow').append('<label>&nbsp;&nbsp;(WRONG!)<label>');
            
            $(context).parents('.quizClass').find('.quizAnswersShow').each(function(){
                $(this).css('visibility','hidden');
            });
            $(context).parent('.quizAnswersShow').css('visibility','visible');
                
        });
}

function previewPage(pageType) {
	initializeBooklet();
	if (pageType != "COVER_PAGE")
		addDummyPages();
	if (pageType == "CONTENT_PAGE"){
		var page = '<div class="contentpage" title="preview page">' + CKEDITOR.instances.body.getData()+ '</div>';
		addpage(page,3);
		$('#mybook').booklet("gotopage", 3);
	}else if (pageType == "COVER_PAGE") {
		var div='<div style="padding:0"><img width="100%" height="100%" src="'+window.uploadimagefilename+'"/></div>';
		addpage(div,1);
		$('#mybook').booklet("gotopage", 1);
	} else if (pageType == "IMAGE_PAGE") {
		var div='<div class="imagepage"><img width="80%" src="'+window.uploadimagefilename+'"/></div>';
		addpage(div,3);
		$('#mybook').booklet("gotopage", 3);
	} else if (pageType == "CLICKIMAGE_PAGE") {
		addpage(CKEDITOR.instances.body.getData());
		$('#mybook').booklet("gotopage", 4);
	}else if (pageType == "QUIZ_PAGE") {
		console.info(window.qas);
		quizPages(window.qas,1);
		$('#mybook').booklet("gotopage", 2);
	}
	addDummyPages(1);
}

function previewBookPage(page,pageno,gotopage) {
    console.info("preview page no "+pageno)
	if (typeof pageno === 'undefined') {
            pageno=page['page_no'];
        }
        console.info("preview page no "+pageno)
        var imagebasepath=window.baseurl+"/booksdata/"+page['books_id']+"/";
        var div="";
	if (page['page_type'] == "CONTENT_PAGE"){
		div = '<div title="'+page['page_type']+'" class="contentpage" title="preview page">' + page['body']+ '</div>';
		addpage(div,pageno);
	}else if (page['page_type'] == "COVER_PAGE") {;
		div='<div title="'+page['page_type']+'" style="padding:0"><img width="100%" height="100%" src="'+imagebasepath+page['image']+'"/></div>';
		addpage(div,1);
	} else if (page['page_type'] == "IMAGE_PAGE") {
            console.info(window.baseurl+page['image']);
		div='<div title="'+page['page_type']+'" class="imagepage"><img width="80%" src="'+imagebasepath+page['image']+'"/></div>';
		addpage(div,pageno);
	} else if (page['page_type'] == "CLICKIMAGE_PAGE") {
                console.info(page);
		div='<div title="'+page['page_type']+'" class="imagepage"><img class="clickimageimg" data-specs="'+page['body']+'" width="80%" src="'+imagebasepath+page['image']+'"/></div>';
		addpage(div,pageno);
	}else if (page['page_type'] == "QUIZ_PAGE") {
		//console.info(page['body']);
		quizPages(JSON.parse(page['body']),pageno)
	}
        if (typeof gotopage !== 'undefined') {
            $('#mybook').booklet("gotopage", pageno);
        }
       // console.info(div);
	
}

function previewBook(bookid){
	initializeBooklet();
	$.getJSON(window.baseurl+"book/preview/"+bookid,function(pages){
	    $.each(pages, function(i, field){
	    	previewBookPage(field);
	    });
	  });
	
}