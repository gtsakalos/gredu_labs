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
            else
            {
                $$value = '';
            }
        }

        $query = "INSERT INTO `school` (`registryNo`, `streetAddress`,
            `phoneNumber`, `faxNumber`, `email`, `educationLevel`, `unitType`,
            `category`, `eduAdmin`, `regionEduAdmin`) VALUES ('$registryNo',
            '$streetAddress', '$phoneNumber', '$faxNumber', '$email',
            '$educationLevel', '$unitType', '$category', '$eduAdmin', '$regionEduAdmin')";
        
        $stm = $this->db->prepare($query);
        
        if (!$stm)
        {
            return $this->db->errorInfo();
        }
        else
        {
            $stm->execute();
        }
    }
    
    
    public function getSchool($id)
    {
        $query = "SELECT `school`.`id`, `school`.`registryNo`,
            `school`.`streetAddress`, `school`.`phoneNumber`, `school`.`faxNumber`,
            `school`.`email`, `school`.`educationLevel`, `school`.`unitType`,
            `school`.`category`, `school`.`eduAdmin`, `school`.`regionEduAdmin`
            FROM `school` WHERE `school`.`id` = $id";
        $stm = $this->db->prepare($query);
        
        if (!stm)
        {
            return $this->db->errorInfo();
        }
        else
        {
           $stm->execute();
           $result= $stm->fetchObject();
           return $result;
        }
    }
}
