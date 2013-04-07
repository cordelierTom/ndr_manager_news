/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function($)
{
    $(".calendar").popover();
    $(".delete").tooltip();
    $("#create_news").collapse();


     $('.new_delete').click(function(event){
       alert(event.target.id);
   })

    $('#confirmAddNews').click(function(){ 
        $.ajax(
        {
            type: "POST",
            url:'addNews.php',
            
            data: {
                'title' : document.addNews.title.value,
                'message' : document.addNews.message.value,
                'tags' : document.addNews.tags.value,
                'dateSuppression' : document.addNews.dateSuppression.value,
                'datePublication' : document.addNews.datePublication.value
            },
            
            success: function(result){
                alert(result);
                location.reload(true);
            }
        });
    });

    /*
     *
     * Filtre
     *
     **/

    var tagSelected = new Array();

    //Verifie qu'un tag existe
    function isTagSelected(tag)
    {
        var length = tagSelected.length;
        for(var i = 0; i < length; i++) {
            if(tagSelected[i] == tag)
                return true;
        }
        return false;
    }

    //Supprime un tag
    function removeTagSelected(tag)
    {
        var length = tagSelected.length;
        for(var i = 0; i < length; i++) {
            if(tagSelected[i] == tag)
                tagSelected.splice(i, 1);
        }
    }

    //Affiche tout les tags
    function showAllTag()
    {
        tagSelected = new Array();
        $(".obj_news").fadeIn("slow");
        $(".filtericon").hide().filter(".all").fadeIn("slow");
    }

    //Affiche les tags selectionnes
    function showSelectedTag()
    {
        var tag = "";
         $(".obj_news").hide();
         $(".filtericon").hide();

        for(var i in tagSelected)
        {
            tag += "."+tagSelected[i];
            $(".filtericon").filter("."+tagSelected[i]).fadeIn("slow");
        }

        $(".obj_news"+tag).fadeIn("slow");
    }

    $(".filtericon").hide().filter(".all").fadeIn("slow"); //Cache les icones par defauts

    //Clique sur un des filtre
    //@TODO use toggle ?
    $(".filter").click(function(event){
        var arrClass = event.target.className.split(" ");
        
        //Je clique sur all j'affiche tout les tags
        if(arrClass[1] == "all")
        {
            showAllTag();
        }
        else
        {
            
            //Le tag n'a pas été selectionner je l'ajoute
            if(!isTagSelected(arrClass[1])){
                tagSelected.push(arrClass[1]);
            }
            //Le tag été selectionne  je le supprime
            else{
                removeTagSelected(arrClass[1]);
            }

            //Tableau vide j'affiche tout les tags
            if(tagSelected.length == 0){
                showAllTag();
            }
            else{
                showSelectedTag();
            }          
        }
    });
}
)(jQuery);


