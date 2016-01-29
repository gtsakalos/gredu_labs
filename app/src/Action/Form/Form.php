<?php
/**
 * gredu_labs
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

namespace GrEduLabs\Action\Form;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use GrEduLabs\DBService\SchoolService;
use GrEduLabs\DBService\TeacherService;

class Form
{
    /**
     * @var Twig
     */
    protected $view;

    /**
     * Constructor
     * @param Twig $view
     */
    public function __construct(
        Twig $view,
        $school_service, 
        $teacher_service, 
        $lab_service,
        $equipment_service
        )
    {

        $this->school_service = $school_service;
        $this->teacher_service = $teacher_service;
        $this->lab_service = $lab_service;
        $this->equipment_service = $equipment_service;
    }

    public function __invoke(Request $req, Response $res)
    {
        $test = [
            'registryNo' => '1',
            'educationLevel' => 'aLevel',
            'unitType' => 'aType',
            'category' => 'the_category',
            'eduAdmin' => 'theAdmin',
            'regionEduAdmin' => 'superadmin'
        ];
        $test2 = [
            'registryNo' => '2',
            'educationLevel' => 'bLevel',
            'unitType' => 'bType',
            'category' => 'theb_category',
            'eduAdmin' => 'thebAdmin',
            'regionEduAdmin' => 'superadmin2',
            'streetAddress' => 'the_street',
            'phoneNumber' => 'the_phone',
            'faxNumber' => 'the_fax',
            'email' => 'the_email'
        ];

        $test3 = [
            'school_id' => 1,
            'name' => 'tname',
            'surname' => 'sname',
            'speciality' => 'special',
            'phoneNumber' => 'the_phone',
            'email' => 'the_email',
            'labSupervisor' => 1,
            'schoolPrincipal' => 0,
        ];

        $lab_array = [
            'name' => 'ergastirio tade',
            'school' => 4,
            'teacher' => 2,
            'area' => 40,
        ];

        $soft = [
            'name' => 'windows millenium',
            'manufacturer' => 'microsoft',
            'website' => 'www.foo.gr'
        ];
        //$result = $this->teacher_service->createTeacher($test3);
        //$result = $this->teacher_service->getTeacherBySchoolId(1);
        //$result = $this->school_service->createSchool($test2);
        //$result = $this->school_service->getSchool(11);
        //print_r($result);
        //echo $result;
        #$this->foo = new SchoolService($this->db);
        #return $this->view->render($res, 'form.twig');
        //$this->lab_service->createLab($lab_array);
        //$result = $this->lab_service->getLabsBySchoolId(1);
        $result = $this->equipment_service->getAllSoftwareCategories();
        print_r($result);
    }
}
