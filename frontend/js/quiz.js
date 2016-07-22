
$(function() {

	// IBRAHIM code start 
    var attemptedQsArray = [];
    var currentQID;
        $(".correct").hide();
        $(".ans").css("color", "#5CACEE").css("margin-left", "20px");

        $(".ans").hover(function()
        {
           currentQID = $(this).closest('div').attr('id');
//            alert(currentQID + jQuery.inArray(currentQID, attemptedQsArray));
           if (jQuery.inArray(currentQID, attemptedQsArray) == -1)
           {
               $(this).css("color","#A4D3EE");
//               alert(currentQID);
           }
        },
        function()
        {
            if (jQuery.inArray(currentQID, attemptedQsArray) == -1)
            {
                $(this).css("color","#5CACEE");
//               alert(currentQID);
            }
        });

        $(".ans").on("click",function()
        {
            if (jQuery.inArray(currentQID, attemptedQsArray) == -1)
            {
                if($('#'+currentQID + " .correct").html() == $(this).html())
                {
                    $('#'+currentQID + " .ans").css("color","#FFFFFF");
                    $(this).css("color","#5CACEE");
                    $(this).append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(CORRECT!)");
                }
                else if($('#'+currentQID + " .correct").html() != $(this).html())
                {
                    $('#'+currentQID + " .ans").css("color","#FFFFFF");
                    $(this).css("color","#EF8B8B");
                    $(this).append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(WRONG!)");
                }

                attemptedQsArray.push(currentQID);
//                alert($(".correct").html() + $(this).html());
            }
        });
    
    
    // IBRAHIM code ends
});