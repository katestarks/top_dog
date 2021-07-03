<?php

namespace TopDog\Scraper\Classes;

class CurlHandler {

    private $ch;

    /**
     * CurlHandler constructor.
     *
     * this construct method initialises the curl
     *
     */
    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }

    /**
     * gets the curl handle
     *
     * @returns the private $ch
     */
    public function getCurlHandle()
    {
        return $this->ch;
    }
}