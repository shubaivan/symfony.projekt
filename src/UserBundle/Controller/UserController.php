<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\UpdateProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;

class UserController extends Controller
{
    /**
     * @param  Request                                                  $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template()
     */
    public function updateContactsAction(Request $request)
    {
        $userAuth = $this->getUser();

        if (!$userAuth) {
            return $this->redirect($this->generateUrl('blog_home'));
        }

        $dm = $this->get('doctrine.orm.entity_manager');
        $user = $dm->getRepository('UserBundle:User')->findOneById($userAuth->getId());

        if (strstr($user->getEmail(),'@example.com')) {
            $user->setEmail('');
        }

        $form = $this->CreateForm(new UpdateProfileType(), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $dm->flush();

            $router = $this->generateUrl("blog_home");

            return $this->redirect(
                $router
            );
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
