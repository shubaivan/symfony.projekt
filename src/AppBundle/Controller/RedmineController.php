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
     * @Route("/redmine", name="redmine")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';

        $config = array($url, $apiKey);
        $redmine = new Redmine($config);
        $redmine->getIssues("?query_id=1");
        return array(
            "redmine" => $redmine,
        );
    }

    /**
     * @Route("/redminebundle", name="redmine_bundle")
     * @Method({"GET"})
     * @Template()
     */
    public function redmineAction()
    {
        $client = new \Redmine\Client('https://redmine.ekreative.com', '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c');
//        $client = new \Redmine\Client('https://redmine.ekreative.com', 'test', '9uu82T487m6V41G');

//        $client->api('user')->all();
        $client->api('user')->listing();

//        $client->api('issue')->create([
//            'project_id'  => 'test',
//            'subject'     => 'some subject',
//            'description' => 'a long description blablabla',
//            'assigned_to' => 'user1',
//        ]);
//        $client->api('issue')->all([
//            'limit' => 1000
//        ]);
        var_dump($client);

        return array(
            "client" => $client,
        );
    }

    /**
     * @Route("/client", name="redmine")
     * @Method({"GET"})
     * @Template()
     */
    public function clientAction()
    {
        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $httpAuthString = 'test';

        $client = new \Redmine\Client($url, $apiKey, $httpAuthString);
        $issueList = $client->api('issue')->all(array(
            'limit' => 3
        ));


//        return array(
//            "issueList" => $issueList,
//        );


        foreach ($issueList['issues'] as $issue) {

            $fullIssue = $client->api('issue')->show($issue['id'], ['include' => 'journals']);
//            print_r($fullIssue);

        }
                return array(
            "fullIssue" => $fullIssue,
        );
    }


}
