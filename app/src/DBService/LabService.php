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
        $required = ['name', 'school', 'area'];
        foreach ($required as $value){
            if (array_key_exists($value, $data)){
                if ($value == 'school')
                {
                    $school_id = $data[$value];
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
        if array_key_exists('teacher', $data)
        {
            $teacher_id = $data['teacher'];
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

    public function updateLab(Array $data, $lab_id)
    {
        $lab = R::load('lab', $lab_id);
        foreach ($data as $key => $value)
        {
            $lab[$key] = $value;
        }
        R::store($lab);
        
    }
    
}
