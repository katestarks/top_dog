<?php
require_once '../../vendor/autoload.php';

$dbConnection = new TopDog\Classes\PDOConnection();
$dbHandler = new TopDog\Classes\DbHandler($dbConnection);

$ch = new TopDog\Scraper\Classes\CurlHandler();
$apiGrab = new TopDog\Scraper\Classes\APIGrabber($ch);

$dataProcessor = new TopDog\Scraper\Classes\DataProcessor($apiGrab, $dbHandler);
$dataProcessor->scrapeDogApi();
