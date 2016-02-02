<?php

namespace GrEduLabs\DBService;

use R;


class ApplicationService
{
    
    public function __construct($school_service, $equipment_service)
    {
        $this->school_service = $school_service;
        $this->equipment_service = $equipment_service;
    }


    public function createApplication(Array $data)
    {
        $application = R::dispense('application');
        $required = ['school', 'request_for', 'teacher', 'newLab'];

        foreach ($required as $value){
            if (array_key_exists($value, $data)){
                if ($value == 'school')
                {
                    $school_id = $data[$value];
                }
                else
                {
                $application[$value] = $data[$value];
                }
            }
            else
            {
                return -1;
            }
        }
        
        $school = $this->school_service->getSchool($school_id);
        $application->school = $school;
        $id = R::store($application);
        return $id;
        
    }
    
    
    public function getApplicationById($id)
    {
        $appl = R::load('application', $id);
        return $appl;
    }
    
    
    public function getApplicationBySchoolId($id)
    {
        $school = $this->school_service->getSchool($id);
        $application = $school->ownApplication;
        return $application;
        
    }
    
}
