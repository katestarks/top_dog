<?php
namespace TopDog\Classes;

class DogManager
{
	private $dbHandler;
	private $dropdownMaker;
	private $dogs;
	private $breeds;
	private $dogDisplayer;
	private $faveId;

    /**
     * DogManager constructor.
     *
     * @param DbHandler $dbHandler Db Connection from Class DbHandler
     * @param DropdownMaker $dropdownMaker Class for creating dropdowns
     * @param DogDisplayer $dogDisplayer Class for displaying dog images
     */
    public function __construct(DbHandler $dbHandler, DropdownMaker $dropdownMaker, DogDisplayer $dogDisplayer)
	{
		$this->dbHandler = $dbHandler;
		$this->dropdownMaker = $dropdownMaker;
		$this->dogDisplayer = $dogDisplayer;

	}

    /**
     * Sets $dogs to the return of the getDogs method
     */
    public function populateDogs($breed_id) {
		$this->dogs = $this->dbHandler->getDogs($breed_id);
	}

    /**
     * Sets $breeds to the return of the getBreed method
     */
    public function getBreeds() {
		$this->breeds = $this->dbHandler->getBreed();
	}

    /**
     * Sets $dropdownMaker to the return of the populateDropdown method
     */
    public function makeDropdown() {
		return $this->dropdownMaker->populateDropdown($this->breeds);
	}

    /**
     * Sets $dogDisplayer to the return of the displayDogs method
     */
    public function displayDogs(){
		return $this->dogDisplayer->displayDogs($this->dogs);
	}

    /**
     * Sets $faveId to the return of the getFavouriteDog method
     */
	public function getFaveId($breed_id){
        $this->faveId = $this->dbHandler->getFavouriteDog($breed_id);
    }

    /**
     * Calls setFav method
     */
    public function faveToDb($image_id, $breed_id){
        $this->dbHandler->setFav($image_id, $breed_id);
    }

    /**
     * Checks the dogs array of object for the dog with the same id as the favourite one taken from the database and set
     * the isFav variable to true to display it properly
     */
    public function setFavouriteDog() {
        foreach ($this->dogs as $dog) {
            if ($dog->getId() == $this->faveId['fav_dog']) {
                $dog->setIsFav();
            }
        }
    }
}