<?php

namespace AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyRedmine extends Controller
{
    public function Name()
    {
        $projectListName = array();

        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $httpAuthString = 'test';

        $client = new \Redmine\Client($url, $apiKey, $httpAuthString);

        $allProjects = $client->api('project')->all();

//        dump($allProjects);exit;
        foreach ($allProjects["projects"] as $projects) {

//            dump($projects);exit;
            foreach ($projects as $key => $projectName) {
                if ($key == 'name') {
//                        dump($projectName);
                    array_push($projectListName, $projectName);
                }

            }

        }

        return $projectListName;
    }

    public function Issue()
    {
        $issuesList = array();

        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $httpAuthString = 'test';
        $client = new \Redmine\Client($url, $apiKey, $httpAuthString);
        $issueList = $client->api('issue')->all(array());

        dump($issueList);
        foreach ($issueList['issues'] as $issue) {

            foreach ($issue as $key => $issueDescription) {
                if ($key == 'description') {
//                        dump($issueDescription);
                    array_push($issuesList, $issueDescription);
                }
            }
        }

        return  $issuesList;
    }

    public function projectIssue()
    {
        $issueNameAllProject = array();

        $url = 'https://redmine.ekreative.com';
        $apiKey = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
        $httpAuthString = 'test';
        $client = new \Redmine\Client($url, $apiKey, $httpAuthString);
        $issueList = $client->api('issue')->all(array());

        foreach ($issueList['issues'] as $issue) {

            foreach ($issue['project'] as $key => $issueNameProject) {

                if ($key == 'name') {
//                            dump($issueNameProject);
                    array_push($issueNameAllProject, $issueNameProject);
                }
            }
//            dump($issueNameAllProject);
        }

        return  $issueNameAllProject;
    }
}
