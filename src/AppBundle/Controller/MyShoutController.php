<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("my-shouts")
 */
class MyShoutController extends Controller
{
    /**
     * @Route("/", name="my_shout_list")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $shouts = $em->getRepository('AppBundle:Shout')
            ->findBy([
                'user' => $this->getUser()
            ], ['createdAt' => 'DESC']);

        $paginator = $this->get('knp_paginator');
        $results = $paginator->paginate(
            $shouts,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('myShouts/list.html.twig', [
            'shouts' => $results
        ]);
    }
}
