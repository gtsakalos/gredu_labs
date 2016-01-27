<?php

namespace GrEduLabs\DBService;

use PDO as PDOConnection;

class SchoolService
{
    public function __construct(PDOConnection $db)
    {
        $this->db = $db;
    }

    
    public function createSchool(Array $data)
    {
        $required = ['registryNo', 'educationLevel', 'unitType', 'category', 'eduAdmin', 'regionEduAdmin'];
        $optional = ['streetAddress', 'phoneNumber', 'faxNumber', 'email'];

        foreach ($required as $value){
            if (array_key_exists($value, $data)){
                $$value = $data[$value];
            }
            else
            {
                return -1;
            }
        }
        foreach ($optional as $value){
            if (array_key_exists($value, $data)){
                $$value = $data[$value];
            }
        }

        $query = "INSERT INTO `school` (`registryNo`, `streetAddress`, `phoneNumber`, `faxNumber`, `email`, `educationLevel`, `unitType`, `category`, `eduAdmin`, `regionEduAdmin`) VALUES ('regNo', 'strAd', 'phone', 'fax', 'email', 'edulvl', 'utype', 'cat', 'eadm', 'readm')";
        $this->db->query($query);
    }
    
    
    public function getSchool()
    {
    }
}
