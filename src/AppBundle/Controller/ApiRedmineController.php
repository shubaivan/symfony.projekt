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
        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $httpAuthString = 'test';

        $client = new \Redmine\Client($url, $apiKey, $httpAuthString);
        $issueList = $client->api('issue')->all(array());

        $restView = View::create();

        foreach ($issueList['issues'] as $issue) {

            $fullIssue = $client->api('issue')->show($issue['id'], ['include' => 'journals']);
            $restView->setData($fullIssue);

        }

        return $restView;
    }
}
