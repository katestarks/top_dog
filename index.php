<?php
require_once __DIR__ . '/vendor/autoload.php';

try {
    $db = new \TopDog\Classes\PDOConnection();
}
catch (Exception $e) {
    echo $e->getMessage();
}

$dbHandler = new \TopDog\Classes\DbHandler($db);
$dropdownMaker = new \TopDog\Classes\DropdownMaker();
$dogDisplayer = new \TopDog\Classes\DogDisplayer();
$dogManager = new \TopDog\Classes\DogManager($dbHandler, $dropdownMaker, $dogDisplayer);

if(isset($_POST['Breeds'])) {
    $breeds = $_POST['Breeds'];
    if ($breeds != 0) {
        if (isset($_POST['favDogId'])) {
            $favDogId = $_POST['favDogId'];
            $dogManager->faveToDb($favDogId, $breeds);
        }
        $dogManager->populateDogs($breeds);
        $dogManager->getFaveId($breeds);
        $dogManager->setFavouriteDog();
        $dogImagesOutput = $dogManager->displayDogs();
    }
}

$dogManager->getBreeds();
$dropdownOutput = $dogManager->makeDropdown();

?>

<html lang="en">
<head>
    <title>Top Dog</title>
    <link href='styles/normalize.css' rel='stylesheet'>
    <link href="styles/styles.css" rel="stylesheet">
</head>
<body>

<h1>Top Dog</h1>

<form method="POST">
    <select name="Breeds" title="Breeds">
        <option value="0">Choose your breed!</option>
        <?php
        if (isset($dropdownOutput)) {
            echo $dropdownOutput;
        }
        ?>
    </select>
    <input type="submit">
</form>

<main class="dog-house">
    <?php
        if(isset($dogImagesOutput)) {
            echo $dogImagesOutput['faveDog'];
            echo $dogImagesOutput['dogs'];
        }
    ?>
</main>

</body>
</html>
