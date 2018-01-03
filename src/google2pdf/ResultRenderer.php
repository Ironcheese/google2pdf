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


    public function render(string $templatePath):string {
        // Improvement: Check if Template file exists
        // Improvement: Check if there are actually items
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    public function generatePDF(string $html) {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');

        // Render the HTML as PDF
        $dompdf->render();
        file_put_contents(BASE_DIR.'/results.pdf', $dompdf->output());
    }


}
