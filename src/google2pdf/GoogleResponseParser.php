<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.01.2018
 * Time: 16:18
 */

namespace Ironcheese\google2pdf;


class GoogleResponseParser {

    protected $content = [];

    public function setContent($content) {
        $this->content = $content;
    }

    public function parse() {

        foreach ($this->content as $index => $content) {
            $doc = new \DOMDocument();
            $doc->loadHTML($content, LIBXML_NOERROR|LIBXML_NOWARNING);
            $dom = new \DOMXPath($doc);
            // Hopefully Google does not change the "g" class for its search results!
            $nodes = $dom->query("//div[@class='g']");
            var_dump($nodes);
        }
    }
}
