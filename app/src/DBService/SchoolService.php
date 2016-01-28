<?php

namespace GrEduLabs\DBService;

use PDO as PDOConnection;
use R;

class SchoolService
{

    public function createSchool(Array $data)
    {
        $school = R::dispense('school');
        $required = ['registryNo', 'educationLevel', 'unitType', 'category', 'eduAdmin', 'regionEduAdmin'];
        $optional = ['streetAddress', 'phoneNumber', 'faxNumber', 'email'];

        foreach ($required as $value){
            if (array_key_exists($value, $data)){
               $school[$value] = $data[$value];
            }
            else
            {
                return -1;
            }
        }

        foreach ($optional as $value){
            if (array_key_exists($value, $data)){
                $school[$value] = $data[$value];
            }
            else
            {
                $school[$value] = '';
            }
        }

        $id = R::store($school);
        return $id;
    }
    
    
    public function getSchool($id)
    {
        $school = R::load('school', $id);
        return $school;
    }
}
