<?php

class Tag {

    private $libelle;
    static public $tags_list = array();

    /*
     * 
     */
    public function __construct($libelle) {
        $this->libelle = $libelle;
    }

    /*
     * 
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /*
     * 
     */
    static function add($tag)
    {
        if(Tag::exist($tag))
            return;

        Tag::$tags_list[] = $tag;
    }

    /*
     * 
     */
    static function exist($tag)
    {
        //Cast en string car $tag est un SimpleXML Object
        return in_array((string)$tag, Tag::$tags_list);
    }

    /*
     * 
     */
    static function generateMenu()
    {
        sort(Tag::$tags_list, SORT_STRING);
        
        $title_menu = "Filtre par mot-clés";

        echo '<div class="span3">';
            echo '<div class="well sidebar-nav">';
                echo '<ul class="nav nav-list">';
                     echo '<li class="nav-header">'.$title_menu.'</li>';
                     /*Link tag*/
                     foreach(Tag::$tags_list as $tag_id => $libelle)
                     {
                         echo '<li><a href="#filter#">'.$libelle.'</a></li>';
                     }
                echo '</ul>';
            echo '</div><!--/.well -->';
        echo ' </div><!--/span-->';
    }
}