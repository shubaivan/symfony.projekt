<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use AppBundle\Entity\Issue;
use AppBundle\Form\Type\AddIssueType;

/**
 * @Route("/issue")
 */
class IssueController extends Controller
{
    /**
     * @Route("/{slug}/add", name="issue_add")
     * @Method({"POST"})
     */
    public function createIssueAction($slug, Request $request)
    {
        $issue = new Issue();

        $form = $this->createForm(new AddIssueType(), $issue);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $issue->setAuthor($this->getUser());
            $issue->setPost($this->getDoctrine()->getRepository('AppBundle:Post')->findOneBySlugPost($slug));

            $em = $this->getDoctrine()->getManager();
            $em->persist($issue);
            $em->flush();

            $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findBySlugPost($slug);

            $issues = array();

            for ($i = 0; $i < count($post[0]->getIssue()); $i++) {

                $issues[$i]["text"] = $post[0]->getIssue()[$i]->getText();
                $issues[$i]["createdAt"] = $post[0]->getIssue()[$i]->getCreatedAt()->format("d.m.Y H:i:s");
            }

            return new JsonResponse($issues);
        }

        return new JsonResponse([], 500);
    }

    /**
     * @Route("/last/{count}", defaults={"count" = 10} ,requirements={"count" = "\d+"} , name="issue_last")
     * @Method({"GET"})
     * @Template()
     */
    public function lastAction($count)
    {
        $issues = $this->getDoctrine()->getRepository('AppBundle:Issue')->findBy([], ['id' => 'DESC'], $count);

        return array(
            "issues" => $issues,
        );
    }
}
