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
use GuzzleHttp\Client as HttpClient;

class Google2PdfCommand extends Command {




    /**
     * configure Command Signature
     * use:
     */
    public function configure() {
        $this->setName("google2pdf")
            ->setAliases(['g2p', 'search', 'get', 'grab'])
            ->setDescription('Crawl Google Search Results and save them to a PDF File')
            ->addArgument('searchTerm', InputArgument::REQUIRED, 'Search Query, e.g. "PHP Backend"')
            ->addArgument('maxResults', InputArgument::OPTIONAL, 'How many search results should be saved?', 27);
            // ->addOption('verbosity', 'v', InputOption::VALUE_OPTIONAL, 'Set information verbosity');
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
        $searchTerm = $input->getArgument('searchTerm');
        $maxResults = (int)$input->getArgument('maxResults');

        $crawler = new GoogleCrawler(new HttpClient);
        $crawler->startCrawling($searchTerm, $maxResults);

        $parser = new GoogleResponseParser;
        $parser->setContent($crawler->getResponseData());
        $parser->parse();

        $items = $parser->getItems($maxResults);

        // Dev Output
        $output->writeln("<info>{$parser->getStats()}</info>");
        $output->writeln("----------------------------------------");
        foreach ($items as $index => $item) {
            $output->writeln("<info>Result: $index</info>");
            $output->writeln($item->title);
            $output->writeln($item->href);
            $output->writeln("<comment>$item->description</comment>");
            $output->writeln("----------------------------------------");
        }

        // Guzzle make request
        // wait for response
        // parse html response
        // write html content to pdf file
    }

}
