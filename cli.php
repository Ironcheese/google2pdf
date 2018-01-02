<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02.01.2018
 * Time: 14:43
 */

use Ironcheese\google2pdf\Google2PdfCommand;
use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

$app = new Application('Google2Pdf', "0.0.1");
$app->add(new Google2PdfCommand());

$app->run();
