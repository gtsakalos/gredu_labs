<?php

namespace GrEduLabs\DBService;

use R;


class TeacherService
{
    
    public function __construct($school_service)
    {
        $this->school_service = $school_service;
    }

    public function createTeacher(Array $data)
    {
        $teacher = R::dispense('teacher');
        $required = ['school_id', 'name', 'surname', 'phoneNumber', 'labSupervisor', 'schoolPrincipal'];
        $optional = ['speciality', 'email'];

        foreach ($required as $value){
            if (array_key_exists($value, $data)){
                $teacher[$value] = $data[$value];
            }
            else
            {
                return -1;
            }
        }

        foreach ($optional as $value){
            if (array_key_exists($value, $data)){
                $teacher[$value] = $data[$value];
            }
            else
            {
                $$value = '';
            }
        }
        
        $school = $this->school_service->getSchool($teacher['school_id']);
        $teacher->school = $school;
        $id = R::store($teacher);
        return $id;
        
    }
    
    
    public function getTeacherById($id)
    {
        $teacher = R::load('teacher', $id);
        return $teacher;
    }
    
    
    public function getTeachersBySchoolId($id)
    {
        $school = $this->school_service->getSchool($id);
        $teachers = $school->ownTeacher;
        return $teachers;
        
    }
    
}
