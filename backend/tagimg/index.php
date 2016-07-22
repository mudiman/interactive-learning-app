<?php 
include 'dbconfig.php';
?>
<html>
    <head>
        <title>Image Tagging with jQuery and PHP</title>
        <link href="jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript" src="jquery-ui.min.js"></script>
        <style type="text/css" >

            body{
                font-size:13px;
                font-family:"Arial";
            }
            #mapper{
                border:2px solid #EEE;
                width:100px;
                height:100px;
                min-width:30px;
                min-height:30px;
                z-index:1000;
                position:absolute;
                top:0;
                display:none;
            }
            .tagged{
                min-width:40px;
                min-height:40px;
                z-index:1000;
                position:absolute;
            }

            #planetmap div{

                display:block;
                position:absolute;
            }




            #main_panel{
                margin: auto;
                padding: 10px;
/*                width: 1000px;*/
            }
            #url_panel{

            }
            #form_panel{
                float: left;
                background:#eee;
                border:5px solid #FFF;
                outline:1px solid #eee;
                left: 100px;
                padding: 5px;
                position: absolute;
                top: 40px;
                width: 335px;
                display:none;
                z-index:2000;
            }

            #form_panel input,textarea{
                padding:3px;
                background:#FFF;
                border:1px solid #CFCFCF;
                color:#000;
            }

            #image_panel{
                float:left;
                width:600px;
                position:relative;
                width: 500px;
                height: 500px;
            }
            #image_panel img{
