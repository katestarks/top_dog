<?php
namespace TopDog\Scraper\Classes;

class APIGrabber
{
	private $ch;

	/**
	 *APIGrabber constructor.
	 *This constructor accepts a curl object and initialises
	 *an object that interacts with an API
	 *@param $curl which is a curlHandler object
	 */
	public function __construct(CurlHandler $curl){
		$this->ch = $curl->getCurlHandle();
	}

	/**
	 *Fetches data from API
	 *@param $url which represents the API
	 *@return String of data from the API
	 */
	public function getData(string $url) : String{
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$output = curl_exec($this->ch);
		return $output;
	}

	/**
	 *Converts String of data into an Array
	 *@param $data a string which represents the data from the API
	 *@return Array of results
	 */
	public function jsonData(string $data) : array{
		return json_decode($data, true);
	}
}