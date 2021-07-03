<?php

namespace TopDog\Classes;

use TopDog\Interfaces\DbConnection;

class DbHandler
{
    private $dbConnection;

    /**
     * DbHandler constructor.
     *
     * @param $db DbConnection object
     */
    public function __construct(DbConnection $db) {
        $this->dbConnection = $db;
    }

    /**
     * Deletes all the data in the breed table in the top_dog DB
     */
    public function truncateBreedTable() :void {
        $db = $this->dbConnection->getConnection();
        $query = $db->prepare("TRUNCATE TABLE `breed_table`");
        $query->execute();
    }

    /**
     * Deletes all the data in the image table in the top_dog DB
     */
    public function truncateImageTable() :void {
        $db = $this->dbConnection->getConnection();
        $query = $db->prepare("TRUNCATE TABLE `image_table`");
        $query->execute();
    }

    /**
     * inserts the breed and sub breed into the database using different MySQL statements depending on whether the database already contains the content
     *
     * @param $breed_name string name of dog breed category
     * @param $sub_breed string name of sub dog breed category if available
     *
     * @return boolean dependent on if insertion is successful
     */
    public function insertBreed (string $breed_name, string $sub_breed) :bool{
        $db = $this->dbConnection->getConnection();
        $query = $db->prepare("INSERT INTO `breed_table` (`breed_name`, `sub_breed`) VALUES (:breed_name, :sub_breed)");
        $query->bindParam(':breed_name', $breed_name);
        $query->bindParam(':sub_breed', $sub_breed);
        return $query->execute();
    }

    /**
     * inserts urls and breed-ids into the database base using different MySQL statements depending on whether the database has content already
     *
     * @param $breed_id string id of breed type
     * @param $url_image string url to image
     *
     * @return boolean dependent on if insertion is successful
     */
    public function insertImages (string $breed_id, string $url_image) :bool{
        $db = $this->dbConnection->getConnection();
        $query = $db->prepare("INSERT INTO `image_table` (`url_image`, `breed_id`) VALUES (:url_image, :breed_id)");
        $query->bindParam(':breed_id', $breed_id);
        $query->bindParam(':url_image', $url_image);
        return $query->execute();
    }

    /**
     * retrieves the id, breed names and sub breeds from the breeds table
     *
     * @return array containing the the id, breed_name and sub_breed
     */
    public function getBreed () :array{
        $db = $this->dbConnection->getConnection();
        $query= $db->prepare("SELECT `id`, `breed_name`, `sub_breed` FROM `breed_table`");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Gets all the dog's images and populate the info from the database into an object
     *
     * @param $id string Id of the choosen breed
     *
     * @return array Array of objects with every dog's image information
     */
    public function getDogs(string $id) : array
    {
        $db = $this->dbConnection->getConnection();
        $query= $db->prepare("SELECT `id`, `url_image`, `breed_id` FROM `image_table` WHERE `breed_id`=:breed_id");
        $query->bindParam(':breed_id', $id);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, 'TopDog\Classes\Dog');
    }

    /**
     * This function updates the fav_dog column of the selected breed to the selected image id
     *
     * @param string $image_id is the ID of the chosen dog image
     *
     * @param string $breed_id is the ID of the chosen breed
     *
     * @return bool dependent on if update is successful
     */
    public function setFav(string $image_id, string $breed_id) :bool{
        $db = $this->dbConnection->getConnection();
        $query= $db->prepare("UPDATE `breed_table` SET `fav_dog` = :image_id WHERE `id` = :breed_id");
        $query->bindParam(':image_id', $image_id);
        $query->bindParam(':breed_id', $breed_id);
        return $query->execute();
    }

    /**
     * Gets the ID number of the favourite image of a certain breed
     *
     * @param string $id The id of the breed
     *
     * @return string the ID of the favourite image
     */
    public function getFavouriteDog (string $id) : array {
        $db = $this->dbConnection->getConnection();
        $query= $db->prepare("SELECT `fav_dog` FROM `breed_table` WHERE `id`=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
}
