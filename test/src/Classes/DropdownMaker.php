<?php

    require_once '../../../vendor/autoload.php';

    use PHPUnit\Framework\Testcase;

    class DropdownMaker extends Testcase
    {
        public function testInternalType()
        {
            $dropDownMaker = new TopDog\Classes\DropdownMaker();
            $this->assertInternalType('object', $dropDownMaker);
        }

        public function testPopulateDropdownSuccessWithSubBreed()
        {
            $dropDownMaker = new TopDog\Classes\DropdownMaker();
            $test = [['id'=>1,'breed_name'=>'hound','sub_breed'=>'blood']];
            $result = $dropDownMaker->populateDropdown($test);
            $this->assertEquals('<option value=1>blood hound</option>', $result);
        }

        public function testPopulateDropdownSuccessWithoutSubBreed()
        {
            $dropDownMaker = new TopDog\Classes\DropdownMaker();
            $test = [['id'=>1,'breed_name'=>'hound','sub_breed'=>'']];
            $result = $dropDownMaker->populateDropdown($test);
            $this->assertEquals('<option value=1>hound</option>', $result);
        }

        public function testPopulateDropdownFailure()
        {
            $dropDownMaker = new TopDog\Classes\DropdownMaker();
            $test = [[]];
            $result = $dropDownMaker->populateDropdown($test);
            $this->assertEquals('<option>No Doggies</option>', $result);
        }

        public function testPopulateDropdownStringMalformed()
        {
            $dropDownMaker = new TopDog\Classes\DropdownMaker();
            $test = 'Hello Pedro!';
            $this->expectException(TypeError::class);
            $dropDownMaker->populateDropdown($test);
        }
        public function testPopulateDropdownNumberMalformed()
        {
            $dropDownMaker = new TopDog\Classes\DropdownMaker();
            $test = 3;
            $this->expectException(TypeError::class);
            $dropDownMaker->populateDropdown($test);
        }
    }