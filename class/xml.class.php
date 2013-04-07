<?php

class XML {
    
    static function SimpleXmlElementToString(SimpleXMLElement $xml)
    {
        return strip_tags($xml->asXML());
    }

        static function SimpleXmlElementToInt(SimpleXMLElement $xml)
    {
        return  intval(strip_tags($xml->asXML()));
    }
}

