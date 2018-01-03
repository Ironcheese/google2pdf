<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.01.2018
 * Time: 10:59
 */

namespace Ironcheese\google2pdf;


class DummyResponse {

    protected $page = 0;

    public function __construct(int $page = 0) {
        $this->page = $page;
    }

    public function getStatusCode():int {
        return 200;
    }

    public function getBody():string {
        $file = __DIR__."/../google-search_php-backend-developer_page-{$this->page}.html";
        // $file = __DIR__."/../body.html";
        return file_get_contents($file);
    }
}
