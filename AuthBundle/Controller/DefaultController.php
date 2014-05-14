<?php

namespace Auth\AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $users = $this->container->get('fos_user.user_manager')->findUsers();

        return $this->render('AuthBundle:Default:index.html.twig', array('users' => $users, 'param'=>$this->container->getParameter('referal.param.name')));
    }
}
