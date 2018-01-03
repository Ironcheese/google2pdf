<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.01.2018
 * Time: 16:01
 */
namespace Ironcheese\google2pdf;

require 'vendor/autoload.php';

define('BASE_DIR', __DIR__);

$maxResults = 27;
if (isset($_GET['max'])) {
    $maxResults = (int)$_GET['max'];
}

// Get the information
$crawler = new GoogleCrawler(new DummyClient);
$crawler->startCrawling("Demo Test Search", $maxResults);

// Parse it
$parser = new GoogleResponseParser;
$parser->setContent($crawler->getResponseData())
    ->parse();

// Render it
$renderer = new ResultRenderer;
$renderer->setItems($parser->getItems($maxResults));
$output = $renderer->render(__DIR__.'/src/google2pdf/template.php');
echo $output;
