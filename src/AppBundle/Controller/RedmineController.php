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

        $config = $this -> get('my_redmine');
//        $config->url = 'https://redmine.ekreative.com';
//        $config->apikey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $redmine = new Redmine($config);

        $overdueissues = $redmine->getIssues("?query_id=10");
        return array(
            "overdueissues" => $overdueissues,
        );
    }

}