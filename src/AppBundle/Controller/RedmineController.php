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

class RedmineController extends Controller
{
    /**
     * @Route("/redmine", name="redmine")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {

        $config = $this->get('my_redmine');
//        $config->url = 'https://redmine.ekreative.com';
//        $config->apikey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $redmine = new Redmine($config);


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
//        $client = new \Redmine\Client('https://redmine.ekreative.com', '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c');
        $client = new \Redmine\Client('https://redmine.ekreative.com', 'test', '9uu82T487m6V41G');

//        $client->api('user')->all();
//        $client->api('user')->listing();

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


}
