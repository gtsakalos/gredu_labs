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
    public function __construct(Twig $view, SchoolService $school_service)
    {
        $this->view = $view;
        $this->school_service = $school_service;
    }

    public function __invoke(Request $req, Response $res)
    {
        $this->school_service->createSchool(['registryNo' => 'foo']);
        #$this->foo = new SchoolService($this->db);
        #return $this->view->render($res, 'form.twig');
    }
}
