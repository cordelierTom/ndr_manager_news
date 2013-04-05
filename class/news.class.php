<?php

class News {

    const data_file = "news";
    const data_dir  = "data";
    
    static public $news_list = array();
    static public $tags_list = array();
    
    private $title;
    private $dateCreation;
    private $dateSuppresion;
    private $description;
    private $tags;
    private $datePublication;


    function __construct($title, $dateCreation, $dateSuppresion, $datePublication, $description, $tags) {
        $this->title = $title;
        $this->dateCreation = $dateCreation;
        $this->dateSuppresion = $dateSuppresion;
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
        News::$news_list[] = $this;

        $news =  simplexml_load_file(constant('News::data_dir')."/" .constant('News::data_file').".xml");

        $new = $news->addChild("news");
        $news->addChild("id", 100); //@TODO  Fix ME
        $new->addChild("description", $this->getDescription());
        $new->addChild("title", $this->getTitle());
        $new->addChild("dateCreation", $this->dateCreation);
        $new->addChild("datePublication", $this->datePublication);
        $new->addChild("dateSuppresion", $this->dateSuppresion);
        $tags = $new->addChild("tags");
        foreach ($this->tags as $tag)
        {
            $tags->addChild("tag", $tag);
        }

        //@TODO: FIX ME
        /*
        $fp = fopen('test.txt', 'w');
        fwrite($fp, $news->asXML());*/
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

           $id = $new->id;
           $title = $new->title;
           $dateCreation = $new->dateCreation;
           $dateSuppresion = $new->dateSuppression;
           $datePublication = $new->datePublication;
           $description = $new->description;
           $tags = array();

           //Add tags
           foreach($new->tags as $tag)
           {
              foreach($tag->tag as $tag)
              {
                 $tags[] = new Tag($tag);;
                 Tag::add($tag);
              }
           }

           // @ TODO : Clean constructeur directement passé l'objet.
           if(!News::exist($id))
            News::$news_list[] = new News($title, $dateCreation, $dateSuppresion, $datePublication, $description, $tags);
       }
    }


    /***
     * DATE
     */

    static function datefr2us($datefr)
    {
        $dateus=explode('/',$datefr);
        return $dateus[2].'-'.$dateus[1].'-'.$dateus[0];
    }

    static function dateus2fr($dateus)
    {
        $datefr=explode('-',$dateus);
        return $datefr[2].'/'.$datefr[1].'/'.$datefr[0];
    }

    /***
     * GETTER
     */


    public function getTitle() {
        return $this->title;
    }


    public function getDescription() {
        return $this->description;
    }

    public function getDateCreation() {
        return $this->dateus2fr($this->dateCreation);
    }

    public function getDateSuppresion() {
        return $this->dateus2fr($this->dateSuppresion);
    }


    public function getDatePublication() {
        return $this->dateus2fr($this->datePublication);
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
         $formulaire .= '<div>'.Lang::LANG_DATE_SUPPRESSION.': <input name="dateSuppression" type="text" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d" placeholder="DD/MM/YYYY" required></div>';
         $formulaire .= '<div>'.Lang::LANG_DATE_PUBLICATION.': <input name="datePublication" type="text" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d" placeholder="DD/MM/YYYY" required></div>';
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
        $string_date = $string_date.'<small>'.Lang::LANG_DATE_CREATION.' : '.$this->getDateCreation().'</small><br>';
        $string_date = $string_date.'<small>'.Lang::LANG_DATE_PUBLICATION.': '.$this->getDatePublication().'</small><br>';
        $string_date = $string_date.'<small>'.Lang::LANG_DATE_SUPPRESSION.': '.$this->getDateSuppresion().'</small>';

        $view = '';
        $view .= '<div class="obj_news '.$string_class.' well">';
        $view .= '<div class="text-right"><a href="#delete#" class="delete" data-toggle="tooltip" title="'.Lang::LANG_SUPPRIMER.'"><i class="icon-remove"></i></a></div>';
        $view .= '<h2>';
        $view .= $this->getTitle();
        $view .= '</h2>';
        $view .= '<p>';
        $view .= $this->getDescription();
        $view .= '<div class="text-right"><a class="calendar" data-content="'.$string_date.'" data-html="true" data-placement="left" href="#calendar#" data-original-title="'.Lang::LANG_TITLE_CALENDAR.'><i class="icon-calendar"></i></a></div>';
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
        if(in_array($id, News::$news_list))
        {
            return $this->news_list[$id];
        }

        return NULL;
    }

    /*
     * 
     */
    static function edit($id)
    {
       
    }
}