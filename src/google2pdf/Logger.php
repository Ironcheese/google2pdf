<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.01.2018
 * Time: 11:34
 */
namespace Ironcheese\google2pdf;
use Psr\Log\LoggerInterface;

trait Logger {

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function setLogger(LoggerInterface $logger):void {
        $this->logger = $logger;
    }

}
