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
use Symfony\Component\Console\Output\OutputInterface;

class Google2PdfCommand extends Command {

    /**
     * configure Command Signature
     * use:
     */
    public function configure() {
        $this->setName("google2pdf")
            ->setAliases(['g2p', 'search', 'get', 'grab'])
            ->setDescription('Crawl Google Search Results and save them to a PDF File')
            ->addArgument('query', InputArgument::REQUIRED, 'Search Query, e.g. "PHP Backend"')
            ->addArgument('resultCount', InputArgument::OPTIONAL, 'How many search results should be saved?', 10);
    }

    /**
     * execute this command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        $output->write("hello?");
    }

}
