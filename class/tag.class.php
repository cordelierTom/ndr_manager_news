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

    static function generateLink($libelle, $icon=false)
    {

        $data = '<a class="filter '.strtolower($libelle).'" href="#filter#">'.$libelle;
        if($icon)
        {
            $data .=' <i class="filtericon '.strtolower($libelle).' icon-ok" ></i>';
        }
        $data .= '</a>';
        return  $data;
    }

    /*
     * Generere le menu de gauche
     */
    static function generateMenu()
    {
        $menu = "";
        sort(Tag::$tags_list, SORT_STRING);

        $menu .= '<div class="span3">';
        $menu .= '<div class="well sidebar-nav">';
        $menu .= '<ul class="nav nav-list">';
        $menu .= '<li class="nav-header">'.LANG::LANG_FILTRE_TAG.'</li>';
        $menu .= '<li><a class="filter all" href="#filter#">'.Lang::LANG_FILTRE_ALL.' <i class="filtericon all icon-ok" hidden="true"></i></a></li>';
        /*Link tag*/
        foreach(Tag::$tags_list as $tag_id => $libelle) {
            $menu .=  '<li>'.Tag::generateLink($libelle, true).'</li>';
        }
        $menu .=  '</ul>';
        $menu .=  '</div><!--/.well -->';
        $menu .=  ' </div><!--/span-->';

        return $menu;
    }
}