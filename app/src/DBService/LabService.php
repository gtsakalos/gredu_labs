<?php

namespace GrEduLabs\DBService;

use R;


class LabService
{
    
    public function __construct($school_service, $teacher_service)
    {
        $this->school_service = $school_service;
        $this->teacher_service = $teacher_service;
    }


    public function createLab(Array $data)
    {
        $lab = R::dispense('lab');
        $required = ['name', 'school', 'teacher', 'area'];

        foreach ($required as $value){
            if (array_key_exists($value, $data)){
                if ($value == 'school')
                {
                    $school_id = $data[$value];
                }
                else if ($value == 'teacher')
                {
                    $teacher_id = $data[$value];
                }
                else
                {
                $lab[$value] = $data[$value];
                }
            }
            else
            {
                return -1;
            }
        }
        
        $school = $this->school_service->getSchool($school_id);
        $teacher = $this->teacher_service->getTeacherById($teacher_id);
        $lab->school = $school;
        $lab->teacher = $teacher;
        $id = R::store($lab);
        return $id;
        
    }
    
    
    public function getLabById($id)
    {
        $lab = R::load('lab', $id);
        return $lab;
    }
    
    
    public function getLabsBySchoolId($id)
    {
        $school = $this->school_service->getSchool($id);
        $labs = $school->ownLab;
        return $labs;
        
    }
    
}