/*                left:0;top:-102px;*/
                max-width: 600px;
                overflow: hidden;

            }
            .image_list{
                width: 200px;
                float: left;
                
            }
   .image_list_inner{
         margin-top: 5px;
                
            }
   .image_coordinates{
                float: left;
                min-width: 300px;
                margin-left: 50px;
                margin-right: 50px;
                
            }
            #form_panel .label{
                float:left;
                width:80px;
                padding:5px;
            }

            #form_panel .field{
                float:left;
                width:200px;
                padding:5px;
            }

            #form_panel .row{
                clear:both;
            }

            .tagged_title{
                background: none repeat scroll 0 0 #538DD3;
                border: 2px solid;
                color: #FFFFFF;
                font-size: 12px;
                font-weight: bold;
                padding: 3px;
                margin-top:5px;
            }


            #info_panel{
                padding:10px;
                margin:20px 0;
                background:#eee;
            }


            input[type='button']{
                background: none repeat scroll 0 0 #2769C4;
                border: 1px solid #CFCFCF;
                color: #FFFFFF;
                font-weight: bold;
                height: 30px;
                padding: 5px;
            }
            .clear{
                clear: both;
            }
            
            .min_max thead th{
                width: 100px;
                border: 1px solid black;
            }
            .min_max_tr{
                text-align: center;
            }
            .tablebody_min_max td{
                border:1px solid black;
            }

        </style>
        <script>
            $(document).ready(function() {
                //// test start
$('#loader_img').show();
$('#imageMap').load(function(){
$('#loader_img').hide();
});


$('#loader_imgs').show();
$('.image_list_inner').each(function(){
    var contex = this;
     $($(contex).children('img').get(0)).load(function(){
     $($(contex).children('img').get(1)).hide();
 });
    
  });

                ///// test ends
              var image_idt = $("#imageMap").attr('alt');

              $.ajax({
                     url : "showtags.php",
                     type:"POST",
                     data:{"image_id":image_idt}
                    }).done(function(resp){
                      $("#planetmap").html(resp);
                      $(".tagged_box").css("display","block");
                      $(".tagged").css("border","2px solid #EEE");
                      $(".tagged_title").css("display","block");
                    });
                    
                    

                $("#imageMap").click(function(e){


                    var image_left = $(this).offset().left;
                    var click_left = e.pageX;
                    var left_distance = click_left - image_left;

                    var image_top = $(this).offset().top;
                    var click_top = e.pageY;
                    var top_distance = click_top - image_top;

                    var mapper_width = $('#mapper').width();
                    var imagemap_width = $('#imageMap').width();

                    var mapper_height = $('#mapper').height();
                    var imagemap_height = $('#imageMap').height();


			



                    if((top_distance + mapper_height > imagemap_height) && (left_distance + mapper_width > imagemap_width)){
                        $('#mapper').css("left", (click_left - mapper_width - image_left  ))
                        .css("top",(click_top - mapper_height - image_top  ))
                        .css("width","100px")
                        .css("height","100px")
                        .show();
                    }
                    else if(left_distance + mapper_width > imagemap_width){


                        $('#mapper').css("left", (click_left - mapper_width - image_left  ))
                        .css("top",top_distance)
                        .css("width","100px")
                        .css("height","100px")
                        .show();
			
                    }
                    else if(top_distance + mapper_height > imagemap_height){
                        $('#mapper').css("left", left_distance)
                        .css("top",(click_top - mapper_height - image_top  ))
                        .css("width","100px")
                        .css("height","100px")
                        .show();
                    }
                    else{


                        $('#mapper').css("left",left_distance)
                        .css("top",top_distance)
                        .css("width","100px")
                        .css("height","100px")
                        .show();
                    }


                    $("#mapper").resizable({ containment: "parent" });
                    $("#mapper").draggable({ containment: "parent" });
                    
                });
                
                
                
                // new code start
                
                $(".image_list_inner_img").click(function(){
                    var id = $(this).data("imageid");
                    var image_path = $(this).attr('src');
                    $("#imageMap").attr("alt",id);
                    $("#imageMap").attr('src',image_path); 
                    
                    $.ajax({
                     url : "get_tages.php",
                     type:"POST",
                     data:{"image_id":id}
                    }).done(function(resp){
                      $("#tablebody_min_max").html(resp);  
                    });
                    
                     $.ajax({
                     url : "showtags.php",
                     type:"POST",
                     data:{"image_id":id}
                    }).done(function(resp){
                      $("#planetmap").html(resp);
                      $(".tagged_box").css("display","block");
                      $(".tagged").css("border","2px solid #EEE");
                      $(".tagged_title").css("display","block");
                    });

                });
                
                
                // new code  ends 


            });



     $(".tagged").live("click",function(){
                    
               var taging_id = $(this).attr("id");
               var image_id = $(this).attr("alt");
                $(this).find(".tagged_box").html("<img src='del.png' class='openDialog' value='Delete' onclick='deleteTag("+taging_id+","+image_id+")' />\n\
                    <img src='save.png' onclick='editTag("+taging_id+","+image_id+");' value='Save' />");

                var img_scope_top = $("#imageMap").offset().top + $("#imageMap").height() - $(this).find(".tagged_box").height();
                var img_scope_left = $("#imageMap").offset().left + $("#imageMap").width() - $(this).find(".tagged_box").width();

                $(this).draggable({ containment:[$("#imageMap").offset().left,$("#imageMap").offset().top,img_scope_left,img_scope_top]  });
                $(this).resizable({ containment: "#imageMap",});
                    //$(this).draggable({ containment: "parent" });

            });
            
            
            
            var cancelTag = function(){
               $("#title").val('');
                $("#form_panel").hide(); 
            }
            var addTag = function(){
                var position = $('#mapper').position();


                var pos_x = position.left;
                var pos_y = position.top;
                var pos_width = $('#mapper').width();
                var pos_height = $('#mapper').height();
                
                
                //// asghar's code start
                
                   var start_x = pos_x;
                   var start_y = pos_y;
                   var end_x = pos_x + pos_width;
                   var end_y = pos_y + pos_height;
                   var image_width = $('#imageMap').width();
                   var image_height = $('#imageMap').height();
                   
                   var min_x = start_x / image_width;
                   var max_x = end_x / image_width;
                   var min_y = start_y / image_height;
                   var max_y = end_y / image_height;
                   var item_name = $("#title").val();
                   var image_id = $("#imageMap").attr('alt');
                   
                   $.ajax({
                       type:"POST",
                       url:"save_tages.php",
                       data:{"min_x":min_x,"max_x":max_x,"min_y":min_y,"max_y":max_y,"image_id":image_id,"item_name":item_name,"pos_x":pos_x,"pos_y":pos_y,"pos_w":pos_width,"pos_h":pos_height}
                   }).done(function(resp){
                       
                     $.ajax({
                     url : "get_tages.php",
                     type:"POST",
                     data:{"image_id":image_id}
                    }).done(function(resp){
                      $("#tablebody_min_max").html(resp);  
                    });
                    
                    $.ajax({
                     url : "showtags.php",
                     type:"POST",
                     data:{"image_id":image_id}
                    }).done(function(resp){
                      $("#planetmap").html(resp);
                      $(".tagged_box").css("display","block");
                      $(".tagged").css("border","2px solid #EEE");
                      $(".tagged_title").css("display","block");
                    });
                       //alert("item saved in database");
                   });


                $("#mapper").hide();
                $("#title").val('');
                $("#form_panel").hide();
                

            };

            var openDialog = function(){
                var position = $('#mapper').position();
                var pos_t = position.top;
                
                $("#form_panel").css({"top":pos_t +"px"});
                $("#form_panel").fadeIn("slow");
            };

            var showTags = function(){
                $(".tagged_box").css("display","block");
                $(".tagged").css("border","2px solid #EEE");
                $(".tagged_title").css("display","block");
            };

            var hideTags = function(){
                $(".tagged_box").css("display","none");
                $(".tagged").css("border","none");
                $(".tagged_title").css("display","none");
            };
		
            var editTag = function(taging_id,image_id){
                 
                 
                 var position = $('.tagged#'+taging_id).position();


                var pos_x = position.left;
                var pos_y = position.top;
                var pos_width = $('.tagged#'+taging_id).width();
                var pos_height = $('.tagged#'+taging_id).height();
                
                   var start_x = pos_x;
                   var start_y = pos_y;
                   var end_x = pos_x + pos_width;
                   var end_y = pos_y + pos_height;
                   var image_width = $('#imageMap').width();
                   var image_height = $('#imageMap').height();
                   
                   var min_x = start_x / image_width;
                   var max_x = end_x / image_width;
                   var min_y = start_y / image_height;
                   var max_y = end_y / image_height;
                   var item_name = $("#title").val();
                   var image_id = $("#imageMap").attr('alt');

                 
                 $.ajax({
                     url : "update_tages.php",
                     type:"POST",
                     data:{"taging_id":taging_id, "min_x":min_x,"max_x":max_x,"min_y":min_y,"max_y":max_y,"image_id":image_id,"item_name":item_name,"pos_x":pos_x,"pos_y":pos_y,"pos_w":pos_width,"pos_h":pos_height}
                    }).done(function(){
                       $.ajax({
                     url : "get_tages.php",
                     type:"POST",
                     data:{"image_id":image_id}
                    }).done(function(resp){
                      $("#tablebody_min_max").html(resp);  
                    }); 
                    
                    $.ajax({
                     url : "showtags.php",
                     type:"POST",
                     data:{"image_id":image_id}
                    }).done(function(resp){
                      $("#planetmap").html(resp);
                      $(".tagged_box").css("display","block");
                      $(".tagged").css("border","2px solid #EEE");
                      $(".tagged_title").css("display","block");
                    });
                    
                    
                    });

            }

            var deleteTag = function(taging_id,image_id){
                
                 $.ajax({
                     url : "delete_tages.php",
                     type:"POST",
                     data:{"taging_id":taging_id}
                    }).done(function(){
                       $.ajax({
                     url : "get_tages.php",
                     type:"POST",
                     data:{"image_id":image_id}
                    }).done(function(resp){
                      $("#tablebody_min_max").html(resp);  
                    }); 
                    
                    $.ajax({
                     url : "showtags.php",
                     type:"POST",
                     data:{"image_id":image_id}
                    }).done(function(resp){
                      $("#planetmap").html(resp);
                      $(".tagged_box").css("display","block");
                      $(".tagged").css("border","2px solid #EEE");
                      $(".tagged_title").css("display","block");
                    });
                    
                    
                    });
                
                
               
            };



        </script>
    </head>
    <body>
        <div class="menubar">
            <h4><a href="addcontent/index.php">Add content</a></h4>
        </div>
        <div id='main_panel'>

             <div>
                <div id='image_panel' >
                    
                     <?php 
                    $sql = "select * from images order by id desc limit 1";
                   $result =  mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result)){
                        $iamgesrc = $row['image_path'];
                        $image_id = $row['id'];
                        //echo " <div class='image_list_inner' ><img src='{$row['image_path']}' id='imageMap'  width='200' height='200' class='image_list_inner_img' data-imageid='{$row['id']}' /></div> <div class='clear'></div>";
                    }
                    echo "<img src='loading_circle.gif' id='loader_img' width='500' height='500' style='position: absolute; z-index:999;'/>";
                    echo "<img src='$iamgesrc' id='imageMap'  width='500' height='500' alt='$image_id'/>";
                   
                    $minmaxhtml = "";
                    $sql = "select * from image_tages where image_id = $image_id";
                    $result = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result)){
                        $minmaxhtml .= "<tr class='min_max_tr'>
                           <td>{$row['item_name']}</td> 
                           <td>
                           <img src='del.png' class='openDialog' value='Delete' onclick='deleteTag({$row['id']},{$row['image_id']})' />
                           
                            </td>
                       </tr>";
                    }

                    ?>
                    
                    
                    
                    <div id='mapper' ><img src='save.png' onclick='openDialog()' width=20 height=20 />
                    
                    </div>

                    <div id="planetmap">

                    </div>
                    <div id='form_panel'>
                        <div class='row'>
                            <div class='label'>Title</div><div class='field'><input type='text' id='title' /></div>
                        </div>
                        <div class='row'>
                            <div class='label'></div>
                            <div class='field'>
                                <input type='button' value='Add Tag' onclick='addTag()' />
                                <input type='button' value='Cancel' onclick='cancelTag()' />

                            </div>
                        </div>

                    </div>
           <div style="background: none repeat scroll 0 0 #C7C7C8;
                 border: 1px solid #AEAEAE;
                 clear: both;
                 margin: 20px auto;
                 margin-top: 2px;
                 padding: 20px 0;
                 float: left;
