<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 12.12.14
 * Time: 15:54
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use AppBundle\Entity\Post;
use AppBundle\Form\Type\AddPostType;
use AppBundle\Form\Type\EditPostType;
use AppBundle\Form\Type\AddIssueType;

class PostController extends Controller
{
    /**
     * @Route("/", name="blog_home")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findBy([], ['id' => 'DESC']);

        return array(
            "posts" => $posts,
        );
    }

    /**
     * @Route("/post/add", name="post_add_get")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function addAction(Request $request)
    {
        $tags = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Tag')
            ->getHastTags();

        $post = new Post();

        $form = $this->createForm(new AddPostType($tags), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($post->getTag() as $value) {
                $value->addPost($post);
            }

            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

        return array(
            "form" => $form->createView(),
        );
    }

    /**
     * @Route("/post/{slug}/", name="view_post")
     * @Method({"GET"})
     * @Template()
     */
    public function viewAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBy(['slugPost' => $slug]);

        $form = $this->createForm(new AddIssueType());

        return array(
            "post" => $post,
            "form" => $form->createView(),
        );
    }

    /**
     * @Route("/post/{slug}/edit", name="edit_post")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Post')
            ->findOneBySlugPost($slug);

        if ($request->isMethod('POST')) {
            foreach ($post->getTag() as $key => $value) {
                $post->removeTag($value);
                $value->removePost($post);
            }
        }

        $form = $this->createForm(new EditPostType($em), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($post->getTag() as $value) {
                $value->addPost($post);
            }

            $em->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

        return array(
            "form" => $form->createView(),
        );
    }

    /**
     * @Route("/post/{slug}/delete", name="delete_post")
     * @Method({"DELETE"})
     */
    public function deletePostAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->findBySlugPost($slug)[0];

        foreach ($post->getTag() as $value) {
            $value->removePost($post);
            $post->removeTag($value);
        }

        $em->remove($post);
        $em->flush();

        return JsonResponse::create(["code" => 200]);
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
        $client->api('issue')->all([
            'limit' => 1000
        ]);
        var_dump($client);

        return array(
            "client" => $client,
            );
    }

}
