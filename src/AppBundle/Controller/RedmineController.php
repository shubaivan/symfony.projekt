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
use AppBundle\Service\Project;

class RedmineController extends Controller
{
    /**
     * @Route("/project", name="project")
     * @Method({"GET"})
     * @Template()
     */
    public function projectAction()
    {
        $name = $this->get('my_project');
        $projectListName = $name->Name();

        return array(
            "projectListName" => $projectListName,
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

    /**
     * @Route("/new/issues", name="new_issues")
     * @Method(methods={"GET", "POST"})
     * @Template()
     */
    public function newIssuesAction()
    {
        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $httpAuthString = 'test';

        $client = new \Redmine\Client($url, $apiKey, $httpAuthString);

        $ret = $client->api('issue')->create(array(
            'project_id'     => 'test',
            'subject'        => 'test api (xml) 3',
            'description'    => 'test api',
            'assigned_to_id' => 'user1',
//            'custom_fields'  => array(
//                array(
//                    'id'    => 2,
//                    'name'  => 'Issuer',
//                    'value' => $_POST['ISSUER'],
//                ),
//                array(
//                    'id'    => 5,
//                    'name'  => 'Phone',
//                    'value' => $_POST['PHONE'],
//                ),
//                array(
//                    'id'    => '8',
//                    'name'  => 'Email',
//                    'value' => $_POST['EMAIL'],
//                ),
//            ),
//            'watcher_user_ids' => array(),
        ));

        if( $ret instanceof SimpleXMLElement ){
            //look in the Object
            var_dump($ret);
        }
        else{
            if( $ret === true ){
                echo "success";
            }
            else{
                echo "error";
            }
        }
//        var_dump($ret);
//        echo $ret->asXML();
//        return array(
//            "fullIssues" => $fullIssue,
//        );
    }
}
