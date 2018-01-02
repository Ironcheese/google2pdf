<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.01.2018
 * Time: 15:30
 */

namespace Ironcheese\google2pdf;


use GuzzleHttp\ClientInterface;

class GoogleCrawler {

    /**
     * Base Google URL for searching
     */
    const BASE_URL = "https://www.google.de/search";

    /**
     * How many results does Google display per page?
     */
    const RESULTS_PER_PAGE = 10;

    protected $client = null;

    /**
     * the search term for google to search for ¯\_(ツ)_/¯
     * @var null
     */
    protected $searchTerm = "";

    /**
     * how many results should be retrieved?
     * @var int
     */
    protected $maxResults = 10;

    /**
     * timeout between the crawl requests
     * @var int
     */
    protected $timeout = 10;
    protected $responseData = [];

    // ----------------------------------------------------------------------------
    // Functions
    // ----------------------------------------------------------------------------

    /**
     * GoogleCrawler constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }

    /**
     * startCrawling
     * - Actually start the crawling process
     *
     * @param string $searchTerm
     * @param int    $maxResults
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function startCrawling(string $searchTerm, int $maxResults) {
        $this->setSearchTerm($searchTerm);
        $this->setMaxResults($maxResults);

        $trips = ceil($this->getMaxResults() / self::RESULTS_PER_PAGE);
        for($i = 0; $i < $trips; $i++) {
            $this->fetch($i);
            // Add timeout to prevent captcha blockage
        }
    }

    // ----------------------------------------------------------------------------
    // Helper Functions
    // ----------------------------------------------------------------------------

    /**
     * fetch
     *
     * @param int $cycle
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function fetch(int $cycle) {
        $response = $this->client->request('GET', $this->buildURL($cycle));
        if ($response->getStatusCode() === 200) {
            $this->responseData[] = $response->getBody();
        }
    }

    /**
     * build the url for google
     *
     * @param int $cycle
     * @return string
     */
    protected function buildURL(int $cycle = 0):string {
        $url = self::BASE_URL;
        $params = ['q' => $this->getSearchTerm()];

        if ($cycle > 0) {
            $params['start'] = $cycle * self::RESULTS_PER_PAGE;
        }

        return $url . "?" . http_build_query($params);
    }

    // ----------------------------------------------------------------------------
    // Getters and Setters
    // ----------------------------------------------------------------------------

    public function getResponseData():array {
        return $this->responseData;
    }

    /**
     * @return int
     */
    public function getTimeout():int {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout):void {
        $this->timeout = $timeout;
    }

    /**
     * @return string
     */
    public function getSearchTerm():string {
        return $this->searchTerm;
    }

    /**
     * @param string $searchTerm
     */
    public function setSearchTerm(string $searchTerm):void {
        $this->searchTerm = $searchTerm;
    }

    /**
     * @return int
     */
    public function getMaxResults():int {
        return $this->maxResults;
    }

    /**
     * @param int $maxResults
     */
    public function setMaxResults(int $maxResults):void {
        $this->maxResults = $maxResults;
    }

}
