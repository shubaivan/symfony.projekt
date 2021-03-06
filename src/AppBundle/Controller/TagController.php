<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use AppBundle\Entity\Tag;
use AppBundle\Form\Type\AddTagType;

/**
 * @Route("/tag")
 */
class TagController extends Controller
{
    /**
     * @Route("/add", name="tag_add_page")
     * @Method({"POST", "GET"})
     * @Template()
     */
    public function addAction(Request $request)
    {
        $tag = new Tag();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new AddTagType(), $tag);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($tag);
            $em->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

        return [
            "form" => $form->createView()
        ];
    }

    /**
     * @Route("/last", name="tag_last_page")
     * @Method({"GET"})
     * @Template()
     */
    public function lastAction()
    {
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->getLastTags(15);

        return array(
            "tags" => $tags,
        );
    }

    /**
     * @Route("/{slug}", name="tag_page")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getRepository('AppBundle:Tag');
        $tag = $em->findOneByHashSlug($slug);

        return array(
            "tag" => $tag,
        );
    }

    /**
     * @Route("/topTags")
     * @Method({"GET"})
     * @Template()
     */
    public function topTagsAction()
    {
        $tags = $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findTopTags();

        return [
            "tags" => $tags
        ];
    }
}
