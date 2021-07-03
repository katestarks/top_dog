<?php

    require_once '../../../vendor/autoload.php';

	use PHPUnit\Framework\Testcase;

	class DogTest extends Testcase
	{
		public function testGetId ()
		{
            $this->markTestSkipped('Not possible now private method');
			$dog = new \TopDog\Classes\Dog(1,2, 'www.lovehoney.co.uk');
			$result = $dog->getID();
			$this->assertEquals($result, 1);
		}

		public function testGetBreedId ()
		{
            $this->markTestSkipped('Not possible now private method');
			$dog = new \TopDog\Classes\Dog(1,2, 'www.lovehoney.co.uk');
			$result = $dog->getBreedId();
			$this->assertEquals($result, 2);
		}

		public function testGetUrl ()
		{
            $this->markTestSkipped('Not possible now private method');
			$dog = new \TopDog\Classes\Dog(1,2, 'www.lovehoney.co.uk');
			$result = $dog->getUrl();
			$this->assertEquals($result, 'www.lovehoney.co.uk');
		}

		public function testGetInfo ()
		{
            $this->markTestSkipped('Not possible now private method');
			$dog = new \TopDog\Classes\Dog(1,2, 'www.lovehoney.co.uk');
			$result = $dog->getInfo();
			$this->assertEquals($result, ['id'=> 1,'breedId'=>2, 'url'=> 'www.lovehoney.co.uk']);
		}
	}