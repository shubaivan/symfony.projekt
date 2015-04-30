<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 21.01.15
 * Time: 10:16
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\Redmine;
use AppBundle\Service\Client;

class RedmineController extends Controller
{
    /**
     * @Route("/project", name="project")
     * @Method({"GET"})
     * @Template()
     */
    public function projectAction()
    {
        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $httpAuthString = 'test';

        $client = new \Redmine\Client($url, $apiKey, $httpAuthString);

        $project = $client->api('project')->all();

        var_dump($project);

        return array(
            "projects" => $project,
        );
    }

    /**
     * @Route("/issues", name="issues")
     * @Method({"GET"})
     * @Template()
     */
    public function issuesAction()
    {
        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $httpAuthString = 'test';
        $client = new \Redmine\Client($url, $apiKey, $httpAuthString);
        $issueList = $client->api('issue')->all(array());
//        return array(
//            "issueList" => $issueList,
//        );
        foreach ($issueList['issues'] as $issue) {
            $fullIssue = $client->api('issue')->show($issue['id']);
//            print_r($fullIssue);
            var_dump($fullIssue);
        }
        return array(
            "fullIssues" => $fullIssue,
        );
    }
}
