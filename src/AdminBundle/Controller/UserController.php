<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('AdminBundle:User:list.html.twig', [
        	'users' => $users
        	]);
    }

    /**
     * @Route("admin/user/new", name="admin_user_new")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // Encode plain password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setEnabled(true);
            $user->setRole("ROLE_ADMIN");
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_user');
        }
        return $this->render('AdminBundle:User:new.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/user/{id}/edit", name="admin_user_edit")
     */

    public function editAction(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('admin_user');
        }
        return $this->render('AdminBundle:User:edit.html.twig', [
                'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("admin/user/{id}/delete", name="admin_user_delete")
     */
    
    public function deleteAction(User $user, Request $request)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('admin_user');
        
    }    



}

