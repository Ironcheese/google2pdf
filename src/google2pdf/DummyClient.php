<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.01.2018
 * Time: 16:24
 */

namespace Ironcheese\google2pdf;


class DummyClient {

    /**
     * fake request method
     *
     * @param string $method
     * @param string $url
     * @return DummyResponse
     */
    public function request(string $method, string $url) {  
        $query = parse_url($url, PHP_URL_QUERY);
        $page = 0; // First request has no "start" param

        if ($query) {
            $params = [];
            parse_str($query, $params);
            if (isset($params['start'])) {
                $page = ceil((int)$params['start'] / GoogleCrawler::RESULTS_PER_PAGE);
            }
        }

        return new DummyResponse($page);
    }

}
