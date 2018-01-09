<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.01.2018
 * Time: 14:36
 */

namespace Ironcheese\google2pdf;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use GuzzleHttp\Client as HttpClient;

class Google2PdfCommand extends Command {

    /**
     * configure Command Signature
     * usage examples:
     *  > php cli.php grab "Foobar" 20
     *
     *  // Grab 100 results for "foobar" and save them into "foobar-results" with a timeout of 13 Seconds between requests
     *  > php cli.php grab -t 13 -f foobar-results foobar 100
     */
    public function configure() {
        $this->setName("google2pdf")
            ->setAliases(['g2p', 'search', 'get', 'grab'])
            ->setDescription('Crawl Google Search Results and save them to a PDF File')
            ->addArgument('searchTerm', InputArgument::REQUIRED, 'Search Query, e.g. "PHP Backend"')
            ->addArgument('maxResults', InputArgument::OPTIONAL, 'How many search results should be saved?', 27)
            ->addOption('timeout', 't', InputOption::VALUE_REQUIRED, 'Set timeout pause in seconds', 10)
            ->addOption('filename', 'f', InputArgument::OPTIONAL, 'Set PDF Filename', 'results');
    }

    /**
     * execute this command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        $logger = new ConsoleLogger($output);

        $searchTerm = $input->getArgument('searchTerm');
        $maxResults = (int)$input->getArgument('maxResults');
        $timeout = (int)$input->getOption('timeout');
        $filename = $input->getOption('filename');

        // Get the information
        $crawler = new GoogleCrawler(new HttpClient);
        $crawler->setLogger($logger);
        $crawler->setTimeout($timeout);
        $crawler->startCrawling($searchTerm, $maxResults);

        // Parse it
        $parser = new GoogleResponseParser;
        $parser->setLogger($logger);
        $parser->setContent($crawler->getResponseData())
            ->parse();

        // Render it
        $renderer = new ResultRenderer;
        $renderer->setLogger($logger);
        $renderer->setItems($parser->getItems($maxResults));
        $renderer->setStats($parser->getStats());
        $renderer->setSearchTerm($searchTerm);
        $renderer->setMaxItems($maxResults);
        $output = $renderer->render(__DIR__.'/template.php');
        $renderer->generatePDF($filename, $output);
    }

}
