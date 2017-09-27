<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{

	/**
	 * @Route("admin/user", name="admin_user")
     */
    public function userAction()
    {
//        dump("Asd");die;
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')
            ->findAll();

        return $this->render('AdminBundle:user:list.html.twig', [
        	'users' => $users
        	]);
    }
}

