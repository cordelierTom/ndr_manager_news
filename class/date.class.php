<?php

class Date {

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
}