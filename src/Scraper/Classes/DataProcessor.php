<?php

namespace TopDog\Scraper\Classes;

use TopDog\Classes\DbHandler;

class DataProcessor
{
    private $APIGrabber;
    private $dbHandler;

    /**
     * DataProcessor constructor.
     *
     * @param APIGrabber $APIGrabber API Request from Class APIGrabber
     * @param DbHandler $dbHandler
     */
    public function __construct(APIGrabber $APIGrabber, DbHandler $dbHandler)
    {
        $this->APIGrabber = $APIGrabber;
        $this->dbHandler = $dbHandler;
    }


    /**
     * This public method is called to kick off the api scrape, it calls and managers other con
     *
     * @return void - not return, adds data scraped from API to prepared database
     */
    public function scrapeDogApi() {
        $this->dbHandler->truncateBreedTable();
        $this->dbHandler->truncateImageTable();
        $arrayBreeds = $this->processBreedData();
        foreach ($arrayBreeds as $breed) {
            $this->dbHandler->insertBreed($breed['breed_name'], $breed['sub_breed']);
        }
        $breeds = $this->dbHandler->getBreed();
        $urlRequests = $this->createImageUrlWithId($breeds);
        $arrayImages = $this->processImageData($urlRequests);
        foreach ($arrayImages as $images) {
            foreach ($images['urlImage'] as $url) {
                $this->dbHandler->insertImages($images['id'], $url);
            }
        }
    }

    /**
     * Sends an API request and reorganises data to store in the database
     *
     * @return array $result Array that is put into database
     */
    private function processBreedData(): array
    {
        $result = [];
        $placeholder = [];
        $response = $this->APIGrabber->getData('https://dog.ceo/api/breeds/list/all');
        $breed = $this->APIGrabber->jsonData($response);
        if (!$this->successApiRequest($breed)) {
            $result['errorMessage'] = 'Not successful';
        } else {
            foreach ($breed['message'] as $key => $value) {
                if (count($value) > 0) {
                    foreach ($value as $subBreed) {
                        if ($key === 'cattledog') {
                            $placeholder['breed_name'] = $key;
                            $placeholder['sub_breed'] = '';
                            $result[] = $placeholder;
                        } else {
                            $placeholder['breed_name'] = $key;
                            $placeholder['sub_breed'] = $subBreed;
                            $result[] = $placeholder;
                        }
                    }
                } else {
                    $placeholder['breed_name'] = $key;
                    $placeholder['sub_breed'] = '';
                    $result[] = $placeholder;
                }
            }
        }
        return $result;
    }

    /**
     * Checks if API request has been successful
     *
     * @param  array $breed Array taken from API
     *
     * @return bool Result of if statement
     */
    public function successApiRequest(array $breed): bool
    {
        if ($breed["status"] === "success") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Takes id from array taken from top_dog database and creates an id linked to url
     *
     * @param array $breeds Array taken from database
     *
     * @return array $result Array with ids of breed and url for API request to store images
     */
    private function createImageUrlWithId(array $breeds): array
    {
        $result = [];
        $placeholder = [];
        foreach ($breeds as $breed) {
            if(count($breed, true) > 0) {
                $placeholder['id'] = $breed['id'];
                $main = $breed['breed_name'];
                if (strlen($breed['sub_breed']) > 0) {
                    $sub = $breed['sub_breed'];
                    $placeholder['urlRequest'] = 'https://dog.ceo/api/breed/' . $main . '-' . $sub . '/images';
                } else {
                    $placeholder['urlRequest'] = 'https://dog.ceo/api/breed/' . $main . '/images';
                }
                $result[] = $placeholder;
            }
        }
        return $result;
    }

    /**
     * Takes Url requests array and API images array and generates a new array that has id referring to a breed and all the url images of that breed
     *
     * @param array $urls The Urls for the request
     *
     * @return array The reorganised array that will be put into the database
     */
    private function processImageData(array $urls): array
    {
        $result = [];
        foreach ($urls as $url) {
            $response = $this->APIGrabber->getData($url['urlRequest']);
            $images = $this->APIGrabber->jsonData($response);
            $placeholder = [];
            if (!$this->successApiRequest($images)) {
                $result['errorMessage'] = 'Not successful';
            } else {
                $placeholder['id'] = $url['id'];
                $placeholder['urlImage'] = [];
                foreach ($images['message'] as $value) {
                    $placeholder['urlImage'][] = $value;
                }
                $result[] = $placeholder;
            }
        }
        return $result;
    }
}
