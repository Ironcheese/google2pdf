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
    protected $items = [];

    protected $stats = "";

    public function setContent($content) {
        $this->content = $content;
    }

    public function parse() {
        foreach ($this->content as $index => $content) {
            $doc = new \DOMDocument();
            $doc->loadHTML($content, LIBXML_NOERROR|LIBXML_NOWARNING); // Google Markup is... well,... messy!
            $dom = new \DOMXPath($doc);

            // Maybe interessting?
            if ($index === 0) {
                $this->stats = utf8_decode(
                    $dom->query("//div[@id='resultStats']")
                    ->item(0)->nodeValue
                );
            }

            // Hopefully Google does not change the "g" class for its search results!
            $nodes = $dom->query("//div[@id='search']//div[@class='g']");
            foreach ($nodes as $node) {
                $this->items[] = new SearchResult($dom, $node);
            }
        }
    }

    /**
     * @param int $max
     * @return array
     */
    public function getItems(int $max = 0): array {
        if ($max > 0) {
            return array_slice($this->items, 0, $max);
        }
        return $this->items;
    }

    /**
     * @return string
     */
    public function getStats(): string {
        return $this->stats;
    }
}
