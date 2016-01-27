<?php

namespace GrEduLabs\DBService;

use PDO as PDOConnection;

class TeacherService
{
    public function __construct(PDOConnection $db)
    {
        $this->db = $db;
    }

    
    public function createTeacher(Array $data)
    {
        $required = ['school_id', 'name', 'surname', 'phoneNumber', 'labSupervisor', 'schoolPrincipal'];
        $optional = ['speciality', 'email'];

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

        $query = "INSERT INTO `teacher` (`school_id`, `name`, `surname`,
            `speciality`, `phoneNumber`, `email`, `labSupervisor`,
            `schoolPrincipal`) VALUES ($school_id, '$name', '$surname', '$speciality',
            '$phoneNumber', '$email', $labSupervisor, $schoolPrincipal";
        
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
    
    
    public function getTeacherById($id)
    {
        $query = "SELECT `teacher`.`id`, `teacher`.`school_id`,
            `teacher`.`name`, `teacher`.`surname`, `teacher`.`speciality`,
            `teacher`.`phoneNumber`, `teacher`.`email`, `teacher`.`labSupervisor`,
            `teacher`.`schoolPrincipal` FROM `teacher` WHERE `teacher`.`id` = $id";
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
    
    
    public function getTeacherBySchoolId($id)
    {
        $query = "SELECT `teacher`.`id`, `teacher`.`school_id`,
            `teacher`.`name`, `teacher`.`surname`, `teacher`.`speciality`,
            `teacher`.`phoneNumber`, `teacher`.`email`, `teacher`.`labSupervisor`,
            `teacher`.`schoolPrincipal` FROM `teacher` WHERE `teacher`.`school_id` = $id";
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
