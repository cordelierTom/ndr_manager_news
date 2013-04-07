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


    function __construct($id, $title, $dateCreation, $dateSuppression, $datePublication, $description, $tags) {
        $this->id = $id;
        $this->title = $title;
        $this->dateCreation = $dateCreation;
        $this->dateSuppression = $dateSuppression;
        $this->datePublication = $datePublication;
        $this->description = $description;
        $this->tags = $tags;
    }


    /*
     * 
     */
    public function save()
    {
        News::loadNews();

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

        $news->asXML(constant('News::data_dir')."/" .constant('News::data_file').".xml");
        News::$news_list[] = $this;
    }

    /**
     * 
     */
    static function loadNews()
    {
       $news =  simplexml_load_file(constant('News::data_dir')."/" .constant('News::data_file').".xml");

       //On charge les news
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


    /***
     * GETTER
     */

    static function getLastId()
    {
        if(end(News::$news_list))
            return end(News::$news_list)->id;

        return 0;
    }

    public function getId() {
        return $this->id;
    }

   
    public function getTitle() {
        return $this->title;
    }


    public function getDescription() {
        return $this->description;
    }

    public function getDateCreation() {
        return Date::dateus2fr($this->dateCreation);
    }

    public function getDateSuppression() {
        return Date::dateus2fr($this->dateSuppression);
    }


    public function getDatePublication() {
        return Date::dateus2fr($this->datePublication);
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
     * Genere toute les news
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
     * Genere une news
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
     *
     * 
     */
    static function exist($id)
    {
        if(key_exists($id, News::$news_list))
        {
            return true;
        }

        return false;
    }

    /*
     * 
     */

    static function delete($id)
    {
        News::loadNews();
        $news =  simplexml_load_file(constant('News::data_dir')."/" .constant('News::data_file').".xml");


         //On charge les news
        foreach ($news->new as $key => $new)
        {
            if($id == XML::SimpleXmlElementToInt($new->id))
            {
                unset($news->new[$key]);
                echo $news->asXML();
                break;
            }
        }
    }


    static function edit($id)
    {
       
    }
}