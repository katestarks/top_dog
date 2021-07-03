<?php
require_once '../../../vendor/autoload.php';

use PHPUnit\Framework\Testcase;

class DogDisplayerTest extends Testcase
{
    public function testGetId()
    {
        $dog = $this->createMock(TopDog\Classes\Dog::class); //blank pretend object
        $dog->method('getUrl')
            ->willReturn('www.dog.com');
        $inputDogs = [$dog];
        $dogDisplayer = new \TopDog\Classes\DogDisplayer();
        $result = $dogDisplayer->displayDogs($inputDogs);
        $stringResult = '<div class="dog-holder"><form action="post"><div class="dog-image"><img src="www.dog.com" alt="doggy"></div><input type="hidden" id="favDogId" name="favDogId" value="0"><input type="submit" value="Make favourite!"></form></div>';
        $this->assertEquals($result['dogs'], $stringResult);
    }

    public function testFailure()
    {
        $dog = $this->createMock(TopDog\Classes\Dog::class); //blank pretend object
        $dog->method('getUrl')
            ->willReturn('');
        $inputDogs = [$dog];
        $dogDisplayer = new \TopDog\Classes\DogDisplayer();
        $result = $dogDisplayer->displayDogs($inputDogs);
        $stringResult = '<div class="dog-holder"><form action="post"><div class="dog-image"><img src="" alt="doggy"></div><input type="hidden" id="favDogId" name="favDogId" value="0"><input type="submit" value="Make favourite!"></form></div>';
        $this->assertEquals($result['dogs'], $stringResult);
    }

    public function testMalformed()
    {
        $dogDisplayer = new \TopDog\Classes\DogDisplayer();
        $this->expectException(TypeError::class);
        $dogDisplayer->displayDogs(7);
    }

    public function testFavGetId()
    {
        $dog = $this->createMock(TopDog\Classes\Dog::class); //blank pretend object
        $dog->method('getIsFav')
            ->willReturn('www.dog.com');
        $inputDogs = [$dog];
        $dogDisplayer = new \TopDog\Classes\DogDisplayer();
        $result = $dogDisplayer->displayDogs($inputDogs);
        $stringResult = '<div class="best-dog"><div class="dog-image"><img src="" alt="doggy"></div><h3>The Best Doggo!</h3></div>';
        $this->assertEquals($result['faveDog'], $stringResult);
    }

    public function testFavFailure()
    {
        $dog = $this->createMock(TopDog\Classes\Dog::class); //blank pretend object
        $dog->method('getIsFav')
            ->willReturn('<div class="best-dog"><div class="dog-image"><img src="" alt="doggy"></div><h3>The Best Doggo!</h3></div>');
        $inputDogs = [$dog];
        $dogDisplayer = new \TopDog\Classes\DogDisplayer();
        $result = $dogDisplayer->displayDogs($inputDogs);
        $stringResult = '<div class="best-dog"><div class="dog-image"><img src="" alt="doggy"></div><h3>The Best Doggo!</h3></div>';
        $this->assertEquals($result['faveDog'], $stringResult);
    }

    public function testFavMalformed()
    {
        $dogDisplayer = new \TopDog\Classes\DogDisplayer();
        $this->expectException(TypeError::class);
        $dogDisplayer->displayDogs(7);
    }
}