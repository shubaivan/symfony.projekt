<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 21.04.15
 * Time: 16:16
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use AppBundle\Service\Redmine;

class ApiRedmineController extends FOSRestController
{
    /**
     * Gets Issues,
     *
     * @ApiDoc(
     * resource = true,
     * description = "getIssues",
     * output="",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Dream is not found"
     * },
     * section="All issue "
     * )
     *
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getAllIssueAction()
    {
        $issue = $this->get('my_redmine');
        $issuesList = $issue->Issue();

        $nameProject = $this->get('my_redmine');
        $issueNameAllProject = $nameProject->projectIssue();
//
//        return array(
//            "issuesList" => $issuesList,
//            "issueNameAllProject" => $issueNameAllProject,
//        );

        $restView = View::create();

        $restView->setData([$issuesList, $issueNameAllProject]);

        return $restView;
    }

    /**
     * Gets name Projects,
     *
     * @ApiDoc(
     * resource = true,
     * description = "get name Project",
     * output="",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Project is not found"
     * },
     * section="All name Project "
     * )
     *
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getAllProjectAction()
    {
        $name = $this->get('my_redmine');
        $projectListName = $name->Name();

        $restView = View::create();

        $restView->setData($projectListName);

        return $restView;
    }
}