/*                 text-align: center;*/
                 width: 498px;">
                <form action="upload_file.php" method="post" enctype="multipart/form-data">
                    Upload new Image:
                    <input type="file" name="file" />
                     <input type="submit" value="Upload">
                </form>
<!--                <input type="button" value="Show Tags" onclick="showTags()" />
                <input type="button" value="Hide Tags" onclick="hideTags()" />-->
            </div>
                </div>
                <div class="image_coordinates">
                    <table class="min_max">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Action</th>

                                
                            </tr>
                        </thead>
                        <tbody class="tablebody_min_max" id="tablebody_min_max">
                            <?php echo $minmaxhtml;?>
                        </tbody>
                    </table>
                 </div>
                 <div class="image_list">
                    <?php 
                    $sql = "select * from images order by id desc";
                   $result =  mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result)){
                        echo " <div class='image_list_inner' >
                            
                            <img src='{$row['image_path']}' id='imageMap'  width='200' height='200' class='image_list_inner_img' data-imageid='{$row['id']}' />
                            <img src='loading_circle.gif' id='loader_imgs' width='200' height='200' style='position: absolute; z-index:999; right: 235px;'/>
                          </div> <div class='clear'>
                        </div>";
                    }
                    
                    
                    ?>
                 </div>

            </div>

        </div>
    </body>
</html>




