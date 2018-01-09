<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.01.2018
 * Time: 15:21
 */

namespace Ironcheese\google2pdf;
use Dompdf\Dompdf;

class ResultRenderer {

    use Logger;

    protected $maxItems;
    protected $searchTerm;
    protected $stats = "";
    protected $items = [];

    /**
     * ResultRenderer constructor.
     */
    public function __construct() {
    }

    public function setItems($items) {
        $this->items = $items;
        return $this;
    }

    public function setStats($stats) {
        $this->stats = $stats;
        return $this;
    }

    public function render(string $templatePath):string {
        $this->logger->info("Rendering Template");
        // Improvement: Check if Template file exists
        // Improvement: Check if there are actually items
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    /**
     * generate the  PDF
     *
     * @param string $name
     * @param string $html
     */
    public function generatePDF(string $name, string $html) {
        $this->logger->info("Generating PDF File");
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');

        // Render the HTML as PDF
        $dompdf->render();
        //@Todo: Sanitize Filename?
        $filename = BASE_DIR."/generated-pdfs/$name-".date("Ymd-His").'.pdf';
        file_put_contents($filename, $dompdf->output());
        $this->logger->info("DONE! PDF File: $filename generated.");
    }

    public function setSearchTerm(string $searchTerm) {
        $this->searchTerm = $searchTerm;
    }

    public function setMaxItems(int $maxResults) {
        $this->maxItems = $maxResults;
    }


}
