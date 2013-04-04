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

    $(".filter").click(function(event){
        var arrClass = event.target.className.split(" ");

        if(arrClass[1] == "all")
        {
            $(".obj_news").show();
        }
        else
        {
            $(".obj_news").hide();
            $(".obj_news").filter("."+arrClass[1]).show();
        }
     
    });
}
)(jQuery);


