<?php
namespace TopDog\Classes;

class DropdownMaker
{
    /** This method takes in an array that contains an array of dogs and convert it into an HTML string that will populate the dog breed dropdown
     *
     * @param array $breeds is an array containing arrays of dogs
     *
     * @return string that will populate the dropdown of dog breeds
     */
    public function populateDropdown (array $breeds) : string
    {
        $dropDownList = '';
        if ($breeds == [[]] || $breeds == []) {
            $dropDownList .= "<option>No Doggies</option>";
        } else
            if (count($breeds, true) > 0) {
                foreach ($breeds as $breed) {
                    if ($breed['sub_breed'] === '') {
                        $dropDownList .= "<option value=" . $breed['id'] . ">" . $breed['breed_name'] . "</option>";
                    } else {
                        $dropDownList .= "<option value=" . $breed['id'] . ">" . $breed['sub_breed'] . " " . $breed['breed_name'] . "</option>";
                    }
                }
            }
        return $dropDownList;
    }
}