/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(
function($)
{
    $(".calendar").popover();
    $(".delete").tooltip();
    $("#create_news").collapse();

    $(".filtericon").hide().filter(".all").show();

    $(".filter").click(function(event){
        var arrClass = event.target.className.split(" ");

        if(arrClass[1] == "all")
        {
            $(".obj_news").show();
            $(".filtericon").hide().filter(".all").show();
        }
        else
        {
            $(".obj_news").hide();
            $(".filtericon").hide();

            $(".obj_news").filter("."+arrClass[1]).show();
            $(".filtericon").filter("."+arrClass[1]).show();
        }
     
    });
}
)(jQuery);


