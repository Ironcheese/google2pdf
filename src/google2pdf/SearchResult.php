<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.01.2018
 * Time: 13:32
 */

namespace Ironcheese\google2pdf;


class SearchResult {

    protected $node;
    protected $dom;

    public $title = "";
    public $href = "";
    public $description = "";

    /**
     * SearchResult constructor.
     *
     * @param \DOMXPath   $dom
     * @param \DOMElement $node
     */
    public function __construct(\DOMXPath $dom, \DOMElement  $node) {
        $this->dom = $dom;
        $this->node = $node;
        $this->parse();
    }

    public function parse() {
        $this->parseTitle();
        $this->parseDescription();
    }

    /**
     * parse the title and its href
     * -> Beware: Href needs some serious sanitizing!
     */
    public function parseTitle() {
        $titleNode = $this->dom->query(".//h3[@class='r']/a", $this->node)->item(0);
        $this->title = utf8_decode($titleNode->nodeValue);

        // Cleanup href Attribute
        $this->href = str_replace(['/url?q='], '', $titleNode->getAttribute('href'));
        $this->href = preg_replace(
            "/(&sa=[A-Z])(&ved=[0-9a-zA-Z\D]{40})(&usg=[0-9a-zA-Z\D]{28})/",
            "",
            $this->href
        );
    }

    public function parseDescription() {
        $decNode = $this->dom->query(".//span[@class='st']", $this->node)->item(0);
        $this->description = utf8_decode($decNode->nodeValue);
    }

}
