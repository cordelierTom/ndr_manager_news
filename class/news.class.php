<?php

class News {

    const data_file = "news";
    const data_dir  = "data";
    
    static public $news_list = array();
    static public $tags_list = array();

    private $id;
    private $title;
    private $dateCreation;
    private $dateSuppression;
    private $description;
    private $tags;
    private $datePublication;


    /**
     *
     * @param Uint $id
     * @param String $title
     * @param String $dateCreation
     * @param String $dateSuppression
     * @param String $datePublication
     * @param String $description
     * @param Array() $tags
     */
    function __construct($id, $title, $dateCreation, $dateSuppression, $datePublication, $description, $tags) {
        $this->id = $id;
        $this->title = $title;
        $this->dateCreation = $dateCreation;
        $this->dateSuppression = $dateSuppression;
        $this->datePublication = $datePublication;
        $this->description = $description;
        $this->tags = $tags;
    }

     /*** *************
     * GETTER
     **************** */

    /**
     *
     * @return Uint
     */
    static function getLastId()
    {
        if(end(News::$news_list))
            return end(News::$news_list)->id;

        return 0;
    }

    /*
     * @return Uint
     */
    public function getId() {
        return $this->id;
    }


    /**
     *
     * @return String
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     *
     * @return String
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * /!\ Attention format DD/MM/YYYY par defaut
     * @return Date
     */
    public function getDateCreation($format_fr = true) {

        if($format_fr)
            return Date::dateus2fr($this->dateCreation);
        else
            return $this->dateCreation;
    }

     /**
     * /!\ Attention format DD/MM/YYYY par defaut
     * @return Date
     */
    public function getDateSuppression($format_fr = true) {
        if($format_fr)
            return Date::dateus2fr($this->dateSuppression);
        else
           $this->dateSuppression;
    }

     /**
     * /!\ Attention format DD/MM/YYYY par defaut
     * @return Date
     */
    public function getDatePublication($format_fr = true) {
        if($format_fr)
            return Date::dateus2fr($this->datePublication);
        else
            $this->datePublication;
    }

    /******************************
     * DATA
     ***************************** */
    
    /*
     * Sauvegarde la news dans le fichier
     */
    public function save()
    {
        $news =  simplexml_load_file(constant('News::data_dir')."/" .constant('News::data_file').".xml");

        $new = $news->addChild("new");
        $new->addChild("id", $this->id);
        $new->addChild("description", $this->getDescription());
        $new->addChild("title", $this->getTitle());
        $new->addChild("dateCreation", $this->dateCreation);
        $new->addChild("datePublication", $this->datePublication);
        $new->addChild("dateSuppression", $this->dateSuppression);
        $tags = $new->addChild("tags");
      
        foreach ($this->tags as $tag)
        {
            $tags->addChild("tag", $tag);
        }

        XML::saveXMLDocument($news, constant('News::data_dir')."/" .constant('News::data_file').".xml");
        News::$news_list[$this->id] = $this;
    }


    /**
     * Supprime la news du fichier
     * @param Uint $id
     */
    static function delete($id)
    {
        News::loadNews();
        //On charge les news
        $news =  simplexml_load_file(constant('News::data_dir')."/" .constant('News::data_file').".xml");

        $count = 0;
        foreach ($news->new as $new)
        {
            if($id == XML::SimpleXmlElementToInt($new->id))
            {
               unset($news->new[$count]);
               break;
            }
            $count++;
        }

        XML::saveXMLDocument($news , constant('News::data_dir')."/" .constant('News::data_file').".xml");
        array_splice(News::$news_list, $id, 1);
    }

    static function edit($id)
    {

    }

    /****************
     * OTHER
     *************** */

    /**
     * Chargement de toute les news a partir du fichier
     */
    static function loadNews()
    {
       $news =  simplexml_load_file(constant('News::data_dir')."/" .constant('News::data_file').".xml");

       //Traitement des news
       foreach ($news->new as $new)
       {
           $id = XML::SimpleXmlElementToInt($new->id);
           $title = XML::SimpleXmlElementToString($new->title);
           $dateCreation = XML::SimpleXmlElementToString($new->dateCreation);
           $dateSuppression = XML::SimpleXmlElementToString($new->dateSuppression);
           $datePublication = XML::SimpleXmlElementToString($new->datePublication);
           $description = XML::SimpleXmlElementToString($new->description);
           $tags = array();

           //Add tags
           foreach($new->tags as $tag)
           {
              foreach($tag->tag as $tag)
              {
                 $tag = XML::SimpleXmlElementToString($tag);
                 $tags[] = new Tag($tag);;
                 Tag::add($tag);
              }
           }

           // @ TODO : Clean constructeur directement passé l'objet.
           if(!News::exist($id))
                News::$news_list[$id] = new News($id, $title, $dateCreation, $dateSuppression, $datePublication, $description, $tags);
       }
    }

