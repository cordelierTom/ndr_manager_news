<?php
class View{
    private $_data;
    private $_file;
    function __construct($file){
        $this->setFile($file);
        $this->_data=array();
    }
    function __set($name,$value){
        return $this->_data[$name]=$value;
    }
    function __get($name){
        return $this->_data[$name];
    }
    function __isset($name){
        return isset($this->_data[$name]);
    }
    function display(){
        include(DIR_VIEW.$this->_file);
    }
    function setFile($file){
        if(substr($file,-4)!='.php'){
            $file.='.php';
        }
        return $this->_file=$file;
    }
}