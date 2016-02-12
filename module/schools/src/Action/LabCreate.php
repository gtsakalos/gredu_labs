<?php
/**
 * gredu_labs.
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

namespace GrEduLabs\Schools\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class LabCreate
{

    public function __construct($labservice)
    {
        $this->labservice = $labservice;
    }

    public function __invoke(Request $req, Response $res, array $args = [])
    {
        error_log(print_r('i am hre', TRUE)); 
        $school = $req->getAttribute('school', false);
        if (!$school) {
            return $res->withStatus(403, 'No school');
        }
        $params = $req->getParams();
        error_log(print_r($params, TRUE)); 
        $id     = $params['id'];
        unset($params['id']);
        $params['school_id'] = $school->id;
        if ($id > 0) {
            $id  = $this->labservice->updateLab($params, $id);
            $lab = $this->labservice->getLabById($id);
        } else {
            $id  = $this->labservice->createLab($params);
            if ($id > 0) {
                $lab = $this->labservice->getLabById($id);
            }
        }
        if (isset($lab)) {
            return $res->withJson($lab->export())->withStatus(201);
        }
        else {
            return $res->withStatus(400);
        }

    }
}