    /**
     * Genere le formulaire
     */

     static function generateFormulaire()
     {
         $formulaire = '';
         $formulaire .= '<div class="well">';
         $formulaire .= '<h5> <a href="#" data-toggle="collapse" data-target="#create_news"><i class="icon-file"></i>'.Lang::LANG_CREATE_NEWS.'</a></h5>';
         $formulaire .= '<div id="create_news" class="collapse in">';
         $formulaire .= '<form name="addNews">';
         $formulaire .= '<div><input name="title" type="text" placeholder="'.Lang::LANG_PLACEHOLDER_TITLE.'" required></div>';
         $formulaire .= '<div><textarea name="message" rows="5" style="width: 1005px; height: 139px;" required></textarea></div>';
         $formulaire .= '<div>'.Lang::LANG_TAG.': <input name ="tags" type="text" placeholder="'.Lang::LANG_PLACEHOLDER_TAG.'" required></div>';
         $formulaire .= '<div>'.Lang::LANG_DATE_SUPPRESSION.': <input name="dateSuppression" type="text" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d" placeholder="DD/MM/YYYY" value="'.date("d/m/Y").'" required></div>';
         $formulaire .= '<div>'.Lang::LANG_DATE_PUBLICATION.': <input name="datePublication" type="text" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d" placeholder="DD/MM/YYYY" value="'.date("d/m/Y").'" required></div>';
         $formulaire .= '<div><button id="confirmAddNews"class="btn btn-success" type="button">'.Lang::LANG_VALIDER.'</button></div>';
         $formulaire .= '</form>';
         $formulaire .= '</div>';
         $formulaire .= '</div>';

         return $formulaire;
     }

    /*
     * Genere toute les news ou une new
     * 
     */
    static function viewAll($id = NULL)
    {
        $news_view = '';

        if(isset($id))
        {
            if(Views::exist($id))
                $news_view = Views::$list_views[$id]->view();
        }
        else
        {
            foreach(News::$news_list as $news)
            {
                $news_view .= $news->view();
            }
        }

        return $news_view;
    }

    /*
     * Genere la vu de la new
     */
    public function view()
    {

        /*TAG*/
        $string_tag = '';
        $separator = ',';

        /*TAG Class*/
        $string_class = '';
        $string_class_separator = ' ';

        foreach($this->tags as $key => $tag)
        {
            $string_tag = $string_tag.''.$tag->getLink();
            $string_class = $string_class.''.strtolower($tag->getLibelle());


            if($tag != end($this->tags))
            {
                $string_tag = $string_tag.$separator;
                $string_class = $string_class.$string_class_separator;
            }
        }

        /*DATE*/
        $string_date = '';
        $string_date .='<small>'.Lang::LANG_DATE_CREATION.' : '.$this->getDateCreation().'</small><br>';
        $string_date .='<small>'.Lang::LANG_DATE_PUBLICATION.': '.$this->getDatePublication().'</small><br>';
        $string_date .='<small>'.Lang::LANG_DATE_SUPPRESSION.': '.$this->getDateSuppression().'</small>';

        /*VIEW*/
        $view = '';
        $view .= '<div class="obj_news '.$string_class.' well">';
        $view .= '<div class="text-right"><a href="#delete#" class="new_delete" id="'.$this->id.'" data-toggle="tooltip" title="'.Lang::LANG_SUPPRIMER.'"><i class="icon-remove"></i></a></div>';
        $view .= '<h2>';
        $view .= $this->getTitle();
        $view .= '</h2>';
        $view .= '<p>';
        $view .= $this->getDescription();
        $view .= '<div class="text-right"><a class="calendar" data-content="'.$string_date.'" data-html="true" data-placement="left" href="#calendar#" data-original-title="'.Lang::LANG_TITLE_CALENDAR.'"><i class="icon-calendar"></i></a></div>';
        $view .= '<div class="text-left"><small>'.Lang::LANG_TAG.': '.$string_tag.'</small></div>';
        $view .= '</p>';
        $view .= '<hr></hr>';
        $view .= '</div>';

        return $view;
    }

    /*
     * Alerte(s) haut de page
     */
    static function generateAlert()
    {
        $alert = '<div class="alert fade in" id="delete" hidden><button class="close" data-dismiss="alert" type="button">×</button>'.Lang::LANG_NEW_DELETE.'</div>';
        $alert .= '<div class="alert fade in" id="add" hidden><button class="close" data-dismiss="alert" type="button">×</button>'.Lang::LANG_NEW_ADD.'</div>';
        return $alert;
    }

    /*
     * @param Uint id
     */
    static function exist($id)
    {
        if(key_exists($id, News::$news_list))
        {
            return true;
        }

        return false;
    }
}
