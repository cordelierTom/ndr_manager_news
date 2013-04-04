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
    public function getLink()
    {
         return Tag::generateLink($this->libelle);
    }

    static function generateLink($libelle)
    {
        return '<a class="filter '.strtolower($libelle).'" href="#filter#">'.$libelle.'</a>';
    }

    /*
     * 
     */
    static function generateMenu()
    {
        sort(Tag::$tags_list, SORT_STRING);

        echo '<div class="span3">';
            echo '<div class="well sidebar-nav">';
                echo '<ul class="nav nav-list">';
                     echo '<li class="nav-header">'.LANG::LANG_FILTRE_TAG.'</li>';
                     echo '<li><a class="filter all" href="#filter#">'.Lang::LANG_FILTRE_ALL.'</a></li>';
                     /*Link tag*/
                     foreach(Tag::$tags_list as $tag_id => $libelle)
                     {
                         echo '<li>'.Tag::generateLink($libelle).'</li>';
                     }
                echo '</ul>';
            echo '</div><!--/.well -->';
        echo ' </div><!--/span-->';
    }
}