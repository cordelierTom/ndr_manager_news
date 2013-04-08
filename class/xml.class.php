<?php

class XML {
    /*
     * Convertit un SimpleXmlElement en string
     */
    static function SimpleXmlElementToString(SimpleXMLElement $xml)
    {
        return strip_tags($xml->asXML());
    }

    /*
     * Convertit un SimpleXmlElement en Int
     */
    static function SimpleXmlElementToInt(SimpleXMLElement $xml)
    {
        return  intval(strip_tags($xml->asXML()));
    }

    /*
     * Sauvegarde un XML Document dans le fichier spécifier en conservant la norme
     */
    static function saveXMLDocument(SimpleXMLElement $xml, $file)
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        $dom->save($file);
    }
}
