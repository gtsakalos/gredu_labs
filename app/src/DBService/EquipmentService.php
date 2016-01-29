<?php

namespace GrEduLabs\DBService;

use R;


class EquipmentService
{
    
    public function __construct($school_service)
    {
        $this->school_service = $school_service;
    }

    public function createItemCategory($name){
        $item_category = R::dispense('itemcategory');
        $item_category->name = $name;
        $id = R::store($item_category);
        return $id;
    }

    public function getAllItemCategories(){
        $categories = R::findAll('itemcategory');
        return $categories;
    }


    public function createSoftwareCategory(Array $data){
        $soft_category = R::dispense('softwarecategory');
        $soft_category->name = $data['name'];
        $soft_category->manufacturer = $data['manufacturer'];
        $soft_category->website = $data['website'];
        $id = R::store($soft_category);
        return $id;
    }

    public function getAllSoftwareCategories(){
        $categories = R::findAll('softwarecategory');
        return $categories;
    }

}
