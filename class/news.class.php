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


    public function __construct($title, $dateCreation, $dateSuppresion, $datePublication, $dateSupression, $description, $tags) {
        $this->title = $title;
        $this->dateCreation = $dateCreation;
        $this->dateSuppresion = $dateSuppresion;
        $this->datePublication = $datePublication;
        $this->description = $description;
        $this->tags = $tags;
    }


    public function save()
    {
        
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
            News::$news_list[] = new News($title, $dateCreation, $dateSuppresion, $datePublication, $dateSuppresion, $description, $tags);
       }
    }


    /***
     * DATE
     */

    function datefr2us($datefr)
    {
        $dateus=explode('/',$datefr);
        return $dateus[2].'-'.$dateus[1].'-'.$dateus[0];
    }

    function dateus2fr($dateus)
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


    /*
     *
     * 
     */
    static function viewAll()
    {
            echo '<div class="span9">';
            foreach (News::$news_list as $news)
            {
                $news->view();
            }
           echo '</div>';
       
    }

    public function view()
    {

        /*TAG*/
        $string_tag = '';
        $separator = ',';

        foreach($this->tags as $key => $tag)
        {
            $string_tag = $string_tag.'<a href="">'.$tag->getLibelle().'</a>';

            if($tag != end($this->tags))
            {
                $string_tag = $string_tag.$separator;
            }

        }

        /*DATE*/
        $string_date = '';
        $string_date = $string_date.'<small>Date de création : '.$this->getDateCreation().'</small><br>';
        $string_date = $string_date.'<small>Date de supprésion: '.$this->getDateCreation().'</small><br>';
        $string_date = $string_date.'<small>Date de publication: '.$this->getDateCreation().'</small>';

        echo '<div class="well">';
        echo '<h2>';
        echo '<a href=""><i class="icon-pencil"></i></a>';
        echo $this->getTitle();
        echo '</h2>';
        echo '<p>';
        echo $this->getDescription();

        echo '<div class="text-right"><a class="calendar" data-content="'.$string_date.'" data-html="true" data-placement="left" href="#" data-original-title="Informations"><i class="icon-calendar"></i></a></div>';
        echo '<div class="text-left"><small>Mot-clés : '.$string_tag.'</small></div>';
        echo '</p>';
        echo '<hr></hr>';
        echo '</div>';
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